<?php
require("SSI.php");
echo "This is Update 2<br><br><br>";
$table = $_GET['Name'];
$return = $_GET['return'];
$array = array();
$name = array();
if (isset($_GET['ID']))
{
	for ($a = 0; $a < count($_POST); $a++)
	{
		$array[$a] = 0;
	}
	$i = 0;
	foreach($_POST as $value)
	{
		$array[$i] = $value;
		$i++;
	}
	$idfeild = $array[0] . $array[1];
	$i = 0;
	foreach (array_keys($_POST) as $field)
	{
		$name[$i] = $field;
		$i++;
	}
}
else
{
	
	for ($a = 0; $a < count($_POST); $a++)
	{
		$array[$a] = 0;
	}
	$i = 0;
	foreach($_POST as $value)
	{
		$array[$i] = $value;
		$i++;
	}
	$i = 0;
		foreach (array_keys($_POST) as $field)
	{
		$name[$i] = $field;
		$i++;
	}

	$idfeild = $array[0] . $array[1];

}
$db_secondDb = "cardgame";
	$tod_connection = mysql_connect($db_server, $db_user, $db_passwd);
	mysql_select_db($db_secondDb,$tod_connection);
	 
	 if (mysqli_connect_error()) {

            die('Connect Error (' . mysqli_connect_errno() . ') '

                    . mysqli_connect_error());

        }
	$sql = 'SELECT * FROM ' . $table . ' Where ' . $name[0] . ' = ' . $array[0] . ' && ' . $name[1] . ' = ' .$array[1];
	echo "<BR>" . $sql . "<BR>";
	$res = mysql_query($sql,  $tod_connection);
	

	if (mysql_num_rows($res) == 0)
	{
		$holder = "";
		foreach($_POST as $value)
		{
			
			if(is_array($value)) //Only use the post variable if it is an array
			{
				foreach($value as $subvalue)
				{
					//Loop through, enclosing each $subvalue variable in a quote (" ") and attaching a 
					//space to it's end and concatenate all the values and store the the result in the 
					//$holder variable
					$holder = $holder."\"".$subvalue."\" ";
				}
			}
			else
			{
				if (is_numeric($value))
				 	$holder = $holder. $value . "~";
				else
					$holder = $holder .'"'.$value .'"'. "~" ; 
			
			}
		}
		if(!empty($holder))//The user entered something into the form, use it to query the db
		{
			echo $holder;
			//Remove white spaces from the content of the $holder
			//and break it into the $new array using a black space as a delimiter
			$new = explode("~", trim($holder));
			//Reconvert the $new array into a string seperating each element with a comma(,) and 
			//reassign it to the $prepared variable
			$prepared = implode(",", $new);
			$prepared = trim($prepared, ",");
			//Form and execute your query
			$sql = "INSERT INTO ".$table." VALUES(".$prepared.")";
			echo $sql;
			
		}
	}
	else
	{
		foreach($_POST as $k=>$v)
		{
			@$select.=" `".mysql_real_escape_string($k)."` = '".mysql_real_escape_string($v)."',";
		}
		$select = rtrim($select,',');
		$sql = "UPDATE ".$table." SET".$select." WHERE ". $name[0] . ' = ' . $array[0] . ' && ' . $name[1] . ' = ' .$array[1];
		echo $sql;
		
	}

if (!mysql_query($sql))
{
  die('Error: ' . mysql_error($tod_connection));
  }
else
{
  echo "1 record added";
}

mysql_close($tod_connection);
header( 'Location: '.$return );

?> 
