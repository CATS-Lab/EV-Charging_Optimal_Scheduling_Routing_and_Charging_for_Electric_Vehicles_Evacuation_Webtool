<?php
if (!isset($_COOKIE["sid"])) {
    die("Please login");
};
session_id($_COOKIE["sid"]);
session_start();
include("../../../function/connection.php");
$email = $_SESSION['user'];
if ($con->connect_error) {
    die('Could not connect to the database.');
} else {
    $delimiter = ",";
    $tablename = $email;
    $Select = "SELECT * FROM `$tablename`";
    //$Select = "SELECT * FROM reserve_demands WHERE email='$email' LIMIT 1";
    $result = mysqli_query($con, $Select);
    $filename = './data/userResult7.csv';
    //$user_data = mysqli_fetch_assoc($result);
    $file = fopen($filename, "w");
    $rowNum=mysqli_num_rows($result);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { 
            //printf ("%s (%s)\n", $row["id1"], $row["arrival_time"]) ;         
            //$lineData = array($row['id1'], $row['arrival_time'], $row['arrival_node'], $row['arrival_node_name'], $row['arrival_energy'], $row['arrival_node_lat'], $row['arrival_node_lon']);
            //printf("ID: %s  Name: %s", $row[0], $row[1]);
            //printf ("%s (%s)\n", $lineData[0], $lineData[1]) ;
           fputcsv($file, $row);
        }
    } else {
        die('result is empty.');
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Leaflet OSRM Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <link rel="stylesheet" href="../dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="../../../css/style.css">
    <link rel="stylesheet" href="../../../css/styleI.css">
    <link rel="stylesheet" href="rouIndex.css" />

</head>

<body>
    <div>
        <div style="background-color:#00324d" ;>
            <div class="headerbar" style="width: 55%">
                <img src="../../../img/brandname1.JPG" width="240" height="60" class="logo fltlft">
            </div>
        </div>
        <div class="topnav">
            <a href="../../../logout.php" style="float:right"><i class="fa fa-sign-in">&nbsp; LOG OUT</i></a>
            <!-- <a href="../../../reseUser.php" style="float:right"><i class="fa fa-home">&nbsp; Make Reservation</i></a> -->
            <a href="../../../index.html" style="float:right"><i class="fa fa-home">&nbsp; HOME</i></a>
        </div>
        <div class="colu2" id="rightbar2">
            <div id="map"></div>
        </div>

    </div>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
    <script src="../dist/leaflet-routing-machine.js"></script>
    <script src="Control.Geocoder.js"></script>
    <script src="config.js"></script>
    <script src="route.js"></script>

</body>

</html>