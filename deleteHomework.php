<?php

session_start();
    if (!(isset($_SESSION['login']))) {
        header("Location: loginForm.php");
        exit();
    }

$ID = htmlspecialchars($_POST["event_id"]);

//open database connection
$conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error("SQL", E_USER_ERROR);
$db = mysql_select_db('c2230a09proj',$conn) or trigger_error("SQL", E_USER_ERROR);

$query = "DELETE FROM assignments WHERE assignment_id = $ID limit 1";
$result = mysql_query($query) or trigger_error("SQL", E_USER_ERROR);

header("location: dashboard.php");
?>
