<?php
session_start();
include "connection.php";
require '../../vendor/autoload.php';

use Ramsey\Uuid\Uuid;

// Function to generate a UUID
function makeID()
{
    return Uuid::uuid4()->toString();
}
function generateRandomId()
{
    $randomNumber = rand(100000, 999999);
    $randomChars = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
    $combined = strval($randomNumber) . $randomChars;
    return str_shuffle($combined);
}
/////////////////////////////////////////////////////////////////
//                    Decode quote
/////////////////////////////////////////////////////////////////
function decodeHtml($encodedString)
{
    $decodedString = htmlspecialchars_decode($encodedString, ENT_QUOTES);
    // First, decode HTML entities  
    $decodedString = html_entity_decode($decodedString, ENT_QUOTES, 'UTF-8');

    // Second, decode any numeric character references (if needed)  
    $decodedString = html_entity_decode($decodedString, ENT_QUOTES, 'UTF-8');

    return $decodedString;
}
// User ID from session
if (!isset($_SESSION['AID'])) {
    echo json_encode(["state" => "error", "message" => "User not authenticated."]);
    include "close_connection.php";
    exit;
}
// allUsers, bannedUsers, deletedUsers, noActionUsers
if (isset($_POST['purpose']) && ($_POST['purpose'] === 'allUsers' || $_POST['purpose'] === 'bannedUsers' || $_POST['purpose'] === 'deletedUsers' || $_POST['purpose'] === 'noActionUsers')) {
    $filterValue = isset($_POST['filterValue']) ? $_POST['filterValue'] : null;
    $AdminType = $_SESSION['AdminType'];
    if ($_POST['purpose'] === 'allUsers') {
        $actionFilter = "";  // Filter deleted users
    } else if ($_POST['purpose'] === 'deletedUsers') {
        $actionFilter = "AND u.action = 'd'";  // Filter deleted users
    } elseif ($_POST['purpose'] === 'bannedUsers') {
        $actionFilter = "AND u.action = 'b'";  // Filter banned users
    } elseif ($_POST['purpose'] === 'noActionUsers') {
        $actionFilter = "AND u.action = 'n'";  // Filter users with no action
    }
    // Validate filterValue: Check if it's not empty and is a number
    $filterCondition = "";
    if ($filterValue !== null && $filterValue !== "" && is_numeric($filterValue)) {
        $filterValue = intval($filterValue); // Ensure it's an integer
        $filterCondition = "HAVING COUNT(cr.course_ID) = $filterValue ";
    }

    // Get the page number and calculate the offset
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1; // Default to page 1 if not set
    $items_per_page = 20; // Number of records per page
    $offset = ($page - 1) * $items_per_page;

    // Query to get students and the number of courses they registered for with pagination
    $query = "SELECT u.user_ID, u.Name, ua.Email, u.Date, u.action, u.Image, COUNT(cr.course_ID) AS registered_courses
        FROM user u 
        LEFT JOIN course_registered cr 
        ON u.user_ID = cr.user_ID 
        LEFT JOIN authentication ua 
        ON u.user_ID = ua.user_ID 
        WHERE u.type = 's'  $actionFilter
        GROUP BY u.user_ID 
        $filterCondition 
        ORDER BY u.Date DESC 
        LIMIT $offset, $items_per_page";

    // Count query for total users with the filter condition
    $count = "SELECT COUNT(*) AS total_users
        FROM (
            SELECT u.user_ID
            FROM user u 
            LEFT JOIN course_registered cr 
            ON u.user_ID = cr.user_ID 
            LEFT JOIN authentication ua 
            ON u.user_ID = ua.user_ID 
            WHERE u.type = 's' $actionFilter
            GROUP BY u.user_ID 
            $filterCondition
        ) AS filtered_users";

    $result = mysqli_query($trainmastas_conn, $query);
    $result_count = mysqli_query($trainmastas_conn, $count);

    $data = [];
    $total_users = 0;
    if ($result && mysqli_num_rows($result) > 0) {
        $state = "success";
        while ($row = mysqli_fetch_assoc($result)) {
            $row['user_ID'] = base64_encode($row['user_ID']);
            $data[] = $row; // Collect each student's data
        }
    } else {
        $state = "noUser";
    }

    if ($result_count && $row_count = mysqli_fetch_assoc($result_count)) {
        $total_users = $row_count['total_users'];
    }

    echo json_encode(['state' => $state, 'data' => $data, 'total_users' => $total_users, 'user_type' => $AdminType]);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "clearAll") {
    if ($_SESSION['AdminType']  !== "super") {
        echo json_encode(["state" => "notAuthorized", "message" => "User authorized."]);
        include "close_connection.php";
        exit;
    }
    $deletedUsers = $_POST['filterValue'];
    $adminID = $_SESSION['AID'];  // Assuming admin ID is stored in session

    // Fetch all users with action = 'd'
    $usersQuery = "SELECT u.user_ID, ua.Email, u.Name, u.Image 
    FROM user u
    LEFT JOIN authentication ua 
    ON u.user_ID = ua.user_ID
    WHERE u.action = 'd' AND u.type='s'";
    $usersResult = mysqli_query($trainmastas_conn, $usersQuery);
    $userNotCleared = [];
    if ($usersResult && mysqli_num_rows($usersResult) > 0) {
        while ($userRow = mysqli_fetch_assoc($usersResult)) {
            $userID = $userRow['user_ID'];
            $userEmail = $userRow['Email'];
            $userImage = $userRow['Image'];

            // 1. Check if the user is registered for any premium courses with Cost > 0  
            $checkPremiumCoursesQuery = "  
                SELECT COUNT(*) as count FROM course_registered cp   
                JOIN course c ON cp.course_ID = c.course_ID   
                WHERE cp.user_ID = '$userID' AND c.Cost > 0  
            ";
            $premiumResult = mysqli_query($trainmastas_conn, $checkPremiumCoursesQuery);
            $premiumRow = mysqli_fetch_assoc($premiumResult);
            $hasPremiumCourse = $premiumRow['count'] > 0;
            if ($hasPremiumCourse) {
                // User is registered for at least one premium course, skip deletion  
                $userNotCleared[] = $userRow['Name'];
                continue;
            } else {
                // 2. Proceed with deletion from the user table if no premium courses found  
                // Delete from the user table  
                $deleteUserQuery = "DELETE FROM user WHERE user_ID = '$userID'";
                mysqli_query($trainmastas_conn, $deleteUserQuery);

                // 3. Delete user registered courses  
                // Delete from the course registered table  
                $deleteUserQuery = "DELETE FROM course_registered WHERE user_ID = '$userID'";
                mysqli_query($trainmastas_conn, $deleteUserQuery);

                // 4. Delete from the authentication table  
                $deleteAuthQuery = "DELETE FROM authentication WHERE user_ID = '$userID'";
                mysqli_query($trainmastas_conn, $deleteAuthQuery);

                // 5. Delete image from the profile folder (if it exists)  
                if ($userImage && file_exists("../profile/$userImage")) {
                    unlink("../profile/$userImage");
                }

                // 5. Insert into the user_deleted table  
                $deleteRecordQuery = "INSERT INTO user_deleted (user_ID, email, admin_ID, type, date)   
                       VALUES ('$userID', '$userEmail', '$adminID', 's', NOW())";
                mysqli_query($trainmastas_conn, $deleteRecordQuery);
            }
        }

        // Commit the transaction after all deletions are successful
        mysqli_commit($trainmastas_conn);
        echo json_encode(['state' => 'deleted_success', 'message' => 'Users deleted successfully.', 'userNotCleared' => $userNotCleared]);
    } else {
        echo json_encode(['state' => 'no_users', 'message' => 'No users found with action = "d".']);
    }
} else if (isset($_POST['purpose']) && !empty($_POST['id']) && ($_POST['purpose'] == "deleteThis" || $_POST['purpose'] == "banThis" || $_POST['purpose'] == "restoreThis" || $_POST['purpose'] == "unBanThis")) {
    // Decode the user ID from base64
    $userID = base64_decode($_POST['id']);

    $action = '';
    $successMessage = '';
    $state = "error";
    // Determine the action based on the purpose
    if ($_POST['purpose'] == "deleteThis") {
        $action = 'd';
        $state = "user_marked_deleted";
        $successMessage = 'User marked for deletion.';
    } else if ($_POST['purpose'] == "banThis") {
        $action = 'b';
        $state = "user_marked_banned";
        $successMessage = 'User marked as banned.';
    } else {
        $state = "user_delete_free";
        if ($_POST['purpose'] == "unBanThis") {
            $state = "user_ban_free";
        }
        $action = 'n';
        $successMessage = 'User marked as no action restriction.';
    }

    // If action is valid, proceed with the update
    if (!empty($action)) {
        $updateActionQuery = "UPDATE user SET action = ? WHERE user_ID = ?";
        $stmt = mysqli_prepare($trainmastas_conn, $updateActionQuery);

        // Bind parameters to the statement  
        mysqli_stmt_bind_param($stmt, 'ss', $action, $userID);

        // Execute the prepared statement  
        $updateResult = mysqli_stmt_execute($stmt);
        // Check if the update was successful  
        if ($updateResult && mysqli_stmt_affected_rows($stmt) > 0) {
            echo json_encode(['state' => $state, 'message' => $successMessage]);
        } else {
            echo json_encode(['state' => "error", 'message' => 'Failed to update user action or user not found.']);
        }
    } else {
        echo json_encode(['state' => "error", 'message' => 'Invalid action specified.']);
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "sentThisUserDetails" && !empty($_POST['id'])) {
    // Decode the user ID from base64
    $user_id = base64_decode($_POST['id']);

    // Fetch user details from user
    $userDetailsQuery = "SELECT u.user_ID, u.Name, u.Description, u.type, u.Image, u.action, u.Date, ua.Email 
                         FROM user u 
                         LEFT JOIN authentication ua 
                         ON u.user_ID = ua.user_ID 
                         WHERE u.user_ID = '$user_id' AND u.type = 's'";
    $userDetailsResult = mysqli_query($trainmastas_conn, $userDetailsQuery);

    // Check if the user exists
    if ($userDetailsResult && mysqli_num_rows($userDetailsResult) > 0) {
        $userDetails = mysqli_fetch_assoc($userDetailsResult);
        $userDetails["user_ID"] = base64_encode($userDetails["user_ID"]);
        $userDetails["Name"] = decodeHtml($userDetails["Name"]);
        $userDetails["Description"] = decodeHtml($userDetails["Description"]);
        // Fetch total count of registered courses
        $coursesCountQuery = "SELECT COUNT(*) AS totalCourses 
                              FROM course_registered 
                              WHERE user_ID = '$user_id'";
        $coursesCountResult = mysqli_query($trainmastas_conn, $coursesCountQuery);
        $totalCourses = ($coursesCountResult && mysqli_num_rows($coursesCountResult) > 0)
            ? mysqli_fetch_assoc($coursesCountResult)['totalCourses']
            : 0;

        // Fetch course registrations (5 at a time)
        $coursePage = isset($_POST['coursePage']) ? intval($_POST['coursePage']) : 1;
        $itemsPerPage = 5;
        $offset = ($coursePage - 1) * $itemsPerPage;

        $coursesQuery = "SELECT cr.course_ID, cr.Level, c.Title, c.Num_test, cr.Date 
                 FROM course_registered cr 
                 JOIN course c 
                 ON c.course_ID = cr.course_ID 
                 WHERE cr.user_ID = '$user_id' 
                 LIMIT $offset, $itemsPerPage";

        $coursesResult = mysqli_query($trainmastas_conn, $coursesQuery);
        $courseData = [];

        if ($coursesResult && mysqli_num_rows($coursesResult) > 0) {
            while ($course = mysqli_fetch_assoc($coursesResult)) {
                $course["course_ID"] = base64_encode($course["course_ID"]);
                $course["Title"] = decodeHtml($course["Title"]);

                // Fetch all scores for this course
                $course_id = base64_decode($course["course_ID"]);
                $scoresQuery = "SELECT Attempt_num, Answers, Score, Date AS ScoreDate 
                        FROM course_score 
                        WHERE course_ID = '$course_id' AND user_ID = '$user_id'";
                $scoresResult = mysqli_query($trainmastas_conn, $scoresQuery);

                $scores = [];
                if ($scoresResult && mysqli_num_rows($scoresResult) > 0) {
                    while ($score = mysqli_fetch_assoc($scoresResult)) {
                        $scores[] = $score;
                    }
                }
                $course["Scores"] = $scores; // Add all scores for this course
                $courseData[] = $course;
            }
        }

        // Fetch total count of feedback
        $feedbackCountQuery = "SELECT COUNT(*) AS totalFeedback 
                               FROM course_feedback 
                               WHERE feedback_giver_ID = '$user_id'";
        $feedbackCountResult = mysqli_query($trainmastas_conn, $feedbackCountQuery);
        $totalFeedback = ($feedbackCountResult && mysqli_num_rows($feedbackCountResult) > 0)
            ? mysqli_fetch_assoc($feedbackCountResult)['totalFeedback']
            : 0;

        // Fetch course feedback (5 at a time)
        $feedbackPage = isset($_POST['feedbackPage']) ? intval($_POST['feedbackPage']) : 1;
        $offset = ($feedbackPage - 1) * $itemsPerPage;

        $feedbackQuery = "SELECT cf.course_ID, cf.feedback_giver_ID, cf.Feedback, cf.Rate, cf.Date, 
                                 c.Title AS courseTitle, u.user_ID AS creator_ID, u.Name AS creatorName
                          FROM course_feedback cf
                          JOIN course c 
                          ON cf.course_ID = c.course_ID
                          JOIN user u 
                          ON c.user_ID = u.user_ID
                          WHERE cf.feedback_giver_ID = '$user_id' 
                          LIMIT $offset, $itemsPerPage";
        $feedbackResult = mysqli_query($trainmastas_conn, $feedbackQuery);
        $feedbackData = [];
        if ($feedbackResult && mysqli_num_rows($feedbackResult) > 0) {
            while ($feedback = mysqli_fetch_assoc($feedbackResult)) {
                $feedback["course_ID"] = base64_encode($feedback["course_ID"]);
                $feedback["feedback_giver_ID"] = base64_encode($feedback["feedback_giver_ID"]);
                $feedback["courseTitle"] = decodeHtml($feedback["courseTitle"]);
                $feedback["creatorName"] = decodeHtml($feedback["creatorName"]);
                $feedback["creator_ID"] = base64_encode($feedback["creator_ID"]);
                $feedbackData[] = $feedback;
            }
        }

        // Fetch fields from the `fields` table (up to 10 fields)
        $fieldsQuery = "SELECT field_num, Field 
                        FROM fields 
                        WHERE user_ID = '$user_id' 
                        LIMIT 10";
        $fieldsResult = mysqli_query($trainmastas_conn, $fieldsQuery);
        $fieldsData = [];
        if ($fieldsResult && mysqli_num_rows($fieldsResult) > 0) {
            while ($field = mysqli_fetch_assoc($fieldsResult)) {
                $fieldsData[] = $field;
            }
        }

        // Send response
        echo json_encode([
            'state' => 'successFetching',
            'userDetails' => $userDetails,
            'totalCourses' => $totalCourses,
            'totalFeedback' => $totalFeedback,
            'registeredCourses' => $courseData,
            'courseFeedback' => $feedbackData,
            'fields' => $fieldsData,
        ]);
    } else {
        echo json_encode(['state' => 'notfound', 'message' => 'User not found or is not a student.']);
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "fetchFeedback" && !empty($_POST['id']) && isset($_POST['page'])) {
    // Decode the user ID from base64
    $user_id = base64_decode($_POST['id']);
    $page = intval($_POST['page']);
    $itemsPerPage = 5;
    $offset = ($page - 1) * $itemsPerPage;

    // Fetch course feedback
    $feedbackQuery = "SELECT cf.course_ID, cf.feedback_giver_ID, cf.Feedback, cf.Rate, cf.Date, 
                             c.Title AS courseTitle, u.user_ID AS creator_ID, u.Name AS creatorName
                      FROM course_feedback cf
                      JOIN course c 
                      ON cf.course_ID = c.course_ID
                      JOIN user u 
                      ON c.user_ID = u.user_ID
                      WHERE cf.feedback_giver_ID = '$user_id' 
                      LIMIT $offset, $itemsPerPage";
    $feedbackResult = mysqli_query($trainmastas_conn, $feedbackQuery);
    $feedbackData = [];
    if ($feedbackResult && mysqli_num_rows($feedbackResult) > 0) {
        while ($feedback = mysqli_fetch_assoc($feedbackResult)) {
            $feedback["course_ID"] = base64_encode($feedback["course_ID"]);
            $feedback["feedback_giver_ID"] = base64_encode($feedback["feedback_giver_ID"]);
            $feedback["creator_ID"] = base64_encode($feedback["creator_ID"]);
            $feedbackData[] = $feedback;
        }
    }

    // Send response
    echo json_encode([
        'state' => 'successFetchingFeedback',
        'courseFeedback' => $feedbackData,
    ]);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "fetchRegistered" && !empty($_POST['id']) && isset($_POST['page'])) {
    // Fetch Registered Courses Section
    // Decode the user ID from base64
    $user_id = base64_decode($_POST['id']);
    $page = intval($_POST['page']);
    $itemsPerPage = 5;
    $offset = ($page - 1) * $itemsPerPage;

    // // Fetch registered courses
    // $coursesQuery = "SELECT cr.course_ID, cr.Level, c.Title, cr.Date, cs.Attempt_num, cs.Answers, cs.Score, cs.Date AS ScoreDate 
    //     FROM course_registered cr JOIN course c ON c.course_ID = cr.course_ID LEFT JOIN 
    //     course_score cs ON cr.course_ID = cs.course_ID AND cr.user_ID = cs.user_ID WHERE cr.user_ID = '$user_id' 
    //     LIMIT $offset, $itemsPerPage";
    // $coursesResult = mysqli_query($trainmastas_conn, $coursesQuery);
    // $courseData = [];
    // if ($coursesResult && mysqli_num_rows($coursesResult) > 0) {
    //     while ($course = mysqli_fetch_assoc($coursesResult)) {
    //         $course["course_ID"] = base64_encode($course["course_ID"]);
    //         $course["creator_ID"] = base64_encode($course["creator_ID"]);
    //         $courseData[] = $course;
    //     }
    // }
    // Fetch course registrations (5 at a time)
    $coursePage = isset($_POST['coursePage']) ? intval($_POST['coursePage']) : 1;
    $itemsPerPage = 5;
    $offset = ($coursePage - 1) * $itemsPerPage;

    $coursesQuery = "SELECT cr.course_ID, cr.Level, c.Title,c.Num_test, cr.Date 
                 FROM course_registered cr 
                 JOIN course c 
                 ON c.course_ID = cr.course_ID 
                 WHERE cr.user_ID = '$user_id' 
                 LIMIT $offset, $itemsPerPage";

    $coursesResult = mysqli_query($trainmastas_conn, $coursesQuery);
    $courseData = [];

    if ($coursesResult && mysqli_num_rows($coursesResult) > 0) {
        while ($course = mysqli_fetch_assoc($coursesResult)) {
            $course["course_ID"] = base64_encode($course["course_ID"]);
            $course["Title"] = decodeHtml($course["Title"]);

            // Fetch all scores for this course
            $course_id = base64_decode($course["course_ID"]);
            $scoresQuery = "SELECT Attempt_num, Answers, Score, Date AS ScoreDate 
                        FROM course_score 
                        WHERE course_ID = '$course_id' AND user_ID = '$user_id'";
            $scoresResult = mysqli_query($trainmastas_conn, $scoresQuery);

            $scores = [];
            if ($scoresResult && mysqli_num_rows($scoresResult) > 0) {
                while ($score = mysqli_fetch_assoc($scoresResult)) {
                    $scores[] = $score;
                }
            }
            $course["Scores"] = $scores; // Add all scores for this course
            $courseData[] = $course;
        }
    }

    // Send response
    echo json_encode([
        'state' => 'successFetchingRegistered',
        'registeredCourses' => $courseData,
    ]);
} else {
    echo json_encode(["state" => "error", "message" => "Invalid purpose."]);
}
include "close_connection.php";
