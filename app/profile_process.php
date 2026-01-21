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

if (isset($_POST['purpose']) && $_POST['purpose'] == 'sendUserProfileDetails') {

    // Get user ID from session
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }
    // SQL query
    $user_info_sql = "
    SELECT 
        u.`user_ID`,
        u.`Name`,
        u.`type`,
        u.Description,
        u.`Image`,
        u.`Date`,
        a.`Email`,
        f.`field_num`,
        f.`Field`
    FROM 
        `user` u
    LEFT JOIN 
        `authentication` a ON u.`user_ID` = a.`user_ID`
    LEFT JOIN 
        `fields` f ON u.`user_ID` = f.`user_ID`
    WHERE 
        u.`user_ID` = '$UID'
";

    // Execute query
    $result = $trainmastas_conn->query($user_info_sql);



    // Prepare the SQL query  
    $stmtLink = $trainmastas_conn->prepare("SELECT COALESCE(MAX(CASE WHEN `type` = 'l' THEN `link` END), '') AS linkedinLink,  
    COALESCE(MAX(CASE WHEN `type` = 'p' THEN `link` END), '') AS portfolioLink, COALESCE(MAX(CASE WHEN `type` = 'c' THEN `link` END), '') AS cvLink FROM `user_link` WHERE `user_ID` = ?");

    // Bind the user ID parameter  
    $stmtLink->bind_param("s", $UID);
    $stmtLink->execute();

    // Bind result variables  
    $stmtLink->bind_result($linkedinLink, $portfolioLink, $cvLink);
    $stmtLink->fetch();
    $stmtLink->close();
    // Initialize an array to store user info
    $user_data = array(
        'state' => 'success',
        'fields' => array(),
        'linkedinLink' => $linkedinLink,
        'portfolioLink' => $portfolioLink,
        'cvLink' => $cvLink
    );
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Populate basic user information (only once)
            if (empty($user_data['user_ID'])) {
                $user_data['user_ID'] = base64_encode($row['user_ID']);
                // $user_data['Name'] = $row['Name'];
                $user_data["Description"] = decodeHtml($row['Description']);
                $user_data['Name'] = decodeHtml($row['Name']);
                // $user_data['Description'] = $row['Description'];
                $user_data['type'] = $row['type'];
                $user_data['Image'] = $row['Image'];  // Default to null if Image is not provided
                $user_data['Date'] = $row['Date'];
                $user_data['Email'] = $row['Email'];
            }

            // Append each field to the fields array
            if ($row['field_num'] !== null) {
                $user_data['fields'][] = array(
                    'field_num' => $row['field_num'],
                    'Field' => decodeHtml($row['Field'])
                );
            }
        }
    } else {
        echo json_encode(array('state' => 'error', 'message' => 'User not found or no data available.'));
        include "close_connection.php";
        exit();
    }

    echo json_encode($user_data);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == 'sendOtherProfile') {

    // Get the user ID from the POST request
    $UID = $_POST['OtherUser_ID'];
    if ($UID == null || $UID == '') {
        echo json_encode(array('state' => 'error', 'message' => 'Invalid user ID.'));
        include "close_connection.php";
        exit();
    }
    $UID = base64_decode($UID);

    $stmt = $trainmastas_conn->prepare("SELECT `Name`, `Description`, `type`, `Image`, `action`, `Date` FROM `user` WHERE `user_ID` = ?");
    $stmt->bind_param("s", $UID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query was successful
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check for `action` and `type` conditions
        if ($row['action'] !== 'n') {
            echo json_encode(array('state' => 'notActiveUser'));
            include "close_connection.php";
            exit();
        }
        if ($row['type'] !== 'c') {
            echo json_encode(array('state' => 'student'));
            include "close_connection.php";
            exit();
        }

        // Initialize an array to store user info
        $user_data = array(
            'state' => 'success',
            'Name' => decodeHtml($row['Name']),
            'Description' => decodeHtml($row['Description']),
            'Image' => $row['Image'], // Default to null if Image is not provided
            'Date' => $row['Date']
        );

        // Fetch the LinkedIn and Portfolio links only if the user data query was successful
        $stmtLink = $trainmastas_conn->prepare("
            SELECT 
                COALESCE(MAX(CASE WHEN `type` = 'l' THEN `link` END), '') AS linkedinLink,  
                COALESCE(MAX(CASE WHEN `type` = 'p' THEN `link` END), '') AS portfolioLink,
                COALESCE(MAX(CASE WHEN `type` = 'c' THEN `link` END), '') AS cvLink  
            FROM 
                `user_link` 
            WHERE 
                `user_ID` = ?
        ");
        // Bind the user ID parameter
        $stmtLink->bind_param("s", $UID);

        $stmtLink->execute();

        // Bind result variables
        $stmtLink->bind_result($linkedinLink, $portfolioLink, $cvLink);
        $stmtLink->fetch();
        $stmtLink->close();

        // Add social links to the user data
        $user_data['linkedinLink'] = $linkedinLink;
        $user_data['portfolioLink'] = $portfolioLink;
        $user_data['cvLink'] = $cvLink;

        // Return the user data as JSON
        echo json_encode($user_data);
    } else {
        // Return an error response if the user was not found
        echo json_encode(array('state' => 'notfound'));
        include "close_connection.php";
        exit();
    }
} else if (isset($_POST['purpose']) && $_POST['purpose'] == 'save') {
    // Get user ID from session
    if (!$UID) {
        // Not logged in, or token is invalid/expired
        echo json_encode([
            "state" => "error",
            "message" => "User not authenticated."
        ]);
        include "close_connection.php";
        exit;
    }

    // Get posted data
    $userName = isset($_POST['userName']) ? htmlspecialchars($_POST['userName'], ENT_QUOTES, 'UTF-8') : null;
    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8') : null;
    $linkedin = isset($_POST['linkedin']) ? htmlspecialchars($_POST['linkedin'], ENT_QUOTES, 'UTF-8') : null;
    $portfolio = isset($_POST['portfolio']) ? htmlspecialchars($_POST['portfolio'], ENT_QUOTES, 'UTF-8') : null;
    $currentPicture = isset($_POST['currentPicture']) ? htmlspecialchars($_POST['currentPicture'], ENT_QUOTES, 'UTF-8') : null;
    $currentCV = isset($_POST['currentCV']) ? htmlspecialchars($_POST['currentCV'], ENT_QUOTES, 'UTF-8') : null;

    // Handling picture upload if there's a new one
    $picture = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        // Check for existing picture  
        $currentPicture = str_replace('profile/', '', $currentPicture);
        // Define the upload directory for profile pictures  
        $uploadDir = '../profile/'; // Directory for storing profile pictures  

        // Get the original file name and file extension  
        $originalFileName = basename($_FILES['picture']['name']);
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION); // e.g., 'jpg', 'png'  

        // Generate a unique name for the new picture  
        $newPictureName = uniqid('profile_', true) . '.' . $fileExtension;
        $newPicturePath = $uploadDir . $newPictureName;

        // If the current picture exists, delete it  
        if ($currentPicture && file_exists($uploadDir . $currentPicture)) {
            unlink($uploadDir . $currentPicture);
        }

        // Upload the new picture  
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $newPicturePath)) {
            $picture = $newPictureName; // Save the new picture's name to DB  
        }
    }


    // Handling cv upload if there's a new one
    $cv = null;
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        // Check for existing CV  
        $currentCV = str_replace('https://trainmastas.com/cv/', '', $currentCV);
        // Define the upload directory for profile cv  
        $uploadDirCV = '../cv/'; // Directory for storing profile CV  

        // Get the original file name and file extension  
        $originalFileName = basename($_FILES['cv']['name']);
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION); // e.g., 'jpg', 'png'  
        // Generate a unique name for the new cv  
        $newCVName = uniqid('cv_', true) . '.' . $fileExtension;
        $newCVPath = $uploadDirCV . $newCVName;
        // If the current CV exists, delete it  
        if ($currentCV && file_exists($uploadDirCV . $currentCV)) {
            unlink($uploadDirCV . $currentCV);
        }

        // Upload the new cv  
        if (move_uploaded_file($_FILES['cv']['tmp_name'], $newCVPath)) {
            $cv = $newCVName; // Save the new CV's name to DB  
        }
    }

    // Update user data if there's a change
    $updateUserQuery = "UPDATE `user` SET ";

    $fieldsToUpdate = [];
    $control = false;
    // Check if the name or description has changed
    if ($userName) {
        $fieldsToUpdate[] = "`Name` = '$userName'";
        $control = true;
    }

    if ($description) {
        $fieldsToUpdate[] = "`Description` = '$description'";
        $control = true;
    }

    // Update or insert LinkedIn link  
    if ($linkedin) {
        // Check if the link already exists  
        $link_stmt = $trainmastas_conn->prepare("SELECT COUNT(*) FROM `user_link` WHERE `user_ID` = ? AND `type` = 'l'");
        $link_stmt->bind_param("s", $UID);
        $link_stmt->execute();
        $link_stmt->bind_result($count);
        $link_stmt->fetch();
        $link_stmt->close();
        if ($count > 0) {
            // Update the existing LinkedIn link  
            $link_stmt = $trainmastas_conn->prepare("UPDATE `user_link` SET `link` = ? WHERE `user_ID` = ? AND `type` = 'l'");
            $link_stmt->bind_param("ss", $linkedin, $UID);
            $link_stmt->execute();
            $link_stmt->close();
        } else {
            // Insert new LinkedIn link  
            $link_stmt = $trainmastas_conn->prepare("INSERT INTO `user_link`(`user_ID`, `type`, `link`) VALUES (?, 'l', ?)");
            $link_stmt->bind_param("ss", $UID, $linkedin);
            $link_stmt->execute();
            $link_stmt->close();
        }
    }

    // Update or insert CV link  
    if ($cv) {
        // Check if the link already exists  
        $link_stmt = $trainmastas_conn->prepare("SELECT COUNT(*) FROM `user_link` WHERE `user_ID` = ? AND `type` = 'c'");
        $link_stmt->bind_param("s", $UID);
        $link_stmt->execute();
        $link_stmt->bind_result($count);
        $link_stmt->fetch();
        $link_stmt->close();
        if ($count > 0) {
            // Update the existing CV link  
            $link_stmt = $trainmastas_conn->prepare("UPDATE `user_link` SET `link` = ? WHERE `user_ID` = ? AND `type` = 'c'");
            $link_stmt->bind_param("ss", $cv, $UID);
            $link_stmt->execute();
            $link_stmt->close();
        } else {
            // Insert new cv link  
            $link_stmt = $trainmastas_conn->prepare("INSERT INTO `user_link`(`user_ID`, `type`, `link`) VALUES (?, 'c', ?)");
            $link_stmt->bind_param("ss", $UID, $cv);
            $link_stmt->execute();
            $link_stmt->close();
        }
    }
    // Update or insert Portfolio link  
    if ($portfolio) {
        // Check if the link already exists  
        $link_stmt = $trainmastas_conn->prepare("SELECT COUNT(*) FROM `user_link` WHERE `user_ID` = ? AND `type` = 'p'");
        $link_stmt->bind_param("s", $UID);
        $link_stmt->execute();
        $link_stmt->bind_result($count);
        $link_stmt->fetch();
        $link_stmt->close();

        if ($count > 0) {
            // Update the existing Portfolio link  
            $link_stmt = $trainmastas_conn->prepare("UPDATE `user_link` SET `link` = ? WHERE `user_ID` = ? AND `type` = 'p'");
            $link_stmt->bind_param("ss", $portfolio,  $UID);
            $link_stmt->execute();
            $link_stmt->close();
        } else {
            // Insert new Portfolio link  
            $link_stmt = $trainmastas_conn->prepare("INSERT INTO `user_link`(`user_ID`, `type`, `link`) VALUES (?, 'p', ?)");
            $link_stmt->bind_param("ss", $UID, $portfolio);
            $link_stmt->execute();
            $link_stmt->close();
        }
    }

    if ($picture) {
        $fieldsToUpdate[] = "`Image` = '$picture'";
        $control = true;
    }

    if (count($fieldsToUpdate) > 0) {
        $updateUserQuery .=  implode(", ", $fieldsToUpdate);
        $control = true;
    }
    // Update the user table if there are changes
    if (count($fieldsToUpdate) > 0) {
        $updateUserQuery .= " WHERE `user_ID` = '$UID'";
        if ($control == true) {
            $trainmastas_conn->query($updateUserQuery);
        }
    }

    // Handle fields if they have changed
    if (isset($_POST['selectedFields']) && $_POST['selectedFields'] !== '') {
        $selectedFields = explode(',', $_POST['selectedFields']); // Split the string into an array

        // First, delete all current fields associated with the user
        $deleteFieldsQuery = "DELETE FROM `fields` WHERE `user_ID` = '$UID'";
        $trainmastas_conn->query($deleteFieldsQuery);

        // Insert new fields into the fields table
        foreach ($selectedFields as $index => $field) {
            $field = htmlspecialchars($field, ENT_QUOTES, 'UTF-8');
            $fieldNum = $index + 1; // Assuming field_num starts from 1
            $insertFieldQuery = "
                INSERT INTO `fields` (`user_ID`, `field_num`, `Field`) 
                VALUES ('$UID', '$fieldNum', '$field')
            ";
            $trainmastas_conn->query($insertFieldQuery);
            if ($index > 10) break;
        }
    }

    // Respond with success
    echo json_encode(array('state' => 'success'));
}

// Close the connection
include "close_connection.php";
