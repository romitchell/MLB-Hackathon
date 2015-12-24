<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Types of Pitchers</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script>
	function showTeam(team) {
		if (team == "") {
			document.getElementById("pitchers").innerHTML = "";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("pitchers").innerHTML = xmlhttp.responseText;
				}
			};
			document.getElementById("pitchers").innerHTML = "Getting Pitchers";
			document.getElementById("pitches").innerHTML = "";
			document.getElementById("table").innerHTML = "";
			xmlhttp.open("GET","getpitcher.php?team="+team,true);
			xmlhttp.send();
		}
	}
	function showPitcher(pitcher) {
		if (pitcher == "") {
			document.getElementById("pitches").innerHTML = "";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("pitches").innerHTML = xmlhttp.responseText;
				}
			};
			document.getElementById("pitches").innerHTML = "Retreiving pitches";
			document.getElementById("table").innerHTML = "";
			xmlhttp.open("GET","getpitches.php?pitcher="+pitcher,true);
			xmlhttp.send();
		}
	}
	function showPitches(pitch) {
		if (pitch == "") {
			document.getElementById("table").innerHTML = "";
			return;
		} else { 
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("table").innerHTML = xmlhttp.responseText;
				}
			};
			var pitcher = pitch.split("+");
			document.getElementById("table").innerHTML = " Retreiving data. This could take a few seconds.";
			xmlhttp.open("GET","getpitcherinfo.php?pitcher="+pitcher[1]+"&pitch="+pitcher[0],true);
			xmlhttp.send();
		}
	}
	</script>
	<?php
	$servername = "127.0.0.1"; $username = "root"; $password = ""; $dbname = "mlb"; $tbname = "2013season";
	?>
  </head>
  <body>
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="#">WebSiteName</a>
		</div>
		<div>
		  <ul class="nav navbar-nav">
			<li><a href="index.php">Home</a></li>
			<li class="active"><a href="pitchers.php">Type of Pitchers</a></li>
			<li><a href="#">Page 2</a></li>
			<li><a href="#">Page 3</a></li>
		  </ul>
		</div>
	  </div>
	</nav> 
	<div class="row" style="padding: 5px">
		<div class="col-sm-2">
			<select name="teams" onchange="showTeam(this.value)" class="form-control">
				<option selected="true" disabled="disabled" value="">Select a Team:</option>
				<?php
				$starttime = microtime(true);
				$conn = mysqli_connect($servername, $username, $password, $dbname);
				// Check connection
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}
				
				$sql = "SELECT DISTINCT home FROM ".$tbname."";
				$result = mysqli_query($conn, $sql);
				while($row = mysqli_fetch_assoc($result)) {
					echo '<option value="'.$row['home'].'">'.$row['home'].'</option>';
				}
				$endtime = microtime(true);
				$duration = $endtime - $starttime; 
				echo '<option disabled="disabled" value="">'.$duration."</option>";
				mysqli_close($conn);
				?>
			</select>
		</div>
		<div id="pitchers" class="col-sm-2">
		</div>
		<div id="pitches" class="col-sm-2">
		</div>
	</div>
	
	<br/>
	<div style="padding: 5px" id="table"></div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
