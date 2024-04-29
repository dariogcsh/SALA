<?php session_start();
    if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])){
    
    } elseif (!isset($_SESSION["CodiEmpl"]) AND isset($_SESSION["CodiClie"])) {
     
      } else {
        header("Location: index.php");
      }

     ?>

<!doctype html>
<html>
<head>
    <title>Tutoriales</title> 
    <link rel="stylesheet" type="text/css" href="style.css">
   
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"><!-- iconos -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/i18n/defaults-*.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
  <div class="container-fluid" style="padding-top: 100px;">
 
      <?php include("barramenu.php"); ?>
    <div class="row">
    	<div class="col-xs-0 col-sm-0 col-md-1"></div>
	  	<div class="col-xs-12 col-sm-12 col-md-4">
      <div class="embed-responsive embed-responsive-16by9">
	  		<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/UkcnlMA6AbA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
	  		<h4 style="text-align: center; ">My Operation 1</h4>
	  		<br>
	  	</div>

	  	<div class="col-xs-0 col-sm-0 col-md-2"></div>
	  	<div class="col-xs-12 col-sm-12 col-md-4">
      <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/U0FEFkBpV3U" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
        <h4 style="text-align: center; ">My Operation 2</h4>
        <br>
      </div>
	  	<div class="col-xs-0 col-sm-0 col-md-1"></div>
  	</div>

    <div class="row">
      <div class="col-xs-0 col-sm-0 col-md-1"></div>
      <div class="col-xs-12 col-sm-12 col-md-4">
      <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Qwxzz4o6hRo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
        <h4 style="text-align: center; ">My Maintenance</h4>
        <br>
      </div>

      <div class="col-xs-0 col-sm-0 col-md-2"></div>
      <div class="col-xs-12 col-sm-12 col-md-4">

      </div>
      <div class="col-xs-0 col-sm-0 col-md-1"></div>
    </div>
  </div>
</body>
</html>