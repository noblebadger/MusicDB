<!DOCTYPE html>

<head>
<title>Albums</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<!-- external includes -->
<script src= "script.js"></script>
<?php include 'handler.php';

	$cd_rel= new handler("CD", array("cdID", "artID", "cdTitle", "cdGenre", "cdTrackno", "cdPrice"), "ASC", $conn);
	$cd_rel->set_alt_field('artName', 'Artist');
?>

<h1>Albums</h1>
<div class= "navbar">
	<h3><a href= "home.php"> Home </a></h3>
	<h3><a href= "artists.php"> Artists </a></h3>
	<h3><a href= "tracks.php"> CD's </a></h3>
	<h3><a href= "tracks.php"> Tracks </a></h3>
</div>

<div id= "update" onclick= "updateinfo('add', 'select1', 2); updateinfo('add', 'select2', 2)"> Update Info </div>

<form name= "addfrm" method= "get" class= "editbox" onsubmit= "return (val_digit('add[]', 3) && val_set ('add[]'));">
	<fieldset>
		<legend> Add </legend>
			<label for="add[]">Choose Artist</label>	
			<select name= "add[]">
				<!-- want to display a list or artists to associate cd with -->
				<!-- In this case we need the ID -->
				<?php $cd_rel->get_opts("artName", "Artist")
				?>	
			</select>
			<label for="add[]">Album Title</label>
			<input type= "text" name= "add[]">
			<label for="add[]">Genre</label>
			<input type= "text" name= "add[]">
			<label for="add[]">Track Number</label>
			<input type= "text" name= "add[]">
			<label for="add[]">Price</label>
			<input type= "text" name= "add[]">
			<input type= "submit" value= "Add">
		</fieldset>	
</form>

<form method= "get" class= "editbox" onsubmit= "return val_set('change');">
	<!-- override the standard position of edit box -->
	<fieldset>
		<legend> Edit </legend>
		<label for="edit">Album Title</label>
		<select name= "edit" id= "select1">
			<?php $cd_rel->get_opts("cdTitle");?>
		</select>
		<label for="field">Select Field</label>
		<select name= "field">
			<option value= "artID"> Artist </option>
			<option value= "cdTitle"> Title </option>
			<option value= "cdGenre"> Genre </option>
			<option value= "cdTrackno"> Track Number </option>
			<option value= "cdPrice"> Price </option>
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
	    <label for="delete">Choose Album To Delete</label>
	    <select name= "delete" id= "select2">
			<?php $cd_rel->get_opts("cdTitle");?>
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
		$cd_rel->change_item($_GET['field']); 

	if (isset($_GET['add']))
		$cd_rel->add_row();

	if (isset($_GET['delete']))
		$cd_rel->delete_row("cdID");

	if (isset($_GET['search']))
		$cd_rel->search_query("cdTitle");
	else
		$cd_rel->print_table();

?>


<hr>
</body>

