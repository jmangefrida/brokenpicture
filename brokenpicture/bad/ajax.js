
var xmlHttp;

var news="news";
var i=0;
var x=0;
var feeds;
var divids = new Array();
var urls = new Array();
var rnum =0;
var url;
var divid;

function getData(url, divid)
{
	urls.push(url);
	divids.push(divid);
	
	if (divids.length == 1)
	{
		requestData();
	}
}

function requestData()
{
	
	if (divids.length == 0)
	{
		return;
		
	}

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }

url= urls.shift();

xmlHttp.onreadystatechange=stateChanged
xmlHttp.open("GET",url,true)
xmlHttp.send(null)

}


function stateChanged()
{
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
divid = divids.shift(); 
	
document.getElementById(divid).innerHTML=xmlHttp.responseText;
 
requestData();
 }

}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
