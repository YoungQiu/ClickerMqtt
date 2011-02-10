<?php

require("./api/phpMQTT.php");
//require("./sampleData.php");

if ($argc != 2) {
	echo "Usage: <mqttSub.php> <Topic>\n"; 
	exit(1);
}

$mqtt = new phpMQTT("localhost", 1883, "Clicker MQTT Subscribe");

if(!$mqtt->connect()){ 
	exit(1);
} 
		
$topics[$argv[1]] = array("qos"=>0, "function"=>"parseMsg"); 
$mqtt->subscribe($topics, 0); 

while(1) {
	$mqtt->proc();
}  
	
$mqtt->close();

// ---------------------------------------------------------------------

/* The first function called from a subscribe topic */	
function parseMsg($topic, $msg) {  
		
	echo "$msg\n";
	$input = explode(" ", $msg); // Msg: "ClickerID [space] answer", split here
	
	processMsg($input[0], $input[1], 1); // <--------------------Implement question number later
}

/* Process message and update database */
function processMsg($clickerID, $answer, $questionNumber) { 
	 			
	$correct = true; 
	
	$con = mysql_connect(':/Applications/MAMP/tmp/mysql/mysql.sock',
  					     'root',
  					     'root');
					
	mysql_select_db("ClickerMQTT", $con);
	
	/* Add a record into 'Inputs' */
	$result = mysql_query("SELECT * FROM Inputs 
						   WHERE ClickerID='$clickerID' && QuestionNumber='$questionNumber'");
	$row = mysql_fetch_array($result);
	
	if (strcmp($row['ClickerID'], $clickerID) != 0) { // Add a new row 
		mysql_query("INSERT INTO Inputs(ClickerID, QuestionNumber, Answer) 
					 VALUES ('$clickerID', '$questionNumber', '$answer')");
	} else { // Update the row 
		mysql_query("UPDATE Inputs SET Answer='$answer'
					 WHERE ClickerID='$clickerID' && QuestionNumber='$questionNumber'");
	}
	
	/* Check answer */
	$result = mysql_query("SELECT * FROM Questions WHERE Number='$questionNumber'");	
	$row = mysql_fetch_array($result);
	$correctAnswer = $row['Answer'];
	
	if ($correctAnswer != $answer) {
		$correct = false;
	}
	
	
	/* Update Table colour */
	if ($correct == false) { // Student input wrong answer
	
		/* Find tableNumber */
		$result = mysql_query("SELECT * FROM Students
					 		   WHERE ClickerID='$clickerID'");
		$row = mysql_fetch_array($result);
		$tableNumber = $row['TableNumber'];
		
		/* Look up the next level colour */
		$result = mysql_query("SELECT * FROM Tables
							   WHERE Number='$tableNumber'");
		$row = mysql_fetch_array($result);
		$colour = $row['Colour']; // Get current colour 
		
		$result = mysql_query("SELECT * FROM Colours		
							   WHERE Colour='$colour'");
		$row = mysql_fetch_array($result); // Find next level colour
		$level = $row['ID'];
		if ($level != 9) {
			$level++;
		} 
		
		$result = mysql_query("SELECT * FROM Colours
					 		   WHERE ID='$level'");
		$row = mysql_fetch_array($result);
		$colour = $row['Colour'];
		
		/* Update table */
		$result = mysql_query("UPDATE Tables SET Colour='$colour'
					 		   WHERE Number='$tableNumber'");
	}
	
	mysql_close($con);
}

?>
