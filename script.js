/* JS FUNCTION DEFS */


/* checks whether all text boxes in a list are valid */
function val_set (names) {

	var alltxt= document.getElementsByName(names)
	var i= 0;
	var valid= true;

	while ((i < alltxt.length) & (valid == true))
	{
		if (alltxt[i].value == "")
			valid= false;
		i++;
	}
	
	if (!valid)
	{ 
		window.alert('Text box needs to be set!');
		return false;
	}
	else
		return true;
} 

/* checks the type of data in text box */
/* start aovids having to traverse the whole list */
function val_digit (names, start) {

	var inputs= document.getElementsByName(names);
	var i= start;
	var valid= true;

	while (i < inputs.length)
	{
		if (isNaN(inputs[i].value))
		{
			valid= false;
			break;
		}	
		i++;
	}

	if (!valid)
	{
		window.alert("Some of the entered values need to be numeric.");
		return false;
	}
	else
		return true;
}

/* reads table puts it into select boxes */
function updateinfo (type, select, colnum) {

	var x = document.getElementById(select);
	x.options.length= 0;
	var last= document.getElementsByTagName("table")[0].rows.length;
	var	i= 1;

	/* get every row in table */
	for (i; i < last; i++)
	{	
		var option = document.createElement("option");
		option.text = document.getElementsByTagName("table")[0].rows[i].cells.item(colnum).innerHTML;
		option.value = document.getElementsByTagName("table")[0].rows[i].cells.item(0).innerHTML;
		x.add(option);
	}

}








