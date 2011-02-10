<?php

$con = mysql_connect(':/Applications/MAMP/tmp/mysql/mysql.sock',
  					  'root',
  					  'root');
					
mysql_select_db("ClickerMQTT", $con);

$colours = mysql_query("SELECT * FROM Tables");
while($row = mysql_fetch_array($colours)) {
	echo $row['Colour']." ";
}

mysql_close($con);

?>