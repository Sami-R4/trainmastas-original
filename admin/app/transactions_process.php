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

if (isset($_POST['purpose']) && in_array($_POST['purpose'], ['course_payment', 'payment'])) {
    $purpose = $_POST['purpose'];
    $filterValue1 = isset($_POST['filterValue1']) ? $_POST['filterValue1'] : '';
    $filterValue2 = isset($_POST['filterValue2']) ? $_POST['filterValue2'] : '';
    $additionalSQL = '';
    $additionalSQL2 = '';
    $date_threshold = date('Y-m-d', strtotime('-4 days')); // Set threshold date

    // Get the page number and calculate the offset
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1; // Default to page 1 if not set
    $items_per_page = 20; // Number of records per page
    $offset = ($page - 1) * $items_per_page;

    // Switch case for paymentTab
    switch ($filterValue1) {
        case 'pending':
            $additionalSQL .= " AND cp.status = 'pending'";
            $additionalSQL2 .= " AND r.status = 'pending'";
            break;
        case 'ready':
            $additionalSQL .= " AND cp.status = 'success'";
            $additionalSQL2 .= " AND r.status = 'success'";
            break;
        case 'withdrew':
            $additionalSQL .= " AND pw.approved_date is NOT NULL ";
            $additionalSQL2 .= " AND r.status = 'failed'";
            break;
        case 'all':
        default:
            $additionalSQL .= " ";
            break;
    }

    // Switch case for Purpose filter
    switch ($filterValue2) {
        case 'fee':
            $additionalSQL .= " AND cp.Purpose='fee' ";
            break;
        case 'cer':
            $additionalSQL .= " AND cp.Purpose='cer' ";
            break;
        case 'all':
        default:
            $additionalSQL .= " ";
            break;
    }

    // Count total records
    if ($purpose === 'course_payment') {
        $count_query = "SELECT COUNT(*) as total_count FROM course_payment cp LEFT JOIN withdrew_payment wp ON cp.user_ID = wp.user_ID WHERE 1 $additionalSQL";
    } else {
        $count_query = "SELECT COUNT(*) as total_count FROM recharge r WHERE 1";
    }
    $count_result = mysqli_query($trainmastas_conn, $count_query);
    $total_count = ($count_result && mysqli_num_rows($count_result) > 0) ? mysqli_fetch_assoc($count_result)['total_count'] : 0;

    // Fetch transactions from either course_payment or payment table
    if ($purpose === 'course_payment') {
        $query = "SELECT cp.payment_ID, cp.course_ID, c.Title, cp.user_ID, cp.Purpose, cp.Amount, cp.Date, cp.status, u.Name,  u.type, u.Image 
                  FROM course_payment cp 
                  LEFT JOIN user u ON cp.user_ID = u.user_ID 
                  LEFT JOIN course c ON cp.course_ID = c.course_ID 
                  LEFT JOIN withdrew_payment wp ON cp.user_ID = wp.user_ID 
                  WHERE 1 $additionalSQL 
                  ORDER BY cp.Date DESC 
                  LIMIT $items_per_page OFFSET $offset";
    } else {
        $query = "SELECT r.payment_ID, r.user_ID, r.status, r.Payment_method, r.Amount, r.Date, u.Name,  u.type, u.Image 
                  FROM recharge r 
                  LEFT JOIN user u ON r.user_ID = u.user_ID 
                  WHERE 1  
                  ORDER BY r.Date DESC 
                  LIMIT $items_per_page OFFSET $offset";
    }
    $result = mysqli_query($trainmastas_conn, $query);
    $payments = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $row['user_ID'] = base64_encode($row['user_ID']);
            $row['payment_ID'] = base64_encode($row['payment_ID']);
            if (isset($row['course_ID']) && !empty($row['course_ID'])) {
                $row['course_ID'] = base64_encode($row['course_ID']);
            }
            $payments[] = $row;
        }
    }

    echo json_encode([
        'state' => "success",
        'transactions' => $payments,
        'date_threshold' => $date_threshold,
        'total_Transactions' => $total_count
    ]);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "sentThisDetails" && !empty($_POST['id'])) {
    $payment_id = base64_decode($_POST['id']); // 'id' refers to the payment ID
    // Check if the payment exists in course_payment
    $check_course_payment_query = "SELECT `payment_ID` FROM `course_payment` WHERE `payment_ID` = '$payment_id' LIMIT 1";
    $check_result = mysqli_query($trainmastas_conn, $check_course_payment_query);
    if ($check_result && mysqli_num_rows($check_result) > 0) {
        // Fetch transaction from course_payment
        $query = "SELECT 
                    cp.payment_ID, 
                    cp.course_ID, 
                    c.Title, 
                    cp.user_ID, 
                    cp.Purpose, 
                    cp.Amount, 
                    cp.Date, 
                    cp.status, 
                    u.Name,  
                    u.type,
                    u.Image 
                  FROM course_payment cp
                  LEFT JOIN user u ON cp.user_ID = u.user_ID 
                  LEFT JOIN course c ON cp.course_ID = c.course_ID 
                  WHERE cp.payment_ID = '$payment_id'
                  LIMIT 1";
    } else {
        // Fetch transaction from recharge
        $query = "SELECT 
                    r.payment_ID, 
                    r.user_ID, 
                    r.status,
                    r.Payment_method, 
                    r.Amount, 
                    r.Date, 
                    u.Name,  
                    u.type,
                    u.Image 
                  FROM recharge r 
                  LEFT JOIN user u ON r.user_ID = u.user_ID 
                  WHERE r.payment_ID = '$payment_id'
                  LIMIT 1";
    }

    // Execute the selected query
    $result = mysqli_query($trainmastas_conn, $query);
    $transaction = [];
    if ($result && mysqli_num_rows($result) > 0) {
        $transaction = mysqli_fetch_assoc($result);

        // Encode IDs before sending the response
        $transaction['payment_ID'] = base64_encode($transaction['payment_ID']);
        $transaction['user_ID'] = base64_encode($transaction['user_ID']);

        if (!empty($transaction['course_ID'])) {
            $transaction['course_ID'] = base64_encode($transaction['course_ID']);
        }

        echo json_encode([
            'state' => "successFetching",
            'transaction' => $transaction
        ]);
    } else {
        echo json_encode([
            'state' => "notfound",
            'message' => "Transaction not found."
        ]);
    }
} else {
    echo json_encode(["state" => "error", "message" => "Invalid purpose."]);
}
include "close_connection.php";
