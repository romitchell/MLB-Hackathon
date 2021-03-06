<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Home</title>

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
	function showPitcher(str) {
		if (str == "") {
			document.getElementById("txtHint").innerHTML = "";
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
					document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
				}
			};
			xmlhttp.open("GET","getpitcher.php?pitcher="+str,true);
			xmlhttp.send();
		}
	}
	</script>
	<?php
	$servername = "127.0.0.1"; $username = "root"; $password = ""; $dbname = "mlb"; $tbname = "2015ws";
	?>
  </head>
  <body>
   <?php include "navBar.html"; ?>
	<div class="row">
		<div class="col-sm-2">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
				<?php 
					if(!isset($_GET['pitcher'])) {
						echo "Select a Pitcher";
					}
					else{
						echo $_GET['pitcher'];
					}
				?>
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<?php
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					// Check connection
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					$sql = "SELECT DISTINCT pitcher FROM ".$tbname;
					$result = mysqli_query($conn, $sql);
					while($row = mysqli_fetch_assoc($result)) {
						echo "<li><a href='index.php?pitcher=".$row["pitcher"]."'>".$row["pitcher"]."</a></li>";
					}
					mysqli_close($conn);
					?>
				</ul>
			</div>
		</div>
		
		<div class="col-sm-2">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Dropdown Example
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<?php
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					// Check connection
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					$sql = "SELECT DISTINCT pitcher FROM ".$tbname;
					$result = mysqli_query($conn, $sql);
					while($row = mysqli_fetch_assoc($result)) {
						echo "<li><a href='#'>".$row["pitcher"]."</a></li>";
					}
					mysqli_close($conn);
					?>
				</ul>
			</div>
		</div>
		<p>
		
		</p>
	</div>
	
	<br/>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
