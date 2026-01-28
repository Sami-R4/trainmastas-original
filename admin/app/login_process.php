<?php
session_start();
include "connection.php"; // Ensure this file has proper database connection variables

// Check if form is submitted
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])) {
    // Retrieve and sanitize POST data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($email) || empty($password) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "invalid";
        include "close_connection.php";
        exit();
    }

    // Check if the user exists and is not deleted/banned
    $sql = "SELECT user_ID, Type, Password, action FROM admin WHERE Email = ?";
    $stmt = $trainmastas_conn->prepare($sql);
    if ($stmt === false) {
        echo "error";
        include "close_connection.php";
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo "notfound";
        $stmt->close();
        include "close_connection.php";
        exit();
    }

    $stmt->bind_result($UID, $Type, $hashedPassword, $action);
    $stmt->fetch();
    $stmt->close();

    // Check if action is 'd' (deleted) or 'b' (banned)
    if ($action === 'd') {
        echo "deleted"; // Account deleted or banned
        include "close_connection.php";
        exit();
    }
    if ($action === 'b') {
        echo "banned"; // Account deleted or banned
        include "close_connection.php";
        exit();
    }

    // Check if user exists in admin_deleted (permanently deleted)
    $deleteCheckSQL = "SELECT 1 FROM admin_deleted WHERE email = ? LIMIT 1";
    $deleteStmt = $trainmastas_conn->prepare($deleteCheckSQL);
    if ($deleteStmt === false) {
        echo "error";
        include "close_connection.php";
        exit();
    }
    $deleteStmt->bind_param("s", $email);
    $deleteStmt->execute();
    $deleteStmt->store_result();

    if ($deleteStmt->num_rows > 0) {
        echo "deleted_forever"; // Account permanently deleted
        $deleteStmt->close();
        include "close_connection.php";
        exit();
    }
    $deleteStmt->close();

    // Verify password
    if (!password_verify($password, $hashedPassword)) {
        echo "wrong";
        include "close_connection.php";
        exit();
    }

    // Set session variables
    $_SESSION['AID'] = $UID;
    $_SESSION['AdminType'] = $Type;
    if ($Type == "super") {
        $dateThreshold = date('Y-m-d H:i:s', strtotime('-10 days'));

        // Delete records where the date is 10 days ago or older  
        $deleteOldRejections = "DELETE FROM courses_rejected WHERE date < ?";
        $stmt = $trainmastas_conn->prepare($deleteOldRejections);
        $stmt->bind_param("s", $dateThreshold);
        $stmt->execute();
        $stmt->close();
    }
    echo "success";
} else {
    header("location: login.php");
}
include "close_connection.php";
