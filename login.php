<?php
    session_start();

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);

        //open database connection
        $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error("SQL", E_USER_ERROR);
        $db = mysql_select_db('c2230a09proj',$conn) or trigger_error("SQL", E_USER_ERROR);

        $password = md5($password);
        $query = "SELECT firstName, lastName, userName, email, id, firstTime FROM users WHERE userName = '$username' AND pass = '$password'";
        $result = mysql_query($query) or trigger_error("SQL", E_USER_ERROR);

        $num_rows = mysql_num_rows($result);

        if($num_rows == 1){
            $row = mysql_fetch_row($result);

            $_SESSION['login'] = true;
            $_SESSION['firstName'] = $row[0];
            $_SESSION['lastName'] = $row[1];
            $_SESSION['username'] = $row[2];
            $_SESSION['email'] = $row[3];
            $_SESSION['user_id'] = $row[4];
            $_SESSION['firstTime'] = $row[5];

            if ($_SESSION['firstTime'] == 1){
                $user_id = $_SESSION['user_id'];

                $query = "UPDATE users SET firstTime = '0' WHERE id = '$user_id'";
                $result = mysql_query($query) or trigger_error("SQL", E_USER_ERROR);

            }
            header("Location: dashboard.php");
        }
        else {
            header("Location: loginForm.php");
        }

    }
    else {
        header("Location: loginForm.php");
    }



    ?>
