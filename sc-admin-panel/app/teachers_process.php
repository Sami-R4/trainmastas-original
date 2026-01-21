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
if (isset($_POST['purpose']) && ($_POST['purpose'] === 'allUsers' || $_POST['purpose'] === 'bannedUsers' || $_POST['purpose'] === 'deletedUsers' || $_POST['purpose'] === 'admittedUsers' || $_POST['purpose'] === 'requestedUsers' || $_POST['purpose'] === 'noActionUsers')) {
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
    } elseif ($_POST['purpose'] === 'requestedUsers') {
        $actionFilter = "AND u.action != 'd' AND u.action != 'b' AND u.verified_submitted_date IS NOT NULL ";  // Filter banned users
    } elseif ($_POST['purpose'] === 'admittedUsers') {
        $actionFilter = "AND u.action != 'd' AND u.action != 'b'  AND u.verified IS NOT NULL ";  // Filter users with no action
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

    // Query to get teachers and the number of courses they registered for with pagination
    $query = "SELECT u.user_ID, u.Name, ua.Email, u.Date, u.action, u.Image, COUNT(cr.course_ID) AS registered_courses, COUNT(c.course_ID) AS produced_courses
        FROM user u 
        LEFT JOIN course_registered cr 
        ON u.user_ID = cr.user_ID 
        LEFT JOIN course c 
        ON u.user_ID = c.user_ID 
        LEFT JOIN authentication ua 
        ON u.user_ID = ua.user_ID 
        WHERE u.type = 'c'  $actionFilter
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
            WHERE u.type = 'c' $actionFilter
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
    if ($_SESSION['AdminType'] !== "super") {
        echo json_encode(["state" => "notAuthorized", "message" => "User authorized."]);
        include "close_connection.php";
        exit;
    }
    $deletedUsers = $_POST['filterValue'];
    $adminID = $_SESSION['AID'];  // Assuming admin ID is stored in session

    // Fetch all users with action = 'd'
    $usersQuery = "SELECT u.user_ID, u.Name, ua.Email, u.Image 
    FROM user u
    LEFT JOIN authentication ua 
    ON u.user_ID = ua.user_ID
    WHERE u.action = 'd' AND u.type='c'";
    $usersResult = mysqli_query($trainmastas_conn, $usersQuery);

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
            if (!$premiumResult) {
                die('Query Error: ' . mysqli_error($trainmastas_conn));
            }
            $premiumRow = mysqli_fetch_assoc($premiumResult);
            $hasPremiumCourse = $premiumRow['count'] > 0;

            // 2. Check if the user's created courses have registered users  
            $checkUserCoursesQuery = "  
                SELECT c.course_ID  
                FROM course c  
                LEFT JOIN course_registered cr ON c.course_ID = cr.course_ID  
                WHERE c.user_ID = '$userID' AND cr.course_ID IS NOT NULL  
            ";
            $userCoursesResult = mysqli_query($trainmastas_conn, $checkUserCoursesQuery);
            if (!$userCoursesResult) {
                die('Query Error: ' . mysqli_error($trainmastas_conn));
            }

            // Check if there are registered users for the user's created courses  
            $hasRegisteredUsers = mysqli_num_rows($userCoursesResult) > 0;

            // 3. Skip deletion if either condition is true  
            if ($hasPremiumCourse || $hasRegisteredUsers) {
                // User has premium courses or registered users, skip deletion  
                $userNotCleared[] = $userRow['Name'];
                continue;
            }

            // 4. Proceed with deletion from the user table if no premium courses found and no registered users  
            // Delete from the user table  
            $deleteUserQuery = "DELETE FROM user WHERE user_ID = '$userID'";
            mysqli_query($trainmastas_conn, $deleteUserQuery);

            // Delete from the course registered table  
            $deleteRegisteredCoursesQuery = "DELETE FROM course_registered WHERE user_ID = '$userID'";
            mysqli_query($trainmastas_conn, $deleteRegisteredCoursesQuery);

            $getCourseIdsQuery = "SELECT course_ID FROM course WHERE user_ID = '$userID'";
            $result = mysqli_query($trainmastas_conn, $getCourseIdsQuery);

            if ($result && mysqli_num_rows($result) > 0) {
                // Step 2: Prepare an array to hold course_IDs  
                $courseIds = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $courseIds[] = $row['course_ID'];
                }

                // Step 3: If we have course_IDs, create and execute the delete query  
                if (!empty($courseIds)) {
                    // Turn the array into a comma-separated string for the SQL query  
                    // Use single quotes around each ID for non-integer values  
                    $courseIdsString = "'" . implode("','", $courseIds) . "'";

                    // Now delete from course_modules based on the course_IDs found  
                    $deleteCourseModulesQuery = "DELETE FROM course_modules WHERE course_ID IN ($courseIdsString)";
                    mysqli_query($trainmastas_conn, $deleteCourseModulesQuery);
                    // Now delete from course_modules based on the course_IDs found  
                    $deleteCourseModulesQuery = "DELETE FROM course_video WHERE course_ID IN ($courseIdsString)";
                    mysqli_query($trainmastas_conn, $deleteCourseModulesQuery);
                    $deleteCourseModulesQuery = "DELETE FROM course_scope WHERE course_ID IN ($courseIdsString)";
                    mysqli_query($trainmastas_conn, $deleteCourseModulesQuery);
                    $deleteCourseModulesQuery = "DELETE FROM course_score WHERE course_ID IN ($courseIdsString)";
                    mysqli_query($trainmastas_conn, $deleteCourseModulesQuery);
                    $deleteCourseModulesQuery = "DELETE FROM course_test WHERE course_ID IN ($courseIdsString)";
                    mysqli_query($trainmastas_conn, $deleteCourseModulesQuery);
                }
            }
            // Delete from the course table  
            $deleteRegisteredCoursesQuery = "DELETE FROM course WHERE user_ID = '$userID'";
            mysqli_query($trainmastas_conn, $deleteRegisteredCoursesQuery);

            // Delete from the authentication table  
            $deleteAuthQuery = "DELETE FROM authentication WHERE user_ID = '$userID'";
            mysqli_query($trainmastas_conn, $deleteAuthQuery);

            // Delete image from the profile folder (if it exists)  
            if ($userImage && file_exists("../profile/$userImage")) {
                unlink("../profile/$userImage");
            }

            // Insert into the user_deleted table  
            $deleteRecordQuery = "INSERT INTO user_deleted (user_ID, email, admin_ID, type, date)   
                   VALUES ('$userID', '$userEmail', '$adminID', 's', NOW())";
            mysqli_query($trainmastas_conn, $deleteRecordQuery);
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

    //     $userDetailsQuery = "  
    //     SELECT   
    //         u.user_ID,   
    //         u.Name,   
    //         u.Description,   
    //         u.type AS user_type,   
    //         u.Image,   
    //         u.action,   
    //         u.Date,   
    //         ua.Email,   
    //         li.link,  
    //         li.type AS link_type  
    //     FROM   
    //         user u   
    //     LEFT JOIN   
    //         authentication ua ON u.user_ID = ua.user_ID   
    //     LEFT JOIN   
    //         user_link li ON u.user_ID = li.user_ID   
    //     WHERE   
    //         u.user_ID = '$user_id'   
    //         AND u.type = 'c'  
    // ";

    $userDetailsQuery = "SELECT u.user_ID, u.Name, u.Description, u.type AS user_type, u.Image, u.action, u.Date, ua.Email, li.link, li.type AS link_type, u.verified_submitted_date, u.verified, 
    tr.Reason AS rejection_reason, tr.reapplied FROM user u LEFT JOIN authentication ua ON u.user_ID = ua.user_ID LEFT JOIN user_link li 
    ON u.user_ID = li.user_ID LEFT JOIN teachers_rejected tr ON u.user_ID = tr.user_ID WHERE u.user_ID = '$user_id' AND u.type = 'c'";
    $userDetailsResult = mysqli_query($trainmastas_conn, $userDetailsQuery);

    // Check if the user exists
    if ($userDetailsResult && mysqli_num_rows($userDetailsResult) > 0) {
        while ($row = mysqli_fetch_assoc($userDetailsResult)) {
            // If user is not yet added, add their general info  
            if (empty($userDetails)) {
                $userDetails = [
                    "user_ID" => base64_encode($row["user_ID"]),
                    "Name" => decodeHtml($row["Name"]),
                    "Description" => decodeHtml($row["Description"]),
                    "user_type" => $row["user_type"],
                    "Image" => $row["Image"],
                    "action" => $row["action"],
                    "Date" => $row["Date"],
                    "Email" => $row["Email"],
                    "links" => [] // Initialize an empty array for links  
                ];

                $applied = false;
                $reapplied = false;
                $rejection_reason = null;

                // Check if user submitted verification
                if (!empty($row["verified_submitted_date"])) {
                    $applied = true;

                    // Check if rejected
                    if (!empty($row["rejection_reason"])) {
                        $rejection_reason = decodeHtml($row["rejection_reason"]);
                        $reapplied = ($row["reapplied"] == 1);
                    }
                }

                $userDetails["applied"] = $applied;

                if (!is_null($rejection_reason)) {
                    $userDetails["rejected"] = true;
                    $userDetails["reapplied"] = $reapplied;
                    $userDetails["rejection_reason"] = $rejection_reason;
                } else {
                    $userDetails["rejected"] = false;
                }
            }

            // Append the current link and link type to the links array  
            if ($row["link"] !== null) { // Check to avoid NULL links  
                $userDetails["links"][] = [
                    "link" => $row["link"],
                    "link_type" => $row["link_type"],
                ];
            }
        }
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

        // / Fetch created courses
        $coursesQuery = "SELECT c.course_ID, COUNT(cr.course_ID) AS registered, c.Title, c.action, c.Num_test, c.Cost, c.Num_modules, c.Date   
        FROM course c   
        JOIN course_registered cr   
        ON c.course_ID = cr.course_ID   
        WHERE c.user_ID = '$user_id'   
        GROUP BY c.course_ID   
        LIMIT $offset, $itemsPerPage";
        $coursesCreatedResult = mysqli_query($trainmastas_conn, $coursesQuery);
        $courseCreatedData = [];

        if ($coursesCreatedResult && mysqli_num_rows($coursesCreatedResult) > 0) {
            while ($course = mysqli_fetch_assoc($coursesCreatedResult)) {
                $course["course_ID"] = base64_encode($course["course_ID"]);
                $course["Title"] = decodeHtml($course["Title"]);
                $courseCreatedData[] = $course;
            }
        }
        // Fetch total count of created courses
        $coursesCreatedCountQuery = "SELECT COUNT(*) AS totalCreatedCourses 
        FROM course c   
        JOIN course_registered cr   
        ON c.course_ID = cr.course_ID   
        WHERE c.user_ID = '$user_id'";
        $coursesCreatedCountResult = mysqli_query($trainmastas_conn, $coursesCreatedCountQuery);
        $totalCreatedCourses = ($coursesCreatedCountResult && mysqli_num_rows($coursesCreatedCountResult) > 0)
            ? mysqli_fetch_assoc($coursesCreatedCountResult)['totalCreatedCourses']
            : 0;

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
            'totalCreatedCourses' => $totalCreatedCourses,
            'totalFeedback' => $totalFeedback,
            'registeredCourses' => $courseData,
            'createdCourses' => $courseCreatedData,
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
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "fetchCreated" && !empty($_POST['id']) && isset($_POST['page'])) {
    // Fetch Created Courses Section  
    // Decode the user ID from base64  
    $user_id = base64_decode($_POST['id']);
    $page = intval($_POST['page']);
    $itemsPerPage = 5;

    // Fetch created courses (5 at a time)  
    $coursePage = isset($_POST['coursePage']) ? intval($_POST['coursePage']) : 1;
    $offset = ($coursePage - 1) * $itemsPerPage;

    // Fetch created courses with registration count  
    $coursesQuery = "SELECT c.course_ID, COUNT(cr.course_ID) AS registered, c.Title, c.action, c.Num_test, c.Cost, c.Num_modules, c.Date   
                     FROM course c   
                     LEFT JOIN course_registered cr   
                     ON c.course_ID = cr.course_ID   
                     WHERE c.user_ID = '$user_id'   
                     GROUP BY c.course_ID   
                     LIMIT $offset, $itemsPerPage";

    $coursesCreatedResult = mysqli_query($trainmastas_conn, $coursesQuery);
    $courseCreatedData = [];

    if ($coursesCreatedResult && mysqli_num_rows($coursesCreatedResult) > 0) {
        while ($course = mysqli_fetch_assoc($coursesCreatedResult)) {
            $course["course_ID"] = base64_encode($course["course_ID"]);
            $course["Title"] = decodeHtml($course["Title"]);
            $courseCreatedData[] = $course;
        }
    }

    // Fetch total count of created courses  
    $coursesCreatedCountQuery = "SELECT COUNT(*) AS totalCreatedCourses   
                                  FROM course c   
                                  JOIN course_registered cr   
                                  ON c.course_ID = cr.course_ID   
                                  WHERE c.user_ID = '$user_id'";
    $coursesCreatedCountResult = mysqli_query($trainmastas_conn, $coursesCreatedCountQuery);
    $totalCreatedCourses = ($coursesCreatedCountResult && mysqli_num_rows($coursesCreatedCountResult) > 0)
        ? mysqli_fetch_assoc($coursesCreatedCountResult)['totalCreatedCourses']
        : 0;

    // Send response  
    echo json_encode([
        'state' => 'successFetchingCreated',
        'createdCourses' => $courseCreatedData,
        'totalCreatedCourses' => $totalCreatedCourses,
    ]);
} else if (isset($_POST['purpose']) && ($_POST['purpose'] === "approve" || $_POST['purpose'] === "reject")) {
    $user_ID = base64_decode(trim($_POST['id']));
    $purpose = $_POST['purpose'];

    if (empty($user_ID)) {
        echo json_encode([
            'state' => 'error',
            'message' => 'Missing user ID.'
        ]);
        include "close_connection.php";
        exit;
    }

    if ($purpose === "approve") {
        // ✅ Approve the teacher
        $verify_sql = "UPDATE user SET verified = 1 WHERE user_ID = ?";
        $verify_stmt = $trainmastas_conn->prepare($verify_sql);
        $verify_stmt->bind_param("s", $user_ID);

        if ($verify_stmt->execute()) {
            // Remove from rejected list (if previously rejected)
            $del_sql = "DELETE FROM teachers_rejected WHERE user_ID = ?";
            $del_stmt = $trainmastas_conn->prepare($del_sql);
            $del_stmt->bind_param("s", $user_ID);
            $del_stmt->execute();
            $del_stmt->close();

            echo json_encode([
                'state' => 'userValidated',
                'message' => 'Teacher has been approved successfully.'
            ]);
            // EMAIL TO BE SENT
        } else {
            echo json_encode([
                'state' => 'error',
                'message' => 'Failed to approve the teacher.'
            ]);
        }

        $verify_stmt->close();
    } else if ($purpose === "reject") {
        // ❌ Reject the teacher
        $reason = trim($_POST['page'] ?? '');

        if (empty($reason)) {
            // EMAIL TO BE SENT

            echo json_encode([
                'state' => 'error',
                'message' => 'Please provide a reason for rejection.'
            ]);
            include "close_connection.php";
            exit;
        }

        $date = date("Y-m-d H:i:s");

        // Check if already rejected
        $check_sql = "SELECT user_ID FROM teachers_rejected WHERE user_ID = ?";
        $check_stmt = $trainmastas_conn->prepare($check_sql);
        $check_stmt->bind_param("s", $user_ID);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Update existing rejection
            $update_sql = "UPDATE teachers_rejected SET Reason = ?, reapplied = 0, Date = ? WHERE user_ID = ?";
            $update_stmt = $trainmastas_conn->prepare($update_sql);
            $update_stmt->bind_param("sss", $reason, $date, $user_ID);
            $update_stmt->execute();
            $update_stmt->close();
        } else {
            // Insert new rejection
            $insert_sql = "INSERT INTO teachers_rejected (user_ID, Reason, reapplied, Date) VALUES (?, ?, 0, ?)";
            $insert_stmt = $trainmastas_conn->prepare($insert_sql);
            $insert_stmt->bind_param("sss", $user_ID, $reason, $date);
            $insert_stmt->execute();
            $insert_stmt->close();
        }

        // Ensure user is marked as not verified
        $reset_sql = "UPDATE user SET verified = 0 WHERE user_ID = ?";
        $reset_stmt = $trainmastas_conn->prepare($reset_sql);
        $reset_stmt->bind_param("s", $user_ID);
        $reset_stmt->execute();
        $reset_stmt->close();

        echo json_encode([
            'state' => 'userRejected',
            'message' => 'Teacher has been rejected successfully.'
        ]);

        $check_stmt->close();
    } else {
        echo json_encode([
            'state' => 'error',
            'message' => 'Invalid purpose provided.'
        ]);
    }
} else {
    echo json_encode(["state" => "error", "message" => "Invalid purpose."]);
}
include "close_connection.php";
