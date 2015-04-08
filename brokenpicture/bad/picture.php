<!DOCTYPE html>
<html>
<head>
<link href="bootstrap-3.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="main.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="panel panel-default">
<div class="panel-body">
    <img alt="" src="getpic.php">
  </div>
</div>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#phraseModal" data-whatever="@mdo">Write phrase</button>


<div class="modal fade" id="phraseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id=modalbox>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Send to Next Player</h4>
      </div>
      <div class="modal-body">
            
            <div><div class="center-block">...</div>
<div>
<input type="text" class="center-block form-control input-lg" id=get_phrase placeholder="Enter your phrase here">
<br>
</div>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#messageModal">Done!</button>
    </div>
  </div>
</div>
  </div>
</div>
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <button type="button" class="btn btn-primary" onclick="sendphrase();" data-dismiss="modal">Send message</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src=draw.js></script>
<script type="text/javascript" src=ajax.js></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap-3.3.2/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    var x = screen.width;
    //alert(x);
function sendphrase() {
	var phraseval = $( "#get_phrase" ).val();
	var nextplayer = $("#inputEmail").val();
   $.post("http://cpuoftheheart.com/drawing/phraseupload.php",{ phrase: phraseval, player: nextplayer }).done(function( data ) {
	   report = document.getElementById("page");
	   //alert(data);
   });

}
</script>
</body>
</html>