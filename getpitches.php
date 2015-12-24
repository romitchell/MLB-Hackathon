<!DOCTYPE html>
<html>
<head>
<style>

</style>
</head>
<body>

<?php
$servername = "127.0.0.1"; $username = "root"; $password = ""; $dbname = "mlb"; $tbname = "2013season";
$pitcher = strval($_GET['pitcher']);
$pitchType = array("CH" => "Changeup", "CU" => "Curveball", "FA" => "Fastball", "FT" => "Two Seamer", "FF" => "Four Seamer", "FC" => "Cutter", "SL" => "Slider", "FS" => "Splitter", "SI" => "Sinker", "FO" => "Forkball", "KN" => "Knuckleball", "KC" => "Knuckle Curve", "SC" => "Screwball", "GY" => "Gyroball", "EP" => "Eephus", "PO" => "Pitchout", "IN" => "Intentional Ball", "AB" => "Automatic Ball", "AS" => "Automatic Strike", "UN" => "Unknown");
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
$sql="SELECT DISTINCT pitcher, pitchType FROM ".$tbname." WHERE pitcher ='".$pitcher."'";
$pitches = mysqli_query($conn,$sql);
echo '<select class="form-control" name="pitches" onchange="showPitches(this.value)">
	<option selected="true" disabled="disabled" value="">Select a Pitch Type:</option>';
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_assoc($result)) {
		echo '<option value="'.$row['pitchType'].'+'.$pitcher.'">'.$pitchType[$row['pitchType']].'</option>';
	}
	mysqli_close($conn);
echo '</select>';	
?>
</body>
</html>
