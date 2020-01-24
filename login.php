<?php
include_once "include/functions.php";
include_once "include/config.php";
//$cookieParams = session_get_cookie_params();
//session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], ".code-end.ro", $cookieParams["secure"]=true, $cookieParams["httponly"]=true);
session_name('cnec-secure');
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.php");
    exit;
}
require_once "include/config.php";
$name = $password = "";
$name_err = $password_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $name_err = "Please enter username.";
    } else{
        $name = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($name_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT name, password FROM users WHERE name = ?";

        if($stmt = mysqli_prepare($dbi,$sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);

            // Set parameters
            $param_name = $name;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $name, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password,$hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["name"] = $name;
                            // Redirect user to welcome page
                            header("location: catalog");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                            echo $password_err;
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $name_err = "No account found with that username.";
                    echo $name_err;
                }
            } else{
                echo "";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($dbi);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
    <title>CodeEnd - Login</title>
</head>

<body>
<div class="hm-header">
    <img src="resources/imgs/logo.png" class="hm-logo" style="margin-bottom:3em">
    <h2 class="title1">Catalog CNEC</h2><br>
    <form class="user-interact" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <input type="username" placeholder="Nume" name='username' class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Parola" name='password' class="form-control">
        </div>
        <button type="submit" class="btn btn-outline-light s-button">Trimite</button>
    </form>
</div>
<div class="filler" style="height:100%;color:rgb(10, 35, 55);"></div>
</body>

</html>