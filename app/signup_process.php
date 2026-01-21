<?php
// Start the session  
session_start();
include "connection.php"; // Ensure this file has proper database connection variables
require '../vendor/autoload.php';
require("send_email.php");
// Check if form is submitted
require_once 'vendors/vendor/autoload.php'; // Load Firebase JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Ramsey\Uuid\Uuid;

// Function to generate a UUID
function makeID()
{
    return Uuid::uuid4()->toString();
}

// Check if form is submitted
if (isset($_POST['name']) && isset($_POST['signup'])) {
    // Retrieve and sanitize POST data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $accountType = trim($_POST['accountType']);

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($accountType)) {
        echo json_encode(['state' => 'invalid']);
        include "close_connection.php";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['state' => 'invalid']);
        include "close_connection.php";
        exit();
    }

    if (strlen($password) < 8) {
        echo json_encode(['state' => 'invalid']);
        include "close_connection.php";
        exit();
    }

    $conn = $trainmastas_conn; // Assuming $trainmastas_conn is defined in connection.php

    // **Check if the user was previously deleted**
    $sql_deleted_check = "SELECT 1 FROM `admin_deleted` WHERE Email = ?";
    $stmt_deleted = $conn->prepare($sql_deleted_check);
    if ($stmt_deleted === false) {
        echo json_encode(['state' => 'error']);
        include "close_connection.php";
        exit();
    }
    $stmt_deleted->bind_param("s", $email);
    $stmt_deleted->execute();
    $stmt_deleted->store_result();

    if ($stmt_deleted->num_rows > 0) {
        echo json_encode(['state' => 'deleted']); // Block signup if email exists in deleted accounts
        $stmt_deleted->close();
        include "close_connection.php";
        exit();
    }
    $stmt_deleted->close();

    // **Check if user already exists**
    $sql_check = "SELECT 1 FROM `authentication` WHERE Email = ?";
    $stmt_check = $conn->prepare($sql_check);
    if ($stmt_check === false) {
        echo json_encode(['state' => 'error']);
        include "close_connection.php";
        exit();
    }
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo json_encode(['state' => 'exist']); // User already exists
        $stmt_check->close();
        include "close_connection.php";
        exit();
    }
    $stmt_check->close();

    // Generate a UUID for the user
    $UID = makeID();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Determine user type and set database connection
    if ($accountType === "student") {
        $userType = 's';
    } elseif ($accountType === "creator") {
        $userType = 'c';
    } else {
        echo json_encode(['state' => 'invalid']);
        include "close_connection.php";
        exit();
    }

    // Insert into the `user` table
    $sql_user = "INSERT INTO `user` (user_ID, Name, type, Image, Date) VALUES (?, ?, ?, null, NOW())";
    $stmt_user = $conn->prepare($sql_user);
    if ($stmt_user === false) {
        echo json_encode(['state' => 'error']);
        include "close_connection.php";
        exit();
    }
    $stmt_user->bind_param("sss", $UID, $name, $userType);

    if ($stmt_user->execute()) {
        // Insert into the `authentication` table
        $sql_auth = "INSERT INTO `authentication` (user_ID, Email, Password) VALUES (?, ?, ?)";
        $stmt_auth = $conn->prepare($sql_auth);
        if ($stmt_auth === false) {
            echo json_encode(['state' => 'error']);

            include "close_connection.php";
            exit();
        }
        $stmt_auth->bind_param("sss", $UID, $email, $hashedPassword);

        if ($stmt_auth->execute()) {
            //////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////
            // ✅ USER IS VERIFIED — CREATE ACCESS + REFRESH TOKENS

            $issuedAt = time();
            $expire = $issuedAt + (60 * 15); // 15 mins for access token
            $secretKey = 'your_super_secret_key_here'; // Save securely

            // 🔁 Generate Refresh Token
            $refreshToken = bin2hex(random_bytes(64)); // 128 characters
            $refreshExpiry = date('Y-m-d H:i:s', time() + (60 * 60 * 24 * 30)); // 30 days
            $refreshID = makeID();


            // Step 1: Check if the refresh token already exists  
            $checkToken = $trainmastas_conn->prepare("SELECT refresh_tokens_id FROM refresh_tokens WHERE user_id = ?");
            $checkToken->bind_param("s", $UID);
            $checkToken->execute();
            $checkToken->store_result();

            if ($checkToken->num_rows > 0) {
                // Step 2: Token exists, update the existing record  
                $checkToken->bind_result($refreshID); // Bind the result  
                $checkToken->fetch(); // Fetch the data to get the refresh tokens id  

                $updateRefresh = $trainmastas_conn->prepare("UPDATE refresh_tokens SET token = ?, expires_at = ? WHERE user_id = ?");
                $updateRefresh->bind_param("sss", $refreshToken, $refreshExpiry, $UID);
                $updateRefresh->execute();
                $updateRefresh->close();
            } else {
                // Token does not exist, insert a new record  
                $insertRefresh = $trainmastas_conn->prepare("INSERT INTO refresh_tokens (refresh_tokens_id, user_id, token, expires_at) VALUES (?, ?, ?, ?)");
                $insertRefresh->bind_param("ssss", $refreshID, $UID, $refreshToken, $refreshExpiry);
                $insertRefresh->execute();
                $insertRefresh->close();
            }
            // Clean up  
            $checkToken->close();


            // Create access token
            $accessPayload = [
                'uid' => $UID,
                'utype' => $userType,
                'refresh_token_id' => $refreshID,  // Add the refresh token ID
                'iat' => $issuedAt,
                'exp' => $expire
            ];
            $accessToken = JWT::encode($accessPayload, $secretKey, 'HS256');
            //////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////

            // 🔄 Return tokens to frontend
            echo json_encode([
                'state' => 'success',
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'user_type' => $userType
            ]);
            $name = ucwords($name);
            // Email HTML content

            // Replace these with actual user details
            $creationDate = date("F j, Y, g:i a"); // Account creation time
            
            // Email HTML content
            $content = "<!DOCTYPE html>
            <html lang='en'>
            
            <head>
                <meta charset='UTF-8' />
                <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                <title>Account Created</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 20px;
                    }
            
                    .container {
                        max-width: 600px;
                        margin: auto;
                        background: #fff;
                        padding: 20px;
                        border-radius: 8px;
                    }
            
                    h2 {
                        color: #333;
                    }
            
                    p {
                        font-size: 16px;
                        line-height: 1.5;
                    }
            
                    .button {
                        display: inline-block;
                        padding: 12px 24px;
                        margin-top: 20px;
                        font-size: 16px;
                        color: #fff;
                        background-color: #198754;
                        border-radius: 4px;
                        text-decoration: none;
                    }
            
                    .footer {
                        margin-top: 20px;
                        font-size: 12px;
                        color: #777;
                    }
                </style>
            </head>
            
            <body>
                <div class='container'>
                    <h2>Hello, {$name}</h2>
                    <p>Thank you for creating an account with us on <strong>{$creationDate}</strong>.</p>
                    <p>We're excited to have you onboard! You can now log in and start exploring:</p>
                    <a href='https://yourwebsite.com/login' class='button'>Log In to Your Account</a>
                    <p>If you did not create this account or believe this is an error, please contact our <a href='mailto:support@trainmastas.com' style='color:#198754'>support</a> team immediately.</p>
                    <div class='footer'>
                        &copy; " . date("Y") . " TrainMastas. All rights reserved.
                    </div>
                </div>
            </body>
            
            </html>";
                        
            // Send verification code to the user email (implement the actual email-sending logic here
            sendEmail($email, $content, "Welcome! Your New Account Has Been Created");
        }
    } else {
        echo json_encode(['state' => 'error']);
    }

    // Close connections
    $stmt_user->close();
    $stmt_auth->close();
} else {
    header("location: login.php");
}
include "close_connection.php";
