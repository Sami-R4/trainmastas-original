<?php
include "connection.php"; // Ensure this file has proper database connection variables
require '../vendor/autoload.php';
require("send_email.php");

use Ramsey\Uuid\Uuid;

// Function to generate a UUID
function makeID()
{
    return Uuid::uuid4()->toString();
}
// Check if form is submitted
require_once 'vendors/vendor/autoload.php'; // Load Firebase JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['state' => 'invalid']);
        exit();
    }

    // Prepare and execute query
    $sql = "SELECT u.user_ID, u.Password, us.type, us.Name, us.action   
            FROM authentication u 
            JOIN user us ON us.user_ID = u.user_ID   
            WHERE u.Email = ?";

    $stmt = $trainmastas_conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(['state' => 'notfound']);
        exit();
    }

    $stmt->bind_result($UID, $hashedPassword, $type, $name, $action);
    $stmt->fetch();
    $stmt->close();

    if ($action === 'd') {
        echo json_encode(['state' => 'deleted']);
        exit();
    }
    if ($action === 'b') {
        echo json_encode(['state' => 'banned']);
        exit();
    }

    // Check if user is permanently deleted
    $deletedCheckQuery = "SELECT 1 FROM admin_deleted WHERE user_ID = ?";
    $deletedStmt = $trainmastas_conn->prepare($deletedCheckQuery);
    $deletedStmt->bind_param("s", $UID);
    $deletedStmt->execute();
    $deletedStmt->store_result();

    if ($deletedStmt->num_rows > 0) {
        echo json_encode(['state' => 'deleted_forever']);
        $deletedStmt->close();
        exit();
    }
    $deletedStmt->close();

    if (!password_verify($password, $hashedPassword)) {
        echo json_encode(['state' => 'wrong']);
        exit();
    }

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
    //////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////

    $accessPayload = [
        'uid' => $UID,
        'utype' => $type,
        'refresh_token_id' => $refreshID,  // Add the refresh token ID
        'iat' => $issuedAt,
        'exp' => $expire
    ];
    $accessToken = JWT::encode($accessPayload, $secretKey, 'HS256');

    // 🔄 Return tokens to frontend
    echo json_encode([
        'state' => 'success',
        'access_token' => $accessToken,
        'refresh_token' => $refreshToken,
        'user_type' => $type
    ]);
    
    $subject = "Security Alert: New Login to Your Account";

    // Replace these with actual user details
    $name = ucwords($name);
    $loginTime = date("F j, Y, g:i a"); // current login time
    $ipAddress = $_SERVER['REMOTE_ADDR']; // detect IP address, optional
    
    // Email HTML content
    $content = "
    <!DOCTYPE html>
    <html lang='en'>
    
    <head>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <title>Login Notification</title>
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
            <p>We noticed a new login to your account on <strong>{$loginTime}</strong>.</p>
            <p>If this was you, no further action is needed. If you did not log in, please secure your account immediately by changing your password and reviewing your recent activity.</p>
            <p>Login details:</p>
            <ul>
                <li><strong>IP Address:</strong> {$ipAddress}</li>
                <!-- Add more details if needed -->
            </ul>
            <p>If you have any questions or need assistance, contact our <a href='mailto:support@trainmastas.com' style='color:#198754'>support</a> team.</p>
            <div class='footer'>
                &copy; " . date("Y") . " TrainMastas. All rights reserved.
            </div>
        </div>
    </body>
    
    </html>";
                
    // Send verification code to the user email (implement the actual email-sending logic here
    sendEmail($email, $content, "Security Alert - New Login to Your Account");
} else {
    header("location: login.php");
}
include "close_connection.php";
