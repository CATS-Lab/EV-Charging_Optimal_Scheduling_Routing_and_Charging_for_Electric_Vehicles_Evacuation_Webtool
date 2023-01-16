<?php
session_start();
include("./function/connection.php");
include("./function/random_num.php");
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
  //if the required fields were posted and the registration was submit, check if the user is registered.
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  //check if the required field is set.
  if (isset($fullname) && isset($email) &&  isset($_POST['password']) && !is_numeric($fullname)) {
    if ($con->connect_error) {
      die('Could not connect to the database.');
    } else {
      //save the user to database
      $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
      $user_id = random_num(20);
      $Insert = "INSERT INTO register (user_id,fullname,email,password) values (?,?,?,?)";
      // prepare inserting the user to the database.
      $stmt = $con->prepare($Select); 
      $stmt->bind_param("s", $email);
      $stmt->execute();      
      $stmt->bind_result($email);
      $stmt->store_result();
      $stmt->fetch();
      $rnum = $stmt->num_rows;
      //check if the email has registed. If the email was not registed, stored in the database and jump to login page.
      if ($rnum == 0) {
        $stmt->close();
        $stmt = $con->prepare($Insert);
        $stmt->bind_param("ssss", $user_id, $fullname, $email, $password);
        if ($stmt->execute()) {
          echo "Sucessfully registered.<br>";
          //jump to login.html after 3 second
          header("refresh:3;url=./login.html");
          print('Loading to login......');
          
        } else {
          echo $stmt->error;
        }
      } else {
        // If the email was registed, echo 'Email has already been registered', and jump to login page.
        echo 'Email has already been registered.<br>';       
        header("refresh:3;url=./login.html");
        //3 sec later ,jump to ./login.html
        print('Loading to login......');
      }
      $stmt->close();
      $con->close();

     
    }
  } else {
    echo "All field are required.";
    die();
  }
} else {
  echo "Submit button is not set";
}
