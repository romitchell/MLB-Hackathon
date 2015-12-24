<!DOCTYPE html>
<html>
<head>
<style>

</style>
</head>
<body>

<?php
$servername = "127.0.0.1"; $username = "root"; $password = ""; $dbname = "mlb"; $tbname = "2013season";
$team = strval($_GET['team']);
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
$sql="SELECT DISTINCT pitcher FROM ".$tbname." WHERE home ='".$team."' AND side ='t' OR visitor ='".$team."' AND side ='b'";
$pitches = mysqli_query($conn,$sql);
echo '<select name="pitchers" onchange="showPitcher(this.value)" class="form-control">
	<option selected="true" disabled="disabled" value="">Select a Pitcher:</option>';
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {
		echo '<option value="'.$row['pitcher'].'">'.$row['pitcher'].'</option>';
	}
	mysqli_close($conn);
echo '</select>';	
?>
</body>
</html>
