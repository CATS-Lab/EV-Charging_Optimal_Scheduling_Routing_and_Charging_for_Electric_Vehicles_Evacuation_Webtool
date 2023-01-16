<!--This document is for the login user to make the route reservation. 
The page include index.html, reserveResult.php,and reservation.html.This is for the navigator manue. 
 -->

<!--verify if the user logged into the system  -->
<?php
if (!isset($_COOKIE["sid"])) {
  die("please login");
}
session_id($_COOKIE["sid"]);
session_start();
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <!-- include all the documents that is needed -->
  <meta charset="utf-8">
  <title>EV Station</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- link to font-awesome.min.css -->
  <link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all"> <!-- link to layout.css-->
  <meta charset="utf-8" <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="#" />

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" /><!-- link to leaflet.css-->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script><!-- link to leaflet.js-->
  <link rel="stylesheet" href="./css/style.css"><!-- link to style.css-->
  <link rel="stylesheet" href="./css/styleI.css"><!-- link to styleI.css-->
</head>

<body>
  <div style="background-color:#00324d" ;>
    <div class="headerbar" style="width: 55%">
      <img src="img/brandname1.JPG" width="240" height="60" class="logo fltlft">
    </div>
  </div>
  <div class="topnav">
    <!--  hrefs link the navigation manue to the document -->

    <!--  link 'Log out' on navigation manue to the index.html document -->
    <a href="index.html" style="float:right"><i class="fa fa-sign-out">&nbsp; Log out</i></a>

    <!--   link  'Reservation resultsthe' on navigation manue to the reserveResult.php document -->
    <a href="reserveResult.php" style="float:right"><i class="fa fa-car">&nbsp; Reservation results</i></a>

    <!--   link 'Make a reservation' on navigation manue to the "reservation.html" document -->
    <a href="reservation.html" style="float:right"><i class="fa fa-user-plus">&nbsp; Make a reservation</i></a>

    <!--   link 'HOME' on navigation manue to the "index.html" document -->
    <a href="index.html" style="float:right"><i class="fa fa-home">&nbsp; HOME</i></a>

  </div>


  <div class="colu2" id="rightbar2">
    <div id="map"></div>
  </div>
  </div>
  <script src="js\map.js"></script> <!--  src link to the Ev staions maps -->

</body>

</html>