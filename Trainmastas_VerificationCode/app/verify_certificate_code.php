<?php

if (isset($_POST['purpose']) && $_POST['purpose'] == "verifyCertificate") {
    require "connection.php"; // or wherever your DB connections are
    $code = trim($_POST['code'] ?? '');

    if (empty($code)) {
        echo json_encode([
            'state' => 'error',
            'message' => 'Certificate code is required.'
        ]);
        include "close_connection.php";
        exit();
    }

    // Check if the certificate exists
    $stmt = $trainmastas_conn->prepare("SELECT * FROM course_registered WHERE certificate_ID = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $cert_result = $stmt->get_result();

    if ($cert_result->num_rows === 0) {
        echo json_encode([
            'state' => 'notfound',
            'message' => 'Certificate not found.'
        ]);
        include "close_connection.php";
        exit();
    }

    $cert_row = $cert_result->fetch_assoc();
    $course_ID = $cert_row['course_ID'];
    $student_ID = $cert_row['user_ID'];
    $cert_date = $cert_row['certificate_Date'];
    $cert_expired_date = $cert_row['certificate_expired_Date'];

    // Get course details
    $course_sql = "SELECT Title, user_ID AS creator_ID FROM course WHERE course_ID = ?";
    $stmt = $trainmastas_conn->prepare($course_sql);
    $stmt->bind_param("s", $course_ID);
    $stmt->execute();
    $course_result = $stmt->get_result();

    if ($course_result->num_rows === 0) {
        echo json_encode([
            'state' => 'error',
            'message' => 'Course not found for this certificate.'
        ]);
        include "close_connection.php";
        exit();
    }

    $course_row = $course_result->fetch_assoc();
    $course_title = $course_row['Title'];
    $creator_ID = $course_row['creator_ID'];

    // Get student name
    $student_sql = "SELECT Name FROM user WHERE user_ID = ?";
    $stmt = $trainmastas_conn->prepare($student_sql);
    $stmt->bind_param("s", $student_ID);
    $stmt->execute();
    $student_result = $stmt->get_result();
    $student_name = $student_result->fetch_assoc()['Name'] ?? 'Unknown';

    // Get creator name
    $creator_sql = "SELECT Name FROM user WHERE user_ID = ?";
    $stmt = $trainmastas_conn->prepare($creator_sql);
    $stmt->bind_param("s", $creator_ID);
    $stmt->execute();
    $creator_result = $stmt->get_result();
    $creator_name = $creator_result->fetch_assoc()['Name'] ?? 'Unknown';

    echo json_encode([
        'state' => 'success',
        'course_title' => $course_title,
        'certificate_date' => $cert_date,
        'student_name' => $student_name,
        'certificate_expired_date' => $cert_expired_date,
        'creator_name' => $creator_name
    ]);

    include "close_connection.php";
    exit();
} else {
    header("location:forbidden.php");
}
