

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
    $filename = './data/userResult3.csv';
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