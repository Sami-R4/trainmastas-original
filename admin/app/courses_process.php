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
// allCourses, bannedCourses, deletedCourses, noActionCourses
if (isset($_POST['purpose']) && ($_POST['purpose'] === 'allCourses' ||  $_POST['purpose'] === 'submittedCourses' || $_POST['purpose'] === 'bannedCourses' || $_POST['purpose'] === 'rejectedCourses'  || $_POST['purpose'] === "editingCourses" || $_POST['purpose'] === 'deletedCourses' || $_POST['purpose'] === 'noActionCourses')) {
    $filterValue = isset($_POST['filterValue']) ? $_POST['filterValue'] : null;
    $AdminType = $_SESSION['AdminType'];

    // Define action filters
    $actionFilter = "";
    $where = "";
    $and = '';
    if ($_POST['purpose'] === 'deletedCourses') {
        $actionFilter = " c.action = 'd' ";
        $where = " WHERE ";
    } elseif ($_POST['purpose'] === 'bannedCourses') {
        $actionFilter = " c.action = 'b' ";
        $where = " WHERE ";
    } elseif ($_POST['purpose'] === 'noActionCourses') {
        $actionFilter = " c.action = 'n' ";
        $where = " WHERE ";
        //
    } elseif ($_POST['purpose'] === 'editingCourses') {
        $actionFilter = " c.action = 'e' AND c.submitted_date IS NULL";
        $where = " WHERE ";
    } elseif ($_POST['purpose'] === 'submittedCourses') {
        $actionFilter = " c.action = 'e' AND c.submitted_date IS NOT NULL";
        $where = " WHERE ";
    } elseif ($_POST['purpose'] === 'rejectedCourses') {
        $actionFilter = " c.action = 'e' AND crr.course_ID IS NOT NULL";
        $where = " WHERE ";
    } else {
        $actionFilter = "";
    }
    // Validate filterValue
    $filterCondition = "";
    if ($filterValue !== null && $filterValue !== "") {
        $filterValue = strtolower($filterValue);
        $where = " WHERE ";
        if ($actionFilter != "") {
            $and = " AND ";
        }
        $filterCondition = "AND (c.Title LIKE '%$filterValue%' OR c.Description LIKE '%$filterValue%' OR c.Category LIKE '%$filterValue%' OR u.Name LIKE '%$filterValue%')";
        // $filterCondition = " WHERE LOWER(c.Title) = '%$filterValue%' OR LOWER(c.Description) = '%$filterValue%' OR LOWER(c.Category) = '%$filterValue%' OR LOWER(u.Name) = '%$filterValue%'";
    }

    // Pagination setup
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $items_per_page = 20;
    $offset = ($page - 1) * $items_per_page;

    // Query to fetch course details along with creator info and statistics
    $query = "
        SELECT 
            c.course_ID, c.Title, c.Description, c.Category, c.Cover_image, c.Cost, c.action, c.Num_modules, c.Num_test, c.Date, c.submitted_date, 
            u.Name AS creator_name, u.Image AS creator_image, crr.date AS rejected_date,
            COUNT(DISTINCT cr.user_ID) AS registered_users,
            COUNT(DISTINCT CASE WHEN cr.Level != 'c' THEN cr.user_ID END) AS active_users,
            COUNT(DISTINCT cf.feedback_giver_ID) AS feedback_count
        FROM course c
        LEFT JOIN user u ON c.user_ID = u.user_ID
        LEFT JOIN course_registered cr ON c.course_ID = cr.course_ID
        LEFT JOIN course_feedback cf ON c.course_ID = cf.course_ID
        LEFT JOIN courses_rejected crr ON c.course_ID = crr.course_ID
        $where $actionFilter $filterCondition
        GROUP BY c.course_ID, u.Name, u.Image
        ORDER BY c.Date DESC
        LIMIT $offset, $items_per_page
    ";
    // Count total courses
    $count = "
        SELECT COUNT(*) AS total_courses FROM (
            SELECT c.course_ID 
            FROM course c
            LEFT JOIN user u ON c.user_ID = u.user_ID
            LEFT JOIN course_registered cr ON c.course_ID = cr.course_ID
            LEFT JOIN course_feedback cf ON c.course_ID = cf.course_ID
            LEFT JOIN courses_rejected crr ON c.course_ID = crr.course_ID
            $where $actionFilter $filterCondition
            GROUP BY c.course_ID
        ) AS filtered_courses
    ";
    $result = mysqli_query($trainmastas_conn, $query);
    $result_count = mysqli_query($trainmastas_conn, $count);

    $data = [];
    $total_courses = 0;
    // echo $query;
    if ($result && mysqli_num_rows($result) > 0) {
        $state = "success";
        while ($row = mysqli_fetch_assoc($result)) {
            $row['course_ID'] = base64_encode($row['course_ID']);
            $row['Title'] = decodeHtml($row['Title']);
            $row['Description'] = decodeHtml($row['Description']);
            $row['creator_name'] = decodeHtml($row['creator_name']);
            $row['Category'] = decodeHtml($row['Category']);
            $data[] = $row;
        }
    } else {
        $state = "success";
    }

    if ($result_count && $row_count = mysqli_fetch_assoc($result_count)) {
        $total_courses = $row_count['total_courses'];
    }

    echo json_encode(['state' => $state, 'data' => $data, 'total_courses' => $total_courses, 'user_type' => $AdminType]);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "clearAll") {
    if ($_SESSION['AdminType'] !== "super") {
        echo json_encode(["state" => "notAuthorized", "message" => "User not authorized."]);
        include "close_connection.php";
        exit;
    }

    $deletedCourses = $_POST['filterValue'];
    $adminID = $_SESSION['AID'];  // Assuming admin ID is stored in session

    // Fetch all courses with action = 'd'
    $coursesQuery = "SELECT c.course_ID, c.Cover_image FROM course c WHERE c.action = 'd'";
    $coursesResult = mysqli_query($trainmastas_conn, $coursesQuery);

    if ($coursesResult && mysqli_num_rows($coursesResult) > 0) {
        while ($courseRow = mysqli_fetch_assoc($coursesResult)) {
            $courseID = $courseRow['course_ID'];
            $courseImage = $courseRow['Cover_image'];

            // Check if the course has registered users
            $checkRegisteredQuery = "SELECT COUNT(*) as user_count FROM course_registered WHERE course_ID = '$courseID'";
            $checkRegisteredResult = mysqli_query($trainmastas_conn, $checkRegisteredQuery);
            $registeredData = mysqli_fetch_assoc($checkRegisteredResult);

            if ($registeredData['user_count'] > 0) {
                // Skip deletion if the course has registered users
                continue;
            }
            // 1. Delete from the course table
            $deleteCourseQuery = "DELETE FROM course WHERE course_ID = '$courseID'";
            mysqli_query($trainmastas_conn, $deleteCourseQuery);

            // 2. Delete related records (modules, tests, enrollments, etc.)
            $deleteModulesQuery = "DELETE FROM modules WHERE course_ID = '$courseID'";
            mysqli_query($trainmastas_conn, $deleteModulesQuery);

            $deleteTestsQuery = "DELETE FROM tests WHERE course_ID = '$courseID'";
            mysqli_query($trainmastas_conn, $deleteTestsQuery);

            // 3. Delete course cover image if it exists
            if ($courseImage && file_exists("../covers/$courseImage")) {
                unlink("../covers/$courseImage");
            }
        }

        // Commit the transaction after all deletions are successful
        mysqli_commit($trainmastas_conn);
        echo json_encode(['state' => 'deleted_success', 'message' => 'Courses deleted successfully.']);
    } else {
        echo json_encode(['state' => 'no_courses', 'message' => 'No courses found with action = "d".']);
    }
} else if (isset($_POST['purpose']) && !empty($_POST['id']) && ($_POST['purpose'] == "deleteThis" || $_POST['purpose'] == "banThis" || $_POST['purpose'] == "validateThis" || $_POST['purpose'] == "restoreThis" || $_POST['purpose'] == "unBanThis")) {
    // Decode the course ID from base64
    $courseID = base64_decode($_POST['id']);

    $action = '';
    $successMessage = '';
    $state = "error";
    // Determine the action based on the purpose
    $more_SQL = '';
    if ($_POST['purpose'] == "deleteThis") {
        $action = 'd';
        $state = "course_marked_deleted";
        $successMessage = 'Course marked for deletion.';
    } else if ($_POST['purpose'] == "banThis") {
        $action = 'b';
        $state = "course_marked_banned";
        $successMessage = 'Course marked as banned.';
    } else if ($_POST['purpose'] == "validateThis") {
        $action = 'n';
        $state = "course_validated";
        $more_SQL = ' , `submitted_date` = null, `validated_date` = now()';
        $successMessage = 'Course was validated.';
    } else {
        $state = "course_delete_free";
        if ($_POST['purpose'] == "unBanThis") {
            $state = "course_ban_free";
        }
        $action = 'n';
        $successMessage = 'Course marked as no action restriction.';
    }

    // If action is valid, proceed with the update
    if (!empty($action)) {
        if ($action == "d") {
            // Define the SQL query  
            $checkQuery = "SELECT COUNT(DISTINCT user_ID) AS registered_users FROM course_registered WHERE course_ID = ?";
            $stmt_temp = mysqli_prepare($trainmastas_conn, $checkQuery);
            mysqli_stmt_bind_param($stmt_temp, 's', $courseID);
            mysqli_stmt_execute($stmt_temp);
            mysqli_stmt_bind_result($stmt_temp,  $registered_users);
            mysqli_stmt_fetch($stmt_temp);
            if ($registered_users != 0) {
                echo json_encode(['state' => "hasRegistered", 'message' => 'Course can not be deleted. It has deleted users']);
                mysqli_stmt_close($stmt_temp);
                include "close_connection.php";
                exit;
            }
            mysqli_stmt_close($stmt_temp);
        }
        $updateActionQuery = "UPDATE course SET action = ? $more_SQL WHERE course_ID = ?";
        $stmt = mysqli_prepare($trainmastas_conn, $updateActionQuery);
        // Bind parameters to the statement  

        mysqli_stmt_bind_param($stmt, 'ss', $action, $courseID);

        // Execute the prepared statement  
        $updateResult = mysqli_stmt_execute($stmt);
        // Check if the update was successful  
        if ($updateResult && mysqli_stmt_affected_rows($stmt) > 0) {
            echo json_encode(['state' => $state, 'message' => $successMessage]);
        } else {
            echo json_encode(['state' => "error", 'message' => 'Failed to update course action or course not found.']);
        }
    } else {
        echo json_encode(['state' => "error", 'message' => 'Invalid action specified.']);
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "sentThisCourseDetails" && !empty($_POST['id'])) {
    // Decode the course ID from base64
    $course_id = base64_decode($_POST['id']);
    // Fetch course registrations (5 at a time)
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $itemsPerPage = 5;
    $offset = ($page - 1) * $itemsPerPage;
    // Fetch course details along with the creator information
    $courseQuery = " 
    SELECT c.course_ID, c.user_ID, c.Title, c.Description, c.Category, c.Cover_image, 
           c.Cost, c.action, c.Num_modules, c.Num_test, c.Date, c.validated_date, c.submitted_date, crr.date AS rejected_date, 
           u.Name AS creator_name, u.Image AS creator_image
    FROM course c
    LEFT JOIN user u ON c.user_ID = u.user_ID
    LEFT JOIN courses_rejected crr ON c.course_ID = crr.course_ID
    WHERE c.course_ID = '$course_id'";
    $courseResult = mysqli_query($trainmastas_conn, $courseQuery);

    $courseData = [];
    if ($courseResult && mysqli_num_rows($courseResult) > 0) {
        $courseData = mysqli_fetch_assoc($courseResult);
        $courseData['course_ID'] = base64_encode($courseData['course_ID']);
        $courseData['user_ID'] = base64_encode($courseData['user_ID']);
        $courseData['creator_name'] = decodeHtml($courseData['creator_name']);
        $courseData['Description'] = decodeHtml($courseData['Description']);
        $courseData['Category'] = decodeHtml($courseData['Category']);
        $courseData['Title'] = decodeHtml($courseData['Title']);
    }



    // Fetch course feedback
    $feedbackQuery = "
    SELECT cf.feedback_giver_ID, cf.Feedback, cf.Rate, cf.Date, 
           u.Name AS feedback_giver_name, u.type, u.Image AS feedback_giver_image
    FROM course_feedback cf
    JOIN user u ON cf.feedback_giver_ID = u.user_ID
    WHERE cf.course_ID = '$course_id' LIMIT $offset, $itemsPerPage";
    $feedbackResult = mysqli_query($trainmastas_conn, $feedbackQuery);
    $courseFeedback = [];
    if ($feedbackResult && mysqli_num_rows($feedbackResult) > 0) {
        while ($feedback = mysqli_fetch_assoc($feedbackResult)) {
            $feedback['feedback_giver_ID'] = base64_encode($feedback['feedback_giver_ID']);
            $feedback['Feedback'] = decodeHtml($feedback['Feedback']);
            $feedback['feedback_giver_name'] = decodeHtml($feedback['feedback_giver_name']);
            $courseFeedback[] = $feedback;
        }
    }

    // Fetch total feedback count
    $totalFeedbackQuery = "SELECT COUNT(*) AS totalFeedback FROM course_feedback WHERE course_ID = '$course_id'";
    $totalFeedbackResult = mysqli_query($trainmastas_conn, $totalFeedbackQuery);
    $totalFeedback = ($totalFeedbackResult && mysqli_num_rows($totalFeedbackResult) > 0)
        ? mysqli_fetch_assoc($totalFeedbackResult)['totalFeedback']
        : 0;

    // Fetch registered users
    $registeredUsersQuery = "
    SELECT cr.user_ID, cr.Level, cr.Date, u.Name, u.Image, ua.Email 
    FROM course_registered cr
    JOIN user u ON cr.user_ID = u.user_ID
    LEFT JOIN authentication ua ON cr.user_ID = ua.user_ID
    WHERE cr.course_ID = '$course_id' LIMIT $offset, $itemsPerPage";
    $registeredUsersResult = mysqli_query($trainmastas_conn, $registeredUsersQuery);

    $registeredUsers = [];
    if ($registeredUsersResult && mysqli_num_rows($registeredUsersResult) > 0) {
        while ($user = mysqli_fetch_assoc($registeredUsersResult)) {
            $user['user_ID'] = base64_encode($user['user_ID']);
            $user['Name'] = decodeHtml($user['Name']);
            $registeredUsers[] = $user;
        }
    }

    // Fetch total registered users count
    $totalRegisteredUsersQuery = "SELECT COUNT(*) AS totalRegistered FROM course_registered WHERE course_ID = '$course_id'";
    $totalRegisteredUsersResult = mysqli_query($trainmastas_conn, $totalRegisteredUsersQuery);
    $totalRegisteredUsers = ($totalRegisteredUsersResult && mysqli_num_rows($totalRegisteredUsersResult) > 0)
        ? mysqli_fetch_assoc($totalRegisteredUsersResult)['totalRegistered']
        : 0;

    // Fetch the first module (Module 1)
    $firstModuleQuery = "
    SELECT cm.Module_num, cm.Title, cm.Description 
    FROM course_modules cm 
    WHERE cm.course_ID = '$course_id' AND cm.Module_num = 1 
    LIMIT 1";
    $firstModuleResult = mysqli_query($trainmastas_conn, $firstModuleQuery);
    $firstModule = null;
    if ($firstModuleResult && mysqli_num_rows($firstModuleResult) > 0) {
        $firstModule = mysqli_fetch_assoc($firstModuleResult);
        $firstModule['Title'] = decodeHtml($firstModule['Title']);
        $firstModule['Description'] = decodeHtml($firstModule['Description']);
    }

    // Fetch the Scope Course
    $firstScopeQuery = "
    SELECT `Scope` FROM `course_scope`
    WHERE course_ID = '$course_id'";
    $firstScopeResult = mysqli_query($trainmastas_conn, $firstScopeQuery);
    $firstScopes = [];

    if ($firstScopeResult) {
        while ($firstScope = mysqli_fetch_assoc($firstScopeResult)) {
            $firstScope['Scope'] = decodeHtml($firstScope['Scope']);
            $firstScopes[] = $firstScope;
        }
    }
    // Define the passing score threshold  
    $passingScoreThreshold = 60;

    // Prepare the SQL statement  
    $averagePassingRateQuery = "  
    SELECT CASE   
        WHEN c.Num_test IS NULL OR c.Num_test = 0 THEN NULL  
        ELSE (AVG(cs.Score) / c.Num_test) * 100   
    END AS average_passing_rate FROM 
    course_score cs JOIN course c ON cs.course_ID = c.course_ID WHERE cs.course_ID = ?";
    // Prepare the statement  
    $stmt = $trainmastas_conn->prepare($averagePassingRateQuery);
    $stmt->bind_param("s", $course_id); // Assuming course_id is an integer  
    $stmt->execute();
    $result = $stmt->get_result();
    $averagePassingRate = 0;
    if ($result && $result->num_rows > 0) {
        $averagePassingRate = $result->fetch_assoc();
        $averagePassingRate = $averagePassingRate['average_passing_rate'];
    }
    $result->free();
    $stmt->close();

    // Fetch the videos of this module from course_video table  
    $videoQuery = "  
    SELECT cv.URL, cv.Video_num   
    FROM course_video cv  
    WHERE cv.course_ID = '$course_id' AND cv.Module_num = 1";
    $videoResult = mysqli_query($trainmastas_conn, $videoQuery);

    $videoData = []; // Initialize as an empty array to hold multiple videos  

    if ($videoResult && mysqli_num_rows($videoResult) > 0) {
        while ($row = mysqli_fetch_assoc($videoResult)) {
            // Add each row to the videoData array  
            $videoData[] = $row;
        }
    }
    // 'courseExists' => $courseExists,
    // Send response
    echo json_encode([
        'state' => 'successFetching',
        'courseData' => $courseData,
        'courseFeedback' => $courseFeedback,
        'totalFeedback' => $totalFeedback,
        'scopes' => $firstScopes,
        'registeredUsers' => $registeredUsers,
        'totalRegisteredUsers' => $totalRegisteredUsers,
        'averagePassingRate' => number_format((float)$averagePassingRate, 1),
        'module' => $firstModule,
        'video' => $videoData,
    ]);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "fetchFeedback" && !empty($_POST['id']) && isset($_POST['page'])) {
    // Decode the user ID from base64 
    $course_id = base64_decode($_POST['id']);
    $page = intval($_POST['page']);
    $itemsPerPage = 5;
    $offset = ($page - 1) * $itemsPerPage;


    // Fetch course feedback
    $feedbackQuery = "
        SELECT cf.feedback_giver_ID, cf.Feedback, cf.Rate, cf.Date, 
           u.Name AS feedback_giver_name, u.type , u.Image AS feedback_giver_image
        FROM course_feedback cf
        JOIN user u ON cf.feedback_giver_ID = u.user_ID
        WHERE cf.course_ID = '$course_id' LIMIT $offset, $itemsPerPage";

    $feedbackResult = mysqli_query($trainmastas_conn, $feedbackQuery);
    $feedbackData = [];
    // echo $feedbackQuery;

    if ($feedbackResult && mysqli_num_rows($feedbackResult) > 0) {
        while ($feedback = mysqli_fetch_assoc($feedbackResult)) {
            $feedback["feedback_giver_ID"] = base64_encode($feedback["feedback_giver_ID"]);
            $feedback["feedback_giver_name"] = decodeHtml($feedback["feedback_giver_name"]);
            $feedbackData[] = $feedback;
        }
    }

    // Send response
    echo json_encode([
        'state' => 'successFetchingFeedback',
        'courseFeedback' => $feedbackData,
    ]);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "fetchRegistered" && !empty($_POST['id']) && isset($_POST['page'])) {
    // Decode the user ID from base64
    $course_id = base64_decode($_POST['id']);
    $page = intval($_POST['page']);
    $itemsPerPage = 5;
    $offset = ($page - 1) * $itemsPerPage;

    // Fetch registered courses (5 at a time)
    $coursesQuery = "
        SELECT cr.user_ID, cr.Level, cr.Date, u.Name, u.Image 
        FROM course_registered cr 
        JOIN user u ON cr.user_ID = u.user_ID
        LEFT JOIN authentication ua ON cr.user_ID = ua.user_ID
        WHERE cr.course_ID = '$course_id' LIMIT $offset, $itemsPerPage";
    $coursesResult = mysqli_query($trainmastas_conn, $coursesQuery);
    $courseData = [];

    if ($coursesResult && mysqli_num_rows($coursesResult) > 0) {
        while ($course = mysqli_fetch_assoc($coursesResult)) {
            $course["user_ID"] = base64_encode($course["user_ID"]);
            $course["Name"] = decodeHtml($course["Name"]);
            $courseData[] = $course;
        }
    }

    // Send response
    echo json_encode([
        'state' => 'successFetchingRegistered',
        'registeredUsers' => $courseData,
    ]);
} else if (isset($_POST['purpose']) && ($_POST['purpose'] == "verify" || $_POST['purpose'] == "default") && !empty($_POST['id']) && isset($_POST['page'])) {
    // Get and decode course ID from POST
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        echo json_encode(['state' => 'error', 'message' => 'Course ID is missing']);
        include "close_connection.php";
        exit;
    }
    $course_id = base64_decode($_POST['id']);

    // Get module identifier (either a number or the string "test")
    if (!isset($_POST['page']) || ($_POST['page'] === '')) {
        echo json_encode(['state' => 'error', 'message' => 'Module identifier is missing']);
        include "close_connection.php";
        exit;
    }
    $page = $_POST['page'];

    // Determine purpose: if purpose == "verify", use the verification DB; otherwise default.
    $purposeParam = isset($_POST['purpose']) ? $_POST['purpose'] : '';

    $conn = $trainmastas_conn; // Use the default connection
    $dbPrefix = "trainmastas_courses";
    // Check if $page is numeric or "test"
    if (is_numeric($page)) {
        // ------------------------------- //
        // Case: Fetch Module & Video Data //
        // ------------------------------- //
        $module_num = intval($page);
        $moreSQL = '';
        if ($module_num > 0) {
            $moreSQL = "AND cm.Module_num = $module_num";
        }
        // Fetch module details from course_modules table
        $moduleQuery = "
            SELECT cm.Module_num, cm.Title, cm.Description 
            FROM {$dbPrefix}.course_modules cm 
            WHERE cm.course_ID = '$course_id' $moreSQL 
            LIMIT 1";
        $moduleResult = mysqli_query($conn, $moduleQuery);
        $moduleData = null;
        if ($moduleResult && mysqli_num_rows($moduleResult) > 0) {
            $moduleData = mysqli_fetch_assoc($moduleResult);
            $moduleData['Title'] = decodeHtml($moduleData['Title']);
            $moduleData['Description'] = decodeHtml($moduleData['Description']);
            if ($module_num == 0) {
                $module_num = $moduleData['Module_num'];
            }
        }

        // Fetch the videos of this module from course_video table  
        $videoQuery = "  
        SELECT cv.URL, cv.Video_num,cv.Module_num   
        FROM {$dbPrefix}.course_video cv  
        WHERE cv.course_ID = '$course_id' AND cv.Module_num = $module_num";
        $videoResult = mysqli_query($conn, $videoQuery);

        $videoData = []; // Initialize as an empty array to hold multiple videos  

        if ($videoResult && mysqli_num_rows($videoResult) > 0) {
            while ($row = mysqli_fetch_assoc($videoResult)) {
                // Add each row to the videoData array  
                $videoData[] = $row;
            }
        }
        $editng_modules = []; // Ensure this is an array  
        $test_edit = ''; // Initialize as an empty string  
        if ($_POST['purpose'] == "verify") {
            $moduleNumsQuery = "SELECT DISTINCT Module_num FROM {$dbPrefix}.course_modules WHERE course_ID = '$course_id'  
            UNION SELECT DISTINCT Module_num FROM {$dbPrefix}.course_video WHERE course_ID = '$course_id' ORDER BY Module_num ASC";
            $moduleNumsResult = mysqli_query($conn, $moduleNumsQuery);

            if ($moduleNumsResult && mysqli_num_rows($moduleNumsResult) > 0) {
                while ($row = mysqli_fetch_assoc($moduleNumsResult)) {
                    $editng_modules[] = $row['Module_num'];
                }
            }

            // Build editng_modules as an associative array element  
            $editng_modules = ['editng_module_Nums' => $editng_modules];
        }
        $test = "no"; // Default value  
        $testExistQuery = "SELECT 1 FROM {$dbPrefix}.course_test WHERE course_ID = '$course_id' LIMIT 1";
        $testExistResult = mysqli_query($conn, $testExistQuery);

        if ($testExistResult && mysqli_num_rows($testExistResult) > 0) {
            $test = "yes";
        }
        $test_edit = ['test' => $test]; // Prepare as an array  
        // Prepare response – base64 encode IDs where applicable  
        if ($moduleData === null) {
            $moduleData = []; // Initialize as an empty array  
        }

        // Base64 encode course_ID if applicable  
        if ($course_id) {
            $moduleData['course_ID'] = base64_encode($course_id);
        }

        $response = [
            'state'  => 'successFetchingModules',
            'video'  => $videoData,
            'module' => $moduleData,
        ];

        // Merge editng_modules if not empty  
        if (!empty($editng_modules['editng_module_Nums'])) {
            $response = array_merge($response, $editng_modules);
        }

        // Merge test_edit if it's not an empty array  
        if (!empty($test_edit)) {
            $response = array_merge($response, $test_edit);
        }
    } else if (strtolower($page) == 'test') {
        // ------------------------------ //
        // Case: Fetch Test Questions     //
        // ------------------------------ //
        // For tests, always use the default courses DB connection and the course_test table.
        $testQuery = "SELECT course_ID, Question_num, Question, Option_A, Option_B, Option_C, Option_D, Answer 
            FROM {$dbPrefix}.course_test 
            WHERE course_ID = '$course_id' 
            ORDER BY CAST(Question_num AS UNSIGNED) ASC";
        $testResult = mysqli_query($conn, $testQuery);
        $testData = [];
        if ($testResult && mysqli_num_rows($testResult) > 0) {
            while ($row = mysqli_fetch_assoc($testResult)) {
                // Base64 encode the course_ID in each question row
                $row['course_ID'] = base64_encode($row['course_ID']);
                // Optionally, decode HTML entities in text fields if needed:
                $row['Question'] = decodeHtml($row['Question']);
                $row['Option_A'] = decodeHtml($row['Option_A']);
                $row['Option_B'] = decodeHtml($row['Option_B']);
                $row['Option_C'] = decodeHtml($row['Option_C']);
                $row['Option_D'] = decodeHtml($row['Option_D']);
                $testData[] = $row;
            }
        }



        $response = [
            'state'               => 'successFetchingTest',
            'test'                => $testData,
        ];
    } else {
        $response = ['state' => 'error', 'message' => 'Invalid module identifier'];
    }


    // Finally, send the JSON response
    echo json_encode($response);
} else if (isset($_POST['purpose']) && ($_POST['purpose'] == "reject" || $_POST['purpose'] == "validate") && !empty($_POST['id']) && isset($_POST['page'])) {
    // Decode course ID from base64
    $course_id = base64_decode($_POST['id']);

    // Determine the purpose
    $purpose = $_POST['purpose'];

    if ($purpose == "validate") {


        // Return a success message
        // Update the action in the courses table to 'n'  
        $updateAction = "UPDATE course SET `action` = 'n', `submitted_date` = null, `validated_date` = now() WHERE course_ID = '$course_id'";
        mysqli_query($trainmastas_conn, $updateAction);
        echo json_encode([
            'state'   => 'successValidatingModules',
            'message' => 'Modules, test questions, and videos have been successfully validated, transferred, and deleted from the validation database.'
        ]);
    } else if ($purpose == "reject") {
        // For rejection, get the message from $_POST['page']
        $message = mysqli_real_escape_string($trainmastas_conn, $_POST['page']);
        // Insert a rejection record into the courses_rejected table (columns: course_ID, message, date)
        $insertOrUpdateRejection = "  INSERT INTO courses_rejected (course_ID, Reason, date)
        VALUES ('$course_id', '$message', NOW()) ON DUPLICATE KEY UPDATE Reason = VALUES(Reason), date = NOW()";
        mysqli_query($trainmastas_conn, $insertOrUpdateRejection);
        // Update the action in the courses table to 'n'  
        $updateAction = "UPDATE course SET `action` = 'e' WHERE course_ID = '$course_id'";
        mysqli_query($trainmastas_conn, $updateAction);

        echo json_encode([
            'state'   => 'successRejecting',
            'message' => 'Course has been rejected with the provided message.'
        ]);
    }
} else {
    echo json_encode(["state" => "error", "message" => "Invalid purpose."]);
}
include "close_connection.php";
