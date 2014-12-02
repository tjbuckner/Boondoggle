<?php
    session_start();
    if (!(isset($_SESSION['login']))) {
        header("Location: loginForm.php");
        exit();
    }

    echo $_POST['class_id'];

    $class_id = $_POST['class_id'];

    $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error(header("Location: dashboard.php"));
    $db = mysql_select_db('c2230a09proj',$conn) or trigger_error(header("Location: dashboard.php"));

    $query = "DELETE FROM class WHERE class_id = '$class_id'";
    $result = mysql_query($query);


    if (!$result) {
        die('Invalid query: ' . mysql_error());
        header("location: dashboard.php");
    }

    header("location: dashboard.php");

?>
