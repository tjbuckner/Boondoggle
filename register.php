<?php
    session_start();

    if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['userName']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])){

        if($_POST['password'] != $_POST['confirmPassword']){
            header("Location: loginForm.php");
        }

        $firstName = htmlspecialchars($_POST["firstName"]);
        $lastName = htmlspecialchars($_POST["lastName"]);
        $username = htmlspecialchars($_POST["userName"]);
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);

        //open database connection
        $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error("SQL", E_USER_ERROR);
        $db = mysql_select_db('c2230a09proj',$conn) or trigger_error("SQL", E_USER_ERROR);

        $query = "SELECT userName FROM users WHERE userName = '$username' OR email = '$email'";
        $result = mysql_query($query) or trigger_error("SQL", E_USER_ERROR);

        $num_rows = mysql_num_rows($result);

        if($num_rows == 0) {
            $password = md5($password);
            $registerQuery = "INSERT INTO users (firstName, lastName, userName, email, pass)
    values ('$firstName', '$lastName', '$username', '$email', '$password')";
            mysql_query($registerQuery);

            $user_idQuery = "SELECT id, firstTime FROM users WHERE userName = '$username'";
            $user_idResult = mysql_query($user_idQuery);
            $row = mysql_fetch_row($user_idResult);

            $_SESSION['login'] = true;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $row[0];
            $_SESSION['firstTime'] = $row[1];
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
