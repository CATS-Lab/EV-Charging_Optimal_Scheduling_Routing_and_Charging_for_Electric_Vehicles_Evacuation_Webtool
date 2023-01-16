<?php
// if the user login to the system, begin the session,or else the user can not see the reservation.php.
if (!isset($_COOKIE["sid"])) {
  die("please login");
}
session_id($_COOKIE["sid"]);
session_start();

// connect to the mysql database
include("./function/connection.php");
include("./function/random_num.php");

//if submit the reservation, define variales.
 
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
  //something was posted
  $email = $_SESSION['user'];
  $origin = $_POST['origin'];
  $destination = $_POST['destination'];
  $electric_level = $_POST['electric_level'];
  $departure_date = $_POST['departure_date'];
  $departure_time = $_POST['departure_time'];
  
//Then check the if all required field is set.
//if all the required field is set, and check the MYSQL connection. If the connection is error, reminder Could not connect to the database.
//if connect to tha mysql database, check if the user has reservation.
  if (isset($origin) && isset($destination) && isset($electric_level) && isset($departure_date) && isset($departure_time)) {
    if ($con->connect_error) {
      die('Could not connect to the database.');
    } else {


      $Select = "SELECT email FROM reserve_demands 
      WHERE email='$email' LIMIT 1";
      $reserId = random_num(16);
      $Insert = "INSERT INTO reserve_demands (reserId,email,origin,destination,electric_level,departure_date,departure_time) values (?,?,?,?,?,?,?)";

      $result = mysqli_query($con, $Select);
//If the user does not have reservation, makes a new reservation and echo some reminder.
//If the user have reservation, check if the evacution route has optimized or exist in the database.
// If the evacution route has optimized, echo "has an existing reservation. You can check your reservation results."
/* If the evacution route has not optimized, echo "has an existing reservation. Your evacuation route is optimizing.
      Please check your evacuation route." */
      if ($result == null || mysqli_num_rows($result) == 0) {

        //$reserId = random_num(16);
        $stmt = $con->prepare($Insert);
        $stmt->bind_param("ssssdss", $reserId, $email, $origin, $destination, $electric_level, $departure_date, $departure_time);
        if ($stmt->execute()) {
          echo ('Successfully make a new reservation.<br/>Your evacuation route is optimizing. <br/> Please check back later.');

          header("refresh:6;url=./reseUser.php");
          print('<br/>Loading to homepage......');
          die;
          $stmt->close();
          $con->close();
        } else {
          echo $stmt->error;
          $stmt->close();
          $con->close();
        }
      } else {

        $tablename = $email;
        $SelectFile = "SHOW TABLES LIKE '$tablename'";
        $resultFile = mysqli_query($con, $SelectFile);
        if ($resultFile == null || mysqli_num_rows($resultFile) == 0) {


          echo $email, " has an existing reservation. 
           <br> Your evacuation route is optimizing.
           <br> Please check your evacuation route.";
          header("refresh:5;url=./reseUser.php");
          die;
        } else {

          echo $email, ", has an existing reservation. <br>You can check your reservation results. <br>";
          header("refresh:5;url=./reseUser.php");
        }
      }
    }
  } else {
    echo "All fields are required.";
    die();
  }
} else {
  echo "Submit button is not set";
}
