<?php
// Include config file
require_once "include/config.php";

// Define variables and initialize with empty values
$name = $class = "";
$name_err = $class_err = "";
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $name_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE name = ?";

        if($stmt = mysqli_prepare($dbi, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);

            // Set parameters
            $param_name = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $name_err = "This name is already taken.";
                } else{
                    $name = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }

        // Close statement

    }

    $password = randomPassword();
    if(empty(trim($_POST["class"]))){
        $class_err = "Please enter a password.";
    }
    else{
        $class = trim($_POST["class"]);
    }
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (name, password, class, clearText_pass) VALUES (?, ?, ?,?)";

        if($stmt = mysqli_prepare($dbi, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_password, $param_class, $password);

            // Set parameters
            $param_name = $name;
            $param_class = $class;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                //header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }


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
<div class="ce-header">
    <img src="resources/imgs/logo.png" class="ce-logo" style="margin-bottom:3em">
    <form class="user-interact" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <input type="username" placeholder="Nume" name='username' class="form-control">
        </div>
        <div class="form-group">
            <input type="class" placeholder="Clasa" name='class' class="form-control">
        </div>
        <button type="submit" class="btn btn-outline-light s-button">Trimite</button>
    </form>
</div>
<div class="filler" style="height:100%;color:rgb(10, 35, 55);"></div>
</body>

</html>
