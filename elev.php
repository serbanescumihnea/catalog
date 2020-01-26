<?php
include_once "include/config.php";
session_name('cnec-secure');
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}else if(!isset($_SESSION["permLvl"]) ||!$_SESSION["permLvl"]==1){
    header("location: catalog?note");
}

$noteAdv = false;
$materii = array("Romana","Matematica","Fizica","Chimie","Biologie","Informatica","TIC","Franceza","Germana","Istorie","Geografie","Religie","Logica","Muzica","Desen");
$materie = '';
$clasa = '';
$nota = '';
$name = '';
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $x = urldecode($_SERVER['QUERY_STRING']);
    // Validate username
        // Prepare a select statement
        $sql1 = "SELECT class FROM users WHERE name = '{$x}'";
        $result = $dbi->query($sql1);
        echo $x;
        if ($result === false) {
            user_error("Query failed: " . $dbi->error . "<br />\n$sql1");
            return false;
        }
        if ($result->num_rows == 0) {

        } else {
            if ($result->num_rows ==1) {
                while ($row = $result->fetch_assoc()) {
                    $param_class = $row["class"];
        }
    }



    if(empty(trim($_POST["materie"]))){
        $materie_err = "Introduce-ti o materie.";
    }
    else{
        $param_materie = trim($_POST["materie"]);
    }
    if(empty(trim($_POST["nota"]))){
        $nota_err = "Introduce-ti o nota.";
    }else{
        $param_nota = trim($_POST["nota"]);
    }
    // Check input errors before inserting in database
    if(empty($name_err) && empty($materie_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO note (nume, materie, nota, clasa) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($dbi, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_materie, $param_nota, $param_class);

            // Set parameters
            $name = $param_name;
            $param_materie = $materie;

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
}}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="elev.css">
    <title>CNEC - Catalog</title>
</head>
<body>
<nav class="navbar navbar-dark bg-primary">
    <div class="container1" align="left">
        <a class="navbar-brand" href="#">
            <img src="resources/imgs/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Catalog
        </a>
    </div>
    <div class="nume_elev" align="center"><?php echo $_SESSION["name"]; ?></div>

</nav>
<nav id="nav2" class="navbar navbar-dark bg-primary">
    <div class="container2">

    </div>

</nav>
<div class="formaNote">
    <form class="px-4 py-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">

            <input type="" class="form-control" id="exampleDropdownFormEmail2" name="materie" placeholder="Materie">
        </div>
        <div class="form-group">
            <input type="" class="form-control" id="exampleDropdownFormPassword2" name="nota" placeholder="Nota">
        </div>
            <div class="wrapper">
            <button type="submit" class="btn btn-primary">Inregistreaza</button>
    </div>
    </form>
</div>


</body>