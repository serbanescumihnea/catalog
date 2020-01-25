<?php
include_once "include/config.php";
session_name('cnec-secure');
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}
if(!isset($_SESSION["permLvl"]) ||!$_SESSION["permLvl"]>=1){
    header("location: catalog?note");
}
//$materii = array("Romana","Matematica","Fizica","Chimie","Biologie","Informatica","TIC","Franceza","Germana","Istorie","Geografie","Religie","Logica","Muzica","Desen")
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="profesor.css">
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
        <a class="idk" href="<?php
        if(isset($_GET['manage'])){
            echo"profesor?stats";
        }else if(isset($_GET['stats'])){
            echo"profesor?manage";
        }
        ?>">
            <?php
            if(isset($_GET['manage'])){
                echo"Statistici";
            }else if(isset($_GET['stats'])){
                echo"Managerial";
            }
            ?>
        </a>
    </div>
</nav>
<?php
if(isset($_GET['manage'])) {
    $claseListate = [];
    echo "<table><tr><th class='text-center'>Clasa</th></tr>";
    $sql = "SELECT class FROM users";
    $result = $dbi->query($sql);
//echo "<tr>";
    if ($result === false) {
        user_error("Query failed: " . $dbi->error . "<br />\n$sql");
        return false;
    }
    if ($result->num_rows == 0) {

    } else {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if(!in_array($row['class'],$claseListate)) {
                    echo "<tr><td class='text-center'><a class='xd' href='profesor?manage?{$row['class']}'>{$row['class']}</a></td></tr>";
                    array_push($claseListate, $row['class']);
                }
            }
        }
    }
}
?>
</table>

<?php

?>



</body>