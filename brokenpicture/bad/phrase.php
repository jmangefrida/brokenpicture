<!DOCTYPE html>
<html>
<head>
<link href="bootstrap-3.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="main.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body onload="startup()">
<div id="content">
<div class="panel panel-default">
  <div id="panel" class="panel-body">
    <?php echo $result['phrase'];?>
  </div>
</div>

<button id= "btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Draw reply</button>

</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id=modalbox>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div id="mbody" class="modal-body">
        <div class=panes>
<canvas id="canvas" width="800" height="450" style="border:solid black 1px;" onmousedown="startDraw(event)" onmousemove="doDraw(event)" onmouseup="stopDraw()" onmouseout="stopDraw()">
  Your browser does not support canvas element.
</canvas>
</div>
<div id="colors" class="panes">
<div class=colors id=red onclick="red();"></div>
<div class=colors id=blue onclick="blue();"></div>
<div class=colors id=green onclick="green();"></div>
<div class=colors id=yellow onclick="yellow();"></div>
<div class=colors id=black onclick="black();"></div>
<div class=colors id=white onclick="white();"></div>
<button id="mbtn" style="visibility: hidden;" data-toggle="modal" data-target="#messageModal">OK</button>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#messageModal">Done!</button>
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
        <button type="button" class="btn btn-primary" onclick="testing();" data-dismiss="modal">Send message</button>
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

var c;

function startup() {
	if (screen.width < 900) {
		  document.getElementById("btn").setAttribute("data-target", "");
		  document.getElementById("btn").setAttribute("onclick", "Fill();");
	  }
	  var el = document.getElementsByTagName("canvas")[0];
	  c=document.getElementById("canvas");
	  el.addEventListener("touchstart", handleStart, false);
	  el.addEventListener("touchend", handleEnd, false);
	  el.addEventListener("touchcancel", handleCancel, false);
	  el.addEventListener("touchleave", handleEnd, false);
	  el.addEventListener("touchmove", handleMove, false);
	  //log("initialized.");
	  //alert("active");

	  
	}
	
var ongoingTouches = new Array();
function Fill() {
	document.getElementById("content").innerHTML = document.getElementById("mbody").innerHTML;
	document.getElementById("mbody").innerHTML = "";
	c=document.getElementById("canvas");
	c.width = 550;
	  c.height = 320;
	document.getElementById("mbtn").style.visibility = "visible";
	//document.getElementById("btn").setAttribute("data-target", "#messageModal");
	//document.getElementById("btn").setAttribute("onclick", ""childNodes[0].nodeValue);
	var el = document.getElementsByTagName("canvas")[0];
	  
	  el.addEventListener("touchstart", handleStart, false);
	  el.addEventListener("touchend", handleEnd, false);
	  el.addEventListener("touchcancel", handleCancel, false);
	  el.addEventListener("touchleave", handleEnd, false);
	  el.addEventListener("touchmove", handleMove, false);
	  
}
function handleStart(evt) {
	  evt.preventDefault();
	  //log("touchstart.");
	  var el = document.getElementsByTagName("canvas")[0];
	  var ctx = el.getContext("2d");
	  var touches = evt.changedTouches;
	        
	  for (var i=0; i < touches.length; i++) {
	    //log("touchstart:"+i+"...");
	    ongoingTouches.push(copyTouch(touches[i]));
	    //var color = colorForTouch(touches[i]);
	    //coords = canvas.relMouseCoords(event);
	    ctx.beginPath();
	    ctx.arc(touches[i].pageX - $("#canvas").offset().left , touches[i].pageY - $("#canvas").offset().top,2, 0,2*Math.PI, false);  // a circle at the start
	    ctx.fillStyle = color;
	    ctx.fill();
	    //log("touchstart:"+i+".");
	  }
	}
	
function handleMove(evt) {
	  evt.preventDefault();
	  var el = document.getElementsByTagName("canvas")[0];
	  
	  var ctx = el.getContext("2d");
	  var touches = evt.changedTouches;
	  //coords = canvas.relMouseCoords(event);
	  y = touches[0].pageY - $("#canvas").offset().top;
	  x = touches[0].pageX - $("#canvas").offset().left;
	  for (var i=0; i < touches.length; i++) {
	    //var color = colorForTouch(touches[i]);
	    var idx = ongoingTouchIndexById(touches[i].identifier);

	    if(idx >= 0) {
	      ctx.lineCap = 'round';
	      //log("continuing touch "+idx);
	      ctx.beginPath();
	      //log("ctx.moveTo("+ongoingTouches[idx].pageX+", "+ongoingTouches[idx].pageY+");");
	      ctx.moveTo(ongoingTouches[idx].pageX - $("#canvas").offset().left, ongoingTouches[idx].pageY - $("#canvas").offset().top);
	      //log("ctx.lineTo("+touches[i].pageX+", "+touches[i].pageY+");");
	      ctx.lineTo(touches[i].pageX - $("#canvas").offset().left , touches[i].pageY - $("#canvas").offset().top);
	      ctx.lineWidth = 4;
	      ctx.strokeStyle = color;
	      ctx.stroke();

	      ongoingTouches.splice(idx, 1, copyTouch(touches[i]));  // swap in the new touch record
	      //log(".");
	    } else {
	      //log("can't figure out which touch to continue");
	    }
	  }
	}
	
function handleEnd(evt) {
	  evt.preventDefault();
	  //log("touchend/touchleave.");
	  var el = document.getElementsByTagName("canvas")[0];
	  var ctx = el.getContext("2d");
	  var touches = evt.changedTouches;

	  for (var i=0; i < touches.length; i++) {
	    var color = colorForTouch(touches[i]);
	    var idx = ongoingTouchIndexById(touches[i].identifier);

	    if(idx >= 0) {
	      ctx.lineWidth = 4;
	      ctx.fillStyle = color;
	      ctx.beginPath();
	      ctx.moveTo(ongoingTouches[idx].pageX, ongoingTouches[idx].pageY);
	      ctx.lineTo(touches[i].pageX, touches[i].pageY);
	      //ctx.fillRect(touches[i].pageX-4, touches[i].pageY-4, 8, 8);  // and a square at the end
	      ongoingTouches.splice(idx, 1);  // remove it; we're done
	    } else {
	      //log("can't figure out which touch to end");
	    }
	  }
	}
	
function handleCancel(evt) {
	  evt.preventDefault();
	  //log("touchcancel.");
	  var touches = evt.changedTouches;
	  
	  for (var i=0; i < touches.length; i++) {
	    ongoingTouches.splice(i, 1);  // remove it; we're done
	  }
	}
	
function colorForTouch(touch) {
var r = touch.identifier % 16;
var g = Math.floor(touch.identifier / 3) % 16;
var b = Math.floor(touch.identifier / 7) % 16;
r = r.toString(16); // make it a hex digit
g = g.toString(16); // make it a hex digit
b = b.toString(16); // make it a hex digit
var color = "#" + r + g + b;
//log("color for touch with identifier " + touch.identifier + " = " + color);
return color;
}


function copyTouch(touch) {
	  return { identifier: touch.identifier, pageX: touch.pageX, pageY: touch.pageY };
	}
	
function ongoingTouchIndexById(idToFind) {
	  for (var i=0; i < ongoingTouches.length; i++) {
	    var id = ongoingTouches[i].identifier;
	    
	    if (id == idToFind) {
	      return i;
	    }
	  }
	  return -1;    // not found
	}
	
function log(msg) {
	  var p = document.getElementById('log');
	  p.innerHTML = msg + "\n" + p.innerHTML;
	}
</script>
</body>
</html>