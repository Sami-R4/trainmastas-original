<?php
session_start();
include "connection.php";
require 'vendors/vendor/autoload.php';
require("send_email.php");

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

function createOrUpdateVerification($trainmastas_conn, $UID, $email, $verification_code, $action_type)
{
    $existing_verification_ID = null;
    $attempt_count = null;
    $status = null;
    $updated_at = null;

    $expires_at = date("Y-m-d H:i:s", strtotime("+15 minutes"));
    $current_time = date("Y-m-d H:i:s");
    $six_hours_ago = date("Y-m-d H:i:s", strtotime("-6 hours"));
    $fifteen_minutes_ago = date("Y-m-d H:i:s", strtotime("-15 minutes"));

    // Resolve email or UID
    if ($email === null) {
        $query = "SELECT a.`Email` FROM `authentication` AS a WHERE a.`user_ID` = ?";
        $temp_stmt = $trainmastas_conn->prepare($query);
        $temp_stmt->bind_param("s", $UID);
        $temp_stmt->execute();
        $temp_stmt->bind_result($email);
    } else {
        $query = "SELECT a.`user_ID` FROM `authentication` AS a WHERE a.`Email` = ?";
        $temp_stmt = $trainmastas_conn->prepare($query);
        $temp_stmt->bind_param("s", $email);
        $temp_stmt->execute();
        $temp_stmt->bind_result($UID);
    }

    if (!$temp_stmt->fetch()) {
        $temp_stmt->close();
        return [
            "state" => "error",
            "message" => "Error occurred: User not found."
        ];
    }
    $temp_stmt->close();
    $updated_at = "";
    // Check if a verification record exists
    $query = "SELECT `verification_ID`, `attempt_count`, `status`, `updated_at`  
              FROM `user_verification` 
              WHERE (`Email` = ? OR `user_ID` = ?) AND `action_type` = ?";

    $temp_stmt = $trainmastas_conn->prepare($query);
    $temp_stmt->bind_param("sss", $email, $UID, $action_type);
    $temp_stmt->execute();
    $temp_stmt->bind_result($existing_verification_ID, $attempt_count, $status, $updated_at);
    $record_found = $temp_stmt->fetch();
    $temp_stmt->close();

    if ($record_found) {
        // Handle "verified" status
        if ($status === "verified") {
            // echo $updated_at, $six_hours_ago;
            if (strtotime($updated_at) < strtotime($six_hours_ago)) {
                // Reset attempt count after 6 hours
                $query = "UPDATE `user_verification` 
                          SET `attempt_count` = 1, `verification_code` = ?, `expires_at` = ?, `status` = 'pending', `updated_at` = ?
                          WHERE `verification_ID` = ?";
                $stmt = $trainmastas_conn->prepare($query);
                $stmt->bind_param("ssss", $verification_code, $expires_at, $current_time, $existing_verification_ID);
                $stmt->execute();
                $stmt->close();

                return [
                    "state" => "verifying",
                    "message" => "Verification attempt reset after 6 hours. A new code has been sent.",
                    "email" => $email
                ];
            } else {
                return [
                    "state" => "verified",
                    "message" => "Verification already completed. Please wait for 6 hours before retrying."
                ];
            }
        }

        // Handle "pending" status
        
        if ($status === "pending" && $attempt_count < 3) {
            // Resend the code and increment the attempt count
            $attempt_count++;
            $query = "UPDATE `user_verification` 
                      SET `verification_code` = ?, `attempt_count` = ?, `expires_at` = ?, `updated_at` = ? 
                      WHERE `verification_ID` = ?";
            $stmt = $trainmastas_conn->prepare($query);
            $stmt->bind_param("sisss", $verification_code, $attempt_count, $expires_at, $current_time, $existing_verification_ID);
            $stmt->execute();
            $stmt->close();
            return [
                "state" => "verifying",
                "message" => "Verification code resent.",
                "email" => $email,
                "attemptNum" => $attempt_count
            ];
        } else if ($status === "pending" && $attempt_count >= 3 && strtotime($updated_at) > strtotime($six_hours_ago)) {
            return [
                "state" => "limitReached",
                "message" => "You have reached the maximum attempts within six hours."
            ];
        }
    }

    // Insert a new record if none exists
    $verification_ID = generateRandomId(); // Use a unique ID generator if necessary
    $query = "INSERT INTO `user_verification` 
              (`verification_ID`, `user_ID`, `action_type`, `verification_code`, `attempt_count`, `expires_at`, `status`, `updated_at`) 
              VALUES (?, ?, ?, ?, ?, ?, 'pending', ?)";
    $stmt = $trainmastas_conn->prepare($query);
    $attempt_count = 1; // Start with a fresh attempt count
    $stmt->bind_param(
        "sssisss",
        $verification_ID,
        $UID,
        $action_type,
        $verification_code,
        $attempt_count,
        $expires_at,
        $current_time
    );
    $stmt->execute();
    $stmt->close();

    return [
        "state" => "verifying",
        "message" => "New verification code generated.",
        "email" => $email,
        "attemptNum" => $attempt_count
    ];
}

