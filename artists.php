<!DOCTYPE html>

<head>
<title>Artists</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	
<!-- external includes -->
<script src= "script.js"></script>
<?php include 'handler.php';

	$art_rel= new handler("Artist", array("artID", "artName"), "ASC", $conn);
?>

<h1>Artists</h1>
<div class= "navbar">
	<h3><a href= "home.php"> Home </a></h3>
	<h3><a href= "artists.php"> Artists </a></h3>
	<h3><a href= "albums.php"> CD's </a></h3>
	<h3><a href= "tracks.php"> Tracks </a></h3>
</div>

<div id= "update" onclick= "updateinfo('add', 'select1', 1); updateinfo('add', 'select2', 1);"> Update Info </div>

<form method= "get" class= "editbox" onsubmit= "return (val_set('add'));">
	<fieldset>
		<legend> Add </legend>
			<label for="add">Add Artist Name</label>
			<input type= "text" name= "add">
	    	<input type= "submit" value= "Add">	
		</fieldset>	
</form>

<form method= "get" class= "editbox" onsubmit= "return val_set('change');" >
	<fieldset>
		<legend> Edit </legend>
		<!-- outputs select bar -->
	    <label for="edit">Choose Artist</label>
		<select name= "edit" id= "select1">
			<?php $art_rel->get_opts("artName")?>
	    </select>
	    <label for="change">Rename Element</label>	
		<input type= "text" name= "change">
	    <input type= "submit" value= "Change">
	</fieldset>
</form>

<form method= "get" class= "editbox">
	<fieldset>
		<legend> Delete </legend>
		<!-- outputs select bar -->
	    <label for="delete">Choose Artist To delete</label>
		<select name= "delete" id= "select2">
			<?php $art_rel->get_opts("artName")?>
	    </select>
	  	<label>Delete Chosen</label>
		<input type= "submit" value= "Delete">
	</fieldset>
</form>

<hr>

<form method= "get" class= "search">
	<input type= "text" name= "search">
	<input type= "submit" value= "Search">
</form>

<?php

	if (isset($_GET['change']))
		$art_rel->change_item("artName");
	else if (isset($_GET['add']))
		$art_rel->add_row();
	else if (isset($_GET['delete']))	
		$art_rel->delete_row("artID");

	if (isset($_GET['search']))
		$art_rel->search_query("artName");
	else
		$art_rel->print_table();

?>


<hr>
</body>

