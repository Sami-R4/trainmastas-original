<?php
require_once "vendors/vendor/autoload.php"; // Include the JWT library

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

// Set your secret key (same as the one used during token creation)
$secret_key = 'your_super_secret_key_here';

// Get headers
$headers = getallheaders();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

// Initialize token variable
$token = "";
if ($authHeader && strpos($authHeader, 'Bearer ') === 0) {
    $token = substr($authHeader, 7); // Remove "Bearer " from the token string
}

$UID = null;
$userType = null;
$refreshToken_ID = null;

if (isset($_POST["check_session"]) && $_POST["check_session"] == true) {
    if ($token) {
        require_once 'connection.php';

        try {
            // Try to decode the token normally
            $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
            $UID = $decoded->uid;
            $refreshToken_ID = $decoded->refresh_token_id ?? null;
            $userType = $decoded->utype ?? null;

            echo json_encode(["state" => "success", "UID" => $UID, "UserType" => $userType]);
        } catch (ExpiredException $e) {
            // Token expired — decode payload manually
            $tokenParts = explode('.', $token);
            if (count($tokenParts) === 3) {
                $payload = json_decode(base64_decode($tokenParts[1]));

                if ($payload && isset($payload->uid) && isset($payload->refresh_token_id)) {
                    $UID = $payload->uid;
                    $refreshToken_ID = $payload->refresh_token_id;
                    $userType = $payload->utype ?? null;

                    // Check if the refresh token exists in the database for the user
                    $sql = "SELECT token, expires_at FROM refresh_tokens WHERE user_id = ? AND refresh_tokens_id = ?";
                    $stmt = $trainmastas_conn->prepare($sql);
                    $stmt->bind_param("ss", $UID, $refreshToken_ID);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($storedRefreshToken, $refreshExpiry);
                        $stmt->fetch();

                        if (strtotime($refreshExpiry) < time()) {
                            echo json_encode(["state" => "error", "message" => "Refresh token expired. Please log in again."]);
                        } else {
                            echo json_encode(["state" => "success", "UserType" => $userType]);
                        }
                    } else {
                        echo json_encode(["state" => "error", "message" => "No refresh token found for this session."]);
                    }

                    $stmt->close();
                } else {
                    echo json_encode(["state" => "error", "message" => "Token expired and payload invalid."]);
                }
            } else {
                echo json_encode(["state" => "error", "message" => "Invalid token format."]);
            }
        } catch (Exception $e) {
            echo json_encode(["state" => "unauthorized", "message" => "Invalid token."]);
        }

        require_once 'close_connection.php';
    } else {
        echo json_encode(["state" => "unauthorized", "message" => "No token provided."]);
    }
} else {
    // // Handle backend file calls to check session
    // if ($token) {
    //     try {
    //         // Decode the token to get UID and user type
    //         $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
    //         $UID = $decoded->uid;
    //         $userType = $decoded->utype;

    //         // Do not echo or exit here, just make UID and userType available
    //     } catch (Exception $e) {
    //         $UID = null;
    //         $userType = null;
    //     }
    // }
    // Handle backend file calls to check session
    if ($token) {
        try {
            // Try to decode the token normally
            $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
            $UID = $decoded->uid ?? null;
            $userType = $decoded->utype ?? null;
        } catch (ExpiredException $e) {
            // Token is expired — manually decode payload
            $tokenParts = explode('.', $token);
            if (count($tokenParts) === 3) {
                $payload = json_decode(base64_decode($tokenParts[1]));

                if ($payload && isset($payload->uid)) {
                    $UID = $payload->uid;
                    $userType = $payload->utype ?? null;
                } else {
                    $UID = null;
                    $userType = null;
                }
            } else {
                $UID = null;
                $userType = null;
            }
        } catch (Exception $e) {
            // Token invalid for other reasons
            $UID = null;
            $userType = null;
        }
    }
}
