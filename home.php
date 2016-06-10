<!DOCTYPE html>

<head>
<title> Catalogue of CD's </title>
<link rel="stylesheet" type="text/css" href="/Public_html/style.css">
</head>
<?php include 'handler.php';?>

<body>
<h1> Home </h1>
<div class= "navbar">
	<h3><a href= "home.php"> Home </a></h3>
	<h3><a href= "artists.php"> Artists </a></h3>
	<h3><a href= "albums.php"> CD's </a></h3>
	<h3><a href= "tracks.php"> Tracks </a></h3>
</div>
<br>
<h4> Database Statistics </h4>
<ul>
	<?php list_stats($conn); ?>
</ul>
<hr>
</body>
