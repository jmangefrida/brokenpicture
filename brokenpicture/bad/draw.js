
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
//ctx.fillStyle="#FF0000";
//ctx.fillRect(0,0,150,75);

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


function testing(){
	var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");  // here is the most important part because if you dont replace you will get a DOM 18 exception.


	//window.location.href=image;
	var nextplayer = $("#inputEmail").val();
	$.post("picupload.php",{ image: image, player: nextplayer }).done(function( data ) {
//		   report = document.getElementById("page");
		   //alert(data);
	   });

	report = document.getElementById("print");
	report.innerHTML = "DONE";
}

function sendCoord() {
	pin = 123456;
	if (pin == "123456"){
	url="http://cpuoftheheart.com/drawing/sig.php?";
	for (var i=0; i<coordx.length; i++){
		url=url+"x"+i+"="+coordx[i]+"&y"+i+"="+coordy[i]+"&";
		//var x=document.getElementById("print");
		 //x.innerHTML=url;
		
	}
	getData(url,"print");
	
	//document.getElementById("pin").style.visibility='hidden';
	}else {
		//alert('pin does not match');
	}
}