// Function to verify the code
function verifyCode($trainmastas_conn, $UID, $email, $verification_code)
{
    // Determine whether to use user_ID or email in the query
    // Check if email is null  
    if ($email === null) {
        // Fetch the email using user_ID  
        $query = "SELECT a.`Email` FROM `authentication` AS a WHERE a.`user_ID` = ?"; // Assuming user_ID is the correct field in the admin table  
        $temp_stmt = $trainmastas_conn->prepare($query);
        $temp_stmt->bind_param("s", $UID); // Assuming $UID is a string  
        $temp_stmt->execute();
        $temp_stmt->bind_result($email);
    } else {
        // Fetch the user_ID using email  
        $query = "SELECT a.`user_ID`  FROM `authentication` AS a WHERE a.`Email` = ?"; // Fetch user_ID using the provided email  
        // Prepare the statement  
        $temp_stmt = $trainmastas_conn->prepare($query);
        $temp_stmt->bind_param("s", $email); // Assuming email is a string  
        $temp_stmt->execute();
        $temp_stmt->bind_result($UID);
    }
    $record_found = $temp_stmt->fetch();
    if (!$record_found) {
        return [
            "state" => "error",
            "message" => "Error occurred"
        ];
    }
    $temp_stmt->close();

    // Query to fetch verification details
    $query = "SELECT * FROM `user_verification` 
              WHERE (`Email` = ? OR `user_ID`=?)
              AND `verification_code` = ?";

    $stmt = $trainmastas_conn->prepare($query);
    $stmt->bind_param('sss', $email, $UID, $verification_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];
        $expires_at = $row['expires_at'];
        $updated_at = $row['updated_at'];
        $current_time = date("Y-m-d H:i:s");

        // If status is "verified";
        if ($status === "verified") {
            // Check if the verification was done more than 6 hours ago
            if (strtotime($current_time) - strtotime($updated_at) > 6 * 60 * 60) {
                return ["state" => "expired", "message" => "Verification code expired. Please request a new one."];
            } else {
                return ["state" => "verified_recent", "message" => "Verification code has already been verified within the last 6 hours."];
            }
        }

        // If status is "pending," check for expiration
        if (strtotime($current_time) > strtotime($expires_at)) {
            return ["state" => "expired", "message" => "Verification code has expired. Please request a new one."];
        }

        // Update the status to "verified"
        $updateQuery = "UPDATE `user_verification` 
                        SET `status` = 'verified', `updated_at` = NOW() 
                        WHERE (`Email` = ? OR `user_ID`=?) AND `verification_code` = ?";
        $updateStmt = $trainmastas_conn->prepare($updateQuery);
        $updateStmt->bind_param('sss', $email, $UID, $verification_code);

        if ($updateStmt->execute()) {
            return ["state" => "verified"];
        } else {
            return ["state" => "error", "message" => "Failed to update verification status."];
        }
    } else {
        return ["state" => "wrong", "message" => "Invalid verification code."];
    }
}

