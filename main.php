<html>
<head>
	<Title>Welcome to Axon Lab</TITLE>
	<script type="text/javascript", src="./api/jquery1.5.js"></script>
   	<link rel="stylesheet" type="text/css" href="tables.css"> 
   	
   	<script type="text/javascript">
   		
		function colourAjax() {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { // When server complete and ok
					handleResponse(xmlhttp.responseText);
				}
			}
			xmlhttp.open("GET", "ajaxMysql.php", true); 
			xmlhttp.send(null);
		}
		
		function resetAjax() {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { // When server complete and ok
					colourAjax();
				}
			}
			xmlhttp.open("GET", "reset.php", true); 
			xmlhttp.send(null);
		}
			
		/* Response Handle */
		function handleResponse(str) {
			var colours = new Array();
			colours = str.split(" ");
			
			document.getElementById('table1').style.backgroundColor = colours[0];
			document.getElementById('table2').style.backgroundColor = colours[1];
			document.getElementById("table3").style.backgroundColor = colours[2];
			document.getElementById("table4").style.backgroundColor = colours[3];
			document.getElementById("table5").style.backgroundColor = colours[4];
			document.getElementById("table6").style.backgroundColor = colours[5];
			document.getElementById("table7").style.backgroundColor = colours[6];
			document.getElementById("table8").style.backgroundColor = colours[7];
			document.getElementById("table9").style.backgroundColor = colours[8];
			document.getElementById("table10").style.backgroundColor = colours[9];
			document.getElementById("table11").style.backgroundColor = colours[10];	
		}
		
		/* Interval functions */
		var interval = "";
	
		function startMqtt() {
			mqttAjax();
		}
	
		function start() {
			interval = window.setInterval("colourAjax()", 500);
		}
	
		function stop() {
			if (interval != "") {
				window.clearInterval(interval);
			}
		}
		
		function reset() {
			stop();
			resetAjax();
		}
		
		/* Jquery for fun */
		$(Document).ready(function() {
			$('#room_image_div').fadeOut(500).fadeIn(500);
			$('#control').delay(1000).slideDown(1000);
			$('#control_btn').click(function(){
				$(this).fadeOut();
				$('#control_div').delay(1000).fadeIn(1000);	
				$('#table1').fadeIn(1000);
				$('#table2').fadeIn(1000);
				$('#table3').fadeIn(1000);
				$('#table4').fadeIn(1000);
				$('#table5').fadeIn(1000);
				$('#table6').fadeIn(1000);
				$('#table7').fadeIn(1000);
				$('#table8').fadeIn(1000);
				$('#table9').fadeIn(1000);
				$('#table10').fadeIn(1000);
				$('#table11').fadeIn(1000);
				
				$('#run').click(function() {
					$(this).hide();
					$('#answer').fadeIn(500);
					$('#stop').show();
				});
				
				$('#stop').click(function() {
					$(this).hide();
					$('#answer').fadeOut(500);
					$('#run').show();
				});
			});
		});
	
	</script>
</head>

<body>

<div id="room_image_div" style="position:absolute; text-align:left; width:960px; margin-left:0px; margin-right:auto;">	
<img id="room_image" src="room.png" border="0" width="960" />

<div id="table1" style="display:none"></div>
<div id="table2" style="display:none"></div>
<div id="table3" style="display:none"></div>
<div id="table4" style="display:none"></div>
<div id="table5" style="display:none"></div>
<div id="table6" style="display:none"></div>
<div id="table7" style="display:none"></div>
<div id="table8" style="display:none"></div>
<div id="table9" style="display:none"></div>
<div id="table10" style="display:none"></div>
<div id="table11" style="display:none"></div>

</div>

<br /><br />

<div id="control" style="display:none; position:absolute; text-align:left; margin-top:620px; margin-left:160px; margin-right:auto;" >
<input id='control_btn' type='button' value='START' style="width:600px" />
</div>

<div id="control_div" style="display:none; position:absolute; text-align:left; margin-top:620px; margin-left:160px; margin-right:auto;" >
<input id="run" type='button' onclick='start();' value='RUN' style="width:400px;" />
<input id="stop" type='button' onclick='stop();' value='STOP' style="display:none; width:400px;" />
<input type='button' onclick='reset();' value='RESET' style="width:200px;" />
</div>

<div id="answer" style="display:none; position:absolute; margin-left:800; margin-top:580">
<p style="color:red"><font size="16"><b>B</b></font></p>
</div>

</body>
</html>

