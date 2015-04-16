
//var c=document.getElementById("Canvas0");
//var ctx=c.getContext("2d");
var drawing = false;
var signing = false;
var c;
var d;
var x1;
var y1;
var x2;
var y2;
//var coordx=new Array();
//var coordy=new Array();
var ctx;
var touch;
var color = "#000000";
var friends = "['jmange@gmail.com']";
//ctx.fillStyle="#FF0000";
//ctx.fillRect(0,0,150,75);

var substringMatcher = function(strs) {
	return function findMatches(q, cb) {
	var matches, substrRegex;
	 
	// an array that will be populated with substring matches
	matches = [];
	 
	// regex used to determine if a string contains the substring `q`
	substrRegex = new RegExp(q, 'i');
	 
	// iterate through the pool of strings and for any string that
	// contains the substring `q`, add it to the `matches` array
	$.each(strs, function(i, str) {
	if (substrRegex.test(str)) {
	// the typeahead jQuery plugin expects suggestions to a
	// JavaScript object, refer to typeahead docs for more info
	matches.push({ value: str });
	}
	});
	 
	cb(matches);
	};
	};
	
	
	
	$.getJSON("code/getfriends.php", function(data) {
		friends = data;
		//alert(friends);
		$('#inputEmail').typeahead({
			hint: true,
			highlight: true,
			minLength: 1
			},
			{
			name: 'friends',
			displayKey: 'value',
			source: substringMatcher(friends)
			}); 
		
	});
	
	
	 
	

function scroll(){
	setTimeout(window.scrollTo(0,100),2000);
}

function relMouseCoords(event){
    var totalOffsetX = 0;
    var totalOffsetY = 0;
    var canvasX = 0;
    var canvasY = 0;
    var currentElement = this;

    do{
        totalOffsetX += currentElement.offsetLeft - currentElement.scrollLeft;
        totalOffsetY += currentElement.offsetTop - currentElement.scrollTop;
    }
    while(currentElement = currentElement.offsetParent)

    canvasX = event.pageX - totalOffsetX;
    canvasY = event.pageY - totalOffsetY;

    return {x:canvasX, y:canvasY}
}
HTMLCanvasElement.prototype.relMouseCoords = relMouseCoords;

function startDraw(event) {
	c=document.getElementById("canvas");
	d=document.getElementById("modalbox");
	ctx=c.getContext("2d");
 drawing = true;
 coords = canvas.relMouseCoords(event);
 x1 = coords.x;
 y1 = coords.y;
 //x1=event.clientX + window.pageXOffset - c.offsetLeft - d.offsetLeft;
 //y1=event.clientY + window.pageYOffset - c.offsetTop - d.offsetTop;
 //alert('test');
 //var sincoord=[x1,y1];
 //coordx.push(x1);
 //coordy.push(y1);
 //doDraw(event);
 //report = document.getElementById("report");
}

function red() {
	color = "#ff0000";
}

function blue() {
	color = "#0000ff";
}

function green() {
	color = "#00ff00";
}

function black() {
	color = "#000000";
}

function yellow() {
	color = "#ffff00";
}

function white() {
	color = "#ffffff";
}

function colorchange() {
	color = document.getElementById("colorpicker").value;
}

function cleardrawing() {
	ctx.clearRect(0, 0, canvas.width, canvas.height);
}

function stopDraw() {
if(drawing) { 
drawing = false;
// var x=document.getElementById("print");
// x.innerHTML=coord; 
// sendCoord();
}
}

function doDraw(event) {
if (drawing){
	 coords = canvas.relMouseCoords(event);
	 x2 = coords.x;
	 y2 = coords.y;
	 //alert(x2);
  //x2=event.clientX + window.pageXOffset - c.offsetLeft;
  //y2=event.clientY + window.pageYOffset - c.offsetTop;
  //report.innerHTML = x2 + y2;
  //x2 = (event.pageX - document.getElementById('Canvas0').offset().left) + self.frame.scrollLeft();
  //y2 = (event.pageY - $('#Canvas0').offset().top) + self.frame.scrollTop();
  //alert(y2);
  ctx.beginPath();
  ctx.lineCap = 'round';
  ctx.lineWidth = 6;
  ctx.moveTo(x1,y1);
  ctx.lineTo(x2,y2);
  ctx.strokeStyle = color;
  ctx.stroke();
  //var sincoord=[x2,y2];
  //coordx.push(x2);
  //coordy.push(y2);
  x1=x2;
  y1=y2;
  //ctx.fillStyle="#FF0000";
  //ctx.fillRect(x,y,3,3);
  //alert('test');
  //doDraw(event);
  ctx = NULL;

}
}


function testing(status){
	var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");  // here is the most important part because if you dont replace you will get a DOM 18 exception.


	//window.location.href=image;
	var nextplayer = $("#inputEmail").val();
	$.post("code/doupload.php",{ data: image, player: nextplayer, status: status }).done(function( data ) {
//		   report = document.getElementById("page");
		   //alert(data);
		  window.location.replace("http://brokenpicture.com/mygames.php");
	   });

	report = document.getElementById("print");
	report.innerHTML = "DONE";
}

function sendstart() {
	var phraseval = $( "#get_phrase" ).val();
	var nextplayer = $("#inputEmail").val();
   $.post("http://brokenpicture.com/code/dostart.php",{ phrase: phraseval, player: nextplayer }).done(function( data ) {
	   //report = document.getElementById("page");
	   //alert(data);
	   window.location.replace("http://brokenpicture.com/mygames.php");
   });

}

function sendphrase(status) {
	var phraseval = $( "#get_phrase" ).val();
	var nextplayer = $("#inputEmail").val();
   $.post("http://brokenpicture.com/code/doupload.php",{ data: phraseval, player: nextplayer, status: status }).done(function( data ) {
	   //report = document.getElementById("page");
	   //alert(data);
	   window.location.replace("http://brokenpicture.com/mygames.php");
   });

}

function loadgameinfo(hash) {
	$.get("http://brokenpicture.com/code/getgameinfo.php?hash=" + hash, function(data, status) {
		document.getElementById('gamedescriptioncontent').innerHTML = data;
	});
}

//function sendCoord() {
//	pin = 123456;
//	if (pin == "123456"){
//	url="http://cpuoftheheart.com/drawing/sig.php?";
//	for (var i=0; i<coordx.length; i++){
//		url=url+"x"+i+"="+coordx[i]+"&y"+i+"="+coordy[i]+"&";
//		//var x=document.getElementById("print");
//		 //x.innerHTML=url;
//		
//	}
//	getData(url,"print");
//	
//	//document.getElementById("pin").style.visibility='hidden';
//	}else {
//		//alert('pin does not match');
//	}
//}


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

