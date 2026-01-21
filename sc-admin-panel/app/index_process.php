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
function generateRandomId()
{
    $randomNumber = rand(100000, 999999);
    $randomChars = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
    $combined = strval($randomNumber) . $randomChars;
    return str_shuffle($combined);
}

// User ID from session
if (!isset($_SESSION['AID'])) {
    echo json_encode(["state" => "error", "message" => "User not authenticated."]);
    include "close_connection.php";
    exit;
}
if (isset($_POST['purpose']) && $_POST['purpose'] === "sendIndexDetails") {

    $AID = $_SESSION['AID'];
    // c.action = 'e' AND c.submitted_date IS NOT NULL
    $queries = [
        'course' => [
            'active_courses' => "SELECT COUNT(*) AS count FROM course WHERE action = 'n'",
            'editing_courses' => "SELECT COUNT(*) AS count FROM course WHERE action = 'e' AND submitted_date IS NULL",
            'submitted_courses' => "SELECT COUNT(*) AS count FROM course WHERE action = 'e' AND submitted_date IS NOT NULL",
            'registered_courses' => "SELECT COUNT(*) AS count FROM course_registered",
            'course_with_tests' => "SELECT COUNT(*) AS count FROM course WHERE Num_test > 0",
            'course_without_tests' => "SELECT COUNT(*) AS count FROM course WHERE Num_test = 0",
            'free_courses' => "SELECT COUNT(*) AS count FROM course WHERE Cost = 0",
            'premium_courses' => "SELECT COUNT(*) AS count FROM course WHERE Cost > 0"
        ],
        'users' => [
            'total_students' => "SELECT COUNT(*) AS count FROM user WHERE type = 's'",
            'total_teachers' => "SELECT COUNT(*) AS count FROM user WHERE type = 'c'",
            'total_admins' => "SELECT COUNT(*) AS count FROM admin",
            'total_super_admin' => "SELECT COUNT(*) AS count FROM admin WHERE Type = 'super'",
            'total_middle_admin' => "SELECT COUNT(*) AS count FROM admin WHERE Type = 'middle'",
            'total_lower_admin' => "SELECT COUNT(*) AS count FROM admin WHERE Type = 'lower'",
            'total_banned_users' => "SELECT COUNT(*) AS count FROM user WHERE action = 'b'",
            'total_active_users' => "SELECT COUNT(*) AS count FROM user WHERE action = 'n'"
        ],
        'payment' => [
            'course_payments_fees' => "SELECT COUNT(*) AS count FROM course_payment WHERE Purpose = 'fee'",
            'course_payments_certificates' => "SELECT COUNT(*) AS count FROM course_payment WHERE Purpose = 'cer'",
            'successful_payments' => "SELECT COUNT(*) AS count FROM course_payment WHERE status = 'success'",
            'pending_payments' => "SELECT COUNT(*) AS count FROM course_payment WHERE status = 'pending'",
            'cancel_payments' => "SELECT COUNT(*) AS count FROM course_payment WHERE status = 'cancel'",
            'other_payments' => "SELECT COUNT(*) AS count FROM payment"
        ],
        'certificate' => [
            'certificates_bought' => "SELECT COUNT(*) AS count FROM certificates",
            'course_certificate_given' => "SELECT COUNT(*) AS count FROM course_registered WHERE Level = 'c'"
        ]
    ];

    // Execute queries and store results grouped by category
    $results = [];
    foreach ($queries as $category => $categoryQueries) {
        $results[$category] = [];
        foreach ($categoryQueries as $key => $query) {
            $conn = strpos($key, 'payments') !== false ? $trainmastas_conn : (strpos($key, 'total') !== false ? $trainmastas_conn : $trainmastas_conn);
            $result = $conn->query($query);
            if ($result && $row = $result->fetch_assoc()) {
                $results[$category][] = ["name" => str_replace('_', ' ', $key), "value" => $row['count']];
            } else {
                $results[$category][] = ["name" => str_replace('_', ' ', $key), "value" => 0]; // Default to 0 if query fails
            }
        }
    }
    echo json_encode(["state" => "success", "data" => $results]);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "userDetails") {
    // Get logged-in user ID from session
    $UID = $_SESSION['AID'];

    // Select user info from user database
    $user_sql = "SELECT `Name`, `type` FROM `admin` WHERE `user_ID` = '$UID'";
    $user_result = $trainmastas_conn->query($user_sql);
    if (!$user_result || $user_result->num_rows == 0) {
        // Error handling for user selection
        echo json_encode(array('state' => 'error', 'message' => 'User not found or query failed.'));
        include "close_connection.php";
        exit();
    }

    $user_info = $user_result->fetch_assoc();
    $user_info["Name"] = decodeHtml($user_info["Name"]);
    // decodeHtml

    // Encode user_ID
    $response = array('state' => "success", 'userDetails' => $user_info);
    echo json_encode($response);
} else {

    echo json_encode(["state" => "error", "message" => "Invalid purpose."]);
}
include "close_connection.php";
