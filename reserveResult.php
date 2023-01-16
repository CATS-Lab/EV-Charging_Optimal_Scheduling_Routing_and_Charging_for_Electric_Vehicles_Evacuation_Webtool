 <!-- if the user login to the system, begin the session,or else the user can not see the reserResult.php. -->
 <?php
  if (!isset($_COOKIE["sid"])) {
    die("Please login");
  };
  session_id($_COOKIE["sid"]);
  session_start();
  ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">

 <head>
   <meta charset="utf-8">
   <title>Login Form</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="./css/styleLogin.css">
 </head>

 <body bgcolor="#a7c7ab">
   <div id="id03" class="tabcontent">
     <span onclick="parent.location='reseUser.php'" class="close" title="Close Modal">&times</span>
     <form class="modal-content animate" method="POST">
       <div class="section-center">
         <div class="container">
           <div class="row">
             <div class="login-form" style="padding:50px " ;>
               <div class="form-header">
                 <h1>Reservation Results</h1>
                 <hr>
               </div>

               <!-- connect to mysql database, if the connection failed, echo 'Could not connect to the database.' 
              if the connection succeeded, check if the user has a reservation. 
              if the user don't have a reservation, please make a reservation and jumb back to make a reservation page. 
              if the user has a reservation, and then check if the evacuation route is optimized.
              if the evacuation route optimized, jump to show the route.
              if the evacuation route is not optimized, echo 'Your evacuation route is still optimizing.
                    Please check back later.'   
              -->
               <?php
                include("./function/connection.php");
                $email = $_SESSION['user'];
                if ($con->connect_error) {
                  die('Could not connect to the database.');
                } else {
                  $Select = "SELECT * FROM reserve_demands WHERE email='$email' LIMIT 1";
                  $result = mysqli_query($con, $Select);
                  if ($result == null || mysqli_num_rows($result) == 0) {
                    echo 'No reservation results. Please make a reservation.<br>';
                    header("refresh:6;url=./reseUser.php");
                    echo "Loading to the reservation page ......";

                    die;
                  } else {
                    $user_data = mysqli_fetch_assoc($result);
                    $reserId = $user_data['reserId'];
                    $tablename = $email;
                    $SelectFile = "SHOW TABLES LIKE '$tablename'";
                    $resultFile = mysqli_query($con, $SelectFile);
                    if ($resultFile == null || mysqli_num_rows($resultFile) == 0) {
                      echo $email, "'s reservation # is $reserId. 
                    <br/>Your evacuation route is still optimizing.
                    <br/> Please check back later.";
                      header("refresh:6;url=./reseUser.php");
                      //header("Location: ./routing-machine/leaflet-routing-machine/examples/route.html");
                      die;
                    } else {
                      $Select2 = "SELECT * FROM `$tablename`";
                      $result = mysqli_query($con, $Select2);
                      $filename = './routing-machine/leaflet-routing-machine/examples/userResult1.csv';
                      //$user_data = mysqli_fetch_assoc($result);
                      $file = fopen($filename, "w");
                      //$rowNum=mysqli_num_rows($result);
                      if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                          fputcsv($file, $row);
                        }
                        fclose($file);

                        echo $email, ", Your reservation # is $reserId. <br>";
                        header("refresh:6;url=./routing-machine/leaflet-routing-machine/examples/route.html");
                        //header("Location: ./routing-machine/leaflet-routing-machine/examples/route.html");
                        echo "Loading reservation results......";
                      } else {
                        die('route result is empty.');
                      }
                    }
                  }
                }
                ?>


             </div>
           </div>
           <script>
             var modal = document.getElementById('id03');
             window.onclick = function(event) {
               if (event.target == modal) {
                 modal.style.display = "";
               }
             }
           </script>
         </div>
       </div>
     </form>
   </div>
 </body>

 </html>