// Function to update the password
function updatePassword($trainmastas_conn, $UID, $email, $password)
{
    if ($email == null) {
        $addQuery = "user_ID";
        $bindThis = $UID;
    } else {
        $addQuery = "Email";
        $bindThis = $email;
    }
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE `authentication` SET `Password` = ? WHERE `$addQuery` = ?";
    $stmt = $trainmastas_conn->prepare($query);
    $stmt->bind_param('ss', $passwordHash, $bindThis);

    if ($stmt->execute()) {
        return ["state" => "success"];
    } else {
        return ["state" => "error", "message" => "Failed to update password."];
    }
}
// Function to generate code
function generateVerificationCode()
{
    return rand(100000, 999999); // Generate a 6-digit random code
}
if (isset($_POST['purpose']) && $_POST['purpose'] === "verifyPasswordAction") {
    $purpose = $_POST['purpose'];
    $password = $_POST['password'];
    $email = null;

    // Check if the user is inside (logged in) or outside (using email)
    if (isset($_POST['user-email'])) {
        $UID = null;
        $email = $_POST['user-email'];
    } else {
        echo json_encode(["state" => "error", "message" => "Invalid request."]);
        header("location:login.php");
        include "close_connection.php";
        exit;
    }

    // Fetch stored password hash if the user_ID is present
    if ($UID) {
        $query = "SELECT password FROM authentication WHERE user_ID = ?";
        $stmt = $trainmastas_conn->prepare($query);
        $stmt->bind_param("s", $UID);
        $stmt->execute();
        $stmt->bind_result($stored_hash);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($password, $stored_hash)) {
            echo json_encode(["state" => "samePassword"]);
            include "close_connection.php";
            exit;
        }
    }

    // Generate and process the verification code
    $verification_code = generateVerificationCode();
    $action_type = "password";
    $response = createOrUpdateVerification($trainmastas_conn, $UID, $email, $verification_code, $action_type);

    if ($response["state"] === "limitReached") {
        echo json_encode($response);
        include "close_connection.php";
        exit;
    }
    $content = '<!DOCTYPE html>
                <html lang="en">  
                <head>  
                    <meta charset="UTF-8">  
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
                    <title>TrainMastas Password Verification</title>  
                    <style>  
                        body {  
                            font-family: Arial, sans-serif;  
                            margin: 0;  
                            padding: 0;  
                            background-color: #198754;  
                            color: #333;  
                        }  
                        .container {  
                            width: 100%;  
                            max-width: 600px;  
                            margin: 20px auto;  
                            background: #ffffff;  
                            border-radius: 8px;  
                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);  
                            overflow: hidden;  
                        }  
                        .header {  
                            background-color: #198754; /* Success color */  
                            color: #ffffff;  
                            padding: 20px;  
                            text-align: center;  
                        }  
                        .content {  
                            padding: 20px;  
                        }  
                        .footer {  
                            padding: 10px;  
                            text-align: center;  
                            font-size: 12px;  
                            color: #888;  
                        }  
                        .code {  
                            font-size: 24px;  
                            font-weight: bold;  
                            color: #198754; /* Success color */  
                        }  
                    </style>  
                </head>  
                <body>  
                    <div class="container">  
                        <div class="header">  
                            <h1>TrainMastas</h1>  
                            <p>Password Verification Code</p>  
                        </div>  
                        <div class="content">  
                            <p>Hello,</p>  
                            <p>Your password verification code is:</p>  
                            <p class="code">'. $verification_code. '</p><!-- Replace with actual code -->  
                            <p>Please enter this code in the application to proceed.</p>  
                            <p>If you didn’t request this code, please ignore this email.</p>  
                        </div>  
                        <div class="footer">  
                            <p>&copy; 2025 TrainMastas. All rights reserved.</p>  
                        </div>  
                    </div>  
                </body>  
                </html>';
                
    // Send verification code to the user email (implement the actual email-sending logic here
    sendEmail($email, $content, "TrainMastas - One-Time Verification Code");
    echo json_encode($response);
} else if (isset($_POST['purpose']) && $_POST['purpose'] === "verifyPasswordActionReset") {
    $purpose = $_POST['purpose'];
    $password = $_POST['password'];

    $email = null;

    // Check if the user is inside (logged in) or outside (using email)
    if ($UID) {
        $addQuery = "user_ID";
        $bindThis = $UID;
    } else if (isset($_SESSION['user-email'])) {
        $email = $_SESSION['user-email'];
        $addQuery = "Email";
        $UID = null;
        $bindThis = $_SESSION['user-email'];
    } else {
        echo json_encode(["state" => "error", "message" => "Invalid request."]);
        header("location:login.php");
        include "close_connection.php";
        exit;
    }

    // Fetch stored password hash if the user_ID is present
    if ($bindThis) {
        $query = "SELECT password FROM authentication WHERE $addQuery = ?";
        $stmt = $trainmastas_conn->prepare($query);
        $stmt->bind_param("s", $bindThis);
        $stmt->execute();
        $stmt->bind_result($stored_hash);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($password, $stored_hash)) {
            echo json_encode(["state" => "samePassword"]);
            include "close_connection.php";
            exit;
        }
    }

    $passwordUpdateResult = updatePassword($trainmastas_conn, $UID, $email, $password);
    echo json_encode($passwordUpdateResult);
} else if (isset($_POST['purpose']) && $_POST['purpose'] === "verifyPasswordCode") {
    $email = null;
    $verification_code = $_POST['verificationCode'];
    $password = $_POST['password'];
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }

    // Step 1: Verify the code
    $verificationResult = verifyCode($trainmastas_conn, $UID, $email, $verification_code);

    if ($verificationResult['state'] === "verified") {
        // Step 2: Update the password
        $passwordUpdateResult = updatePassword($trainmastas_conn, $UID, $email, $password);
        echo json_encode($passwordUpdateResult);
    } else {
        // Send the verification result if code verification fails
        echo json_encode($verificationResult);
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] === "verifyPasswordCodeReset") {
    // Verification of code when not logged in
    $email = null;
    $verification_code = $_POST['verificationCode'];
    if (isset($_SESSION['user-email'])) {
        $UID = null;
        $email = $_SESSION['user-email']; // Replace with actual session or user ID
    } else {
        header("location:login.php");
    }
    // Step 1: Verify the code
    $verificationResult = verifyCode($trainmastas_conn, $UID, $email, $verification_code);
    echo json_encode($verificationResult);
} else if (isset($_POST['purpose']) && $_POST['purpose'] === "verifyEmailAction") {
    if (isset($_POST['email'])) {
        // Get the email from POST data  
        $UID = null;
        $email = $_POST['email'];
        $_SESSION['user-email'] = $email;

        // Sanitize and validate the email  
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // The email is valid, now prepare the query  
            $query = "SELECT COUNT(*) FROM authentication WHERE email = ?";

            // Initialize a prepared statement  
            if ($stmt = $trainmastas_conn->prepare($query)) {
                // Bind the parameter  
                $stmt->bind_param("s", $email); // "s" specifies the variable type => string  

                // Execute the statement  
                $stmt->execute();

                // Get the result  
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                // Check if email exists  
                if ($count > 0) {
                    // Generate and process the verification code
                    $verification_code = generateVerificationCode();
                    $action_type = "password";
                    $response = createOrUpdateVerification($trainmastas_conn, $UID, $email, $verification_code, $action_type);

                    if ($response["state"] === "limitReached") {
                        echo json_encode($response);
                        include "close_connection.php";
                        exit;
                    }

                    $content = '<!DOCTYPE html>
                                <html lang="en">  
                                <head>  
                                    <meta charset="UTF-8">  
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
                                    <title>TrainMastas Password Verification</title>  
                                    <style>  
                                        body {  
                                            font-family: Arial, sans-serif;  
                                            margin: 0;  
                                            padding: 0;  
                                            background-color: #198754;  
                                            color: #333;  
                                        }  
                                        .container {  
                                            width: 100%;  
                                            max-width: 600px;  
                                            margin: 20px auto;  
                                            background: #ffffff;  
                                            border-radius: 8px;  
                                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);  
                                            overflow: hidden;  
                                        }  
                                        .header {  
                                            background-color: #198754; /* Success color */  
                                            color: #ffffff;  
                                            padding: 20px;  
                                            text-align: center;  
                                        }  
                                        .content {  
                                            padding: 20px;  
                                        }  
                                        .footer {  
                                            padding: 10px;  
                                            text-align: center;  
                                            font-size: 12px;  
                                            color: #888;  
                                        }  
                                        .code {  
                                            font-size: 24px;  
                                            font-weight: bold;  
                                            color: #198754; /* Success color */  
                                        }  
                                    </style>  
                                </head>  
                                <body>  
                                    <div class="container">  
                                        <div class="header">  
                                            <h1>TrainMastas</h1>  
                                            <p>Password Verification Code</p>  
                                        </div>  
                                        <div class="content">  
                                            <p>Hello,</p>  
                                            <p>Your password verification code is:</p>  
                                            <p class="code">'. $verification_code. '</p><!-- Replace with actual code -->  
                                            <p>Please enter this code in the application to proceed.</p>  
                                            <p>If you didn’t request this code, please ignore this email.</p>  
                                        </div>  
                                        <div class="footer">  
                                            <p>&copy; 2025 TrainMastas. All rights reserved.</p>  
                                        </div>  
                                    </div>  
                                </body>  
                                </html>';
                
                    // Send verification code to the user email (implement the actual email-sending logic here
                    sendEmail($email, $content, "TrainMastas - One-Time Verification Code");
                } else {
                    $response = [
                        "state" => "not_found",
                        "message" => "Email does not exist in the authentication table."
                    ];
                }

                // Close the statement  
            } else {
                $response = [
                    "state" => "error",
                    "message" => "Error preparing the statement: "
                ];
            }
        } else {
            $response = [
                "state" => "validation_error",
                "message" => "Invalid email format."
            ];
        }
    } else {
        $response = [
            "state" => "error",
            "message" => "Email not provided."
        ];
    }


    // Echo the JSON response  
    echo json_encode($response);
} else {

    echo json_encode(["state" => "error", "message" => "Invalid purpose."]);
}
include "close_connection.php";
