<?php
include 'connection.php';
include "session_checker.php";

/////////////////////////////////////////////////////////////////
//              Complementary Sanitizer
/////////////////////////////////////////////////////////////////
function sanitize($data)
{
    $data = trim(strip_tags($data));
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    $data = addslashes($data);
    return $data;
}
/////////////////////////////////////////////////////////////////
//              Encode ID to be sent
/////////////////////////////////////////////////////////////////
function encode_id($data, $num, $id)
{
    $data[$num] = base64_encode($data[$num]);
    $data[$id] = base64_encode($data[$id]);
    return $data;
}
/////////////////////////////////////////////////////////////////
//              Encode ID to be sent
/////////////////////////////////////////////////////////////////
function unset_item(&$data, $num, $id)
{
    unset($data[$num]);
    unset($data[$id]);
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
/////////////////////////////////////////////////////////////////
//            Sanitizer of Input 
/////////////////////////////////////////////////////////////////
function process_input($conn, $input)
{
    if (is_array($input)) {
        // Process each element of the array
        return array_map(function ($item) use ($conn) {
            return mysqli_real_escape_string($conn, htmlspecialchars(sanitize($item), ENT_QUOTES, 'UTF-8'));
        }, $input);
    } else {
        // Process a single string
        return mysqli_real_escape_string($conn, htmlspecialchars(sanitize($input), ENT_QUOTES, 'UTF-8'));
    }
}

// Check if session is set
if (!$UID) {
    echo json_encode([
        "state" => "error",
        "message" => "User not authenticated."
    ]);
    include "close_connection.php";
    exit;
}

/////////////////////////////////////////////////////////////////
//                        Send Courses Processes
/////////////////////////////////////////////////////////////////
if (isset($_POST['id']) && $_POST['purpose'] == 'viewCourse') {
    $course_ID = base64_decode($_POST['id']);  // Decode the course ID from the frontend
    $purpose = $_POST['currentVal'];

    // Fetch the level of the registered course for this user
    $query = "SELECT c.Title, c.Num_test, cr.Level FROM course_registered cr JOIN course c ON cr.course_ID = c.course_ID
    WHERE c.action != 'd' AND cr.user_ID = ? AND cr.course_ID = ?";
    $stmt = $trainmastas_conn->prepare($query);
    $stmt->bind_param("ss", $UID, $course_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the row once  
        $level = $row['Level']; // Get Level  
        $courseTitle = $row['Title'];
        $courseNum_test = $row['Num_test'];
        if ($purpose == "initial") {
            $moduleNum_query = "SELECT Title, Description FROM course_modules WHERE course_ID = ?";
            $moduleNum_stmt = $trainmastas_conn->prepare($moduleNum_query);
            $moduleNum_stmt->bind_param("s", $course_ID);
            $moduleNum_stmt->execute();
            $moduleNum_result = $moduleNum_stmt->get_result();
            $moduleNum = $moduleNum_result->num_rows;

            ////////////////////////////////////////////////////
            // Verify test status(if he can take exam) 
            $checkAttemptsQuery = "SELECT Attempt_num, Date FROM course_score WHERE course_ID = ? AND user_ID = ? ORDER BY Date DESC LIMIT 1";
            $stmt = $trainmastas_conn->prepare($checkAttemptsQuery);
            $stmt->bind_param("ss", $course_ID, $UID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $testStatus = "";
            $nextAttemptDate = "";

            if ($row) {
                // User has previous attempts; check conditions
                $currentAttempt = (int)$row['Attempt_num'];
                $lastAttemptDate = $row['Date'];

                if ($currentAttempt >= 3) {
                    // User has reached the maximum number of attempts
                    $testStatus = "limitReached";
                } else {
                    // Check if the last attempt was at least 1 month ago
                    $currentDate = new DateTime();
                    $lastDate = new DateTime($lastAttemptDate);
                    $dateDifference = $lastDate->diff($currentDate);

                    if ($dateDifference->m >= 1 || $dateDifference->y >= 1) {
                        // User can start the test
                        $testStatus = "canStart";
                    } else {
                        // User must wait before attempting again
                        $testStatus = "tooSoon";
                        // Calculate the date when the user can take the exam  
                        $nextAttemptDate = clone $lastDate; // Clone to avoid modifying the original date  
                        $nextAttemptDate->modify('+1 month'); // Add one month  
                        // Format the date for display  
                        $nextAttemptDate = $nextAttemptDate->format('Y-m-d');
                    }
                }
            } else {
                // No previous attempts; user can start the test
                $testStatus = "canStart";
            }

            $testNum_query = "SELECT * FROM course_test WHERE course_ID = ?";
            $testNum_stmt = $trainmastas_conn->prepare($testNum_query);
            $testNum_stmt->bind_param("s", $course_ID);
            $testNum_stmt->execute();
            $testNum_result = $testNum_stmt->get_result();
            $testNum = $testNum_result->num_rows;
            $testDuration = "";
            if ($testNum !== 0) {
                $testDuration = $testNum;
                $testNum = "yes";
            } else {
                $testNum = "no";
            }

            $level_query = "SELECT cr.Level FROM course_registered cr JOIN course_payment cp ON (cr.course_ID = cp.course_ID AND cr.user_ID = cp.user_ID)  
                WHERE cr.course_ID = ? AND cr.user_ID = ?";
            $level_stmt = $trainmastas_conn->prepare($level_query);

            $level_stmt->bind_param("ss", $course_ID, $UID);
            $level_stmt->execute();
            $level_result = $level_stmt->get_result();
            $refundEligible = false; // Variable to check refund eligibility  
            if ($level_result->num_rows > 0) {
                $row = $level_result->fetch_assoc();
                $userLevel = $row['Level'];
                // Step 3: Determine if refund is possible  
                if ($userLevel < 2) {
                    $refundEligible = true; // Refund is possible  
                }
            } else {
                $refundEligible = "Not applicable";
            }

            if (is_numeric($level)) {
                // Level is a digit, meaning it's a module number
                $module_num = intval($level);
                $module_query = "SELECT Title, Description FROM course_modules WHERE course_ID = ? AND Module_num = ?";
                $module_stmt = $trainmastas_conn->prepare($module_query);
                $module_stmt->bind_param("si", $course_ID, $module_num);
                $module_stmt->execute();
                $module_result = $module_stmt->get_result();


                if ($module_result->num_rows > 0) {
                    $module = $module_result->fetch_assoc();
                    $module["Title"] = decodeHtml($module["Title"]);
                    $module["Description"] = decodeHtml($module["Description"]);
                    // Fetch the videos for this module
                    $video_query = "SELECT URL FROM course_video WHERE course_ID = ? AND Module_num  = ?";
                    $video_stmt = $trainmastas_conn->prepare($video_query);

                    $video_stmt->bind_param("si", $course_ID, $module_num);
                    $video_stmt->execute();
                    $video_result = $video_stmt->get_result();

                    $videos = [];
                    while ($video_row = $video_result->fetch_assoc()) {
                        $videos[] = $video_row;
                    }
                    echo json_encode(array('module' => $module, 'videos' => $videos, 'moduleNum' => $moduleNum, "level" => $level, 'courseTitle' => $courseTitle, 'courseNum_test' => $courseNum_test, 'refundEligible' => $refundEligible, 'testNum' => $testNum, 'state' => 'success', 'testStatus' => $testStatus, 'nextAttemptDate' => $nextAttemptDate));
                } else {
                    echo json_encode(array('state' => 'noModule'));
                }
                $module_stmt->close();
            } else if ($level === 't') {
                // Level is 't', meaning it's test time
                echo json_encode(array('moduleNum' => $moduleNum, 'testNum' => $testNum, 'refundEligible' => $refundEligible, "level" => $level, 'courseTitle' => $courseTitle, 'courseNum_test' => $courseNum_test,  'state' => 'startTest', 'testStatus' => $testStatus, 'nextAttemptDate' => $nextAttemptDate, 'duration' => $testDuration));
            } else if ($level === 'c') {
                // Level is 'c', meaning the course is completed
                // Select the first module and add a completion indicator
                $module_query = "SELECT cm.Title, c.Cost, cm.Description FROM course_modules cm JOIN course c ON cm.course_ID = c.course_ID WHERE cm.course_ID = ? AND cm.Module_num = 1";
                $module_stmt = $trainmastas_conn->prepare($module_query);
                $module_stmt->bind_param("s", $course_ID);
                $module_stmt->execute();
                $module_result = $module_stmt->get_result();

                if ($module_result->num_rows > 0) {
                    $module = $module_result->fetch_assoc();
                    $module["Title"] = decodeHtml($module["Title"]);
                    $module["Description"] = decodeHtml($module["Description"]);
                    $module["Cost"] = decodeHtml($module["Cost"]); // Decode HTML first  
                    $courseType = ($module["Cost"] == 0) ? "free" : "premium"; // Check cost and update it
                    unset($module["Cost"]);
                    // Fetch the videos for the first module
                    $video_query = "SELECT URL FROM course_video WHERE course_ID = ? AND Module_num  = 1";
                    $video_stmt = $trainmastas_conn->prepare($video_query);
                    $video_stmt->bind_param("s", $course_ID);
                    $video_stmt->execute();
                    $video_result = $video_stmt->get_result();

                    $videos = [];
                    while ($video_row = $video_result->fetch_assoc()) {
                        $videos[] = $video_row;
                    }
                    echo json_encode(array('module' => $module, 'videos' => $videos, 'moduleNum' => $moduleNum, 'testNum' => $testNum, 'refundEligible' => $refundEligible, "level" => $level, 'courseTitle' => $courseTitle, 'courseNum_test' => $courseNum_test,  'completed' => true, 'state' => 'success', 'testStatus' => $testStatus, 'nextAttemptDate' => $nextAttemptDate, 'courseType' => $courseType));
                } else {
                    echo json_encode(array('state' => 'error'));
                }
                $module_stmt->close();
            } else {
                echo json_encode(array('state' => 'invalidModule'));
            }
            $testNum_stmt->close();
            $level_stmt->close();
            $moduleNum_stmt->close();
        } else if ($purpose == "test") {
            // Check the count of records in the course_test table  
            $checkQuery = "SELECT COUNT(*) as total FROM course_test WHERE course_ID = ?";
            $stmt = $trainmastas_conn->prepare($checkQuery);
            $stmt->bind_param("s", $course_ID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            // Get the count  
            $answers_num = $row['total'];

            $answers = '';
            for ($i = 1; $i <= $answers_num; $i++) {
                $i == $answers_num ? $answers .= 'n' : $answers .= 'n,';
            }

            // Check if the record exists
            $checkQuery = "SELECT Attempt_num, Date FROM course_score WHERE course_ID = ? AND user_ID = ? ORDER BY Date DESC LIMIT 1";
            $stmt = $trainmastas_conn->prepare($checkQuery);
            $stmt->bind_param("ss", $course_ID, $UID);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();


            if ($row) {
                // If the record exists, get the current attempt count and the latest attempt date
                $currentAttempt = (int)$row['Attempt_num'];
                $lastAttemptDate = $row['Date']; // Date of the last attempt

                // Check if the attempt count is less than 3
                if ($currentAttempt < 4) {
                    // Calculate the date difference
                    $currentDate = new DateTime();
                    $lastDate = new DateTime($lastAttemptDate);
                    $dateDifference = $lastDate->diff($currentDate);

                    if ($dateDifference->m >= 1 || $dateDifference->y >= 1) {
                        // If the difference is at least 1 month, insert a new record
                        $newAttempt = $currentAttempt + 1;

                        $insertQuery = "INSERT INTO course_score (course_ID, user_ID, Attempt_num, Answers, Score, Date) VALUES (?, ?, ?, ?, 0, NOW())";
                        $stmt = $trainmastas_conn->prepare($insertQuery);
                        $stmt->bind_param("ssis", $course_ID, $UID, $newAttempt, $answers);

                        if (!$stmt->execute()) {
                            echo json_encode(array('state' => 'error', 'message' => 'Failed to insert the score.'));
                            include "close_connection.php";
                            exit();
                        }
                    } else {
                        // If less than 1 month, do not allow a new attempt
                        echo json_encode(array('state' => 'tooSoon', 'message' => 'You need to wait at least 1 month before your next attempt.'));
                        include "close_connection.php";
                        exit();
                    }
                } else {
                    // If the attempt count has reached 3, do not allow a new attempt
                    echo json_encode(array('state' => 'limitReached', 'message' => 'You have already made 3 attempts.'));
                    include "close_connection.php";
                    exit();
                }
            } else {
                // If no record exists, insert the first attempt with score = 0
                $newAttempt = 1; // First attempt
                $insertQuery = "INSERT INTO course_score (course_ID, user_ID, Attempt_num, Answers, Score, Date) VALUES (?, ?, ?, ?, 0, NOW())";
                $stmt = $trainmastas_conn->prepare($insertQuery);
                $stmt->bind_param("ssis", $course_ID, $UID,  $newAttempt, $answers);

                if (!$stmt->execute()) {
                    echo json_encode(array('state' => 'error', 'message' => 'Failed to insert the score.'));
                    include "close_connection.php";
                    exit();
                }
            }

            // Fetch the test questions of this course
            $result = mysqli_query($trainmastas_conn, "SELECT Num_test FROM course WHERE course_ID = '$course_ID'");
            $limitTime = "";
            $timeNow = "";
            $duration = "";
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $duration = $row['Num_test']; // Assuming Num_test is in seconds  
                $timeNow = time(); // Current Unix timestamp  
                $limitTime = $timeNow + ($duration * 60);
                $limitTime = date('Y-m-d H:i:s', $limitTime);
                $timeNow = date('Y-m-d H:i:s', $timeNow);
            } else {
                echo json_encode(array('state' => 'error', 'message' => 'Failed to fetch duration.'));
                include "close_connection.php";
                exit();
            }

            $query = "SELECT `Question_num`, `Question`, `Option_A`, `Option_B`, `Option_C`, `Option_D` FROM course_test WHERE course_ID = ? ORDER BY CAST(`Question_num` AS UNSIGNED) ASC";
            $stmt = $trainmastas_conn->prepare($query);
            $stmt->bind_param("s", $course_ID);
            $stmt->execute();
            $result = $stmt->get_result();

            $test = [];
            while ($row = $result->fetch_assoc()) {
                $row['Question'] = decodeHtml($row['Question']);
                $row['Option_A'] = decodeHtml($row['Option_A']);
                $row['Option_B'] = decodeHtml($row['Option_B']);
                $row['Option_C'] = decodeHtml($row['Option_C']);
                $row['Option_D'] = decodeHtml($row['Option_D']);
                $test[] = $row; // Assuming a decodeHtml function exists to decode HTML entities
            }
            if (count($test) > 0) {
                echo json_encode(array('test' => $test, 'state' => 'test', 'currentTime' => $timeNow, 'limitTime' => $limitTime, 'duration' => $duration));
            } else {
                echo json_encode(array('state' => 'noTest'));
                include "close_connection.php";
                exit();
            }
            $newLevel = 'c'; // The new Level is completed
            // Prepare the SQL statement  
            $sql = "UPDATE course_registered SET Level = ? WHERE user_ID = ? AND course_ID = ?";
            // Prepare and execute the statement  
            if ($stmt = $trainmastas_conn->prepare($sql)) {
                // Bind parameters  
                $stmt->bind_param("sss", $newLevel, $UID, $course_ID); // "s" for string (newLevel), "i" for integer (UID and course_ID)  
                // Execute the statement  
                if (!$stmt->execute()) {
                    echo json_encode(array('state' => 'error', 'message' => 'Error when trying to update level'));
                    include "close_connection.php";
                    exit();
                }
            }
            $stmt->close();
        } else if ($purpose == "score") {
            // Fetch the score for this course
            $query = "SELECT cs.Score, c.Cost FROM course_score cs JOIN course c ON cs.course_ID = c.course_ID WHERE cs.course_ID = ? AND cs.user_ID = ?";
            $stmt = $trainmastas_conn->prepare($query);
            $stmt->bind_param("ss", $course_ID, $UID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $score = $row['Score'];
                $courseType = ($row["Cost"] == 0) ? "free" : "premium"; // Check cost and update it

                echo json_encode(array('score' => $score, 'state' => 'success', 'courseType' => $courseType));
            } else {
                echo json_encode(array('state' => 'noScore'));
            }
            $stmt->close();
        } else if (is_numeric($purpose) && $purpose >= 1 && $purpose <= 10) {
            // Fetch the specific module of this course
            $query = "SELECT Title, Description FROM course_modules WHERE course_ID = ? AND Module_num = ?";
            $stmt = $trainmastas_conn->prepare($query);
            $stmt->bind_param("si", $course_ID, $purpose);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $module = $result->fetch_assoc();
                $module["Title"] = decodeHtml($module["Title"]);
                $module["Description"] = decodeHtml($module["Description"]);

                // Fetch the videos for this module
                $video_query = "SELECT URL FROM course_video WHERE course_ID = ? AND Module_num  = ?";
                $video_stmt = $trainmastas_conn->prepare($video_query);
                $video_stmt->bind_param("si", $course_ID, $purpose);
                $video_stmt->execute();
                $video_result = $video_stmt->get_result();

                $videos = [];
                while ($video_row = $video_result->fetch_assoc()) {
                    $videos[] = $video_row;
                }

                echo json_encode(array('module' => $module, 'videos' => $videos, 'state' => 'success', 'moduleNum' => $purpose));

                $video_stmt->close();
            } else {
                echo json_encode(array('state' => 'noModule'));
            }
            $stmt->close();
        } else {
            echo json_encode(array('state' => 'noModule'));
        }
    } else {
        $query = "SELECT c.course_ID, c.user_ID AS courseOwner, cr.user_ID AS registeredUser
        FROM course c 
        LEFT JOIN course_registered cr ON cr.course_ID = c.course_ID AND cr.user_ID = ? 
        WHERE c.course_ID = ? AND c.action != 'd'";

        $stmt = $trainmastas_conn->prepare($query);
        $stmt->bind_param("ss", $UID, $course_ID);
        $stmt->execute();
        $result = $stmt->get_result();

        $state = "noCourse"; // Default state if the course doesn't exist

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (!empty($row['registeredUser'])) {
                $state = "registered"; // User is already registered for the course
            } elseif ($row['courseOwner'] === $UID) {
                $state = "userOwnsCourse"; // The course belongs to the user
            } else {
                $state = "notRegistered"; // User is not registered but can register for this course
            }
        } else {
            $state = "noCourse"; // Course does not exist
        }

        // Return the result as JSON
        echo json_encode(array('state' => $state));
        $stmt->close();
    }
} else if (isset($_POST['id']) && $_POST['purpose'] == 'update') {
    $course_ID = base64_decode($_POST['id']);  // Decode the course ID from the frontend
    $level = $_POST['currentVal'];
    if ($level == "test") {
        $level = "t"; // Level is test
    } else if ($level == "score") {
        $level = "c"; //Level is completed
    } else {
        $query = "SELECT `Module_num` FROM `course_modules` WHERE `Module_num` = ? AND `course_ID` = ?";
        $stmt = $trainmastas_conn->prepare($query);
        $stmt->bind_param("ss", $level, $course_ID);
        $stmt->execute();
        $result = $stmt->get_result();  // This line is unnecessary for an UPDATE statement  
        if ($stmt->affected_rows == 0) {
            echo json_encode(array('state' => 'error'));
            include "close_connection.php";
            exit;
        };
    }
    $query = "UPDATE course_registered cr JOIN course c ON cr.course_ID = c.course_ID  SET cr.Level=? WHERE c.action != 'd' AND cr.course_ID = ? AND cr.user_ID = ?";
    $stmt = $trainmastas_conn->prepare($query);
    $stmt->bind_param("sss", $level, $course_ID, $UID);
    $stmt->execute();
    $result = $stmt->get_result();  // This line is unnecessary for an UPDATE statement  
    if ($stmt->affected_rows > 0) {
        echo json_encode(array('state' =>  "updated"));
    };


    $level_query = "SELECT cr.Level FROM course_registered cr JOIN course_payment cp ON (cr.course_ID = cp.course_ID AND cr.user_ID = cp.user_ID)  
    WHERE cr.course_ID = ? AND cr.user_ID = ? AND cp.status='pending'";
    $level_stmt = $trainmastas_conn->prepare($level_query);

    $level_stmt->bind_param("ss", $course_ID, $UID);
    $level_stmt->execute();
    $level_result = $level_stmt->get_result();
    if ($level_result->num_rows > 0) {
        $row = $level_result->fetch_assoc();
        $userLevel = $row['Level'];
        // Step 3: Determine if transaction should be marked successful  
        if ($userLevel > 1) {
            // Step 6.1: Retrieve the user_ID associated with the course_ID  
            $stmt_course = $trainmastas_conn->prepare("SELECT `user_ID` FROM `course` WHERE `course_ID` = ?");
            $stmt_course->bind_param("s", $course_ID);
            $stmt_course->execute();
            $stmt_course->store_result();
            $stmt_course->bind_result($user_ID); // Get user_ID associated with the course  
            $stmt_course->fetch();
            $stmt_course->close();

            // Step 6.2: Retrieve the current fund for the user associated with this user_ID  
            $stmt_fund = $trainmastas_conn->prepare("SELECT `fund` FROM `user` WHERE `user_ID` = ?");
            $stmt_fund->bind_param("s", $user_ID);
            $stmt_fund->execute();
            $stmt_fund->store_result();
            $stmt_fund->bind_result($current_fund);
            $stmt_fund->fetch();
            $stmt_fund->close();

            // Step 6.3: Retrieve the course cost from the course_payment table  
            $stmt_payment = $trainmastas_conn->prepare("SELECT `Amount` FROM `course_payment` WHERE `course_ID` = ? AND `user_ID` = ? AND `Purpose`='fee'");
            $stmt_payment->bind_param("ss", $course_ID, $UID);  // Ensure both course_ID and user_ID are used for accuracy  
            $stmt_payment->execute();
            $stmt_payment->store_result();
            $stmt_payment->bind_result($course_cost);
            $stmt_payment->fetch();
            $stmt_payment->close();

            if ($current_fund === null) {
                $current_fund = 0; // Default to 0 if fund is NULL  
            }
            $new_fund = $current_fund + $course_cost * 0.5; // Add half of the course cost to the current fund  

            // Step 6.4: Update the fund in the user table  
            $stmt_update_fund = $trainmastas_conn->prepare("UPDATE `user` SET `fund` = ? WHERE `user_ID` = ?");
            $stmt_update_fund->bind_param("ds", $new_fund, $user_ID);
            $stmt_update_fund->execute();
            if ($stmt_update_fund->affected_rows > 0) {
                // Step 6.5: Update payment status to success if the fund is updated successfully  
                $stmt_update_payment = $trainmastas_conn->prepare("UPDATE `course_payment` SET `status` = 'success' WHERE `course_ID` = ? AND `user_ID` = ? AND `Purpose` = 'fee'");
                $stmt_update_payment->bind_param("ss", $course_ID, $UID);
                $stmt_update_payment->execute();
                $stmt_update_payment->close();
                echo json_encode(['state' => "success", 'message' => 'Fund updated successfully and payment status updated to success.']);
            } else {
                echo json_encode(['state' => "error", 'message' => 'An error occurred. Please try again later or contact the support team.']);
            }

            $stmt_update_fund->close();
        }
    }
} else if (isset($_POST['id']) && $_POST['purpose'] == 'score') {
    $course_ID = base64_decode($_POST['id']);  // Decode the course ID from the frontend

    ////////////////////////////////////////////////////
    // Verify test status(if he can take exam) 
    $checkAttemptsQuery = "SELECT cs.Attempt_num, cs.Date, c.Cost FROM course_score cs JOIN course c ON cs.course_ID = c.course_ID WHERE cs.course_ID = ? AND cs.user_ID = ? ORDER BY cs.Date DESC LIMIT 1";
    $stmt = $trainmastas_conn->prepare($checkAttemptsQuery);
    $stmt->bind_param("ss", $course_ID, $UID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $testStatus = "";
    $nextAttemptDate = "";
    $courseType = "";
    if ($row) {
        // User has previous attempts; check conditions
        $currentAttempt = (int)$row['Attempt_num'];
        $lastAttemptDate = $row['Date'];
        $courseType = ($row["Cost"] == 0) ? "free" : "premium"; // Check cost and update it

        if ($currentAttempt >= 3) {
            // User has reached the maximum number of attempts
            $testStatus = "limitReached";
        } else {
            // Check if the last attempt was at least 1 month ago
            $currentDate = new DateTime();
            $lastDate = new DateTime($lastAttemptDate);
            $dateDifference = $lastDate->diff($currentDate);

            if ($dateDifference->m >= 1 || $dateDifference->y >= 1) {
                // User can start the test
                $testStatus = "canStart";
            } else {
                // User must wait before attempting again
                $testStatus = "tooSoon";
                // Calculate the date when the user can take the exam  
                $nextAttemptDate = clone $lastDate; // Clone to avoid modifying the original date  
                $nextAttemptDate->modify('+1 month'); // Add one month  
                // Format the date for display  
                $nextAttemptDate = $nextAttemptDate->format('Y-m-d');
            }
        }
    } else {
        // No previous attempts; user can start the test
        $testStatus = "canStart";
    }
    $query = "SELECT Score,	Attempt_num , Date FROM course_score WHERE course_ID = ? AND user_ID = ?";
    $stmt = $trainmastas_conn->prepare($query);
    $stmt->bind_param("ss", $course_ID, $UID);
    $stmt->execute();
    $result = $stmt->get_result();
    $scores = [];
    if ($result->num_rows > 0) {
        while ($score_data = $result->fetch_assoc()) {
            $scores[] = array(
                'score' => $score_data['Score'],
                'attempt' => $score_data['Attempt_num'],
                'date' => $score_data['Date']
            );
        }
        $query = "SELECT `Question_num` FROM `course_test` WHERE course_ID = ?";
        $stmt = $trainmastas_conn->prepare($query);
        $stmt->bind_param("s", $course_ID);
        $stmt->execute();
        $result = $stmt->get_result();

        $test_number = $result->num_rows;
        $date = date("Y-m-d H:i:s");
        $buy = false;
        if ($courseType == "free") {
            // $query = "SELECT `payment_ID` FROM `course_payment` WHERE `course_ID`='$course_ID' AND `user_ID`='$UID' AND `Purpose`='cer'";
            $query = "SELECT `certificate_ID` FROM `course_registered` WHERE `course_ID`='$course_ID' AND `user_ID`='$UID' AND `certificate_ID` IS NOT NULL";
            // Execute the query  
            $result = mysqli_query($trainmastas_conn, $query);
            if ($result) {
                $num_rows = mysqli_num_rows($result);
                // Set $buy based on whether the number of rows is greater than 0  
                $buy = ($num_rows > 0);
            }
        }
        echo json_encode(array('state' => 'score', 'scores' => $scores, 'total_questions' => $test_number, 'Current_Date' => $date, 'testStatus' => $testStatus, 'nextAttemptDate' => $nextAttemptDate, 'is_bought' => $buy, "courseType" => $courseType));
    } else {
        echo json_encode(array('state' => 'noScore', 'message' => 'No scores found for this course.'));
    }

    $stmt->close();
} else if (isset($_POST['id']) && $_POST['purpose'] == 'testTaken') {
    $course_ID = base64_decode($_POST['id']);  // Decode the course ID from the frontend
    $attempt = $_POST['currentVal']; // Assuming attempt number is provided from frontend

    // Query to fetch scores and passed questions
    $query = "SELECT Score, Attempt_num, Date FROM course_score WHERE course_ID = ? AND user_ID = ? AND Attempt_num = ?";
    $stmt = $trainmastas_conn->prepare($query);
    $stmt->bind_param("sss", $course_ID, $UID, $attempt);
    $stmt->execute();
    $result = $stmt->get_result();

    $scores;
    if ($result->num_rows > 0) {
        $score_data = $result->fetch_assoc();
        $scores = array(
            'score' => $score_data['Score'],
            'attempt' => $score_data['Attempt_num'],
            'date' => $score_data['Date']
        );
        $current_score = $score_data['Score'];
        // Query to fetch user's answers from course_score
        $query = "SELECT Answers FROM course_score WHERE course_ID = ? AND user_ID = ? AND Attempt_num = ?";
        $stmt = $trainmastas_conn->prepare($query);
        $stmt->bind_param("sss", $course_ID, $UID, $attempt);
        $stmt->execute();
        $result = $stmt->get_result();

        $user_answers = [];
        if ($result->num_rows > 0) {
            $answer_data = $result->fetch_assoc();
            $user_answers = explode(",", $answer_data['Answers']);
        }

        // Query to fetch questions, options, and correct answers from course_test
        $query = "SELECT Question_num, Question, Option_A, Option_B, Option_C, Option_D, Answer FROM course_test WHERE course_ID = ? ORDER BY CAST(`Question_num` AS UNSIGNED) ASC";
        $stmt = $trainmastas_conn->prepare($query);
        $stmt->bind_param("s", $course_ID);
        $stmt->execute();
        $result = $stmt->get_result();

        $questions = [];
        $new_score = 0;
        $i = 0;
        while ($question_data = $result->fetch_assoc()) {
            $correct_answer = strtolower(trim(decodeHtml($question_data['Answer'])));
            $user_answer = isset($user_answers[$i]) ? strtolower(trim($user_answers[$i])) : 'n';

            $questions[] = array(
                'question_num' => $question_data['Question_num'],
                'question' => decodeHtml($question_data['Question']),
                'option_a' => decodeHtml($question_data['Option_A']),
                'option_b' => decodeHtml($question_data['Option_B']),
                'option_c' => decodeHtml($question_data['Option_C']),
                'option_d' => decodeHtml($question_data['Option_D']),
                'correct_answer' => $correct_answer,
                'user_answer' => $user_answer,
                'answerIs' => $user_answer === $correct_answer ? 'correct' : 'wrong'
            );

            if ($user_answer === $correct_answer) {
                $new_score++;
            }

            $i++;
        }
        if ($current_score > $new_score) {
            // User lost points due to updated answers — fix some wrong ones to maintain old score
            $answers_fixed = 0;
            foreach ($questions as $index => $q) {
                if ($q['answerIs'] == "wrong" && $user_answers[$index] !== 'n') {
                    $user_answers[$index] = $q['correct_answer']; // change answer to new correct one
                    $questions[$index]['user_answer'] = $q['correct_answer'];
                    $questions[$index]['answerIs'] = 'correct';
                    $answers_fixed++;
                    if (($new_score + $answers_fixed) >= $current_score) break;
                }
            }

            // Update answers and score
            $updated_answers_str = implode(",", $user_answers);
            $updateQuery = "UPDATE course_score SET Answers = ? WHERE course_ID = ? AND user_ID = ? AND Attempt_num = ?";
            $stmt = $trainmastas_conn->prepare($updateQuery);
            $stmt->bind_param("ssss", $updated_answers_str, $course_ID, $UID, $attempt);
            $stmt->execute();
        } else if ($current_score < $new_score) {
            // User gained points — just update the score
            $updateQuery = "UPDATE course_score SET Score = ? WHERE course_ID = ? AND user_ID = ? AND Attempt_num = ?";
            $stmt = $trainmastas_conn->prepare($updateQuery);
            $stmt->bind_param("ssss", $new_score, $course_ID, $UID, $attempt);
            $stmt->execute();
            $scores['score'] = $new_score;
        }

        foreach ($questions as &$question) {
            unset($question['correct_answer']);
        }
        unset($question); // Break the reference after the loop  

        $date = date("Y-m-d H:i:s");
        echo json_encode(array(
            'state' => 'review',
            'scores' => $scores,
            'questions' => $questions, // Added to include questions and answers
            'total_questions' => count($questions),
            'Current_Date' => $date
        ));
    } else {
        echo json_encode(array('state' => 'noScore', 'message' => 'No scores found for this course.'));
    }

    $stmt->close();
} else if (isset($_POST['course_id']) && $_POST['purpose'] == 'testAnswered') {
    $course_ID = base64_decode($_POST['course_id']);

    // Ensure answers are treated as a string
    $submitted_answers = is_array($_POST['answers']) ? implode(',', $_POST['answers']) : $_POST['answers'];
    // Validate the answers
    if (!preg_match('/^[a-dn](,[a-dn])*$/', $submitted_answers)) {
        echo json_encode(array('state' => 'error', 'message' => 'Invalid answer format.'));
        include "close_connection.php";
        exit();
    }

    // Fetch the correct answers from the database
    $correctAnswersQuery = "SELECT Question_num, Answer FROM course_test WHERE course_ID = ?";
    $stmt = $trainmastas_conn->prepare($correctAnswersQuery);
    $stmt->bind_param("s", $course_ID);
    $stmt->execute();
    $result = $stmt->get_result();

    $correct_answers = [];
    while ($row = $result->fetch_assoc()) {
        $correct_answers[$row['Question_num']] = $row['Answer'];
    }

    $stmt->close();

    // Split the submitted answers and compare them
    $submitted_answers_array = explode(',', $submitted_answers);
    $score = 0;
    foreach ($submitted_answers_array as $index => $answer) {
        $question_num = $index + 1;  // Assuming question numbers start at 1
        if (isset($correct_answers[$question_num]) && $correct_answers[$question_num] == $answer) {
            $score++;
        }
    }

    // Check if the record exists
    $checkQuery = "SELECT Attempt_num, Score FROM course_score WHERE course_ID = ? AND user_ID = ? ORDER BY Date DESC LIMIT 1";
    $stmt = $trainmastas_conn->prepare($checkQuery);
    $stmt->bind_param("ss", $course_ID, $UID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row) {
        // If the record exists, check the attempt count
        $currentAttempt = (int)$row['Attempt_num'];
        if ($currentAttempt < 4) {
            // Update the existing record with the new score and date
            $updateQuery = "UPDATE course_score SET  Score = ?, Answers = ?, Date = NOW() WHERE course_ID = ? AND user_ID = ? AND Attempt_num = ?";
            $stmt = $trainmastas_conn->prepare($updateQuery);
            $stmt->bind_param("issss", $score, $submitted_answers, $course_ID, $UID, $currentAttempt);
            if ($stmt->execute()) {
                // Update the Level to 'c' in course_registered table
                $updateLevelQuery = "UPDATE course_registered SET Level = 'c' WHERE course_ID = ? AND user_ID = ?";
                $stmt = $trainmastas_conn->prepare($updateLevelQuery);
                $stmt->bind_param("ss", $course_ID, $UID);
                $stmt->execute();
                echo json_encode(array('state' => 'success', 'attempt_num' => $currentAttempt, 'score' => $score));
            } else {
                echo json_encode(array('state' => 'error', 'message' => 'Failed to update the score.'));
            }
        } else {
            echo json_encode(array('state' => 'error', 'message' => 'You have already made 3 attempts.'));
        }
    } else {
        // If the record does not exist, insert a new one
        $newAttempt = 1; // First attempt
        $insertQuery = "INSERT INTO course_score (course_ID, user_ID, Attempt_num, Score, Date) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $trainmastas_conn->prepare($insertQuery);
        $stmt->bind_param("ssis", $course_ID, $UID, $newAttempt, $score);
        if ($stmt->execute()) {
            echo json_encode(array('state' => 'success', 'attempt_num' => $newAttempt, 'score' => $score));
        } else {
            echo json_encode(array('state' => 'error', 'message' => 'Failed to insert the score.'));
        }
    }
    ///////////////////////////////////////////////////////////
    ///////                Determine Certificate        ///////
    ///////////////////////////////////////////////////////////
    // Generate certificate code eg 34fdc-2f72b-ff030-c80fe
    function generateCertificateCode()
    {
        // Define the character pool: alphanumeric  
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $code = '';
        // Generate 20 random characters  
        for ($i = 0; $i < 20; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        // Format the code with hyphens  
        $formattedCode = substr($code, 0, 5) . '-' . substr($code, 5, 5) . '-' . substr($code, 10, 5) . '-' . substr($code, 15, 5);
        return $formattedCode; // Returns both formatted  
    }
    // Step 1: Get Num_test  
    $sql = "SELECT `Num_test`,`Cost` FROM `course` WHERE `course_ID` = '$course_ID'";
    $result = $trainmastas_conn->query($sql);
    if ($result->num_rows > 0) {
        // Fetch the result  
        $row = $result->fetch_assoc();
        $num_test = $row['Num_test'];
        $temp_score = ($score / $num_test) * 100;
        // Certificate
        if ($row['Cost'] > 0 && $num_test > 0) {
            // Step 2: Check score and insert if passed 
            if ($temp_score >= 80) {
                // Generate a unique certificate ID  
                $unique_certificate_ID = generateCertificateCode();
                $date = date('Y-m-d H:i:s');

                $date_temp = new DateTime(); // Create a new DateTime object with the current date and time  
                $date_temp->modify('+2 years'); // Add 2 years to the current date  
                $updatedDate = $date_temp->format('Y-m-d H:i:s'); // Format the date as a string  

                // Step 3: Insert into the course_registered table  
                $update_sql = "UPDATE `course_registered` SET `certificate_ID` = '$unique_certificate_ID',`certificate_Date` = '$date', `certificate_expired_Date` = '$updatedDate WHERE `user_ID` = '$UID' AND `course_ID` = '$course_ID'";
                $trainmastas_conn->query($update_sql);
            }
        }
    }
    $stmt->close();
} else {
    header('location: ../forbidden.php');
}
include 'close_connection.php';
