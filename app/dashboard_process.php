<?php
include "connection.php";
require '../vendor/autoload.php';
include "session_checker.php";

use Ramsey\Uuid\Uuid;

// Function to generate a UUID
function makeID()
{
    return Uuid::uuid4()->toString();
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
// Remove $ sign
function removeDollarSign($amount)
{
    // Check if the string starts with a dollar sign  
    if (strpos($amount, '$') === 0) {
        // Remove the dollar sign  
        return substr($amount, 1);
    }
    // Return the original amount if no dollar sign is found  
    return $amount;
}

if (isset($_POST['purpose']) && $_POST['purpose'] == 'sendUserDetails') {

    // Get logged-in user ID from 
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }
    // Select user info from user database

    // $user_sql = "SELECT `type`,`verified`, `verified_submitted_date` FROM `user` WHERE `user_ID` = '$UID'";
    $user_sql = "SELECT u.`type`, u.`verified`, u.`verified_submitted_date`, tr.`reapplied`, tr.`Reason`, tr.`Date`  
    FROM `user` AS u LEFT JOIN `teachers_rejected` AS tr ON u.`user_ID` = tr.`user_ID` WHERE u.`user_ID` = '$UID';";
    $user_result = $trainmastas_conn->query($user_sql);

    if (!$user_result || $user_result->num_rows == 0) {
        // Error handling for user selection
        echo json_encode(array('state' => 'error', 'message' => 'User not found or query failed.'));
        include "close_connection.php";
        exit();
    }

    $user_info = $user_result->fetch_assoc();
    // Prepare the response data
    $response = array(
        'state' => "success",
        'userType' => $user_info['type'],
        'isUserVerified' => $user_info['verified'],
        'verifiedDate' => $user_info['verified_submitted_date'],
        'reapplied' => $user_info['reapplied'],
        'Reason' => $user_info['Reason'],
        'created_courses' => array(),
        'registered_courses' => array(),
        'activity_courses' => array(),
        'payment_courses' => array(),
        'total_created_courses' => 0,
        'total_registered_courses' => 0,
        'total_activity_courses' => 0,
        'total_payment_courses' => 0,
        'total_ready_payments_sum' => 0,
        'total_pending_payments_sum' => 0,
        'total_withdrew_payments_sum' => 0,
        'total_added_payments_sum' => 0,
        'total_spent_payments_sum' => 0
    );
    // If the user is a teacher, select the courses they have created from the course database
    if ($user_info['type'] === 'c') {
        $created_courses_sql = "SELECT 
        c.`course_ID`, 
        c.`Title`, 
        c.`Cover_image`, 
        COUNT(cr.`user_ID`) AS num_registered, 
        c.`Date`, 
        c.`action`, 
        c.`Num_modules`, 
        c.`Num_test`,
        IF((SELECT COUNT(*) FROM `course_modules` WHERE `course_ID` = c.`course_ID`) > 0, 'yes', 'no') AS modules,
        IF((SELECT COUNT(*) FROM `course_test` WHERE `course_ID` = c.`course_ID`) > 0, 'yes', 'no') AS tests,
        (SELECT COUNT(DISTINCT user_ID) 
        FROM `course_registered` 
        WHERE `course_ID` = c.`course_ID` AND c.`action` != 'e' AND ((`Level` != 'c' AND c.`Num_test` != 0) OR (c.`Num_test` = 0 AND `Level` !=  c.`Num_modules`)) AND `user_ID` != '$UID') AS num_active
        FROM `course` c LEFT JOIN `course_registered` cr ON c.`course_ID` = cr.`course_ID` WHERE 
        c.`user_ID` = '$UID' AND c.`action` != 'd' 
        GROUP BY c.`course_ID` ORDER BY c.`Date` DESC LIMIT 5";
        $created_courses_result = $trainmastas_conn->query($created_courses_sql);

        if (!$created_courses_result) {
            // Error handling for created courses query
            echo json_encode(array('state' => 'error', 'message' => 'Error retrieving created courses.'));
            include "close_connection.php";
            exit();
        }

        // Fetch total number of created courses
        $total_created_courses_sql = "SELECT COUNT(*) AS total FROM `course` WHERE `user_ID` = '$UID' AND `action` != 'd'";
        $total_created_courses_result = $trainmastas_conn->query($total_created_courses_sql);
        $total_created_courses = $total_created_courses_result->fetch_assoc()['total'];
        $response['total_created_courses'] = $total_created_courses;

        while ($course = $created_courses_result->fetch_assoc()) {
            // Encode course_ID and user_ID
            $course['course_ID'] = base64_encode($course['course_ID']);
            $response['created_courses'][] = $course;
        }

        $date_threshold = date('Y-m-d', strtotime('-4 days'));

        // Fetch total number and sum of Ready Payments
        $ready_payment_total_sql = "SELECT `fund` FROM `user` WHERE `user_ID` = '$UID'";

        $ready_payment_total_result = $trainmastas_conn->query($ready_payment_total_sql);

        if (!$ready_payment_total_result) {
            echo json_encode(array('state' => 'error', 'message' => 'Error retrieving total ready payments.'));
            include "close_connection.php";
            exit();
        }
        $ready_payment_data = $ready_payment_total_result->fetch_assoc();
        $total_ready = $ready_payment_data['fund'];
        $total_ready_sum = $ready_payment_data['fund'] ?? 0; // Handle NULL as 0

        // Fetch total number and sum of Pending Payments
        $pending_payment_total_sql = "SELECT COUNT(*) AS total_pending, SUM(CAST(cp.`Amount` AS DECIMAL(10, 2))) AS total_pending_sum
        FROM `course_payment` cp JOIN `course` c ON cp.`course_ID` = c.`course_ID`
        WHERE c.`user_ID` = '$UID' AND cp.`status` = 'pending'";
        $pending_payment_total_result = $trainmastas_conn->query($pending_payment_total_sql);

        if (!$pending_payment_total_result) {
            echo json_encode(array('state' => 'error', 'message' => 'Error retrieving total pending payments.'));
            include "close_connection.php";
            exit();
        }
        $pending_payment_data = $pending_payment_total_result->fetch_assoc();
        $total_pending = $pending_payment_data['total_pending'];
        $total_pending_sum = $pending_payment_data['total_pending_sum'] ?? 0;

        // Fetch total number and sum of Withdrew Payments
        $withdrew_payment_total_sql = "SELECT SUM(CAST(wp.`Amount` AS DECIMAL(10, 2))) AS total_withdrew_sum FROM withdrew_payment wp 
        WHERE wp.`user_ID` = '$UID' AND (wp.`approved_date` IS NOT NULL OR wp.`Withdrawal_method` = 'internal')";
        $withdrew_payment_total_result = $trainmastas_conn->query($withdrew_payment_total_sql);

        if (!$withdrew_payment_total_result) {
            echo json_encode(array('state' => 'error', 'message' => 'Error retrieving total withdrew payments.'));
            include "close_connection.php";
            exit();
        }
        $withdrew_payment_data = $withdrew_payment_total_result->fetch_assoc();
        $total_withdrew_sum = $withdrew_payment_data['total_withdrew_sum'] ?? 0;

        $response['total_ready_payments_sum'] = $total_ready_sum;
        $response['total_pending_payments_sum'] = $total_pending_sum;
        $response['total_withdrew_payments_sum'] = $total_withdrew_sum;
    }
    // Fetch payment data for courses
    $payment_courses_sql = "SELECT  ap.`status`, ap.`Payment_method`, ap.`Amount`, DATE(ap.`Date`) AS `Date` 
FROM `recharge` AS ap WHERE ap.`user_ID` = '$UID' AND ap.`status`!='failed' ORDER BY ap.`Date` DESC LIMIT 10";
    $payment_courses_result = $trainmastas_conn->query($payment_courses_sql);

    if (!$payment_courses_result) {
        // Error handling for payment courses query
        echo json_encode(array('state' => 'error', 'message' => 'Error retrieving payment courses.'));
        include "close_connection.php";
        exit();
    }
    // Fetch total number of payment transactions

    $total_payment_courses_sql = "SELECT COUNT(*) AS total FROM `recharge` AS ap WHERE ap.`user_ID` = '$UID' AND ap.`status` != 'failed'";
    $total_payment_courses_result = $trainmastas_conn->query($total_payment_courses_sql);
    $total_payment_courses = $total_payment_courses_result->fetch_assoc()['total'];
    $response['total_payment_courses'] = $total_payment_courses;
    while ($payment_course = $payment_courses_result->fetch_assoc()) {
        $response['payment_courses'][] = $payment_course;
    }




    // Fetch sum of user Payments(money spent)
    $spent_payment_total_sql = "SELECT COUNT(*) AS total_spent, SUM(CAST(cp.`Amount` AS DECIMAL(10, 2))) AS total_spent_sum
        FROM `course_payment` cp WHERE cp.`user_ID` = '$UID' AND cp.`status` != 'cancel'";
    $spent_payment_total_result = $trainmastas_conn->query($spent_payment_total_sql);

    if (!$spent_payment_total_result) {
        echo json_encode(array('state' => 'error', 'message' => 'Error retrieving total spent payments.'));
        include "close_connection.php";
        exit();
    }
    $spent_payment_data = $spent_payment_total_result->fetch_assoc();
    $total_spent = $spent_payment_data['total_spent'];
    $total_spent_sum = $spent_payment_data['total_spent_sum'] ?? 0;

    // Fetch total number and sum of added Payments
    $added_payment_total_sql = "SELECT SUM(CAST(ap.`Amount` AS DECIMAL(10, 2))) AS total_added_sum FROM recharge ap 
        WHERE ap.`user_ID` = '$UID' AND ap.`status`!='failed'";
    $added_payment_total_result = $trainmastas_conn->query($added_payment_total_sql);

    if (!$added_payment_total_result) {
        echo json_encode(array('state' => 'error', 'message' => 'Error retrieving total added payments.'));
        include "close_connection.php";
        exit();
    }
    $added_payment_data = $added_payment_total_result->fetch_assoc();
    $total_added_sum = $added_payment_data['total_added_sum'] ?? 0;
    $response['total_spent_payments_sum'] = $total_spent_sum;
    $response['total_added_payments_sum'] = $total_added_sum;


    // Select courses the user has registered for (excluding their own courses)
    $registered_courses_sql = "
    SELECT cr.`course_ID`, c.`Title`, cr.`Level`, cr.`Date`, c.`action`, tu.`Name` AS creator_name
    FROM `course_registered` cr
    LEFT JOIN `course` c ON cr.`course_ID` = c.`course_ID`
    LEFT JOIN user tu ON c.`user_ID` = tu.`user_ID`
    WHERE cr.`user_ID` = '$UID' AND c.`user_ID` != '$UID' AND (c.`action` = 'n'  OR c.`action` = 'e')
    LIMIT 5
";
    $registered_courses_result = $trainmastas_conn->query($registered_courses_sql);

    if (!$registered_courses_result) {
        // Error handling for registered courses query
        echo json_encode(array('state' => 'error', 'message' => 'Error retrieving registered courses.'));
        include "close_connection.php";
        exit();
    }

    // Fetch total number of registered courses
    $total_registered_courses_sql = "
        SELECT COUNT(*) AS total
        FROM `course_registered` cr
        LEFT JOIN `course` c ON cr.`course_ID` = c.`course_ID`
        WHERE cr.`user_ID` = '$UID' AND c.`user_ID` != '$UID' AND (c.`action` = 'n'  OR c.`action` = 'e')
    ";
    $total_registered_courses_result = $trainmastas_conn->query($total_registered_courses_sql);
    $total_registered_courses = $total_registered_courses_result->fetch_assoc()['total'];
    $response['total_registered_courses'] = $total_registered_courses;

    while ($course = $registered_courses_result->fetch_assoc()) {
        // Encode course_ID
        $course['course_ID'] = base64_encode($course['course_ID']);
        $response['registered_courses'][] = $course;
    }

    // Select courses for activity where Level is not 'c' (top 5)
    $activity_courses_sql = "
    SELECT cr.`course_ID`, c.`Title`, cr.`Level`, cr.`Date`, 
           GROUP_CONCAT(DISTINCT cm.`Title` ORDER BY cm.`Title` ASC) AS moduleTitle
    FROM `course_registered` cr
    LEFT JOIN `course` c ON cr.`course_ID` = c.`course_ID`
    LEFT JOIN `course_modules` cm ON (c.`course_ID` = cm.`course_ID` AND cr.`Level` = cm.`Module_num`) 
    WHERE cr.`user_ID` = '$UID' AND cr.`Level` != 'c' AND c.`action` = 'n'
    GROUP BY cr.`course_ID`
    LIMIT 5
";
    $activity_courses_result = $trainmastas_conn->query($activity_courses_sql);

    if (!$activity_courses_result) {
        // Error handling for activity courses query
        echo json_encode(array('state' => 'error', 'message' => 'Error retrieving activity courses.'));
        include "close_connection.php";
        exit();
    }

    // Fetch total number of activity courses
    $total_activity_courses_sql = "
        SELECT COUNT(*) AS total
        FROM `course_registered` cr
        LEFT JOIN `course` c ON cr.`course_ID` = c.`course_ID`
        WHERE cr.`user_ID` = '$UID' AND cr.`Level` != 'c'  AND c.`action` = 'n'
    ";
    $total_activity_courses_result = $trainmastas_conn->query($total_activity_courses_sql);
    $total_activity_courses = $total_activity_courses_result->fetch_assoc()['total'];
    $response['total_activity_courses'] = $total_activity_courses;

    while ($course = $activity_courses_result->fetch_assoc()) {
        // Encode course_ID
        $course['course_ID'] = base64_encode($course['course_ID']);
        $course['Title'] = decodeHtml($course['Title']);
        $course['moduleTitle'] = decodeHtml($course['moduleTitle']);
        $response['activity_courses'][] = $course;
    }

    // Output the result as JSON
    echo json_encode($response);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "userDetails") {
    // Get logged-in user ID from 
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }

    // Select user info from user database
    $user_sql = "SELECT `Name`, `type`, `Image`, `Balance` FROM `user` WHERE `user_ID` = '$UID'";
    $user_result = $trainmastas_conn->query($user_sql);

    if (!$user_result || $user_result->num_rows == 0) {
        // Error handling for user selection
        echo json_encode(array('state' => 'error', 'message' => 'User not found or query failed.'));
        include "close_connection.php";
        exit();
    }

    $user_info = $user_result->fetch_assoc();

    // Encode user_ID
    $response = array('state' => "success", 'userDetails' => $user_info);
    echo json_encode($response);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "registeredCourse") {
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;
    // Fetch registered courses with pagination
    $registered_courses_sql = "
            SELECT cr.`course_ID`, c.`Title`, cr.`Level`, cr.`Date`, c.`action`, tu.`Name` AS creator_name
            FROM `course_registered` cr
            LEFT JOIN `course` c ON cr.`course_ID` = c.`course_ID`
            LEFT JOIN user tu ON c.`user_ID` = tu.`user_ID`
            WHERE cr.`user_ID` = '$UID' AND c.`user_ID` != '$UID' AND (c.`action` = 'n'  OR c.`action` = 'e')
            LIMIT $items_per_page OFFSET $offset
        ";
    $registered_courses_result = $trainmastas_conn->query($registered_courses_sql);
    if ($registered_courses_result) {
        $courses = [];
        while ($course = $registered_courses_result->fetch_assoc()) {
            $course['course_ID'] = base64_encode($course['course_ID']);
            $courses[] = $course;
        }
        echo json_encode(['state' => 'registeredCourse', 'registered_courses' => $courses]);
    } else {
        echo json_encode(['state' => 'error', 'message' => 'Error retrieving registered courses.']);
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "activityCourse") {
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;
    // Fetch activity courses with pagination
    $activity_courses_sql = "SELECT cr.`course_ID`, c.`Title`, cr.`Level`, cr.`Date`, cm.`Title` AS `moduleTitle`  
    FROM `course_registered` cr LEFT JOIN `course` c ON cr.`course_ID` = c.`course_ID`  
    LEFT JOIN `course_modules` cm ON (c.`course_ID` = cm.`course_ID` AND cr.`Level` = cm.`Module_num`)  
    WHERE cr.`user_ID` = '$UID' AND cr.`Level` != 'c' AND c.`action` = 'n' LIMIT $items_per_page OFFSET $offset";

    $activity_courses_result = $trainmastas_conn->query($activity_courses_sql);
    if ($activity_courses_result) {
        $courses = [];
        while ($course = $activity_courses_result->fetch_assoc()) {
            $course['course_ID'] = base64_encode($course['course_ID']);
            $course['Title'] = decodeHtml($course['Title']);
            $course['moduleTitle'] = decodeHtml($course['moduleTitle']);
            $courses[] = $course;
        }
        echo json_encode(['state' => 'activityCourse', 'activity_courses' => $courses]);
    } else {
        echo json_encode(['state' => 'error', 'message' => 'Error retrieving activity courses.']);
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "createdCourse") {
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $items_per_page = 5;
    $offset = ($page - 1) * $items_per_page;

    $created_courses_sql = "SELECT 
    c.`course_ID`, 
    c.`Title`, 
    c.`Cover_image`, 
    COUNT(cr.`user_ID`) AS num_registered, 
    c.`Date`, 
    c.`action`, 
    c.`Num_modules`, 
    c.`Num_test`,
    IF((SELECT COUNT(*) FROM `course_modules` WHERE `course_ID` = c.`course_ID`) > 0, 'yes', 'no') AS modules,
    IF((SELECT COUNT(*) FROM `course_test` WHERE `course_ID` = c.`course_ID`) > 0, 'yes', 'no') AS tests,
    (SELECT COUNT(DISTINCT user_ID) FROM `course_registered` WHERE `course_ID` = c.`course_ID` AND c.`action` != 'e' 
    AND ((`Level` != 'c' AND c.`Num_test` != 0) OR (c.`Num_test` = 0 AND `Level` !=  c.`Num_modules`)) AND `user_ID` != '$UID') AS num_active
    FROM `course` c LEFT JOIN `course_registered` cr ON c.`course_ID` = cr.`course_ID` WHERE c.`user_ID` = '$UID' 
    AND c.`action` != 'd' GROUP BY c.`course_ID`  ORDER BY c.`Date` DESC LIMIT $items_per_page OFFSET $offset";
    $created_courses_result = $trainmastas_conn->query($created_courses_sql);
    if ($created_courses_result) {
        $courses = [];
        while ($course = $created_courses_result->fetch_assoc()) {
            $course['course_ID'] = base64_encode($course['course_ID']);
            $courses[] = $course;
        }
        echo json_encode(['state' => 'createdCourse', 'created_courses' => $courses]);
    } else {
        echo json_encode(['state' => 'error', 'message' => 'Error retrieving created courses.']);
    }
} else if (isset($_POST['purpose']) && (($_POST['purpose'] == "PaymentCourse") || (isset($_POST['purpose']['purpose']) && $_POST['purpose']['purpose'] == "PaymentCourse"))) {
    $date_threshold = date('Y-m-d', strtotime('-4 days'));
    $additionalSQL = '';
    $state = 'PaymentCourse';
    if (isset($_POST['purpose']['paymentTab'])) {
        if (!$UID) {
            // Not logged in, or token is invalid/expired
            echo json_encode([
                "state" => "error",
                "message" => "User not authenticated."
            ]);
            include "close_connection.php";
            exit;
        }
        $paymentTab = $_POST['purpose']['paymentTab'];
        $additionalSQL = ' FROM `course_payment` cp JOIN `course` c ON cp.`course_ID` = c.`course_ID` LEFT JOIN withdrew_payment wp ON cp.user_ID = wp.user_ID ';
        // Switch case for `paymentTab`  
        $valuesToSelect = ' c.`Title`, cp.`Amount`, cp.`Purpose`, DATE(cp.`Date`) AS `Date` ';
        switch ($paymentTab) {
            // case 'all':
            //     $additionalSQL .= ' ';
            //     // Handle the 'all' case  
            //     break;

            case 'pending':
                // Handle the 'pending' case  
                $additionalSQL .= " WHERE c.`user_ID` = '$UID' AND cp.`status` = 'pending' ";
                break;

            case 'ready':
                // Handle the 'ready' case  
                $additionalSQL .= " WHERE c.`user_ID` = '$UID' AND cp.`status` = 'success' ";
                break;

            case 'withdrew':
                $state = 'PaymentWithdrew';
                // Handle the 'withdrew' case  
                $valuesToSelect = ' wp.`Amount`, wp.`Withdrawal_method`,  wp.`requested_date`,  wp.`approved_date` ';
                $additionalSQL = "  FROM `withdrew_payment` wp WHERE wp.`user_ID` = '$UID' AND (wp.`approved_date` IS NOT NULL OR wp.`Withdrawal_method` = 'internal')";
                break;

            case 'added':
                $state = 'PaymentAdded';
                $valuesToSelect = ' ap.`status`, ap.`Payment_method`,  ap.`Amount`,  ap.`Date` ';
                $additionalSQL = "  FROM `recharge` AS ap WHERE ap.`user_ID` = '$UID' AND ap.`status`!='failed'";
                break;
            case 'transactions':
                $additionalSQL .= " WHERE cp.`user_ID` = '$UID' AND cp.`status` != 'cancel' ";
                break;
            default:
                // Handle unexpected values for `paymentTab`  
                echo json_encode(['success' => false, 'message' => 'Invalid payment tab selected.']);
                break;
        }
        if (isset($_POST['purpose']['filterValue']) && $paymentTab != "added" && $paymentTab != "withdrew") {
            $filterValue = $_POST['purpose']['filterValue'];
            switch ($filterValue) {
                case 'all':
                    $additionalSQL .= " AND cp.`Amount`!=0 ORDER BY cp.`Date`";
                    // Handle the 'fee' case  
                    break;
                case 'fee':
                    $additionalSQL .= " AND cp.`Purpose`='fee' AND cp.`Amount`!=0 ORDER BY cp.`Date`";
                    // Handle the 'fee' case  
                    break;

                case 'cer':
                    // Handle the 'certificate' case  
                    $additionalSQL .= "  AND cp.`Purpose`='cer' AND cp.`Amount`!=0 ORDER BY cp.`Date`";
                    break;

                default:
                    // Handle unexpected values for `paymentTab`  
                    echo json_encode(['success' => false, 'message' => 'Invalid filter selected.']);
                    break;
            }
        }
    }
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $items_per_page = 10;
    $offset = ($page - 1) * $items_per_page;
    // Fetch payment data for courses with pagination
    $payment_courses_sql = "SELECT $valuesToSelect
         $additionalSQL  LIMIT $items_per_page OFFSET $offset";
    $payment_courses_result = $trainmastas_conn->query($payment_courses_sql);
    if (!$payment_courses_result) {
        // Error handling for payment courses query
        $error = $trainmastas_conn->error; // Get the error message 
        echo json_encode(array('state' => 'error', 'message' => 'Error retrieving payment courses.'));
        include "close_connection.php";
        exit();
    }
    // Fetch total number of payment transactions
    $total_payment_courses_sql = "SELECT COUNT(*) AS total $additionalSQL";

    $total_payment_courses_result = $trainmastas_conn->query($total_payment_courses_sql);
    $total_payment_courses = $total_payment_courses_result->fetch_assoc()['total'] ?? 0;
    // echo  $total_payment_courses;
    // Fetch data and format response
    $payments = [];
    while ($payment_course = $payment_courses_result->fetch_assoc()) {
        $payments[] = $payment_course;
    }

    // Return JSON response
    echo json_encode([
        'state' => $state,
        'total_payment_courses' => $total_payment_courses,
        'payment_courses' => $payments
    ]);
} else if (isset($_POST['purpose']) && $_POST['purpose'] === "reuseFund") {
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }
    $amount = floatval($_POST['amount']);

    // Validate amount
    if ($amount <= 0) {
        echo json_encode([
            'state' => 'error',
            'message' => 'Invalid amount provided.'
        ]);
        include "close_connection.php";
        exit;
    }

    // Fetch user data
    $stmt = $trainmastas_conn->prepare("SELECT `fund`, `Balance` FROM `user` WHERE `user_ID` = ?");
    $stmt->bind_param("s", $UID);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result->num_rows) {
        echo json_encode([
            'state' => 'error',
            'message' => 'User not found.'
        ]);
        include "close_connection.php";
        exit;
    }

    $user = $result->fetch_assoc();

    if ($user['fund'] >= $amount) {
        $newFund = $user['fund'] - $amount;
        $newBalance = $user['Balance'] + $amount;

        // Update DB
        $update = $trainmastas_conn->prepare("UPDATE `user` SET `fund` = ?, `Balance` = ? WHERE `user_ID` = ?");
        $update->bind_param("dds", $newFund, $newBalance, $UID);
        if ($update->execute()) {
            $withdrew_ID = makeID(); // Must return a unique string/ID

            // Insert into withdrew_payment table using payment_conn
            $insert = $trainmastas_conn->prepare("INSERT INTO `withdrew_payment` (`withdrew_ID`, `Amount`, `Withdrawal_method`, `user_ID`, `requested_date`, `approved_date`) VALUES (?, ?, 'internal', ?, NULL, NULL)");
            $insert->bind_param("sds", $withdrew_ID, $amount, $UID);
            $insert->execute();

            // READY
            $ready_sql = "SELECT `fund` FROM `user` WHERE `user_ID` = '$UID'";
            $ready_result = $trainmastas_conn->query($ready_sql);
            if (!$ready_result) throw new Exception("Error retrieving total ready payments.");
            $ready_data = $ready_result->fetch_assoc();
            $total_ready_sum = $ready_data['fund'] ?? 0;

            // WITHDREW
            $withdrew_sql = "SELECT SUM(CAST(wp.`Amount` AS DECIMAL(10, 2))) AS total_withdrew_sum FROM withdrew_payment wp 
            WHERE wp.`user_ID` = '$UID' AND (wp.`approved_date` IS NOT NULL OR wp.`Withdrawal_method` = 'internal')";
            $withdrew_result = $trainmastas_conn->query($withdrew_sql);
            if (!$withdrew_result) throw new Exception("Error retrieving total withdrew payments.");
            $withdrew_data = $withdrew_result->fetch_assoc();
            $total_withdrew_sum = $withdrew_data['total_withdrew_sum'] ?? 0;

            // ✅ Send response
            echo json_encode([
                'state' => 'success',
                'message' => 'Fund successfully reused and recorded.',
                'total_ready_payments_sum' => $total_ready_sum,
                'total_withdrew_payments_sum' => $total_withdrew_sum
            ]);
        } else {
            echo json_encode([
                'state' => 'error',
                'message' => 'Failed to update records. Please try again.'
            ]);
        }
    } else {
        echo json_encode([
            'state' => 'error',
            'message' => 'Insufficient fund available to reuse.'
        ]);
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] === "submitForVerification") {
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }

    // 1. Check if user exists and has Description, Image, and Verification Status
    $check_sql = "SELECT user_ID, Description, Image, verified, verified_submitted_date 
                  FROM user 
                  WHERE user_ID = ?";
    $check_stmt = $trainmastas_conn->prepare($check_sql);
    $check_stmt->bind_param("s", $UID);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode([
            'state' => 'failed',
            'message' => 'User not found.'
        ]);
        $check_stmt->close();
        include "close_connection.php";
        exit;
    }

    $user_data = $result->fetch_assoc();
    $check_stmt->close();

    // If already verified
    if ($user_data['verified'] == 1) {
        echo json_encode([
            'state' => 'verified',
            'message' => 'You are already a verified teacher.'
        ]);
        include "close_connection.php";
        exit;
    }

    // If verification already submitted
    if (!empty($user_data['verified_submitted_date'])) {
        // Check if in rejected table
        $reject_sql = "SELECT reapplied FROM teachers_rejected WHERE user_ID = ?";
        $reject_stmt = $trainmastas_conn->prepare($reject_sql);
        $reject_stmt->bind_param("s", $UID);
        $reject_stmt->execute();
        $reject_result = $reject_stmt->get_result();

        if ($reject_result->num_rows > 0) {
            $reject_data = $reject_result->fetch_assoc();
            $reject_stmt->close();

            if ($reject_data['reapplied'] == 1) {
                echo json_encode([
                    'state' => 'rejected',
                    'message' => 'You have already reapplied after being rejected. Please wait for our team to review your request.'
                ]);
                include "close_connection.php";
                exit;
            }
        } else {
            // Request is still pending
            echo json_encode([
                'state' => 'pending',
                'message' => 'Your verification request is under review. Please wait for a response.'
            ]);
            include "close_connection.php";
            exit;
        }
    }

    // 2. Check if Description and Image are filled
    if (empty(trim($user_data['Description'])) || empty(trim($user_data['Image']))) {
        echo json_encode([
            'state' => 'incomplete',
            'message' => 'Please complete your profile. Description or profile picture was not found.'
        ]);
        include "close_connection.php";
        exit;
    }

    // 3. Check submitted links
    $links_sql = "SELECT type, link FROM user_link WHERE user_ID = ?";
    $links_stmt = $trainmastas_conn->prepare($links_sql);
    $links_stmt->bind_param("s", $UID);
    $links_stmt->execute();
    $links_result = $links_stmt->get_result();

    $submitted_links = ['c' => false, 'p' => false, 'l' => false];
    while ($row = $links_result->fetch_assoc()) {
        $type = $row['type'];
        $link = trim($row['link']);
        if (!empty($link) && isset($submitted_links[$type])) {
            $submitted_links[$type] = true;
        }
    }
    $links_stmt->close();

    // Count how many valid links are provided
    $valid_links = array_filter($submitted_links);
    $link_count = count($valid_links);

    if ($link_count < 2) {
        echo json_encode([
            'state' => 'incomplete',
            'message' => 'Please submit at least two links (CV, portfolio, or LinkedIn) before requesting verification.'
        ]);
        include "close_connection.php";
        exit;
    }

    // 4. Update verified_submitted_date
    $submittedDate = date("Y-m-d H:i:s");
    $update_sql = "UPDATE user SET verified_submitted_date = ? WHERE user_ID = ?";
    $update_stmt = $trainmastas_conn->prepare($update_sql);
    $update_stmt->bind_param("ss", $submittedDate, $UID);

    if ($update_stmt->execute()) {
        // Also mark reapplied = 1 in rejected table if user was previously rejected
        $reapply_sql = "UPDATE teachers_rejected SET reapplied = 1 WHERE user_ID = ?";
        $reapply_stmt = $trainmastas_conn->prepare($reapply_sql);
        $reapply_stmt->bind_param("s", $UID);
        $reapply_stmt->execute();
        $reapply_stmt->close();

        echo json_encode([
            'state' => 'submittedRequest',
            'message' => 'Verification request submitted successfully.'
        ]);
    } else {
        echo json_encode([
            'state' => 'error',
            'message' => 'Failed to submit verification request.'
        ]);
    }
    $update_stmt->close();
} else {
    header("location:../forbidden.php");
}
include "close_connection.php";
