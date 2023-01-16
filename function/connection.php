<!-- PHP, it now stands for the recursive initialism PHP: Hypertext Preprocessor.PHP is a widely-used Open Source 
general-purpose scripting language that is especially suited for web development
and can be embedded into HTML.
PHP code is usually processed on a web server by a PHP interpreter implemented as a module, 
a daemon or as a Common Gateway Interface (CGI) executable. On a web server, 
the result of the interpreted and executed PHP code – which may be any type of data, 
such as generated HTML or binary image data – would form the whole or part of an HTTP response. 
connect to mysql database 
-->
<?php
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $dbname = "EVpro";
 $con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //echo "Connected successfully";
?>