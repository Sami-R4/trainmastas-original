<?php
include 'connection.php';
require '../vendor/autoload.php';
include "session_checker.php";

use Ramsey\Uuid\Uuid;

// Function to generate a UUID
function makeID()
{
    return Uuid::uuid4()->toString();
}

/////////////////////////////////////////////////////////////////
//              Complementary Sanitizer
/////////////////////////////////////////////////////////////////
function sanitize($data)
{
    $data = trim(strip_tags($data));
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    $data = addslashes($data);
    return $data;
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
/////////////////////////////////////////////////////////////////
//            Sanitizer of Input 
/////////////////////////////////////////////////////////////////
function process_input($conn, $input)
{
    if (is_array($input)) {
        // Process each element of the array
        return array_map(function ($item) use ($conn) {
            return mysqli_real_escape_string($conn, htmlspecialchars(sanitize($item), ENT_QUOTES, 'UTF-8'));
        }, $input);
    } else {
        // Process a single string
        return mysqli_real_escape_string($conn, htmlspecialchars(sanitize($input), ENT_QUOTES, 'UTF-8'));
    }
}
if (isset($_POST['purpose']) && $_POST['purpose'] == 'getCourseById') {

    // Get and decode the course ID from the frontend
    $course_ID = base64_decode($_POST['course_ID']);
    $extra_join = '';
    $query_registered = '';
    if ($UID) {
        $extra_join = "LEFT JOIN course_registered AS cr ON cr.course_ID = cp.course_ID AND cr.user_ID = '$UID'";
        $query_registered = ", CASE WHEN cr.user_ID IS NOT NULL THEN 1 ELSE 0 END AS is_registered";
    }
    $query = "SELECT cp.course_ID, cp.user_ID, cp.Title, cp.Num_test, cp.Description, cp.Category, cp.Cover_image, cp.Cost, cp.action, cp.Date,  
                  u.Name AS Creator_Name, u.Image AS Creator_image,   
                  IFNULL(AVG(cf.Rate), '') AS Avg_Rate,   
                  COUNT(CASE WHEN cf.Rate IS NOT NULL THEN 1 ELSE NULL END) AS Total_Rates  
                  $query_registered  
           FROM course AS cp   
           JOIN user AS u ON cp.user_ID = u.user_ID  
           LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID  
           LEFT JOIN course_scope AS cs ON cp.course_ID = cs.course_ID  
             $extra_join
           WHERE cp.course_ID = ? AND cp.action != 'd'  
           GROUP BY cp.course_ID";
    // Prepare the statement
    $stmt = $trainmastas_conn->prepare($query);
    if (!$stmt) {
        die('Prepare failed: ' . $trainmastas_conn->error);
    }
    // echo $query;
    // Bind the course ID parameter
    $stmt->bind_param('s', $course_ID);

    // Execute the statement and fetch the result
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();

    // Get the scopes for the course
    $scope_query = "SELECT Scope FROM course_scope WHERE course_ID = ?";
    $scope_stmt = $trainmastas_conn->prepare($scope_query);
    $scope_stmt->bind_param('s', $course_ID);
    $scope_stmt->execute();
    $scope_result = $scope_stmt->get_result();

    // Get the number of modules for the course
    $module_query = "SELECT COUNT(*) as module_count FROM course_modules WHERE course_ID = ?";
    $module_stmt = $trainmastas_conn->prepare($module_query);
    $module_stmt->bind_param('s', $course_ID);
    $module_stmt->execute();
    $module_result = $module_stmt->get_result();
    $module_count = $module_result->fetch_assoc()['module_count'];

    // Fetch scopes if they exist
    if ($scope_result->num_rows > 0) {
        $scopes = [];
        while ($scope_row = $scope_result->fetch_assoc()) {
            $scope_row['Scope'] = decodeHtml($scope_row['Scope']);
            $scopes[] = $scope_row;
        }
    } else {
        $scopes = "none";
    }
    // Close statements
    $stmt->close();
    $scope_stmt->close();
    $current_date = date("Y-m-d H:i:s");
    // Prepare the response
    if ($course) {
        $isForUser = ($UID !== null && $UID == $course['user_ID']) ? "yes" : "no";
        $response = array(
            'state' => 'success',
            'Course' => array(
                'course_ID' => base64_encode($course['course_ID']),
                'user_ID' => base64_encode($course['user_ID']),
                'isForUser' => $isForUser,
                'Title' => decodeHtml($course['Title']),
                'Description' => decodeHtml($course['Description']),
                'Category' => decodeHtml($course['Category']),
                'Cover_image' => $course['Cover_image'],
                'Creator_image' => $course['Creator_image'],
                'Cost' => $course['Cost'],
                'action' => $course['action'],
                'Date' => $course['Date'],
                'Creator_Name' => $course['Creator_Name'],
                'Rate' => number_format((float)$course['Avg_Rate'], 1),
                'Total_Rates' => $course['Total_Rates'],
                'Num_test' => $course['Num_test'],
                'is_registered' => isset($course['is_registered']) ? $course['is_registered'] : null,
                'Scopes' => $scopes,
                'Modules' => $module_count,
                'Current_Date' => $current_date
            )
        );
    } else {
        $response = array(
            'state' => 'notfound'
        );
    }

    // Output the JSON response
    echo json_encode($response);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "register") {
    $course_ID = base64_decode($_POST['course_ID']);
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }
    // Check if course exists
    $stmt_course = $trainmastas_conn->prepare("SELECT `Cost` FROM `course` WHERE `course_ID` = ? AND `user_ID` != ?");
    $stmt_course->bind_param("ss", $course_ID, $UID);
    $stmt_course->execute();
    $result_course = $stmt_course->get_result();

    if ($result_course->num_rows === 0) {
        echo json_encode(['state' => "error", 'message' => 'Course does not exist']);
        $stmt_course->close();
        include "close_connection.php";
        exit;
    }

    $course_data = $result_course->fetch_assoc();
    $cost = $course_data['Cost'];
    $stmt_course->close();

    // Check if already registered
    $stmt_check = $trainmastas_conn->prepare("SELECT * FROM `course_registered` WHERE `user_ID` = ? AND `course_ID` = ?");
    $stmt_check->bind_param("ss", $UID, $course_ID);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo json_encode(['state' => "info", 'message' => 'You are already registered for this course']);
        $stmt_check->close();
        include "close_connection.php";
        exit;
    }

    // Check if already paid
    $stmt_check = $trainmastas_conn->prepare("SELECT * FROM `course_payment` WHERE `user_ID` = ? AND `course_ID` = ? AND `Purpose`='fee'");
    $stmt_check->bind_param("ss", $UID, $course_ID);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo json_encode(['state' => "info", 'message' => 'You already paid for this course.']);
        $stmt_check->close();
        include "close_connection.php";
        exit;
    }
    $stmt_check->close();

    // If free course
    if ($cost == 0) {
        $stmt_reg = $trainmastas_conn->prepare("INSERT INTO `course_registered` (`course_ID`, `user_ID`, `Date`) VALUES (?, ?, NOW())");
        $stmt_reg->bind_param("ss", $course_ID, $UID);
        if ($stmt_reg->execute()) {
            echo json_encode(['state' => "success", 'message' => 'Successfully registered for the free course']);
        } else {
            echo json_encode(['state' => "error", 'message' => 'Registration failed. Try again.']);
        }
        $stmt_reg->close();
    } else {
        // Check user balance
        $stmt_balance = $trainmastas_conn->prepare("SELECT `Balance` FROM `user` WHERE `user_ID` = ?");
        $stmt_balance->bind_param("s", $UID);
        $stmt_balance->execute();
        $result_balance = $stmt_balance->get_result();
        $user_data = $result_balance->fetch_assoc();
        $balance = $user_data['Balance'];
        $stmt_balance->close();

        if ($balance < $cost) {
            echo json_encode(['state' => "recharge", 'message' => 'Insufficient balance to register for this course']);
            include "close_connection.php";
            exit;
        }

        // Deduct balance
        $new_balance = $balance - $cost;
        $stmt_update = $trainmastas_conn->prepare("UPDATE `user` SET `Balance` = ? WHERE `user_ID` = ?");
        $stmt_update->bind_param("ds", $new_balance, $UID);
        $stmt_update->execute();
        $stmt_update->close();

        // Register for course
        $stmt_reg_premium = $trainmastas_conn->prepare("INSERT INTO `course_registered` (`course_ID`, `user_ID`,`Level`, `Date`) VALUES (?, ?, ?, NOW())");
        $s = '1';
        $stmt_reg_premium->bind_param("sss", $course_ID, $UID, $s);
        if ($stmt_reg_premium->execute()) {

            // ✅ Log the payment
            $purpose = "fee";
            $payment_ID = makeID();
            $status = 'pending';
            $stmt_pay = $trainmastas_conn->prepare("INSERT INTO `course_payment` (`payment_ID`, `course_ID`, `user_ID`, `Amount`, `Purpose`, `status`, `Date`) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt_pay->bind_param("sssdss", $payment_ID, $course_ID, $UID, $cost, $purpose, $status);
            $stmt_pay->execute();
            $stmt_pay->close();

            echo json_encode(['state' => "success", 'message' => 'Successfully registered for the premium course']);
        } else {
            echo json_encode(['state' => "error", 'message' => 'Registration failed. Try again.']);
        }
        $stmt_reg_premium->close();
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "buy_certificate") {
    $course_ID = base64_decode($_POST['course_ID']);
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }

    // Step 1: Check if user is registered for course
    $stmt_check_reg = $trainmastas_conn->prepare("SELECT * FROM `course_registered` WHERE `user_ID` = ? AND `course_ID` = ?");
    $stmt_check_reg->bind_param("ss", $UID, $course_ID);
    $stmt_check_reg->execute();
    $result_reg = $stmt_check_reg->get_result();
    if ($result_reg->num_rows === 0) {
        echo json_encode(['state' => "error", 'message' => 'You are not registered for this course']);
        $stmt_check_reg->close();
        include "close_connection.php";
        exit;
    }
    $stmt_check_reg->close();

    // Step 2: Get course cost (to check if it's free or premium)
    $stmt_course_cost = $trainmastas_conn->prepare("SELECT `Cost`,`Num_test` FROM `course` WHERE `course_ID` = ?");
    $stmt_course_cost->bind_param("s", $course_ID);
    $stmt_course_cost->execute();
    $result_cost = $stmt_course_cost->get_result();
    $course_data = $result_cost->fetch_assoc();
    $cost = $course_data['Cost'];
    $num_test = $course_data['Num_test'];
    $stmt_course_cost->close();
    if ($cost > 0) {
        echo json_encode(['state' => "error", 'message' => 'This course is premium. The certificate is already included.']);
        include "close_connection.php";
        exit;
    }

    // Step 3: Check if certificate already issued
    $stmt_cert = $trainmastas_conn->prepare("SELECT certificate_ID FROM course_registered WHERE user_ID = ? AND course_ID = ? AND certificate_ID IS NOT NULL");
    $stmt_cert->bind_param("ss", $UID, $course_ID);
    $stmt_cert->execute();
    $result_cert = $stmt_cert->get_result();
    if ($result_cert->num_rows > 0) {
        echo json_encode(['state' => "info", 'message' => 'You have already obtained a certificate for this course']);
        $stmt_cert->close();
        include "close_connection.php";
        exit;
    }
    $stmt_cert->close();

    // Step 4: Get user balance
    $stmt_balance = $trainmastas_conn->prepare("SELECT `Balance` FROM `user` WHERE `user_ID` = ?");
    $stmt_balance->bind_param("s", $UID);
    $stmt_balance->execute();
    $result_balance = $stmt_balance->get_result();
    $user_data = $result_balance->fetch_assoc();
    $balance = $user_data['Balance'];
    $stmt_balance->close();

    // Step 5: Certificate cost
    $certificate_cost = 0;
    switch ($num_test) {
        case 10:
            $certificate_cost = 2.5;
            break;
        case 20:
            $certificate_cost = 5;
            break;
        case 30:
            $certificate_cost = 7.5;
            break;
        case 40:
            $certificate_cost = 10;
            break;
        default:
            echo json_encode(['state' => "error", 'message' => 'Certificate not available for this course']);
            include "close_connection.php";
            exit;
    }
    if ($balance < $certificate_cost) {
        echo json_encode(['state' => "recharge", 'message' => 'Insufficient balance to buy the certificate']);
        include "close_connection.php";
        exit;
    }


    // Step 6: Add fund  
    // Step 6.1: Retrieve the user ID and course cost based on the course_ID  
    $stmt_course = $trainmastas_conn->prepare("SELECT `user_ID` FROM `course` WHERE `course_ID` = ?");
    $stmt_course->bind_param("s", $course_ID);
    $stmt_course->execute();
    $stmt_course->store_result();
    $stmt_course->bind_result($user_ID); // Use user_ID directly from course  
    $stmt_course->fetch();
    $stmt_course->close();

    // Step 6.2: Retrieve the current fund for the user associated with the course  
    $stmt_fund = $trainmastas_conn->prepare("SELECT `fund` FROM `user` WHERE `user_ID` = ?");
    $stmt_fund->bind_param("s", $user_ID); // Use user_ID directly here  
    $stmt_fund->execute();
    $stmt_fund->store_result();
    $stmt_fund->bind_result($current_fund);
    $stmt_fund->fetch();
    $stmt_fund->close();

    // Step 6.3: Calculate the new fund  
    $new_fund = $current_fund + ($certificate_cost * 0.5); // Add the course cost to the user's current fund  

    // Step 6.4: Update the fund in the user table  
    $stmt_update_fund = $trainmastas_conn->prepare("UPDATE `user` SET `fund` = ? WHERE `user_ID` = ?");
    $stmt_update_fund->bind_param("ds", $new_fund, $user_ID); // Use user_ID directly  
    $stmt_update_fund->execute();

    if (!$stmt_update_fund->affected_rows > 0) {
        echo json_encode(['state' => "error", 'message' => 'An error occurred. Please try again later or contact support team.']);
        $stmt_update_fund->close();
        include "close_connection.php";
        exit;
    }

    $stmt_update_fund->close();

    // Step 7: Deduct balance
    $new_balance = $balance - $certificate_cost;
    $stmt_update_balance = $trainmastas_conn->prepare("UPDATE `user` SET `Balance` = ? WHERE `user_ID` = ?");
    $stmt_update_balance->bind_param("ds", $new_balance, $UID);
    $stmt_update_balance->execute();
    $stmt_update_balance->close();

    // Generate certificate code eg 34fdc-2f72b-ff030-c80fe
    function generateCertificateCode()
    {
        // Define the character pool: alphanumeric  
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $code = '';
        // Generate 20 random characters  
        for ($i = 0; $i < 20; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        // Format the code with hyphens  
        $formattedCode = substr($code, 0, 5) . '-' . substr($code, 5, 5) . '-' . substr($code, 10, 5) . '-' . substr($code, 15, 5);
        return $formattedCode; // Returns both formatted  
    }
    // Step 8: Assign certificate ID (here we generate a simple random ID - you can customize)
    $certificate_ID = generateCertificateCode();

    // Step 9: Update certificate info
    $stmt_update_cert = $trainmastas_conn->prepare("UPDATE course_registered SET certificate_ID = ?, certificate_Date = NOW(), certificate_expired_Date = DATE_ADD(NOW(), INTERVAL 2 YEAR)  WHERE course_ID = ? AND user_ID = ?");
    $stmt_update_cert->bind_param("sss", $certificate_ID, $course_ID, $UID);
    $stmt_update_cert->execute();
    $stmt_update_cert->close();

    // Step 10: Log payment
    $purpose = "cer";
    $status = 'success';
    $payment_ID = makeID();
    $stmt_pay_cert = $trainmastas_conn->prepare("INSERT INTO `course_payment` (`payment_ID`, `course_ID`, `user_ID`, `Amount`, `Purpose`, `status`, `Date`) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt_pay_cert->bind_param("sssdss", $payment_ID, $course_ID, $UID, $certificate_cost, $purpose, $status);
    $stmt_pay_cert->execute();
    $stmt_pay_cert->close();

    echo json_encode(['state' => "success", 'message' => 'Certificate purchased and issued successfully']);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "withdraw_course") {
    $course_ID = base64_decode($_POST['course_ID']);

    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }

    // 1. Check if user is registered for the course
    // $stmt_check_reg = $trainmastas_conn->prepare("SELECT `Level` FROM `course_registered` WHERE `user_ID` = ? AND `course_ID` = ?");
    $stmt_check_reg = $trainmastas_conn->prepare(" SELECT cr.`Level`, c.`Num_modules` FROM `course_registered` cr JOIN `course` c ON cr.`course_ID` = c.`course_ID` WHERE cr.`user_ID` = ? AND cr.`course_ID` = ?");

    $stmt_check_reg->bind_param("ss", $UID, $course_ID);
    $stmt_check_reg->execute();
    $result_reg = $stmt_check_reg->get_result();

    if ($result_reg->num_rows === 0) {
        echo json_encode(['state' => "error", 'message' => 'You are not registered for this course']);
        $stmt_check_reg->close();
        include "close_connection.php";
        exit;
    }

    $user_course_data = $result_reg->fetch_assoc();
    $level = $user_course_data['Level'];
    $num_module = $user_course_data['Num_modules'];
    $stmt_check_reg->close();

    // 2. Block withdrawal for users who completed the course or test
    if ($level === 't' || $level === 'c' || $level == $num_module) {
        echo json_encode(['state' => "error", 'message' => 'You cannot withdraw after taking test or completing the course']);
        include "close_connection.php";
        exit;
    }

    // 3. Get course cost to determine if it's free or paid
    $stmt_course = $trainmastas_conn->prepare("SELECT `Cost` FROM `course` WHERE `course_ID` = ?");
    $stmt_course->bind_param("s", $course_ID);
    $stmt_course->execute();
    $result_course = $stmt_course->get_result();
    $course_data = $result_course->fetch_assoc();
    $cost = $course_data['Cost'];
    $stmt_course->close();

    // 4. Free course logic (no refund)
    if ($cost <= 0) {
        $stmt_delete_registration = $trainmastas_conn->prepare("DELETE FROM `course_registered` WHERE `user_ID` = ? AND `course_ID` = ?");
        $stmt_delete_registration->bind_param("ss", $UID, $course_ID);
        $stmt_delete_registration->execute();
        $stmt_delete_registration->close();

        echo json_encode(['state' => "success", 'message' => 'You have been withdrawn from the free course successfully']);
        include "close_connection.php";
        exit;
    }

    // 5. Check if there's a payment record for the course
    $stmt_payment = $trainmastas_conn->prepare("SELECT `payment_ID`, `Amount`, `status` FROM `course_payment` WHERE `user_ID` = ? AND `course_ID` = ? AND `Purpose` = 'fee' LIMIT 1");
    $stmt_payment->bind_param("ss", $UID, $course_ID);
    $stmt_payment->execute();
    $result_payment = $stmt_payment->get_result();
    $payment = true;
    if ($result_payment->num_rows === 0) {
        $payment = false;
    } else {
        $payment = $result_payment->fetch_assoc();
        if (($payment['status'] == 'cancel' && $payment == true)) {
            echo json_encode(['state' => "error", 'message' => 'You have already withdrawn from this course']);
            $stmt_payment->close();
            include "close_connection.php";
            exit;
        }
    }

    $stmt_payment->close();

    // 6. Refund only if user hasn't progressed too far (Level <= 2)
    if (is_numeric($level) && (int)$level <= 2 && $payment == true) {
        // 7. Refund the user
        $refund_amount = (float)$payment['Amount'];
        $stmt_get_balance = $trainmastas_conn->prepare("SELECT `Balance` FROM `user` WHERE `user_ID` = ?");
        $stmt_get_balance->bind_param("s", $UID);
        $stmt_get_balance->execute();
        $res_bal = $stmt_get_balance->get_result();
        $bal_data = $res_bal->fetch_assoc();
        $current_balance = (float)$bal_data['Balance'];
        $stmt_get_balance->close();

        $new_balance = $current_balance + $refund_amount;
        $stmt_update_balance = $trainmastas_conn->prepare("UPDATE `user` SET `Balance` = ? WHERE `user_ID` = ?");
        $stmt_update_balance->bind_param("ds", $new_balance, $UID);
        $stmt_update_balance->execute();
        $stmt_update_balance->close();
    }

    // 8. Remove from course_registered
    $stmt_delete_registration = $trainmastas_conn->prepare("DELETE FROM `course_registered` WHERE `user_ID` = ? AND `course_ID` = ?");
    $stmt_delete_registration->bind_param("ss", $UID, $course_ID);
    $stmt_delete_registration->execute();
    $stmt_delete_registration->close();

    // 9. Mark status = cancel in course_payment
    if ($payment == true) {
        $stmt_update_payment = $trainmastas_conn->prepare("UPDATE `course_payment` SET `status` = 'cancel' WHERE `user_ID` = ? AND `course_ID` = ? AND `Purpose` = 'fee'");
        $stmt_update_payment->bind_param("ss", $UID, $course_ID);
        $stmt_update_payment->execute();
        $stmt_update_payment->close();
    }

    echo json_encode(['state' => "success", 'message' => 'You have been withdrawn and refunded successfully']);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "updateFund") {
    // Decode the course_ID from POST data  
    $course_ID = base64_decode($_POST['id']);

    // Step 6.1: Retrieve the user_ID associated with the course_ID  
    $stmt_course = $trainmastas_conn->prepare("SELECT `user_ID` FROM `course` WHERE `course_ID` = ?");
    $stmt_course->bind_param("s", $course_ID);
    $stmt_course->execute();
    $stmt_course->store_result();
    $stmt_course->bind_result($user_ID); // Get user_ID associated with the course  
    $stmt_course->fetch();
    $stmt_course->close();

    // Step 6.2: Retrieve the current fund for the user associated with this user_ID  
    $stmt_fund = $trainmastas_conn->prepare("SELECT `fund` FROM `user` WHERE `user_ID` = ?");
    $stmt_fund->bind_param("s", $user_ID);
    $stmt_fund->execute();
    $stmt_fund->store_result();
    $stmt_fund->bind_result($current_fund);
    $stmt_fund->fetch();
    $stmt_fund->close();

    // Step 6.3: Retrieve the course cost from the course_payment table  
    $stmt_payment = $trainmastas_conn->prepare("SELECT `Amount` FROM `course_payment` WHERE `course_ID` = ? AND `user_ID` = ? AND `Purpose`='fee'");
    $stmt_payment->bind_param("ss", $course_ID, $user_ID);  // Ensure both course_ID and user_ID are used for accuracy  
    $stmt_payment->execute();
    $stmt_payment->store_result();
    $stmt_payment->bind_result($course_cost);
    $stmt_payment->fetch();
    $stmt_payment->close();

    // Calculate the new fund  
    $new_fund = $current_fund + ($course_cost * 0.7); // Add half of the course cost to the current fund  

    // Step 6.4: Update the fund in the user table  
    $stmt_update_fund = $trainmastas_conn->prepare("UPDATE `user` SET `fund` = ? WHERE `user_ID` = ?");
    $stmt_update_fund->bind_param("ds", $new_fund, $user_ID);
    $stmt_update_fund->execute();

    if ($stmt_update_fund->affected_rows > 0) {
        // Step 6.5: Update payment status to success if the fund is updated successfully  
        $stmt_update_payment = $trainmastas_conn->prepare("UPDATE `course_payment` SET `status` = 'success' WHERE `course_ID` = ? AND `user_ID` = ? AND `Purpose` = 'fee'");
        $stmt_update_payment->bind_param("ss", $course_ID, $user_ID);
        $stmt_update_payment->execute();
        $stmt_update_payment->close();

        echo json_encode(['state' => "success", 'message' => 'Fund updated successfully and payment status updated to success.']);
    } else {
        echo json_encode(['state' => "error", 'message' => 'An error occurred. Please try again later or contact the support team.']);
    }

    $stmt_update_fund->close();
} else {
    header('location: ../login.php');
}
include 'close_connection.php';
