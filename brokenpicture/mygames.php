<?php

function __autoload($class_name) {
    include './classes/' .$class_name . '.php';
}

$greeting = '';
$user = user::check_login();

if ($user instanceof user) {
    //session_start();
    $greeting = "Welcome, <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">" . $user->getEmail() . "</a>";
} else {
    $greeting = "<a href=\"login.php\">Log In</a> / <a href=\"signup.php\">Sign Up</a>";
    require_once 'notloggedin.php';
    exit;
}
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
   <!--   <link rel="icon" href="../../favicon.ico">  -->

    <title>Broken Picture</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/play.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body onload="">
    <?php include_once("code/analyticstracking.php") ?>
    <?php require_once 'ui/navbar.php'; ?>
    
    <div class="panel panel-primary" id="gamelist">
  <div class="panel-heading">
    <h3 class="panel-title">Active Games</h3>
  </div>
  <div class="panel-body">
    <?php include_once 'code/getmygames.php';?>
  </div>
</div>
    
      <div class="panel panel-primary" id="gamedescription">
  <div class="panel-heading">
    <h3 class="panel-title">Game Info</h3>
  </div>
  <div class="panel-body" id="gamedescriptioncontent">
    
  </div>
</div>

    <div class="panel panel-primary" id="gamelist">
  <div class="panel-heading">
    <h3 class="panel-title">Finished Games</h3>
  </div>
  <div class="panel-body">
    <?php include_once 'code/getmyfinishedgames.php';?>
  </div>
</div>
   
        <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="js/draw.js"></script>
    <script src="js/account.js"></script>
  </body>
</html>
