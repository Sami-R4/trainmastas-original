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
/////////////////////////////////////////////////////////////////
//                        Send Courses Processes
/////////////////////////////////////////////////////////////////
function getUserPreferences($UID, $trainmastas_conn)
{
    // Query to get user preferences from the 'fields' table
    $query = "SELECT `Field` FROM `fields` WHERE `user_ID` = ?";

    // Prepare the query statement
    $stmt = $trainmastas_conn->prepare($query);

    if (!$stmt) {
        // Handle error if the statement preparation fails
        die("Error preparing the statement: " . $trainmastas_conn->error);
    }

    // Bind the user ID parameter
    $stmt->bind_param("s", $UID);
    $stmt->execute();

    // Get the result of the query
    $result = $stmt->get_result();
    $preferences = [];

    // Fetch preferences as an array
    while ($row = $result->fetch_assoc()) {
        $preferences[] = $row['Field'];
    }

    // Close the statement
    $stmt->close();

    return $preferences;
}


if (isset($_POST['page']) && $_POST['purpose'] == 'getItems') {
    $page = filter_var(process_input($trainmastas_conn, $_POST['page']), FILTER_SANITIZE_NUMBER_INT);
    $pageNum = isset($_POST['pageNum']) ? $_POST['pageNum'] : 12;

    $limit = (is_numeric($page) && $page >= 1) ? ($page * $pageNum) : $pageNum;
    $start = $limit - $pageNum;

    $query_params = [];
    $Courses = [];
    $num = 0;
    $response = [];
    $total = 0;
    $course_ID = '';
    $exclude_course_condition = "";

    if (isset($_POST['course_ID']) && $_POST['course_ID'] != '') {
        $course_ID = base64_decode($_POST['course_ID']);
        $exclude_course_condition = " AND cp.course_ID != ?";
    }

    if ($UID) {
        
        $user_fields = [];

        $user_query = "SELECT Field FROM fields WHERE user_ID = ?";
        $user_stmt = $trainmastas_conn->prepare($user_query);
        $user_stmt->bind_param("s", $UID);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();

        while ($row = $user_result->fetch_assoc()) {
            $user_fields[] = $row['Field'];
        }
        $user_stmt->close();

        $query_params = [];
        $Courses = [];
        $num = 0;
        $total = 0;

        if (!empty($user_fields)) {
            foreach ($user_fields as $field) {
                $query_params[] = "%$field%";
                $query_params[] = "%$field%";
                $query_params[] = "%$field%";
            }
        }

        $base_query = "
            SELECT 
                cp.course_ID, 
                cp.Title, 
                cp.Cover_image, 
                cp.Cost, 
                cp.Num_test, 
                cp.Date, 
                u.Name AS Creator_Name, 
                u.Image AS Creator_Image, 
                IFNULL(AVG(cf.Rate), '') AS Avg_Rate, 
                COUNT(CASE WHEN cf.Rate IS NOT NULL THEN 1 ELSE NULL END) AS Total_Rates,
                CASE 
                    WHEN (";
        $count_query = "
            SELECT COUNT(DISTINCT cp.course_ID), CASE WHEN (";

        if (!empty($user_fields)) {
            $field_conditions = [];
            foreach ($user_fields as $field) {
                $field_conditions[] = "(cs.Scope LIKE ? OR cp.Category LIKE ? OR cp.Title LIKE ?)";
            }
            $fields_condition = implode(' OR ', $field_conditions);
            $base_query .= $fields_condition;
            $count_query .= $fields_condition;
        } else {
            $base_query .= "0";
            $count_query .= "0";
        }

        $base_query .= ") THEN 1 ELSE 0 END AS MatchesPreference
            FROM course AS cp
            LEFT JOIN course_scope AS cs ON cp.course_ID = cs.course_ID
            LEFT JOIN user AS u ON cp.user_ID = u.user_ID
            LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
            WHERE cp.action = 'n' AND cp.user_ID != ?" . $exclude_course_condition . "
            GROUP BY cp.course_ID
            ORDER BY MatchesPreference DESC, Avg_Rate DESC, cp.Date DESC
            LIMIT ?, ?
        ";

        $count_query .= ") THEN 1 ELSE 0 END AS MatchesPreference
            FROM course AS cp
            LEFT JOIN course_scope AS cs ON cp.course_ID = cs.course_ID
            LEFT JOIN user AS u ON cp.user_ID = u.user_ID
            LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
            WHERE cp.action = 'n' AND cp.user_ID != ?" . $exclude_course_condition . "
        ";

        $query_params[] = $UID;
        if (!empty($course_ID)) {
            $query_params[] = $course_ID;
        }

        // Count query
        $param_types = str_repeat("s", count($user_fields) * 3) . "s" . (!empty($course_ID) ? "s" : "");
        $total_stmt = $trainmastas_conn->prepare($count_query);
        $total_stmt->bind_param($param_types, ...$query_params);
        $total_stmt->execute();
        $total_result = $total_stmt->get_result();
        $total = $total_result->fetch_row()[0];
        $total_stmt->close();

        // Pagination params
        $param_types .= "ii";
        $query_params[] = $start;
        $query_params[] = $limit;

        // Base query
        $stmt = $trainmastas_conn->prepare($base_query);
        $stmt->bind_param($param_types, ...$query_params);
        $stmt->execute();
        $result = $stmt->get_result();
        $num_row = $result->num_rows;
    } else {
        // Not logged in
        $base_query = "
            SELECT 
                cp.course_ID, 
                cp.Title, 
                cp.Cover_image, 
                cp.Cost,
                cp.Num_test, 
                cp.Date, 
                u.Name AS Creator_Name, 
                u.Image AS Creator_Image, 
                IFNULL(AVG(cf.Rate), '') AS Avg_Rate, 
                COUNT(CASE WHEN cf.Rate IS NOT NULL THEN 1 ELSE NULL END) AS Total_Rates
            FROM course AS cp
            LEFT JOIN user AS u ON cp.user_ID = u.user_ID
            LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
            WHERE cp.action = 'n'" . $exclude_course_condition . "
            GROUP BY cp.course_ID 
            ORDER BY Total_Rates DESC, Avg_Rate DESC, cp.Date DESC
            LIMIT ?, ?
        ";

        $count_query = "
            SELECT COUNT(DISTINCT cp.course_ID) 
            FROM course AS cp
            LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
            WHERE cp.action = 'n'" . $exclude_course_condition;

        // Count query
        $query_params = [];
        $param_types = "";

        if (!empty($course_ID)) {
            $query_params[] = $course_ID;
            $param_types .= "s";
        }

        $total_stmt = $trainmastas_conn->prepare($count_query);
        if (!empty($param_types)) {
            $total_stmt->bind_param($param_types, ...$query_params);
        }
        $total_stmt->execute();
        $total_result = $total_stmt->get_result();
        $total = $total_result->fetch_row()[0];
        $total_stmt->close();

        // Pagination
        $query_params[] = $start;
        $query_params[] = $limit;
        $param_types .= "ii";

        // Base query
        $stmt = $trainmastas_conn->prepare($base_query);
        $stmt->bind_param($param_types, ...$query_params);
        $stmt->execute();
        $result = $stmt->get_result();
        $num_row = $result->num_rows;
    }

    if ($num_row > 0) {
        while ($row = $result->fetch_assoc()) {
            $Courses[$num]['Title'] = decodeHtml($row['Title']);
            $Courses[$num]['course_ID'] = base64_encode($row['course_ID']);
            $Courses[$num]['Cover_image'] = $row['Cover_image'];
            $Courses[$num]['Rate'] = number_format((float)$row['Avg_Rate'], 1);
            $Courses[$num]['Creator_Name'] = $row['Creator_Name'];
            $Courses[$num]['Creator_Image'] = $row['Creator_Image'];
            $Courses[$num]['Cost'] = $row['Cost'];
            $Courses[$num]['Total_Rates'] = $row['Total_Rates'];
            $Courses[$num]['Num_test'] = $row['Num_test'];
            $Courses[$num]['Date'] = $row['Date'];
            $num++;
        }

        $Courses[0]['Current_Date'] = date('Y-m-d H:i:s');

        $response = array(
            'state' => 'success',
            'total' => $total,
            'Courses' => $Courses
        );
    } else {
        $response = array('state' => 'notfound');
    }

    $stmt->close();
    echo json_encode($response);
} else if (isset($_POST['page']) && $_POST['purpose'] == 'search') {
    /////////////////////////////////////////////////////////////////
    //                        Courses Search Processes
    /////////////////////////////////////////////////////////////////
    $page = filter_var(process_input($trainmastas_conn, $_POST['page']), FILTER_SANITIZE_NUMBER_INT);
    if (is_numeric($page) && $page >= 1) {
        $limit = $page * 12;
    } else {
        $limit = 12; // Set a default limit
    }
    $start = $limit - 12;
    $search_this = strtolower(decodeHtml(mysqli_real_escape_string($trainmastas_conn, $_POST['type'])));
    $Courses = [];
    $num = 0;
    $response = [];
    $moreQL = '';
    $search_param = '%' . $search_this . '%';
    $param_types = 'sssii'; // Base parameter types for search and limit
    $params = [$search_param, $search_param, $search_param, $start, $limit];

    if ($UID) {
        $moreQL = " AND cp.user_ID != ?";
        $param_types = 'ssssii'; // Add 's' for user_ID (string)
        array_splice($params, -2, 0, $UID); // Insert UID before start and limit
    }

    // Construct the query
    $query = "SELECT cp.course_ID, cp.Title, cp.Cover_image, cp.Num_test, cp.Cost, cp.Date, u.Name AS Creator_Name, u.Image AS Creator_Image,
                  IFNULL(AVG(cf.Rate), '') AS Avg_Rate,
                  COUNT(CASE WHEN cf.Rate IS NOT NULL THEN 1 ELSE NULL END) AS Total_Rates
           FROM course AS cp
           JOIN user AS u ON cp.user_ID = u.user_ID
           LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
           LEFT JOIN course_scope AS cs ON cp.course_ID = cs.course_ID
           WHERE (cp.Title LIKE ? OR cp.Description LIKE ? OR cs.Scope LIKE ?) AND cp.action = 'n'
           $moreQL
           GROUP BY cp.course_ID
           ORDER BY Avg_Rate DESC, cp.Date DESC
           LIMIT ?, ?";

    $count_query = "SELECT COUNT(DISTINCT cp.course_ID)
                FROM course AS cp
                LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
                LEFT JOIN course_scope AS cs ON cp.course_ID = cs.course_ID
                WHERE (cp.Title LIKE ? OR cp.Description LIKE ? OR cs.Scope LIKE ?) AND cp.action = 'n' $moreQL";

    // Prepare the statement
    $stmt = $trainmastas_conn->prepare($query);

    if ($stmt) {
        // Bind the parameters dynamically
        if (!empty($params)) {
            $stmt->bind_param($param_types, ...$params);
        }

        // Execute and fetch results
        $stmt->execute();
        $result = $stmt->get_result();
        $num_row = $result->num_rows;

        $Courses = [];
        $num = 0;
        if ($num_row > 0) {
            while ($row = $result->fetch_assoc()) {
                $Courses[$num]['Title'] = decodeHtml($row['Title']);
                $Courses[$num]['course_ID'] = base64_encode($row['course_ID']);
                $Courses[$num]['Cover_image'] = $row['Cover_image'];
                $Courses[$num]['Rate'] = number_format((float)$row['Avg_Rate'], 1);
                $Courses[$num]['Total_Rates'] = $row['Total_Rates'];
                $Courses[$num]['Num_test'] = $row['Num_test'];
                $Courses[$num]['Creator_Name'] = $row['Creator_Name'];
                $Courses[$num]['Creator_Image'] = $row['Creator_Image'];
                $Courses[$num]['Cost'] = $row['Cost'];
                $Courses[$num]['Date'] = $row['Date'];
                $num++;
            }
            $Courses[0]['Current_Date'] = date('Y-m-d H:i:s');

            // Get the total count of results
            $total_stmt = $trainmastas_conn->prepare($count_query);
            if ($total_stmt) {
                $count_param_types = 'sss';
                $count_params = [$search_param, $search_param, $search_param];
                if ($UID) {
                    $count_param_types .= 's';
                    $count_params[] = $UID;
                }
                $total_stmt->bind_param($count_param_types, ...$count_params);
                $total_stmt->execute();
                $total_result = $total_stmt->get_result();
                $total = $total_result->fetch_row()[0] ?? 0;
                $total_stmt->close();

                $response = array(
                    'state' => 'success',
                    'total' => $total,
                    'Courses' => $Courses
                );
            } else {
                $response = array(
                    'state' => 'error',
                    'message' => 'Error preparing total count query: ' . $trainmastas_conn->error
                );
            }
        } else {
            $response = array(
                'state' => 'notfound'
            );
        }

        // Close the statement
        $stmt->close();
    } else {
        $response = array(
            'state' => 'error',
            'message' => 'Error preparing main query: '
        );
    }

    echo json_encode($response);
} else if (isset($_POST['type']) && $_POST['purpose'] == 'filter') {
    /////////////////////////////////////////////////////////////////
    //                        Courses Search Processes
    /////////////////////////////////////////////////////////////////
    // return mysqli_real_escape_string($conn, htmlspecialchars(sanitize($item), ENT_QUOTES, 'UTF-8'));

    $page = filter_var(process_input($trainmastas_conn, $_POST['page']), FILTER_SANITIZE_NUMBER_INT);
    // Check if $page is a valid integer and handle potential errors
    if (is_numeric($page) && $page >= 1) {
        $limit = $page * 12;
    } else {
        $limit = 12; // Set a default limit
    }
    $start = $limit - 12;
    $period_Search = "DESC";
    $category_Search = "";
    $type_Search = "";
    $search = "";

    // Filter By category
    if (isset($_POST['type']['category'])) {
        $category = process_input($trainmastas_conn, $_POST['type']['category']);
        $or = "";
        for ($i = 0; $i < count($category); $i++) {
            $category_Search .= $or . " cp.Category = '$category[$i]' ";
            $or = ' OR ';
        }
        $category_Search = " AND ($category_Search)";
    }

    // Filter By type
    if (isset($_POST['type']['course_type']) && $_POST['type']['course_type'] !== "") {
        // echo $_POST['type']['course_type'];
        $type = mysqli_real_escape_string($trainmastas_conn, htmlspecialchars($_POST['type']['course_type'], ENT_QUOTES, 'UTF-8'));
        // $type = process_input($trainmastas_conn, $_POST['type']['course_type']);
        if ($type == "free") {
            $type_Search .= " cp.Cost = 0";
        } else {
            $type_Search .= " cp.Cost != 0";
        }
        $type_Search = " AND ($type_Search)";
    }

    // Filter By period
    if (isset($_POST['type']['period']) && $_POST['type']['period'] !== "") {
        $period = mysqli_real_escape_string($trainmastas_conn, htmlspecialchars($_POST['type']['period'], ENT_QUOTES, 'UTF-8'));
        // $period = process_input($trainmastas_conn, $_POST['type']['period']);
        if ($period == "oldest") {
            $period_Search = "ASC";
        }
    }


    $Courses = [];
    $num = 0;
    $response = [];


    if (isset($_POST['type']['search']) && $_POST['type']['search'] !== "") {
        if ($UID) {
            $is_logged_in = true;
        } else {
            $UID = null;
            $is_logged_in = false;
        }

        $search = process_input($trainmastas_conn, $_POST['type']['search']);
        $search_param = '%' . $search . '%';

        // Base SELECT query
        $query = "
            SELECT 
                cp.course_ID, 
                cp.Title, 
                cp.Cover_image, 
                cp.Cost, 
                cp.Date, 
                cp.Num_test,
                u.Name AS Creator_Name, 
                u.Image AS Creator_Image, 
                IFNULL(AVG(cf.Rate), '') AS Avg_Rate, 
                COUNT(CASE WHEN cf.Rate IS NOT NULL THEN 1 ELSE NULL END) AS Total_Rates
            FROM course AS cp
            LEFT JOIN course_scope AS cs ON cp.course_ID = cs.course_ID
            LEFT JOIN user AS u ON cp.user_ID = u.user_ID
            LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
            WHERE cp.action = 'n'
              AND (cp.Title LIKE ? OR cp.Description LIKE ? OR cs.Scope LIKE ?)
        ";

        // Add filter for logged-in user (exclude their courses)
        if ($is_logged_in) {
            $query .= " AND cp.user_ID != ?";
        }

        // Optional filters
        if (!empty($category_Search)) {
            $query .= " $category_Search";
        }
        if (!empty($type_Search)) {
            $query .= " $type_Search";
        }

        $query .= "
            GROUP BY cp.course_ID
            ORDER BY Avg_Rate DESC, cp.Date $period_Search 
            LIMIT ?, ?
        ";

        // Prepare main query
        $stmt = $trainmastas_conn->prepare($query);

        // Bind based on login state
        if ($is_logged_in) {
            $stmt->bind_param('ssssii', $search_param, $search_param, $search_param, $UID, $start, $limit);
        } else {
            $stmt->bind_param('sssii', $search_param, $search_param, $search_param, $start, $limit);
        }

        // Count query (for total results)
        $count_query = "
            SELECT COUNT(DISTINCT cp.course_ID)
            FROM course AS cp
            LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
            LEFT JOIN course_scope AS cs ON cp.course_ID = cs.course_ID
            WHERE cp.action = 'n'
              AND (cp.Title LIKE ? OR cp.Description LIKE ? OR cs.Scope LIKE ?)
        ";

        if (!empty($category_Search)) {
            $count_query .= " $category_Search";
        }
        if (!empty($type_Search)) {
            $count_query .= " $type_Search";
        }

        $total_stmt = $trainmastas_conn->prepare($count_query);
        $total_stmt->bind_param('sss', $search_param, $search_param, $search_param);
    } else if ($UID) {
        // Update base query for logged-in users with dynamic filters
        $base_query = "SELECT cp.course_ID, cp.Title, cp.Num_test, cp.Cover_image, cp.Cost, cp.Date, u.Name AS Creator_Name, u.Image AS Creator_Image, 
        IFNULL(AVG(cf.Rate), '') AS Avg_Rate, COUNT(CASE WHEN cf.Rate IS NOT NULL THEN 1 ELSE NULL END) AS Total_Rates,
        CASE WHEN (";
        $count_query = "SELECT COUNT(DISTINCT cp.course_ID), CASE WHEN (";

        /**
         * @var mixed
         */
        $user_query = "SELECT `Field` FROM `fields` WHERE `user_ID` = ?";
        $user_stmt = $trainmastas_conn->prepare($user_query);
        $user_stmt->bind_param("s", $UID);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();

        while ($row = $user_result->fetch_assoc()) {
            $user_fields[] = $row['Field'];
        }
        $user_stmt->close();

        // Add user preferences conditions
        if (!empty($user_fields)) {
            $field_conditions = [];
            foreach ($user_fields as $field) {
                $field_conditions[] = "(cs.Scope LIKE ? OR cp.Category LIKE ? OR cp.Title LIKE ?)";
            }
            $fields_condition = implode(' OR ', $field_conditions);
            $base_query .= " ($fields_condition) ";
            $count_query .= $fields_condition;
        } else {
            $base_query .= "0";  // No preferences, so always false
            $count_query .= "0";  // No preferences, so always false
        }

        $base_query .= ") THEN 1 ELSE 0 END AS MatchesPreference FROM course AS cp LEFT JOIN course_scope AS cs ON cp.course_ID = cs.course_ID
        LEFT JOIN user AS u ON cp.user_ID = u.user_ID LEFT JOIN course_feedback AS 
        cf ON cp.course_ID = cf.course_ID WHERE cp.action = 'n' AND cp.user_ID != ? ";
        $count_query .= ") THEN 1 ELSE 0 END AS MatchesPreference FROM course AS cp LEFT JOIN course_scope AS cs ON cp.course_ID = cs.course_ID
                LEFT JOIN user AS u ON cp.user_ID = u.user_ID LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
                WHERE cp.action = 'n' AND cp.user_ID != ?";

        // Add category filter
        if (!empty($category_Search)) {
            $base_query .= " $category_Search";
            $count_query .= " $category_Search";
        }

        // Add course type filter
        if (!empty($type_Search)) {
            $base_query .= " $type_Search";
            $count_query .= " $type_Search";
        }

        // Add grouping, sorting, and limits
        $base_query .= " GROUP BY cp.course_ID ORDER BY cp.Date $period_Search, Avg_Rate DESC LIMIT ?, ?";

        // Prepare query parameters
        $query_params = [];
        $param_types = '';

        if (!empty($user_fields)) { // Add user preferences
            foreach ($user_fields as $field) {
                $query_params[] = "%$field%";
                $query_params[] = "%$field%";
                $query_params[] = "%$field%";
                $param_types .= "sss";
            }
        }

        // Add category parameters
        if (isset($categories)) {
            foreach ($categories as $cat) {
                $query_params[] = $cat;
                $param_types .= "s";
                $base_query .= " AND cp.Category LIKE ?";
                $count_query .= " AND cp.Category LIKE ?";
            }
        }

        $query_params[] = $UID; // Start with the UID
        $param_types .= "s"; // UID type

        // Prepare and execute the total count query
        $total_stmt = $trainmastas_conn->prepare($count_query);
        $total_stmt->bind_param($param_types, ...$query_params);
        $total_stmt->execute();
        $total_result = $total_stmt->get_result();
        $total_logged_in = $total_result->fetch_row()[0];

        // Add pagination parameters
        $query_params[] = $start;
        $query_params[] = $limit;
        $param_types .= "ii";
        // Prepare and execute the main query
        $stmt = $trainmastas_conn->prepare($base_query);
        $stmt->bind_param($param_types, ...$query_params);
    } else {
        // When not logged-in
        $query = "SELECT cp.course_ID, cp.Title, cp.Num_test, cp.Cover_image, cp.Cost, cp.Date, u.Name AS Creator_Name, u.Image AS Creator_Image, 
        IFNULL(AVG(cf.Rate), '') AS Avg_Rate, COUNT(CASE WHEN cf.Rate IS NOT NULL THEN 1 ELSE NULL END) AS Total_Rates
        FROM course AS cp 
        JOIN user AS u ON cp.user_ID = u.user_ID
        LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
        WHERE cp.action = 'n'";
        if ($category_Search == !"") {
            $query .= " $category_Search";
        }
        if ($type_Search == !"") {
            $query .= " $type_Search";
        }

        $query .= " GROUP BY cp.course_ID
                    ORDER BY Avg_Rate DESC, cp.Date  $period_Search 
                    LIMIT ?, ?";


        $count_query = "SELECT COUNT(DISTINCT cp.course_ID) 
         FROM course AS cp 
         LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
         WHERE cp.action = 'n'";
        if ($category_Search == !"") {
            $count_query .= "  $category_Search ";
        }
        if ($type_Search == !"") {
            $count_query .= "  $type_Search ";
        }
        $stmt = $trainmastas_conn->prepare($query);
        $stmt->bind_param("ii", $start, $limit);


        $total_stmt = $trainmastas_conn->prepare($count_query);
    }


    // Execute and fetch results
    $stmt->execute();
    $result = $stmt->get_result();
    $num_row = $result->num_rows;

    if ($num_row > 0) {
        $num = 0;
        while ($row = $result->fetch_assoc()) {
            $Courses[$num]['Title'] = decodeHtml($row['Title']);
            $Courses[$num]['course_ID'] = base64_encode($row['course_ID']);
            $Courses[$num]['Cover_image'] = $row['Cover_image'];
            $Courses[$num]['Rate'] = number_format((float)$row['Avg_Rate'], 1);
            $Courses[$num]['Total_Rates'] = $row['Total_Rates'];
            $Courses[$num]['Num_test'] = $row['Num_test'];
            $Courses[$num]['Creator_Name'] = $row['Creator_Name'];
            $Courses[$num]['Creator_Image'] = $row['Creator_Image'];
            $Courses[$num]['Cost'] = $row['Cost'];
            $Courses[$num]['Date'] = $row['Date'];
            $num++;
        }
        $Courses[0]['Current_Date'] = date('Y-m-d H:i:s');
        // echo $count_query;

        $total_stmt->execute();
        $total_result = $total_stmt->get_result();
        $total = $total_result->fetch_row()[0];
        $response = array(
            'state' => 'success',
            'total' => $total,
            'Courses' => $Courses
        );
        $total_stmt->close();
    } else {
        // Course Not Found
        $response = array(
            'state' => 'notfound'
        );
    }

    // Close the statement and connection 
    $stmt->close();
    echo json_encode($response);
    // Echo the JSON-encoded response
} else if (isset($_POST['id']) && $_POST['purpose'] == 'sendUserCourses') {
    // Fetch the page and pageNum from the POST request
    $page = filter_var(process_input($trainmastas_conn, $_POST['page']), FILTER_SANITIZE_NUMBER_INT);
    $pageNum = isset($_POST['pageNum']) ? $_POST['pageNum'] : 12;

    // Check if the page number is valid
    if (is_numeric($page) && $page >= 1) {
        $limit = $page * $pageNum;
    } else {
        $limit = $pageNum; // Default limit if page number is invalid
    }
    $start = $limit - $pageNum;

    // Initialize response variables
    $query_params = [];
    $Courses = [];
    $num = 0;
    $response = [];
    $total = 0;

    if (isset($_POST['id'])) {
        $id = filter_var(base64_decode($_POST['id']), FILTER_SANITIZE_STRING); // Teacher's user_ID

        // Build the count query (to get total courses of the teacher)
        $count_query = "
        SELECT COUNT(DISTINCT cp.course_ID)
        FROM course AS cp
        WHERE cp.action = 'n' AND cp.user_ID = ?
    ";

        // Prepare and execute count query
        $total_stmt = $trainmastas_conn->prepare($count_query);
        $total_stmt->bind_param("s", $id);
        $total_stmt->execute();
        $total_result = $total_stmt->get_result();
        $total = $total_result->fetch_row()[0];

        // Build the base query to fetch courses of the teacher
        $base_query = "
        SELECT 
            cp.course_ID, 
            cp.Title, 
            cp.Cover_image, 
            cp.Cost, 
            cp.Date,
            cp.Num_test, 
            u.Name AS Creator_Name, 
            u.Image AS Creator_Image, 
            IFNULL(AVG(cf.Rate), '') AS Avg_Rate, 
            COUNT(CASE WHEN cf.Rate IS NOT NULL THEN 1 ELSE NULL END) AS Total_Rates
        FROM course AS cp
        LEFT JOIN user AS u ON cp.user_ID = u.user_ID
        LEFT JOIN course_feedback AS cf ON cp.course_ID = cf.course_ID
        WHERE cp.action = 'n' AND cp.user_ID = ?
        GROUP BY cp.course_ID
        ORDER BY Avg_Rate DESC, cp.Date DESC
        LIMIT ?, ?
    ";

        // Execute the base query
        $stmt = $trainmastas_conn->prepare($base_query);
        $stmt->bind_param("sii", $id, $start, $pageNum);
        $stmt->execute();
        $result = $stmt->get_result();
        $num_row = $result->num_rows;

        // Fetch courses
        while ($row = $result->fetch_assoc()) {
            $Courses[] = $row;
        }

        $stmt->close();
    }
    $current_date = date("Y-m-d H:i:s");
    // Response output
    $response = array(
        'state' => 'success',
        'total' => $total,
        'Courses' => $Courses,
        'Current_Date' => $current_date
    );
    echo json_encode($response);
} else if (isset($_POST['course_ID']) && $_POST['purpose'] == 'certificate') {
    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////
    /////////            Certificate           //////////
    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////
    if (!$UID) {
        $response = array(
            'state' => 'notLogin',
            'message' => 'User must login to access this resource.'
        );
        echo json_encode($response);
        include 'close_connection.php';
        exit;
    }

    if (!isset($_POST['course_ID'])) {
        $response = array(
            'state' => 'error',
            'message' => 'Course ID is missing.'
        );
        echo json_encode($response);
        include 'close_connection.php';
        exit;
    }

    $course_ID = base64_decode($_POST['course_ID']);

    // Fetch course details
    $queryCourse = "SELECT u.Name AS Instructor_Name, c.Title, c.Cost FROM course c   
    JOIN user u ON c.user_ID = u.user_ID WHERE c.course_ID = ?";
    $stmtCourse = $trainmastas_conn->prepare($queryCourse);
    $stmtCourse->bind_param('s', $course_ID);
    $stmtCourse->execute();
    $resultCourse = $stmtCourse->get_result();

    if ($resultCourse->num_rows === 0) {
        $response = array(
            'state' => 'invalid',
            'message' => 'Invalid course ID.'
        );
        echo json_encode($response);
        include 'close_connection.php';
        exit;
    }

    $courseData = $resultCourse->fetch_assoc();
    $courseTitle = decodeHtml($courseData['Title']);
    $courseInstructorName = decodeHtml($courseData['Instructor_Name']);
    $courseCost = $courseData['Cost'];

    // Check if course cost is not zero
    if ($courseCost == 0.0) {
        $queryPayment = "SELECT * FROM `course_payment` WHERE `course_ID` = ? AND `user_ID` = ? AND `Purpose`='cer'";
        $stmtPayment = $trainmastas_conn->prepare($queryPayment);
        $stmtPayment->bind_param('ss', $course_ID, $UID);
        $stmtPayment->execute();
        $resultPayment = $stmtPayment->get_result();

        if ($resultPayment->num_rows === 0) {
            $response = array(
                'state' => 'error',
                'message' => 'You did not pay for this certificate. Contact the support team if you think it is an error.'
            );
            echo json_encode($response);
            include 'close_connection.php';
            exit;
        }
    }

    // Fetch registration details
    $queryRegistered = "SELECT `certificate_ID`, `certificate_Date`, `certificate_expired_Date` FROM `course_registered` WHERE `course_ID` = ? AND `user_ID` = ? AND `certificate_ID` IS NOT NULL";
    $stmtRegistered = $trainmastas_conn->prepare($queryRegistered);
    $stmtRegistered->bind_param('ss', $course_ID, $UID);
    $stmtRegistered->execute();
    $resultRegistered = $stmtRegistered->get_result();

    if ($resultRegistered->num_rows === 0) {
        $response = array(
            'state' => 'error',
            'message' => 'No certificate found for this user and course. Contact the support team if you think this is an error.'
        );
        echo json_encode($response);
        include 'close_connection.php';
        exit;
    }

    $registeredData = $resultRegistered->fetch_assoc();
    $certificateID = $registeredData['certificate_ID'];
    $certificateDate = $registeredData['certificate_Date'];
    $certificate_expired_Date = $registeredData['certificate_expired_Date'];

    // Fetch user details
    $queryUser = "SELECT `Name` FROM `user` WHERE `user_ID` = ?";
    $stmtUser = $trainmastas_conn->prepare($queryUser);
    $stmtUser->bind_param('s', $UID);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($resultUser->num_rows === 0) {
        $response = array(
            'state' => 'error',
            'message' => 'User not found.'
        );
        echo json_encode($response);
        include 'close_connection.php';
        exit;
    }

    $userData = $resultUser->fetch_assoc();
    $userName = $userData['Name'];

    // Success response courseInstructorName
    $response = array(
        'state' => 'success',
        'Detail' => array(
            'studentName' => $userName,
            'CourseTitle' => $courseTitle,
            'InstructorName' => $courseInstructorName,
            'CertificateDate' => $certificateDate,
            'certificate_expired_Date' => $certificate_expired_Date,
            'CertificateCode' => $certificateID
        )
    );

    echo json_encode($response);
} else {
    header('location: ../forbidden.php');
}
include 'close_connection.php';
