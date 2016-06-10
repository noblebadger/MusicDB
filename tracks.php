<!DOCTYPE html>

<head>
<title>Tracks</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<!-- external includes -->
<script src= "script.js"></script>
<?php include 'handler.php';

	$track_rel= new handler("Track", array("trID", "cdID", "trTitle", "trRuntime"), "ASC", $conn);
	$track_rel->set_alt_field('cdTitle', 'CD');
?>

<h1>Tracks</h1>
<div class= "navbar">
	<h3><a href= "home.php"> Home </a></h3>
	<h3><a href= "artists.php"> Artists </a></h3>
	<h3><a href= "albums.php"> CD's </a></h3>
	<h3><a href= "tracks.php"> Tracks </a></h3>
</div>

<div id= "update" onclick= "updateinfo('add', 'select1', 2); updateinfo('add', 'select2', 2)"> Update Info </div>

<form method= "get" class= "editbox" onsubmit= "return (val_digit('add[]', 2) && val_set ('add[]'));" >
	<fieldset>
		<legend> Add Track </legend>	
			<label for="add[]">Album Title</label>
			<select name= "add[]">
				<?php $track_rel->get_opts("cdTitle", "CD")?>
			</select>
			<label for="add[]">Track Title</label>
			<input type= "text" name= "add[]">
			<label for="add[]">Run Time (s)</label>
			<input type= "text" name= "add[]">
			<input type= "submit" value= "Add">
		</fieldset>	
</form>

<form method= "get" class= "editbox" onsubmit= "return val_set('change');">
	<fieldset>
		<legend> Edit Track </legend>
		<label for="edit">Track Title</label>
		<select name= "edit" id= "select1">
			<?php $track_rel->get_opts("trTitle");?>
		</select>
		<label for="field">Select Field</label>
		<select name= "field">
			<option value= "cdID"> Album </option>
			<option value= "trTitle"> Title </option>
			<option value= "trRuntime"> Runtime </option>
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
	    <label for="delete">Choose Track To Delete</label>
	    <select name= "delete" id= "select2">
			<?php $track_rel->get_opts("trTitle");?>
		</select>
	  	<label>Delete Chosen</label>
		<input type= "submit" value= "Delete">
	</fieldset>
</form>

<hr>

<form method= "get" class= "search">
	<input id= "search" type= "text" name= "search">
	<input type= "submit" value= "Search">
</form>

<?php 
	if (isset($_GET['change']))
		$track_rel->change_item($_GET['field']); 

	if (isset($_GET['add']))
		$track_rel->add_row();

	if (isset($_GET['delete']))
		$track_rel->delete_row("trID");

	if (isset($_GET['search']))
		$track_rel->search_query("trTitle");
	else
		$track_rel->print_table();
?>




<hr>
</body>

