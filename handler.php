<?php
/* Wrtten by: Adam White */
/* This contains functions to be used to handle 
   different types of database queries */

/* connect to database */
include 'db.php';

class handler 
{
	/* contains all the functions necassary to change database */
	/* designed for one handler per table */

	/* properties */
    private $table;
    private $connection;
    private $fields;
    private $fields_q;
    private $attr_num= 0;
    private $order;

	/* methods */
	public function __construct($table_name, $attributes, $ord, $conn)
	{
		$this->table= $table_name;
		$this->fields= $attributes;
		$this->attr_num= count($this->fields);
		$this->order= $ord;
		$this->connection= $conn;

		/* to do with looking up from other tables */
		$this->alt_field= "";
		$this->alt_table= "";

		/* creates a string form of the schema to insert into a query */
		/* ignore primary key as auto inc */

		for ($i= 1; $i < $this->attr_num; $i++)
		{
			$this->fields_q.= $this->fields[$i];

			/* add comma as needed */
			if ($i <> ($this->attr_num - 1))
				$this->fields_q.= ",";	
		}	

	}

	/* enables array able to be inserted into sql */
	public function convert_array($array)
	{
		$size= count($array);
		$output= "";

		for ($i= 0; $i < $size; $i++)
		{
			if (!is_numeric($array[$i]))
				$output.= "'".$array[$i]."'";
			else
				$output.= (string)$array[$i];

			if ($i <> ($size - 1))
				$output.= ",";
		}	
		
		return $output;
	}

	public function search_query($field)
	{
		$str= (string)$_GET['search'];
	 	$query = "SELECT * FROM {$this->table} WHERE {$field} LIKE '%{$str}%' ORDER BY {$this->fields[0]};";
		$result= mysqli_query($this->connection, $query);
		$num_rows = mysqli_num_rows($result);
		$this->display_Table($num_rows, $result);
	}

	/* alters one attribute of a tuple at a time */
	/* $feild represents the name of the column */
	public function change_item($field)
	{	
		$str= $_GET['change'];
		$row_id= $_GET['edit'];
		$query = "UPDATE {$this->table} SET {$field}= '{$str}' WHERE {$this->fields[0]}= $row_id";
		mysqli_query($this->connection, $query);
	}

	public function add_row()
	{
		$str= $_GET['add'];

		if (!is_string($str))
			$str= $this->convert_array($str);	
		else
			$str= "'".$str."'";

		$query = "INSERT INTO {$this->table}($this->fields_q) VALUES ({$str});"; 
		mysqli_query($this->connection, $query);
	}

	public function print_table()
	{
		$query = "SELECT * FROM {$this->table} ORDER BY {$this->fields[0]} {$this->order}";
		$result= mysqli_query($this->connection, $query);
		$num_rows= mysqli_num_rows($result);
		$this->display_Table($num_rows, $result);
	}

	/* gives a select input list of choosen attribute*/
	/* optionally get from different table */
	public function get_opts($field, $table)
	{

		if (!isset($table))
		{
			$rel= $this->table;
			$col= 0;
		}
		else 
		{
			$rel= $table;
			/* to order by next relevent ID */
			$col= 1;
		}

		$query = "SELECT * FROM {$rel} ORDER BY {$this->fields[$col]} {$this->order}";
		$result= mysqli_query($this->connection, $query);
		$num_rows= mysqli_num_rows($result);
		$this->display_opts($num_rows, $result, $field);

	}

	/* displays data in tabluar form */
	/* alt_field set replaces ids with names */
	public function display_Table($num_rows, $output)
	{
		echo "<table class= 'table'>";
		if ($num_rows != 0)
		{	
			foreach ($this->fields as $attr)
				echo "<th>", htmlspecialchars($attr), "</th>";
			echo "</tr>";

			/* send result to table */
			for ($row_num = 1; $row_num <= $num_rows; $row_num++) 
			{
			 	$row = mysqli_fetch_array($output);
				echo "<tr>";

				for ($column_num= 0; $column_num < $this->attr_num; $column_num++)
				{
					/* relplaces ID with a name */
					if (($column_num == 1) && ($this->alt_field != ""))
						$element= $this->translateid($this->alt_field, 
							$row[$column_num], $this->alt_table)." (".$row[$column_num].")";
					else
						$element= htmlspecialchars($row[$column_num]);

					echo "<td>", $element, "</td>";	
				}

			    echo "</tr>";
			}
			echo "</table>";

		}
		else
			echo "query returned no cells";
	}

	/* displays select box */
	public function display_opts($num_rows, $output, $field)
	{
		if ($num_rows != 0)
		{
			/* send result to table */
			for ($row_num = 1; $row_num <= $num_rows; $row_num++) 
			{
			 	$row = mysqli_fetch_array($output);
			 	/* first row is always ID for all tables */
			    echo "<option value= $row[0] >", htmlspecialchars($row[$field]), "</<option>";
			}
		}
		else
			echo "query returned no cells";
	}

	/* deletes row */
	public function delete_row($field)
	{
		$str= (string)$_GET['delete'];
	 	$query = "DELETE FROM {$this->table} WHERE {$field} = {$str};";
		mysqli_query($this->connection, $query);
	}


	/* we know the id is always the second row */
	public function translateid($field, $lookup, $ouputrel)
	{
		/* lookup is the value we search in other table */
		$query = "SELECT {$field} FROM {$ouputrel} WHERE {$this->fields[1]}= $lookup";
		$row= mysqli_fetch_array(mysqli_query($this->connection, $query));
		return $row[0];
	}

	public function set_alt_field($field, $alt_table)
	{
		$this->alt_field= $field;
		$this->alt_table= $alt_table;
	}

}

/* non-table related functions */

function list_stats($conn)
{
	/* get total no of rows for each table then whole*/
	$tables= array('Artist', 'CD', 'Track');
	$i= 0;
	$total= 0
	;
	for ($i; $i < 3; $i++)
	{
		$query = "SELECT COUNT(*) FROM {$tables[$i]}";
		$row = mysqli_fetch_array(mysqli_query($conn, $query));
		$total+= $row[0];
		$running= $row[0];
		echo "<li>{$tables[$i]}: {$running} </li>";
	}

	echo "<li>Total: {$total}</li>";
}



?>