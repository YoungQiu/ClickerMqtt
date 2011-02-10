<?php

$tc = array();
$con = mysql_connect(':/Applications/MAMP/tmp/mysql/mysql.sock',
  					  'root',
  					  'root');
					
mysql_select_db("ClickerMQTT", $con);

for ($i=1; $i<=11; $i++) {
	mysql_query("UPDATE Tables SET Colour='#008B00'
				 WHERE Number='$i'");
}

mysql_close($con);
?>