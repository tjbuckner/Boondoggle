<?php
    session_start();
    if (!(isset($_SESSION['login']))) {
        header("Location: loginForm.php");
        exit();
    }

    $year = $_POST['year'];
    $class_num = $_POST['class_num'];
    $class_name = $_POST['class_name'];
    $instructor_name = $_POST['instructor_name'];
    $color = $_POST['color'];
    $class_id = $_POST['class_id'];

    $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error(header("Location: dashboard.php"));
    $db = mysql_select_db('c2230a09proj',$conn) or trigger_error(header("Location: dashboard.php"));

    $query = "UPDATE class SET year = '$year', class_num = '$class_num', class_name = '$class_name', instructor_name = '$instructor_name', color = '$color' WHERE class_id = '$class_id'";
    $result = mysql_query($query);


    if (!$result) {
        die('Invalid query: ' . mysql_error());
        header("location: dashboard.php");
    }

    header("location: dashboard.php");

?>
