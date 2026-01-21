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
// allUsers, bannedUsers, deletedUsers, noActionUsers
if (isset($_POST['purpose']) && ($_POST['purpose'] === 'allUsers' || $_POST['purpose'] === 'bannedUsers' || $_POST['purpose'] === 'deletedUsers' || $_POST['purpose'] === 'noActionUsers')) {
    $filterValue = isset($_POST['filterValue']) ? $_POST['filterValue'] : null;
    $actionFilter = "";
    $AID = $_SESSION['AID'];
    $AdminType = $_SESSION['AdminType'];
    if ($_POST['purpose'] === 'allUsers') {
        $actionFilter = "";  // No filter, fetch all admins
    } else if ($_POST['purpose'] === 'deletedUsers') {
        $actionFilter = "AND action = 'd'";  // Fetch deleted admins
    } elseif ($_POST['purpose'] === 'bannedUsers') {
        $actionFilter = "AND action = 'b'";  // Fetch banned admins
    } elseif ($_POST['purpose'] === 'noActionUsers') {
        $actionFilter = "AND action = 'n'";  // Fetch admins with no action
    }

    // Validate filterValue: Check if it's not empty and matches a Type
    $filterCondition = "";
    if ($filterValue !== null && $filterValue !== "") {
        $filterValue = mysqli_real_escape_string($trainmastas_conn, $filterValue); // Sanitize input
        $filterCondition = " AND (Name LIKE '%$filterValue%' OR Type LIKE '%$filterValue%')";
    }

    // Get the page number and calculate the offset
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1; // Default to page 1 if not set
    $items_per_page = 20; // Number of records per page
    $offset = ($page - 1) * $items_per_page;

    // Query to get admins with pagination
    $query = "SELECT user_ID, Name, Email, Date, Type, action 
          FROM admin 
           WHERE user_ID != '$AID' $actionFilter $filterCondition 
          ORDER BY Date DESC 
          LIMIT $offset, $items_per_page";

    // Count query for total admins with the filter condition
    $count = "SELECT COUNT(*) AS total_admins 
          FROM admin 
           WHERE user_ID != '$AID' $actionFilter $filterCondition";
    $result = mysqli_query($trainmastas_conn, $query);
    $result_count = mysqli_query($trainmastas_conn, $count);
    $data = [];
    $total_admins = 0;
    if ($result && mysqli_num_rows($result) > 0) {
        $state = "success";
        while ($row = mysqli_fetch_assoc($result)) {
            $row['user_ID'] = base64_encode($row['user_ID']);
            $data[] = $row; // Collect each admin's data
        }
    } else {
        $state = "noUser";
    }

    if ($result_count && $row_count = mysqli_fetch_assoc($result_count)) {
        $total_admins = $row_count['total_admins'];
    }

    echo json_encode(['state' => $state, 'data' => $data, 'total_admins' => $total_admins, 'AdminType' => $AdminType]);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "clearAll") {
    if ($_SESSION['AdminType'] === "super") {
        // Super admin can delete middle and lower admins  
        $allowedRoles = ["middle", "lower"];
    } elseif ($_SESSION['AdminType'] === "middle") {
        // Middle admin can only delete lower admins  
        $allowedRoles = ["lower"];
    } else {
        // Lower admin cannot delete anyone  
        echo json_encode(["state" => "notAuthorized", "message" => "User not authorized."]);
        include "close_connection.php";
        exit;
    }

    // Fetch all admins with action = 'd' excluding the current admin's ID  
    $currentAdminID = $_SESSION['AID']; // Assuming you have stored admin ID in session  
    $adminsQuery = "SELECT user_ID, Name, Email  
                    FROM admin   
                    WHERE action = 'd' AND user_ID != $currentAdminID";

    $adminsResult = mysqli_query($trainmastas_conn, $adminsQuery);
    $notDeletedNames = []; // Initialize array for names of admins not deleted  

    if ($adminsResult && mysqli_num_rows($adminsResult) > 0) {
        while ($adminRow = mysqli_fetch_assoc($adminsResult)) {
            $adminID = $adminRow['user_ID'];
            $adminName = $adminRow['Name']; // Get the admin's name  
            $adminEmail = $adminRow['Email'];

            // Check if the admin can be deleted based on the admin type  
            $adminTypeQuery = "SELECT AdminType FROM admin WHERE user_ID = $adminID";
            $adminTypeResult = mysqli_query($trainmastas_conn, $adminTypeQuery);
            $adminTypeRow = mysqli_fetch_assoc($adminTypeResult);
            $adminType = $adminTypeRow['AdminType'];

            if (in_array($adminType, $allowedRoles)) {
                // 1. Delete from the admin table  
                $deleteAdminQuery = "DELETE FROM admin WHERE user_ID = $adminID";
                mysqli_query($trainmastas_conn, $deleteAdminQuery);

                // 2. Insert into the admin_deleted table  
                $deleteRecordQuery = "INSERT INTO admin_deleted (user_ID, email, deleted_by, date)   
                                      VALUES ($adminID, '$adminEmail', $currentAdminID, NOW())";
                mysqli_query($trainmastas_conn, $deleteRecordQuery);
            } else {
                // Store the name if the admin cannot be deleted  
                $notDeletedNames[] = $adminName;
            }
        }

        mysqli_commit($trainmastas_conn);
        $response = [
            'state' => 'deleted_success',
            'message' => 'Admins deleted successfully.',
            'userNotCleared' => $notDeletedNames // Return names of not deleted admins  
        ];
        echo json_encode($response);
    } else {
        echo json_encode(['state' => 'no_users', 'message' => 'No admins found with action = "d".']);
    }
} else if (isset($_POST['purpose']) && !empty($_POST['id']) && ($_POST['purpose'] == "deleteThis" || $_POST['purpose'] == "banThis" || $_POST['purpose'] == "restoreThis" || $_POST['purpose'] == "unBanThis")) {

    if ($_SESSION['AdminType'] == "lower") {
        echo json_encode(["state" => "notAuthorized", "message" => "User not authorized."]);
        include "close_connection.php";
        exit;
    }

    $adminID = base64_decode($_POST['id']);
    $action = '';
    $successMessage = '';
    $state = "error";

    // Get the target admin's type
    $getTargetTypeQuery = "SELECT type FROM admin WHERE user_ID = ?";
    $stmt = mysqli_prepare($trainmastas_conn, $getTargetTypeQuery);
    mysqli_stmt_bind_param($stmt, 's', $adminID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        echo json_encode(["state" => "error", "message" => "Admin not found."]);
        include "close_connection.php";
        exit;
    }

    mysqli_stmt_bind_result($stmt, $targetAdminType);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // **Authorization Rules**
    if ($_SESSION['AdminType'] == "super" && $targetAdminType == "super") {
        echo json_encode(["state" => "notAuthorized", "message" => "Super Admins cannot take action against other Super Admins."]);
        include "close_connection.php";
        exit;
    }

    if ($_SESSION['AdminType'] == "middle" && ($targetAdminType == "middle" || $targetAdminType == "super")) {
        echo json_encode(["state" => "notAuthorized", "message" => "Middle Admins cannot take action against other Middle or Super Admins."]);
        include "close_connection.php";
        exit;
    }

    // **Determine Action**
    if ($_POST['purpose'] == "deleteThis") {
        $action = 'd';
        $state = "admin_marked_deleted";
        $successMessage = 'Admin marked for deletion.';
    } elseif ($_POST['purpose'] == "banThis") {
        $action = 'b';
        $state = "admin_marked_banned";
        $successMessage = 'Admin marked as banned.';
    } else {
        $state = "admin_delete_free";
        if ($_POST['purpose'] == "unBanThis") {
            $state = "admin_ban_free";
        }
        $action = 'n';
        $successMessage = 'User marked as no action restriction.';
    }

    // **Update Action in Database**
    $updateActionQuery = "UPDATE admin SET action = ? WHERE user_ID = ?";
    $stmt = mysqli_prepare($trainmastas_conn, $updateActionQuery);
    mysqli_stmt_bind_param($stmt, 'ss', $action, $adminID);
    $updateResult = mysqli_stmt_execute($stmt);

    if ($updateResult && mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(['state' => $state, 'message' => $successMessage]);
    } else {
        echo json_encode(['state' => "error", 'message' => 'Failed to update admin action or admin not found.']);
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "sentThisUserDetails" && !empty($_POST['id'])) {
    // Decode the user ID from base64
    $user_id = base64_decode($_POST['id']);
    $AdminType = $_SESSION['AdminType'];
    // Query user details from the admin table
    $userDetailsQuery = "  
    SELECT   
        Name,   
        Email,   
        Type,   
        Date,
        action  
    FROM admin  
    WHERE user_ID = '$user_id'";

    $userDetailsResult = mysqli_query($trainmastas_conn, $userDetailsQuery);

    // Check if the user exists
    if ($userDetailsResult && mysqli_num_rows($userDetailsResult) > 0) {
        $userDetails = mysqli_fetch_assoc($userDetailsResult);

        // This can be considered if you permit middle admin to delete forever the lower admin
        //   If the admin type is 'middle', fetch related deleted user records
        // if ($userDetails['Type'] === 'middle') {
        //     $itemsPerPage = 20;
        //     $offset = isset($_POST['page']) ? intval($_POST['page']) * $itemsPerPage : 0;

        //     // Fetch from user_deleted table
        //     $userDeletedQuery = "SELECT user_ID, email, admin_ID, type, date 
        //                      FROM user_deleted 
        //                      WHERE admin_ID = '$user_id' 
        //                      LIMIT $offset, $itemsPerPage";
        //     $userDeletedResult = mysqli_query($trainmastas_conn, $userDeletedQuery);
        //     $userDeletedData = [];
        //     if ($userDeletedResult && mysqli_num_rows($userDeletedResult) > 0) {
        //         while ($row = mysqli_fetch_assoc($userDeletedResult)) {
        //             $row["user_ID"] = base64_encode($row["user_ID"]);
        //             $userDeletedData[] = $row;
        //         }
        //     }

        //     // Fetch from admin_deleted table
        //     $adminDeletedQuery = "SELECT user_ID, email, deleted_by, date 
        //                       FROM admin_deleted 
        //                       WHERE deleted_by = '$user_id' 
        //                       LIMIT $offset, $itemsPerPage";
        //     $adminDeletedResult = mysqli_query($trainmastas_conn, $adminDeletedQuery);
        //     $adminDeletedData = [];
        //     if ($adminDeletedResult && mysqli_num_rows($adminDeletedResult) > 0) {
        //         while ($row = mysqli_fetch_assoc($adminDeletedResult)) {
        //             $row["user_ID"] = base64_encode($row["user_ID"]);
        //             $adminDeletedData[] = $row;
        //         }
        //     }
        // }
        // 'userDeleted' => $userDeletedData ?? [],
        // 'adminDeleted' => $adminDeletedData ?? [],

        // Send response
        echo json_encode([
            'state' => 'successFetching',
            'userDetails' => $userDetails,
            'AdminType' => $AdminType,
        ]);
    } else {
        echo json_encode(['state' => 'notfound', 'message' => 'User not found.']);
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] == 'newAdmin') {
    $response = ["state" => "error", "message" => "", "addedAdmins" => [], "failedAdmins" => []];

    // Check if the current user is logged in and has an AdminType
    if (!isset($_SESSION['AdminType'])) {
        $response['message'] = "Unauthorized access.";
        echo json_encode($response);
        exit;
    }

    $currentAdminType = $_SESSION['AdminType']; // Get the admin's type from session

    // Ensure input arrays exist
    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['type'])) {
        $response['message'] = "Invalid request.";
        echo json_encode($response);
        exit;
    }

    // Retrieve input data
    $names = $_POST['name']; // Array of names
    $emails = $_POST['email']; // Array of emails
    $types = $_POST['type']; // Array of admin types (optional, default = lower)

    $validHierarchy = [
        "super" => ["middle", "lower"],  // Super can create Middle or Lower Admin
        "middle" => ["lower"],          // Middle can only create Lower Admin
        "lower" => []                    // Lower cannot create any Admin
    ];

    $defaultPassword = '$2y$10$4TQSJM2349XaCdzsUjH10OE4bR4hk2lrJS8gCNX6QylvWJNX0akm2';
    $action = "n"; // Default action

    // Prepare email existence check query
    $checkQuery = "SELECT Email FROM admin WHERE Email = ?";
    $checkStmt = $trainmastas_conn->prepare($checkQuery);

    // Prepare insertion query
    $insertQuery = "INSERT INTO admin (user_ID, Name, Email, Password, Type, action, Date) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $insertStmt = $trainmastas_conn->prepare($insertQuery);

    foreach ($names as $index => $name) {
        $name = trim($name);
        $email = trim($emails[$index]);
        $type = isset($types[$index]) ? trim($types[$index]) : "lower";

        // Validate inputs
        if (empty($name) || empty($email) || empty($type)) {
            $response['failedAdmins'][] = ["name" => $name, "email" => $email, "reason" => "Missing fields."];
            continue;
        }

        // Check role hierarchy
        if (!isset($validHierarchy[$currentAdminType]) || !in_array($type, $validHierarchy[$currentAdminType])) {
            $response['failedAdmins'][] = ["name" => $name, "email" => $email, "reason" => "Permission denied."];
            continue;
        }

        // Check if email already exists
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
            $response['failedAdmins'][] = ["name" => $name, "email" => $email, "reason" => "Email already exists."];
            continue;
        }

        // Generate a unique user ID
        $user_ID = uniqid("admin_");

        // Insert admin
        $insertStmt->bind_param("ssssss", $user_ID, $name, $email, $defaultPassword, $type, $action);
        if ($insertStmt->execute()) {
            $response['addedAdmins'][] = ["name" => $name];
        } else {
            $response['failedAdmins'][] = ["name" => $name, "reason" => "Insertion failed."];
        }
    }

    // Close statements
    $checkStmt->close();
    $insertStmt->close();

    if (count($response['addedAdmins']) > 0) {
        $response['state'] = "success";
        $response['message'] = count($response['addedAdmins']) . " admins added successfully.";
    } else {
        $response['message'] = "No admins were added.";
    }
    echo json_encode($response);
} else {
    echo json_encode(["state" => "error", "message" => "Invalid purpose."]);
}
include "close_connection.php";
