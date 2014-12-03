<?php
    //start session
    session_start();

    //if the user isn't logged on...
    if (!(isset($_SESSION['login']))) {
        //redirect to login
        header("Location: loginForm.php");
        //and exit the file.
        exit();
    }

    //create an array to hold the json that's created from the database.
    $json = array();

    //db connection
    $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error("SQL", E_USER_ERROR);
    $db = mysql_select_db('c2230a09proj',$conn) or trigger_error("SQL", E_USER_ERROR);

    //SQL query to grab all the attributes of each assignment that belongs to the logged in user
    $query = "select assignment_id, title, due_date, description, all_day, completed, assignments.class_id,
        instructor_name, year, class_name, class_num, color from assignments JOIN class ON
        assignments.class_id = class.class_id OR assignments.class_id is null WHERE assignments.user_id = " . $_SESSION['user_id'] . " ORDER BY assignment_id";
    $result = mysql_query($query);

    //loop through the results
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

        //assign id.
        $row_array['id'] = $row['assignment_id'];
        //assign title.
        $row_array['title'] = htmlspecialchars_decode($row['title']);
        //assign start time.
        $row_array['start'] = $row['due_date'];
        //assign description.
        $row_array['description'] = htmlspecialchars_decode($row['description']);
        //assign class id.
        $class_id = $row['class_id'];
        //assign instructor name.
        $row_array['instructor_name'] = htmlspecialchars_decode($row['instructor_name']);
        //assign year.
        $row_array['class_year'] = htmlspecialchars_decode($row['year']);
        //assign class name.
        $row_array['class_name'] = htmlspecialchars_decode($row['class_name']);
        //assign class number.
        $row_array['class_num'] = htmlspecialchars_decode($row['class_num']);
        //assign class color.
        $row_array['color'] = $row['color'];

        //if all_day is 0 (from the db)...
        if($row['all_day'] == 0){
            //then allDay is false
            $row_array['allDay'] = false;
        }
        //else if it's 1 (from the db)...
        else if ($row['all_day'] == 1){
            //then allDay is true.
            $row_array['allDay'] = true;
        }

        //push created array onto $json
        array_push($json,$row_array);
    }

    //print the encoded $json for fullCalendar to use.
    echo json_encode($json);

?>
