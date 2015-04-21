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
    <link href="main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body onload="scroll();">
<?php include_once("code/analyticstracking.php") ?>
    <?php require_once 'ui/navbar.php'; ?>

    <div class="container">

      <div class="starter-template">
        <h1>Start a new game!</h1>
        <p class="lead">Enter a sentence below, then send it to a friend.<br> They get to draw their interpretation of what you said and pass it on.</p>
      </div>
      <div>
         <input type="text" class="center-block form-control input-lg" id=get_phrase placeholder="Enter your phrase here">
      <br>
         <button id="send" type="button" class="btn btn-primary center-block" data-toggle="modal" data-target="#exampleModal" >Send to next player</button>
      </div>
    </div><!-- /.container -->


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id=modalbox>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Send to Next Player</h4>
      </div>
      <div class="modal-body">
 <div class="form-group">
    <label for="inputEmail">Email</label>
    <input type="text" class="form-control" id="inputEmail" placeholder="Jane.Doe@example.com">
  </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="sendstart();" data-dismiss="modal">Send message</button>
      </div>
    </div>
  </div>
</div>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/typeahead.bundle.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="js/draw.js"></script>
    <script src="js/account.js"></script>
  </body>
</html>
