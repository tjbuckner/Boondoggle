<?php
    session_start();
    if (!(isset($_SESSION['login']))) {
        header("Location: loginForm.php");
        exit();
    }

    $year = htmlspecialchars($_POST['year']);
    $class_num = htmlspecialchars($_POST['class_num']);
    $class_name = htmlspecialchars($_POST['class_name']);
    $instructor_name = $_POST['instructor_name'];
    $color = $_POST['color'];

    $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error(header("Location: dashboard.php"));
    $db = mysql_select_db('c2230a09proj',$conn) or trigger_error(header("Location: dashboard.php"));

    $query = "INSERT INTO class (year, class_num, class_name, instructor_name, user_id, color) VALUES ('$year', '$class_num', '$class_name', '$instructor_name', '" . $_SESSION['user_id'] . "', '$color')";
    $result = mysql_query($query);


    if (!$result) {
        die('Invalid query: ' . mysql_error());
        header("location: dashboard.php");
    }

    header("location: dashboard.php");

?>
