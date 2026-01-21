<?php
require_once "connection.php"; // DB connection
require_once 'vendors/vendor/autoload.php'; // Firebase JWT

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Get headers and extract token
$headers = getallheaders();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
$token = '';

if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $token = $matches[1];
} else {
    echo json_encode(["state" => "error", "message" => "Access token not provided."]);
    exit;
}

// Decode token to get user_id and refresh_tokens_id
$userID = null;
$refreshTokenID = null;

try {
    // Try to decode the token normally
    $decoded = JWT::decode($token, new Key('your_super_secret_key_here', 'HS256'));
    $userID = $decoded->uid ?? null;
    $refreshTokenID = $decoded->refresh_token_id ?? null;
} catch (\Firebase\JWT\ExpiredException $e) {
    // Token expired — manually decode payload
    $parts = explode('.', $token);
    if (count($parts) === 3) {
        $payload = json_decode(base64_decode($parts[1]));
        $userID = $payload->uid ?? null;
        $refreshTokenID = $payload->refresh_token_id ?? null;
    }
} catch (Exception $e) {
    echo json_encode(["state" => "error", "message" => "Invalid token."]);
    exit;
}

if ($userID) {
    if ($refreshTokenID) {
        // Delete the specific session
        $stmt = $trainmastas_conn->prepare("DELETE FROM refresh_tokens WHERE user_id = ? AND refresh_tokens_id = ?");
        $stmt->bind_param("ss", $userID, $refreshTokenID);
    } else {
        // Fallback: delete all sessions for this user
        $stmt = $trainmastas_conn->prepare("DELETE FROM refresh_tokens WHERE user_id = ?");
        $stmt->bind_param("s", $userID);
    }

    $stmt->execute();
    $stmt->close();

    echo json_encode(["state" => "success", "message" => "Logged out successfully."]);
} else {
    echo json_encode(["state" => "error", "message" => "Failed to identify user."]);
}

require_once "close_connection.php";
