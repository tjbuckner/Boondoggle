<?php
    session_start();
    if (!(isset($_SESSION['login']))) {
        header("Location: loginForm.php");
        exit();
    }

        $json = array();

        $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error("SQL", E_USER_ERROR);
        $db = mysql_select_db('c2230a09proj',$conn) or trigger_error("SQL", E_USER_ERROR);


        $query = "select assignment_id, title, due_date, description, all_day, completed, assignments.class_id,
            instructor_name, year, class_name, class_num, color from assignments JOIN class ON
            assignments.class_id = class.class_id OR assignments.class_id is null WHERE assignments.user_id = " . $_SESSION['user_id'] . " ORDER BY assignment_id";
        $result = mysql_query($query);

        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

            $row_array['id'] = $row['assignment_id'];
            $row_array['title'] = $row['title'];
            $row_array['start'] = $row['due_date'];
            $row_array['description'] = $row['description'];


            $class_id = $row['class_id'];

            if(is_null($class_id)){
                $row_array['class_id'] = "0";
            }
            else {
                $row_array['class_id'] = $class_id;
            }

            $row_array['instructor_name'] = $row['instructor_name'];
            $row_array['class_year'] = $row['year'];
            $row_array['class_name'] = $row['class_name'];
            $row_array['class_num'] = $row['class_num'];
            $row_array['color'] = $row['color'];

            if($row['all_day'] == 0){
                $row_array['allDay'] = false;
            }
            else if ($row['all_day'] == 1){
                $row_array['allDay'] = true;
            }

            array_push($json,$row_array);
        }

        echo json_encode($json);

?>
