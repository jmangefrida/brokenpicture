<?php
$i=0;

$lines = "";


while (!($_GET["x$i"] == "")) {
    //echo $_GET["x$i"];
	$lines = $lines . $_GET["x$i"];
	$lines = $lines . ",";
	$lines = $lines . $_GET["y$i"];
	$lines = $lines . " ";
	++$i;
	//echo $lines;
	//$lines = $lines & $_GET["x$i"] & "," & $_GET["y$i"] & " ";
	//echo $lines;
	//echo ++$i;
	//	//echo '[$_GET["x"+$i]],$_GET["y"+$i]]';
//	echo ++$i;
}

//echo "good";
//print_r($_GET);

//echo $lines;

$output = shell_exec('convert -size 612x729 xc:\'rgba(0,0,0,0)\' -fill none -stroke black -draw \'polyline ' . $lines . '\'   PNG32:/var/www/cpuoftheheart/drawing/draw_line.png');
//$output = shell_exec('composite draw_line.png ./img/note-0.png signed.png');

//echo $output;
//$img1 = new Imagick("draw_line.png");
//$img2 = new Imagick("img/note-0.png");
//$img1->compositeimage($img2, $img2->getImageCompose(), 0, 0);
//$img1->writeImage('signed.png');
echo "<img src=draw_line.png>"; 
?>