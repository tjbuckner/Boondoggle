<?php

session_start();
    if (!(isset($_SESSION['login']))) {
        header("Location: loginForm.php");
        exit();
    }

    $id = htmlspecialchars($_POST["event_id"]);
    $title = htmlspecialchars($_POST["title"]);
    $description = htmlspecialchars($_POST["description"]);
    $class_id = htmlspecialchars($_POST['class_id']);
    $all_day = htmlspecialchars($_POST['all_day']);
    $due_date = htmlspecialchars($_POST['due_date']);

    //open database connection
    $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error("SQL", E_USER_ERROR);
    $db = mysql_select_db('c2230a09proj',$conn) or trigger_error("SQL", E_USER_ERROR);

    $query = "UPDATE assignments SET due_date = '$due_date', title = '$title', description = '$description', class_id = '$class_id', all_day = '$all_day' WHERE assignment_id = '$id'";
    $result = mysql_query($query) or trigger_error("SQL", E_USER_ERROR);

    header("location: dashboard.php");
?>
