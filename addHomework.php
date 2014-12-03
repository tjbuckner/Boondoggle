<?php
    session_start();
    if (!(isset($_SESSION['login']))) {
        header("Location: loginForm.php");
        exit();
    }

    $title = htmlspecialchars($_POST['title']);
    $due_date = htmlspecialchars($_POST['due_date']);
    $description = htmlspecialchars($_POST['description']);
    $class_id = htmlspecialchars($_POST['class_id']);
    $all_day = htmlspecialchars($_POST['all_day']);

    $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error(header("Location: dashboard.php"));
    $db = mysql_select_db('c2230a09proj',$conn) or trigger_error(header("Location: dashboard.php"));

    $query = "INSERT INTO assignments (title, due_date, user_id, description, class_id, all_day) VALUES ('$title', '$due_date', " . $_SESSION['user_id'] . ", '$description', '$class_id', '$all_day')";
    $result = mysql_query($query);


    if (!$result) {
        die('Invalid query: ' . mysql_error());
        header("location: dashboard.php");
    }

    header("location: dashboard.php");

?>
