<!-- PHP, it now stands for the recursive initialism PHP: Hypertext Preprocessor.PHP is a widely-used Open Source 
general-purpose scripting language that is especially suited for web development
and can be embedded into HTML.
PHP code is usually processed on a web server by a PHP interpreter implemented as a module, 
a daemon or as a Common Gateway Interface (CGI) executable. On a web server, 
the result of the interpreted and executed PHP code – which may be any type of data, 
such as generated HTML or binary image data – would form the whole or part of an HTTP response. 
-->

<?php

include("./function/connection.php"); // connect to mysql database 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  //something was posted
  $email = $_POST['email']; //verify variable email   = posted ['email'];
  $password = $_POST['password']; //verify variable password   = posted ['password '];
  if (!empty($email) && !empty($password) && !is_numeric($email)) {
    //verify if $email,$password is empty and if  $email is not numeric
    $query = "select * from register where email = '$email' limit 1";  //variable query if the inputted email is on the table register
    $result = mysqli_query($con, $query); //run query if the inputted email is on the table register
    
    // if the queried result is null，  echo "User not found"; if the queried result is non-null and input password is the same as password on "regester" table, login to the system
    if ($result == null || mysqli_num_rows($result) == 0) {
      echo "User not found";
    } else if ($result && mysqli_num_rows($result) == 1) {
      $user_data = mysqli_fetch_assoc($result); 

      if ($user_data['password'] === $password) {
        session_start(); // store the session 
        $_SESSION['user'] = $email; //assign $_SESSION['user'] is email
        setcookie('sid', session_id(), time() + 99 * 365 * 24 * 60 * 60);  //setcookie time         
        header("Location: reseUser.php"); //header to reseUser.php 
        die;
      } else {
        echo "Wrong name or password!";
      }
    } else if (mysqli_num_rows($result) > 1) {
      echo "Erro";
    }
  } else {
    echo "All the field are required";
  }
} else {
  echo "Erro!";
}
?>