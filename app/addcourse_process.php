<?php
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
// Remove $ sign
function removeDollarSign($amount)
{
    // Check if the string starts with a dollar sign  
    if (strpos($amount, '$') === 0) {
        // Remove the dollar sign  
        return substr($amount, 1);
    }
    // Return the original amount if no dollar sign is found  
    return $amount;
}
if (!$UID) {
    // Not logged in, or token is invalid/expired
    echo json_encode([
        "state" => "error",
        "message" => "User not authenticated."
    ]);
    include "close_connection.php";
    exit;
}

$response = array('state' => 'error'); // Default response
if (isset($_POST['purpose']) && $_POST['purpose'] == 'details') {
    // Step 1: Retrieve user ID from  and verify course creator status

    // Check if the user is a course creator
    $sqlUserCheck = "SELECT `type` FROM `user` WHERE `user_ID` = ?";
    $stmtUserCheck = $trainmastas_conn->prepare($sqlUserCheck);
    $stmtUserCheck->bind_param('s', $UID);
    $stmtUserCheck->execute();
    $resultUserCheck = $stmtUserCheck->get_result();

    if ($resultUserCheck->num_rows > 0) {
        $user = $resultUserCheck->fetch_assoc();
        if ($user['type'] !== 'c') {
            $response['state'] = 'not_course_creator';
            echo json_encode($response);
            include "close_connection.php";
            exit;
        }
    } else {
        $response['state'] = 'user_not_found';
        echo json_encode($response);
        include "close_connection.php";
        exit;
    }
    $stmtUserCheck->close();

    // Step 2: Collect and validate form data
    $course_ID = isset($_POST['course_ID']) && !empty($_POST['course_ID']) ? base64_decode($_POST['course_ID']) : null;
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8') : null;
    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8') : null;
    if (isset($_POST['keys'])) {
        $keys = htmlspecialchars($_POST['keys'], ENT_QUOTES, 'UTF-8');

        // Explode the keys string by commas  
        $keys = explode(',', $keys);

        // Trim whitespace from each element in the array  
        $keys = array_map('trim', $keys);
    } else {
        $keys = null; // return an empty array for consistency  
    }

    // Now $keysArray contains the exploded values
    $courseType = isset($_POST['type']) ? htmlspecialchars($_POST['type'], ENT_QUOTES, 'UTF-8') : null;
    $num_modules = isset($_POST['modulesNum']) ? intval($_POST['modulesNum']) : null;
    $testQuestion = isset($_POST['testQuestion']) ? htmlspecialchars($_POST['testQuestion'], ENT_QUOTES, 'UTF-8') : null;
    $category = isset($_POST['category']) ? htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8') : null;
    $price = $courseType === 'premium' && isset($_POST['price']) ? floatval(removeDollarSign($_POST['price'])) : null;
    $num_test = isset($_POST['testNum']) ? intval($_POST['testNum']) : null;
    $action = '';
    // Step 3: Handle cover image upload
    $coverImagePath = null; // Default as null  
    $targetDir = "../covers/"; // Adjust the path as necessary  

    // Check if the directory exists, if not create it  
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); // Creates the directory with appropriate permissions  
    }

    if (isset($_FILES['cover']) && !empty($_FILES['cover']['name'])) {
        $coverImage = $_FILES['cover'];

        // Generate a unique filename  
        $uniqueId = uniqid(); // Generates a unique ID based on the current time in microseconds  
        $coverImageExtension = pathinfo($coverImage['name'], PATHINFO_EXTENSION); // Get the file extension  
        $coverImageName = $uniqueId . '.' . $coverImageExtension; // Create a new filename  
        $targetFilePath = $targetDir . $coverImageName;

        if (move_uploaded_file($coverImage['tmp_name'], $targetFilePath)) {
            $coverImagePath = $coverImageName;
        } else {
            $response['state'] = 'image_upload_error';
            include "close_connection.php";
            echo json_encode($response);
            exit;
        }
    } else if (isset($_POST['cover']) && !empty($_POST['cover'])) {
        $coverImage = $_POST['cover'];
    }

    // Step 4: Insert or update the course data
    if ($course_ID) {
        // Update existing course
        $updates = [];
        $params = [];

        if ($title !== null) {
            $updates[] = "`Title`=?";
            $params[] = $title;
        }
        if ($description !== null) {
            $updates[] = "`Description`=?";
            $params[] = $description;
        }
        if ($category !== null) {
            $updates[] = "`Category`=?";
            $params[] = $category;
        }
        if ($num_test !== null && $num_test != 0) {
            $updates[] = "`Num_test`=?";
            $params[] = $num_test;
            $action = 'e';
            // Update the `course` table with the new action value
            $updateCourseQuery = "UPDATE course SET action = ? WHERE course_ID = ?";
            $updateCourseStmt = $trainmastas_conn->prepare($updateCourseQuery);
            $updateCourseStmt->bind_param("ss", $action, $course_ID);
            $updateCourseStmt->execute();
        }
        if ($coverImagePath !== null) {
            $updates[] = "`Cover_image`=?";
            $params[] = $coverImagePath;

            // Prepare the SQL statement to select Cover_image  
            $stmtSelectCoverImage = $trainmastas_conn->prepare("SELECT `Cover_image` FROM `course` WHERE `course_ID` = ?");
            $stmtSelectCoverImage->bind_param("s", $course_ID);
            $stmtSelectCoverImage->execute();
            $stmtSelectCoverImage->bind_result($coverImage);
            $stmtSelectCoverImage->fetch();

            $stmtSelectCoverImage->close();
        }
        if ($price !== null) {
            $updates[] = "`Cost`=?";
            //Makes sure price is less than 300
            if ($price > 300) {
                $price = 300;
            }
            $params[] = $price;
        }

        if (!empty($updates)) {
            $updates[] = "`Date`=NOW()";
            $sql = "UPDATE `course` SET " . implode(', ', $updates) . " WHERE `course_ID`=?";
            $params[] = $course_ID;
            $stmt = $trainmastas_conn->prepare($sql);
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            if ($stmt && isset($_FILES['cover']) && !empty($_FILES['cover']['name']) && $coverImage !== '' && $coverImage !== null) {
                $filePath = "../covers/" . $coverImage;
                if (file_exists($filePath)) {
                    if (unlink($filePath)) {
                        // Success
                    }
                }
            }

            if ($stmt->execute()) {
                // Step 5: Handle module and test updates
                // Delete excess modules
                if ($num_modules !== null) {
                    $stmtDeleteModules = $trainmastas_conn->prepare("DELETE FROM `course_modules` WHERE `course_ID` = ? AND `Module_num` > ?");
                    $stmtDeleteModules->bind_param("si", $course_ID, $num_modules);
                    $stmtDeleteModules->execute();
                    $stmtDeleteModules->close();
                }

                // Delete excess test questions
                if ($num_test !== null) {
                    $stmtDeleteTests = $trainmastas_conn->prepare("DELETE FROM `course_test` WHERE `course_ID` = ? AND `Question_num` > ?");
                    $stmtDeleteTests->bind_param("si", $course_ID, $num_test);
                    $stmtDeleteTests->execute();
                    $stmtDeleteTests->close();
                }
                $response['state'] = 'update_success';
            } else {
                $response['state'] = 'db_error';
                $response['error'] = $stmt->error;
            }
            $stmt->close();
        } else if ($keys == null) {
            $response['state'] = 'invalid_request';
            include "close_connection.php";
            echo json_encode($response);
            exit;
        }

        // Step 6: Insert/update course scope
        $inserted_course_ID = $course_ID;
        // Delete existing scopes
        $stmtDeleteScopes = $trainmastas_conn->prepare("DELETE FROM `course_scope` WHERE `course_ID` = ?");
        $stmtDeleteScopes->bind_param("s", $course_ID);
        $stmtDeleteScopes->execute();
        $stmtDeleteScopes->close();

        // Insert new scopes
        $stmtScope = $trainmastas_conn->prepare("INSERT INTO `course_scope` ( `course_ID`, `Scope`) VALUES (?, ?)");
        foreach ($keys as $scope) {
            $stmtScope->bind_param('ss', $inserted_course_ID, $scope);
            $stmtScope->execute();
        }
        $stmtScope->close();
        $response['state'] = 'update_success';
    } else {
        // Select number of courses for the given user_ID  
        $sql = "SELECT COUNT(*) as total_items FROM `course` WHERE `user_ID` = ? AND `Cost` = 0";
        $stmt = $trainmastas_conn->prepare($sql);
        $stmt->bind_param('s', $UID); // Assuming $UID is a string  
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row['total_items'] < 5) {
            $price = 0;
        };

        // Insert new course
        $sql = "INSERT INTO `course` (`course_ID`, `user_ID`, `Title`, `Description`, `Category`, `Cover_image`, `Num_modules`, `Num_test`, `Cost`, `action`, `Date`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $trainmastas_conn->prepare($sql);
        $new_course_ID = makeID();
        $action = 'v'; // Default action. Teacher can submit
        $stmt->bind_param('ssssssssss', $new_course_ID, $UID, $title, $description, $category, $coverImagePath, $num_modules, $num_test, $price, $action);

        if ($stmt->execute()) {
            // Step 5: Insert course scope
            $inserted_course_ID = $new_course_ID;
            if ($keys !== null) {
                $stmtScope = $trainmastas_conn->prepare("INSERT INTO `course_scope` (`course_ID`, `Scope`) VALUES (?, ?)");
                foreach ($keys as $scope) {
                    $stmtScope->bind_param('ss', $inserted_course_ID, $scope);
                    $stmtScope->execute();
                }
                $stmtScope->close();
            }
            $response['state'] = 'insert_success';
            $response['course_ID'] = base64_encode($inserted_course_ID);
        } else {
            $response['state'] = 'db_error';
            $response['error'] = $stmt->error;
        }
        $stmt->close();
    }
    // Output the response as JSON
    echo json_encode($response);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == 'modules' && isset($_POST['moduleData'])) {
    $moduleData = $_POST['moduleData'];
    $course_ID = base64_decode($_POST['course_ID']); // course_ID as a string
    $response = array('state' => 'noUpdate'); // Default response

    foreach ($moduleData as $module) {
        // Extract module number from the description key
        $module_num = intval($module['moduleNum']);
        // Extract module description and title
        $descriptionKey = "description-" . $module_num;
        $description = isset($module[$descriptionKey]) ? $module[$descriptionKey] : null;
        $titleKey = "title-" . $module_num;
        $title = isset($module[$titleKey]) ? $module[$titleKey] : null;

        if ($title !== null || $description !== null) {
            // Check if module exists
            $query = "SELECT * FROM course_modules WHERE course_ID = ? AND Module_num = ?";
            $stmt = $trainmastas_conn->prepare($query);
            $stmt->bind_param("ss", $course_ID, $module_num);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0 && $_POST['check'] == "notAdded") {
                // Update existing module (only update non-null fields)
                $updateQuery = "UPDATE course_modules SET ";
                $params = [];
                $types = "";
                $comma = "";

                if ($title !== null) {
                    $updateQuery .= $comma . " Title = ? ";
                    $params[] = $title;
                    $types .= "s";
                    $comma = ",";
                }

                if ($description !== null) {
                    $updateQuery .= $comma . " Description = ? ";
                    $params[] = $description;
                    $types .= "s";
                }

                // Remove the trailing comma and add the WHERE clause
                // $updateQuery = rtrim($updateQuery, ", ") . " WHERE course_ID = ? AND Module_num = ?";
                $updateQuery .=  " WHERE course_ID = ? AND Module_num = ?";
                $params[] = $course_ID;
                $params[] = $module_num;
                $types .= "ss";
                $updateStmt = $trainmastas_conn->prepare($updateQuery);
                $updateStmt->bind_param($types, ...$params);
                if ($updateStmt->execute()) {
                    $response['state'] = 'update_success';
                }
            } else {
                // Insert new module (only insert non-null fields)
                $insertQuery = "INSERT INTO course_modules (course_ID, Module_num";
                $values = "VALUES (?, ?";
                $params = [$course_ID, $module_num];
                $types = "ss";

                if ($title !== null) {
                    $insertQuery .= ", Title";
                    $values .= ", ?";
                    $params[] = $title;
                    $types .= "s";
                }

                if ($description !== null) {
                    $insertQuery .= ", Description";
                    $values .= ", ?";
                    $params[] = $description;
                    $types .= "s";
                }

                $insertQuery .= ") " . $values . ")";
                $insertStmt = $trainmastas_conn->prepare($insertQuery);
                $insertStmt->bind_param($types, ...$params);
                if ($insertStmt->execute()) {
                    $response['state'] = 'insert_success';
                }
            }
        }

        // Handle Module Extras
        if (isset($module['moduleExtras-' . $module_num])) {
            foreach ($module['moduleExtras-' . $module_num] as $extraKey => $extraData) {
                $video_num = intval(explode('-', $extraKey)[1]);

                $url = isset($extraData[0]['value']) ? $extraData[0]['value'] : null;

                if ($url !== null) {
                    // Check if extra exists for the module
                    $query = "SELECT * FROM course_video WHERE course_ID = ? AND Module_num  = ? AND video_num = ?";
                    $stmt = $trainmastas_conn->prepare($query);
                    $stmt->bind_param("sss", $course_ID, $module_num, $video_num);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Update existing video (only update non-null fields)
                        $updateQuery = "UPDATE course_video SET ";
                        $params = [];
                        $types = "";

                        if ($url !== null) {
                            $updateQuery .= "URL = ?, ";
                            $params[] = $url;
                            $types .= "s";
                        }

                        // Remove the trailing comma and add the WHERE clause
                        $updateQuery = rtrim($updateQuery, ", ") . " WHERE course_ID = ? AND Module_num  = ? AND video_num = ?";
                        $params[] = $course_ID;
                        $params[] = $module_num;
                        $params[] = $video_num;
                        $types .= "sss";

                        $updateStmt = $trainmastas_conn->prepare($updateQuery);
                        $updateStmt->bind_param($types, ...$params);
                        if ($updateStmt->execute()) {
                            $response['state'] = 'update_success';
                        }
                    } else {
                        // Insert new video (only insert non-null fields)
                        $insertQuery = "INSERT INTO course_video (course_ID, Module_num , video_num";
                        $values = "VALUES (?, ?, ?";
                        $params = [$course_ID, $module_num, $video_num];
                        $types = "sss";

                        if ($url !== null) {
                            $insertQuery .= ", URL";
                            $values .= ", ?";
                            $params[] = $url;
                            $types .= "s";
                        }

                        $insertQuery .= ") " . $values . ")";
                        $insertStmt = $trainmastas_conn->prepare($insertQuery);
                        $insertStmt->bind_param($types, ...$params);
                        if ($insertStmt->execute()) {
                            $response['state'] = 'insert_success';
                        }
                    }
                }
            }
        }
    }

    if (isset($_POST['status']) && $_POST['status'] == 'save') {
        $action = 'e';
        // Update the `course` table with the new action value
        $updateCourseQuery = "UPDATE course SET action = ?, submitted_date = IF(submitted_date IS NULL OR submitted_date = '', NOW(), submitted_date) WHERE course_ID = ?";
        $updateCourseStmt = $trainmastas_conn->prepare($updateCourseQuery);
        $updateCourseStmt->bind_param("ss", $action, $course_ID);
        $updateCourseStmt->execute();
        $updateCourseStmt->close();

        $stmt = $trainmastas_conn->prepare("SELECT * FROM courses_rejected WHERE course_ID = ?");
        $stmt->bind_param("s", $course_ID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $deleteStmt = $trainmastas_conn->prepare("DELETE FROM courses_rejected WHERE course_ID = ?");
            $deleteStmt->bind_param("s", $course_ID);
            $deleteStmt->execute();
            $deleteStmt->close();
        }
        $stmt->close();
    }

    if (isset($_POST['deleteExtra']) && is_array($_POST['deleteExtra'])) {
        $deleteExtraArray = $_POST['deleteExtra'];

        foreach ($deleteExtraArray as $deleteItem) {
            if (
                isset($deleteItem['moduleNum']) && is_numeric($deleteItem['moduleNum']) &&
                isset($deleteItem['extraVideoNum']) && is_array($deleteItem['extraVideoNum'])
            ) {

                $moduleNum = intval($deleteItem['moduleNum']);

                foreach ($deleteItem['extraVideoNum'] as $videoNumToDelete) {
                    if (is_numeric($videoNumToDelete)) {
                        $videoNum = intval($videoNumToDelete);

                        // Prepare the DELETE query using MySQLi's prepared statements
                        $deleteQuery = "DELETE FROM `course_video`
                                        WHERE `course_ID` = ?
                                          AND `Module_num` = ?
                                          AND `Video_num` = ?";

                        $deleteStmt = $trainmastas_conn->prepare($deleteQuery);

                        if ($deleteStmt) {
                            // Bind the parameters
                            $deleteStmt->bind_param("sii", $course_ID, $moduleNum, $videoNum);

                            // Execute the DELETE query
                            if ($deleteStmt->execute()) {
                                // Deletion successful for this video
                                $response['state'] = 'insert_success';
                            }
                            // Close the statement
                            $deleteStmt->close();
                        }
                    }
                }
            }
        }
    }
    // Output the response as JSON
    echo json_encode($response);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == 'test') {
    $testData = isset($_POST['testData']) ? $_POST['testData'] : null;
    $course_ID = base64_decode($_POST['course_ID']); // course_ID as a string
    $action = ''; // Initialize action as empty
    if ($testData != null) {
        foreach ($testData as $questionData) {
            // Extract question number from the questionData
            $question_num = isset($questionData['question_num']) ? $questionData['question_num'] : null;

            $question = isset($questionData['question']) ? $questionData['question'] : null;
            $optionA = isset($questionData['options']['a']) ? $questionData['options']['a'] : null;
            $optionB = isset($questionData['options']['b']) ? $questionData['options']['b'] : null;
            $optionC = isset($questionData['options']['c']) ? $questionData['options']['c'] : null;
            $optionD = isset($questionData['options']['d']) ? $questionData['options']['d'] : null;
            $correctAnswer = isset($questionData['correctAnswer']) ? $questionData['correctAnswer'] : null;

            if ($question_num !== null && ($question !== null || $optionA !== null || $optionB !== null || $optionC !== null || $optionD !== null || $correctAnswer !== null)) {
                // Check if the question already exists
                $query = "SELECT * FROM course_test WHERE course_ID = ? AND Question_num = ?";
                $stmt = $trainmastas_conn->prepare($query);
                $stmt->bind_param("si", $course_ID, $question_num);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Update existing question (only update non-null fields)
                    $updateQuery = "UPDATE course_test SET ";
                    $params = [];
                    $types = "";

                    if ($question !== null) {
                        $updateQuery .= "Question = ?, ";
                        $params[] = $question;
                        $types .= "s";
                    }

                    if ($optionA !== null) {
                        $updateQuery .= "Option_A = ?, ";
                        $params[] = $optionA;
                        $types .= "s";
                    }

                    if ($optionB !== null) {
                        $updateQuery .= "Option_B = ?, ";
                        $params[] = $optionB;
                        $types .= "s";
                    }

                    if ($optionC !== null) {
                        $updateQuery .= "Option_C = ?, ";
                        $params[] = $optionC;
                        $types .= "s";
                    }

                    if ($optionD !== null) {
                        $updateQuery .= "Option_D = ?, ";
                        $params[] = $optionD;
                        $types .= "s";
                    }

                    if ($correctAnswer !== null) {
                        $updateQuery .= "Answer = ?, ";
                        $params[] = $correctAnswer;
                        $types .= "s";
                    }

                    // Remove the trailing comma and add the WHERE clause
                    $updateQuery = rtrim($updateQuery, ", ") . " WHERE course_ID = ? AND Question_num = ?";
                    $params[] = $course_ID;
                    $params[] = $question_num;
                    $types .= "si";

                    $updateStmt = $trainmastas_conn->prepare($updateQuery);
                    $updateStmt->bind_param($types, ...$params);
                    if ($updateStmt->execute()) {
                        $response['state'] = 'update_success';
                        $action = 'e'; // Update action to 'e' for update


                        $stmt = $trainmastas_conn->prepare("SELECT * FROM courses_rejected WHERE course_ID = ?");
                        $stmt->bind_param("s", $course_ID);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            $deleteStmt = $trainmastas_conn->prepare("DELETE FROM courses_rejected WHERE course_ID = ?");
                            $deleteStmt->bind_param("s", $course_ID);
                            $deleteStmt->execute();
                            $deleteStmt->close();
                        }
                        $stmt->close();
                    }
                } else {
                    // Insert new question (only insert non-null fields)
                    $insertQuery = "INSERT INTO course_test (course_ID, Question_num";
                    $values = "VALUES (?, ?";
                    $params = [$course_ID, $question_num];
                    $types = "si";

                    if ($question !== null) {
                        $insertQuery .= ", Question";
                        $values .= ", ?";
                        $params[] = $question;
                        $types .= "s";
                    }

                    if ($optionA !== null) {
                        $insertQuery .= ", Option_A";
                        $values .= ", ?";
                        $params[] = $optionA;
                        $types .= "s";
                    }

                    if ($optionB !== null) {
                        $insertQuery .= ", Option_B";
                        $values .= ", ?";
                        $params[] = $optionB;
                        $types .= "s";
                    }

                    if ($optionC !== null) {
                        $insertQuery .= ", Option_C";
                        $values .= ", ?";
                        $params[] = $optionC;
                        $types .= "s";
                    }

                    if ($optionD !== null) {
                        $insertQuery .= ", Option_D";
                        $values .= ", ?";
                        $params[] = $optionD;
                        $types .= "s";
                    }

                    if ($correctAnswer !== null) {
                        $insertQuery .= ", Answer";
                        $values .= ", ?";
                        $params[] = $correctAnswer;
                        $types .= "s";
                    }

                    $insertQuery .= ") " . $values . ")";
                    $insertStmt = $trainmastas_conn->prepare($insertQuery);
                    $insertStmt->bind_param($types, ...$params);
                    if ($insertStmt->execute()) {
                        $response['state'] = 'insert_success';
                        $action = 'e'; // Update action to 'n' for insert
                    }
                }
            }
        }
    }

    $sql = "UPDATE `course` c  
        SET c.`submitted_date` = NOW()  
        WHERE c.`course_ID` = ?  
        AND (c.`submitted_date` IS NULL OR c.`submitted_date` = '')  
        AND EXISTS (  
            SELECT 1  
            FROM `course_test` ct  
            WHERE ct.`course_ID` = c.`course_ID`  
            AND ct.`Question_num` IS NOT NULL AND ct.`Question_num` != ''  
            AND ct.`Question` IS NOT NULL AND ct.`Question` != ''  
            AND ct.`Option_A` IS NOT NULL AND ct.`Option_A` != ''  
            AND ct.`Option_B` IS NOT NULL AND ct.`Option_B` != ''  
            AND ct.`Option_C` IS NOT NULL AND ct.`Option_C` != ''  
            AND ct.`Option_D` IS NOT NULL AND ct.`Option_D` != ''  
            AND ct.`Answer` IS NOT NULL AND ct.`Answer` != ''  
            GROUP BY ct.`course_ID`  
            HAVING COUNT(*) = (SELECT c2.`Num_test` FROM `course` c2 WHERE c2.`course_ID` = ct.`course_ID`)  
        );";
    $stmt = $trainmastas_conn->prepare($sql);
    $stmt->bind_param("s", $course_ID); // Assuming course_ID is an integer  
    $stmt->execute();
    $response['state'] = 'insert_success';

    if ($action !== '') {
        // Update the `course` table with the new action value
        $updateCourseQuery = "UPDATE course SET action = ? WHERE course_ID = ?";
        $updateCourseStmt = $trainmastas_conn->prepare($updateCourseQuery);
        $updateCourseStmt->bind_param("ss", $action, $course_ID);
        $updateCourseStmt->execute();
    }
    // Output the response as JSON
    echo json_encode($response);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == 'sendthis') {
    $course_ID = base64_decode($_POST["course_ID"]);
    $sql = "SELECT COUNT(*) AS course_count FROM course WHERE user_ID = ? AND Cost = 0";
    $stmt = $trainmastas_conn->prepare($sql);
    $stmt->bind_param("s", $UID); // "s" denotes that the parameter is an integer  
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $courseFreeCount = $row['course_count'];
    $response['freeCount'] = $courseFreeCount;

    // Check if the  user ID matches the course's user ID
    $query = "SELECT user_ID FROM course WHERE course_ID = ?";
    $stmt = $trainmastas_conn->prepare($query);
    $stmt->bind_param("s", $course_ID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $courseUserID = $row['user_ID'];

        if ($UID == $courseUserID) {

            $courseQuery = "
                SELECT 
                    COUNT(*) AS total_registered,  
                    SUM(
                        CASE 
                            WHEN (`Level` != 'c' AND c.`Num_test` != 0) AND c.`action` != 'e' 
                                OR (c.`Num_test` = 0 AND `Level` != c.`Num_modules`) 
                            THEN 1 
                            ELSE 0 
                        END
                    ) AS total_not_completed  
                FROM   
                    `course_registered` cr
                JOIN 
                    `course` c 
                ON 
                    cr.`course_ID` = c.`course_ID`
                WHERE   
                    cr.`course_ID` = ?  
                ";

            $courseStmt = $trainmastas_conn->prepare($courseQuery);
            $courseStmt->bind_param("s", $course_ID);
            $courseStmt->execute();
            $result3 = $courseStmt->get_result();

            if ($result3->num_rows > 0) {
                $data = $result3->fetch_assoc();

                $totalRegistered = $data['total_registered'];
                $totalNotCompleted = $data['total_not_completed'];

                // Check if the total not completed is greater than 5  
                if ($totalNotCompleted > 0) {
                    $response = [
                        'state' => 'cant'
                    ];
                    include "close_connection.php";
                    echo json_encode($response);
                    exit;
                }

                // Prepare your response if total not completed is 5 or less  
                $response['total_registered'] = $totalRegistered;
            }
            $stmt = $trainmastas_conn->prepare("SELECT Reason FROM courses_rejected WHERE course_ID = ?");
            $stmt->bind_param("s", $course_ID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $rejected = $result->fetch_assoc();
                $response['rejected'] = $rejected['Reason'];
            } else {
                $response['rejected'] = null; // Set to null or another value if not rejected  
            }

            $courseQuery = "SELECT Title, Description, Category, Cover_image, Cost,Num_modules, Num_test, action, Date, submitted_date FROM course WHERE course_ID = ?";
            $courseStmt = $trainmastas_conn->prepare($courseQuery);
            $courseStmt->bind_param("s", $course_ID);
            $courseStmt->execute();
            $courseResult = $courseStmt->get_result();
            $courseDetails = $courseResult->fetch_assoc();

            if ($courseDetails) {
                $response['state'] = 'success';
                $courseDetails["Category"] = decodeHtml($courseDetails["Category"]);
                $courseDetails["Description"] = decodeHtml($courseDetails["Description"]);
                $courseDetails["Title"] = decodeHtml($courseDetails["Title"]);
                $response['course'] = $courseDetails;

                // Fetch associated data
                $videoQuery = "SELECT Module_num , URL, Video_num FROM course_video WHERE course_ID = ?";
                $videoStmt = $trainmastas_conn->prepare($videoQuery);
                $videoStmt->bind_param("s", $course_ID);
                $videoStmt->execute();
                $videoResult = $videoStmt->get_result();
                $videos = $videoResult->fetch_all(MYSQLI_ASSOC);

                // Assign sanitized videos to response  
                $response['videos'] = $videos;

                // Fetch modules  
                $moduleQuery = "SELECT Title, Module_num, Description FROM course_modules WHERE course_ID = ?";
                $moduleStmt = $trainmastas_conn->prepare($moduleQuery);
                $moduleStmt->bind_param("s", $course_ID);
                $moduleStmt->execute();
                $moduleResult = $moduleStmt->get_result();
                $modules = $moduleResult->fetch_all(MYSQLI_ASSOC);

                // Sanitize module titles and descriptions  
                foreach ($modules as &$module) {
                    $module['Title'] = decodeHtml($module['Title']);
                    $module['Description'] = decodeHtml($module['Description']);
                }
                $response['modules'] = $modules;
                // Fetch scopes  
                $scopeQuery = "SELECT Scope FROM course_scope WHERE course_ID = ? ORDER BY Scope ASC";
                $scopeStmt = $trainmastas_conn->prepare($scopeQuery);
                $scopeStmt->bind_param("s", $course_ID);
                $scopeStmt->execute();
                $scopeResult = $scopeStmt->get_result();
                $scopes = $scopeResult->fetch_all(MYSQLI_ASSOC);

                // Sanitize scope descriptions  
                foreach ($scopes as &$scope) {
                    $scope['Scope'] = decodeHtml($scope['Scope']);
                }
                $response['scopes'] = $scopes;

                $testQuery = "SELECT Question_num, Question, Option_A, Option_B, Option_C, Option_D, Answer FROM course_test WHERE course_ID = ?";
                $testStmt = $trainmastas_conn->prepare($testQuery);
                $testStmt->bind_param("s", $course_ID);
                $testStmt->execute();
                $testResult = $testStmt->get_result();
                $response['tests'] = $testResult->fetch_all(MYSQLI_ASSOC);
            } else {
                $response['state'] = 'notfound';
            }
        } else {
            $response['state'] = 'restricted';
        }
    } else {
        $response['state'] = 'notfound';
    }
    // Output the response as JSON
    echo json_encode($response);
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "checkUser") {
    // Get the user_ID from the session

    // Check if user has at least 5 courses created
    $check_user_sql = "
    SELECT u.type, u.verified, COUNT(c.course_ID) AS Total_Courses
    FROM user AS u
    LEFT JOIN course AS c 
    ON u.user_ID = c.user_ID
    WHERE u.user_ID = ? AND c.Cost = 0
";

    // Prepare and execute the query
    $check_user_stmt = $trainmastas_conn->prepare($check_user_sql);
    $check_user_stmt->bind_param("s", $UID);
    if (!$check_user_stmt->execute()) {
        echo json_encode(array('state' => 'error'));
        $check_user_stmt->close();
        include "close_connection.php";
        exit;
    }

    $check_user_result = $check_user_stmt->get_result();

    if ($check_user_result->num_rows > 0) {
        $user_data = $check_user_result->fetch_assoc();
        $verified = $user_data['verified'];
        $total_courses = $user_data['Total_Courses'];

        if ($user_data['type'] == 'c') {
            echo json_encode(array(
                'state' => 'creator',
                'courseProduced' => $total_courses,
                'verified' => $verified
            ));
        } else {
            echo json_encode(array('state' => 'student'));
        }
    } else {
        // If no results, we can still get user info separately
        $fallback_sql = "SELECT type, verified FROM user WHERE user_ID = ?";
        $fallback_stmt = $trainmastas_conn->prepare($fallback_sql);
        $fallback_stmt->bind_param("s", $UID);
        $fallback_stmt->execute();
        $fallback_result = $fallback_stmt->get_result();

        if ($fallback_result->num_rows > 0) {
            $fallback_data = $fallback_result->fetch_assoc();
            if ($fallback_data['type'] == 'c') {
                echo json_encode(array(
                    'state' => 'creator',
                    'courseProduced' => 0,
                    'verified' => $fallback_data['verified']
                ));
            } else {
                echo json_encode(array('state' => 'student'));
            }
        } else {
            echo json_encode(array('state' => 'error'));
        }
        $fallback_stmt->close();
    }

    $check_user_stmt->close();
} else if (isset($_POST['purpose']) && $_POST['purpose'] == "delete") {

    // Check if course_ID is provided
    if (!isset($_POST['course_ID']) || empty($_POST['course_ID'])) {
        $response['state'] = 'invalid_request';
        echo json_encode($response);
        include "close_connection.php";
        exit();
    }

    $course_ID = base64_decode($_POST['course_ID']);

    // First, retrieve the Cover_image name from the course table
    $coverImageQuery = "SELECT Cover_image FROM course WHERE course_ID = ?";
    $stmt = $trainmastas_conn->prepare($coverImageQuery);

    if (!$stmt) {
        $response['state'] = 'delete_failed';
        echo json_encode($response);
        include "close_connection.php";
        exit();
    }

    $stmt->bind_param("s", $course_ID); // Bind the course_ID
    $stmt->execute();
    $stmt->bind_result($cover_image);

    if (!$stmt->fetch()) {
        // If no course is found, return an error response
        $response['state'] = 'course_not_found';
        $stmt->close();
        echo json_encode($response);
        include "close_connection.php";
        exit();
    }
    $stmt->close();

    // Prepare deletion queries for related tables
    $queries = [
        "DELETE FROM course_feedback WHERE course_ID = ?",
        "DELETE FROM course_modules WHERE course_ID = ?",
        "DELETE FROM course_scope WHERE course_ID = ?",
        "DELETE FROM course_test WHERE course_ID = ?",
        "DELETE FROM course_video WHERE course_ID = ?",
        "DELETE FROM course WHERE course_ID = ?"
    ];

    $success = true; // Flag to track success of the operation

    // Start transaction
    $trainmastas_conn->begin_transaction();

    try {
        // Execute deletion queries
        foreach ($queries as $query) {
            $stmt = $trainmastas_conn->prepare($query);
            if (!$stmt) {
            }

            $stmt->bind_param("s", $course_ID); // Bind course_ID to query
            $stmt->execute();
            $stmt->close();
        }

        // Delete the cover image file if it exists
        if (!empty($cover_image) && $cover_image !== '' && $cover_image !== null) {
            $imagePath = "../covers/" . $cover_image; // Construct the file path
            if (file_exists($imagePath) && is_file($imagePath)) {
                if (!unlink($imagePath)) {
                }
            }
        }

        // Commit transaction if all queries are successful
        $trainmastas_conn->commit();
        $response['state'] = 'delete_success';
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $trainmastas_conn->rollback();
        $response['state'] = 'delete_failed';
    } finally {
        // Ensure the connection is closed properly
        echo json_encode($response);
    }
    include "close_connection.php";
    exit();
} else {
    $response['state'] = 'invalid_request';
    // Output the response as JSON
    echo json_encode($response);
}

include "close_connection.php";
