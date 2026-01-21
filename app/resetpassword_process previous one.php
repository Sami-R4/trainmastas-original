<?php
session_start();
include "connection.php";
require '../vendor/autoload.php';
include "session_checker.php";

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

if (isset($_POST['purpose']) && $_POST['purpose'] === "verifyPasswordAction") {
    $purpose = $_POST['purpose'];
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

    // Step 1: Fetch the stored password hash
    $query = "SELECT password FROM authentication WHERE user_ID = ?";
    $stmt = $trainmastas_conn->prepare($query);
    $stmt->bind_param("s", $UID); // Bind the username
    $stmt->execute();
    $stmt->bind_result($stored_hash); // Bind the result
    $stmt->fetch();
    $stmt->close();

    // Step 2: Verify the password
    if ($stored_hash) {
        if (password_verify($password, $stored_hash)) {
            echo json_encode(["state" => "samePassword"]);
        } else {
            // Fetch the email from the authentication table
            $emailQuery = "SELECT `email` FROM `authentication` WHERE `user_ID` = '$UID'";
            $emailResult = $trainmastas_conn->query($emailQuery);

            if ($emailResult && $emailRow = $emailResult->fetch_assoc()) {
                $email = $emailRow['email'];
            } else {
                echo json_encode(["state" => "error", "message" => "Failed to fetch email."]);
                include "close_connection.php";
                exit;
            }

            // Check if the record exists in the user_verification table
            $query = "SELECT `expires_at`, `attempt_count`, `updated_at`
                      FROM `user_verification` 
                      WHERE `user_ID` = '$UID' AND `action_type` = 'password'";
            $result = $trainmastas_conn->query($query);
            $row = $result->fetch_assoc();
            $verification_code = rand(100000, 999999); // Generate a 6-digit code

            $current_time = date("Y-m-d H:i:s");
            $six_hours_ago = date("Y-m-d H:i:s", strtotime("-6 hours"));

            if ($row) {
                $expires_at = $row['expires_at'];
                $attempt_count = (int)$row['attempt_count'];
                $updated_at = $row['updated_at'];

                if ($updated_at > $six_hours_ago) {
                    // Within six hours, enforce the attempt limit
                    if ($attempt_count >= 3) {
                        echo json_encode([
                            "state" => "limitReached",
                            "message" => "You have reached the maximum attempts for the last six hours."
                        ]);
                        include "close_connection.php";
                        exit;
                    }
                    $expires_at_temp = date("Y-m-d H:i:s", strtotime("+15 minutes"));

                    // Increment the attempt count
                    $new_attempt_count = $attempt_count + 1;
                    $updateQuery = "UPDATE `user_verification` 
                                    SET `attempt_count` = '$new_attempt_count', 
                                        `verification_code` = '$verification_code', 
                                        `expires_at` = '$expires_at_temp', 
                                        `updated_at` = '$current_time', 
                                        `status` = 'pending' 
                                    WHERE `user_ID` = '$UID' AND `action_type` = 'password'";

                    if ($trainmastas_conn->query($updateQuery) === TRUE) {
                        echo json_encode([
                            "state" => "verifying",
                            "attemptNum" => $new_attempt_count,
                            "email" => $email
                        ]);
                        ////////////////////////////////////////////////////////////////////
                        //////////////// SEND THIS TO USER'S EMAIL ADDRESS /////////////////
                        ////////////////////////////////////////////////////////////////////
                        // $verification_code;
                        include "close_connection.php";
                        exit;
                    } else {
                        echo json_encode([
                            "state" => "error",
                            "message" => "Failed to update attempt count."
                        ]);
                        include "close_connection.php";
                        exit;
                    }
                }
            }

            // If the record is expired or the six-hour window has passed, create or reset the record
            $trainmastas_conn->query("DELETE FROM `user_verification` WHERE `user_ID` = '$UID' AND `action_type` = 'password'");

            $verification_ID = generateRandomId();
            $action_type = 'password';
            $attempt_count = 1; // Reset attempt count
            $expires_at = date("Y-m-d H:i:s", strtotime("+15 minutes"));
            $status = 'pending';
            $created_at = $current_time;

            $insertQuery = "INSERT INTO `user_verification`(`verification_ID`, `user_ID`, `action_type`, `verification_code`, `attempt_count`, `expires_at`, `status`, `updated_at`, `created_at`) 
                            VALUES ('$verification_ID', '$UID', '$action_type', '$verification_code', '$attempt_count', '$expires_at', '$status', '$current_time', '$current_time')";

            if ($trainmastas_conn->query($insertQuery) === TRUE) {
                echo json_encode([
                    "state" => "verifying",
                    "email" => $email,
                    "attemptNum" => $attempt_count
                ]);
                ////////////////////////////////////////////////////////////////////
                //////////////// SEND THIS TO USER'S EMAIL ADDRESS /////////////////
                ////////////////////////////////////////////////////////////////////
                // $verification_code;
            } else {
                echo json_encode([
                    "state" => "error",
                    "message" => "Failed to insert verification data."
                ]);
            }
        }
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] === "verifyPasswordCode") {
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
    // Check verification code and expiration time
    $query = "SELECT * FROM `user_verification` 
              WHERE `user_ID`='$UID' 
              AND `verification_code`='$verification_code' 
              AND `status`='pending'";

    $result = $trainmastas_conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $expires_at = $row['expires_at'];

        // Check if the code has expired (15 minutes passed)
        $current_time = date("Y-m-d H:i:s");
        if (strtotime($current_time) > strtotime($expires_at)) {
            echo json_encode(["state" => "expired", "message" => "Verification code has expired. Please request a new one."]);
        } else {
            // Mark the verification as completed
            $updateVerificationQuery = "UPDATE `user_verification` SET `status`='verified', `updated_at`=NOW() WHERE `user_ID`='$UID' AND `verification_code`='$verification_code'";
            if ($trainmastas_conn->query($updateVerificationQuery) === TRUE) {
                // Update the user's password
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Using prepared statement to avoid SQL Injection  
                $stmt = $trainmastas_conn->prepare("UPDATE `authentication` SET `Password`=? WHERE `user_ID`=?");
                $stmt->bind_param('ss', $passwordHash, $UID);

                if ($stmt->execute()) {
                    echo json_encode(["state" => "success"]);
                } else {
                    echo json_encode(["state" => "error", "error" => $stmt->error]);
                }
                // Don't forget to close the statement and connection afterward  
                $stmt->close();
            } else {
                echo json_encode(["state" => "error", "message" => "Failed to update verification status."]);
            }
        }
    } else {
        echo json_encode(["state" => "wrong", "message" => "Invalid verification code."]);
    }
} else {
    echo json_encode(["state" => "error", "message" => "Invalid purpose."]);
}
include "close_connection.php";
