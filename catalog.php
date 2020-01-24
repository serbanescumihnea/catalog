<?php
include_once "include/config.php";
session_name('cnec-secure');
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$materii = array("Romana","Matematica","Fizica","Chimie","Biologie","Informatica","TIC","Franceza","Germana","Istorie","Geografie","Religie","Logica","Muzica","Desen")
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="catalog.css">
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
<table>
    <tr>
        <th>Materie</th>
        <th>Note</th>
        <th>Medie</th>
    </tr>
    <?php
    for($i = 0; $i<=count($materii)-1;$i++){
        $sum = 0;
        $count = 0;
        echo "<tr>
        <td>{$materii[$i]}</td>
        ";
        $sql = "SELECT nume, materie, nota FROM note WHERE nume='{$_SESSION["name"]}' AND materie='{$materii[$i]}'";
        $result = $dbi->query($sql);
        echo "<td>";
        if($result === false)
        {
            user_error("Query failed: ".$dbi->error."<br />\n$sql");
            return false;
        }
        if($result->num_rows == 0)
        {
            echo "-";
        }
        else {
            if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "{$row["nota"]},";
                $sum = $sum + $row["nota"];
                $count = $count+1;
            }
        }else{

            }
        }

        if($sum!=0){
        $medie = $sum/$count;
        }else{
            $medie=0;
        }

        echo "</td>";
        if($medie>0) {
            echo "<td>{$medie}</td>";
        }else{
            echo"<td>-</td>";
        }
    }
    ?>
    </tr
</table>

</body>