<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$servername = "127.0.0.1"; $username = "root"; $password = ""; $dbname = "mlb"; $tbname = "2013season";
$pitcher = strval($_GET['pitcher']);
$pitch = strval($_GET['pitch']);
$pitchType = array("CH" => "Changeup", "CU" => "Curveball", "FA" => "Fastball", "FT" => "Two Seamer", "FF" => "Four Seamer", "FC" => "Cutter", "SL" => "Slider", "FS" => "Splitter", "SI" => "Sinker", "FO" => "Forkball", "KN" => "Knuckleball", "KC" => "Knuckle Curve", "SC" => "Screwball", "GY" => "Gyroball", "EP" => "Eephus", "PO" => "Pitchout", "IN" => "Intentional Ball", "AB" => "Automatic Ball", "AS" => "Automatic Strike", "UN" => "Unknown");
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

$sql="SELECT DISTINCT pitcher, pitchType FROM ".$tbname." WHERE pitcher ='".$pitcher."' AND pitchType ='".$pitch."'";
$pitches = mysqli_query($conn,$sql);
echo "<table>
<tr>
<th>Usage</th>
<th>%</th>
<th>Strikes</th>
<th>%</th>
<th>Balls</th>
<th>%</th>
<th>In Play</th>
<th>%</th>
</tr>";
echo "<tr>";

	$usageSql = "SELECT pitcher, pitchType, pitchResult, battedBallType FROM ".$tbname." WHERE pitcher ='".$pitcher."' AND pitchType='".$pitch."'";
	$usage = mysqli_query($conn,$usageSql);
	$totalSql = "SELECT pitcher, pitchType FROM ".$tbname." WHERE pitcher ='".$pitcher."'";
	$total = mysqli_num_rows(mysqli_query($conn,$totalSql));
	$count = mysqli_num_rows($usage)*1.0/$total;
	$strikesTotal = $ballsTotal = $ipTotal = 0;
	echo "<td>".$total."</td>";
	echo "<td>".round($count*100, 2)."%</td>";
	while($pitchResult = mysqli_fetch_array($usage)) {
		if ($pitchResult["pitchResult"] == "SL" or $pitchResult["pitchResult"] == "SS" or $pitchResult["pitchResult"] == "F" or $pitchResult["pitchResult"] == "FT" or $pitchResult["pitchResult"] == "FB" or $pitchResult["pitchResult"] == "MB" or $pitchResult["pitchResult"] == "AB") $strikesTotal++;
		if ($pitchResult["pitchResult"] == "B" or $pitchResult["pitchResult"] == "BID" or $pitchResult["pitchResult"] == "HBP" or $pitchResult["pitchResult"] == "IB" or $pitchResult["pitchResult"] == "PO" or $pitchResult["pitchResult"] == "AB") $ballsTotal++;
		if ($pitchResult["pitchResult"] == "IP") $ipTotal++; 
	}
	echo "<td>".$strikesTotal."</td>";
	echo "<td>".@round($strikesTotal*100.0/mysqli_num_rows($usage), 2)."%</td>";
	echo "<td>".$ballsTotal."</td>";
	echo "<td>".@round($ballsTotal*100.0/mysqli_num_rows($usage), 2)."%</td>";
	echo "<td>".$ipTotal."</td>";
	echo "<td>".@round($ipTotal*100.0/mysqli_num_rows($usage), 2)."%</td>";
	echo "</tr>";

echo "</table>";
echo '<h2>In Play Stats</h2>';
$sql="SELECT DISTINCT pitcher, pitchType FROM ".$tbname." WHERE pitcher ='".$pitcher."'";
$pitches = mysqli_query($conn,$sql);
echo "<table>
<tr>
<th></th>
<th>Total</th>
<th>%</th>
<th>Pop Ups</th>
<th>%</th>
<th>Fly Balls</th>
<th>%</th>
<th>Ground Balls</th>
<th>%</th>
<th>Line Drives</th>
<th>%</th>
</tr>";


echo "<tr>";
$inPlaySql = "SELECT battedBallType, paResult FROM ".$tbname." WHERE pitcher ='".$pitcher."' AND pitchType='".$pitch."' AND pitchResult='IP'";
$inPlay = mysqli_query($conn,$inPlaySql);
$puTotal = $fbTotal = $gbTotal = $ldTotal = $miscTotal = $hitpuTotal = $hitfbTotal = $hitgbTotal = $hitldTotal = 0;
while($inPlayResult = mysqli_fetch_array($inPlay)) {
	if ($inPlayResult["battedBallType"] == "PU") $puTotal++; 
	else if ($inPlayResult["battedBallType"] == "FB") $fbTotal++; 
	else if ($inPlayResult["battedBallType"] == "GB") $gbTotal++; 
	else if ($inPlayResult["battedBallType"] == "LD") $ldTotal++; 
	else {};
	if($inPlayResult["battedBallType"] == "PU" and ($inPlayResult["paResult"] == "S" or $inPlayResult["paResult"] == "D" or $inPlayResult["paResult"] == "T" or $inPlayResult["paResult"] == "HR)")) $hitpuTotal++;
	else if($inPlayResult["battedBallType"] == "FB" and ($inPlayResult["paResult"] == "S" or $inPlayResult["paResult"] == "D" or $inPlayResult["paResult"] == "T" or $inPlayResult["paResult"] == "HR)")) $hitfbTotal++;
	else if($inPlayResult["battedBallType"] == "GB" and ($inPlayResult["paResult"] == "S" or $inPlayResult["paResult"] == "D" or $inPlayResult["paResult"] == "T" or $inPlayResult["paResult"] == "HR)")) $hitgbTotal++;
	else if($inPlayResult["battedBallType"] == "LD" and ($inPlayResult["paResult"] == "S" or $inPlayResult["paResult"] == "D" or $inPlayResult["paResult"] == "T" or $inPlayResult["paResult"] == "HR)")) $hitldTotal++;
	else {};
}
echo "<td>Total</td>";
echo "<td>".($puTotal+$fbTotal+$gbTotal+$ldTotal)."</td>";
echo "<td>".@round(($puTotal+$fbTotal+$gbTotal+$ldTotal)*100.0/mysqli_num_rows($inPlay), 2)."%</td>";
echo "<td>".$puTotal."</td>";
echo "<td>".@round($puTotal*100.0/mysqli_num_rows($inPlay), 2)."%</td>";
echo "<td>".$fbTotal."</td>";
echo "<td>".@round($fbTotal*100.0/mysqli_num_rows($inPlay), 2)."%</td>";
echo "<td>".$gbTotal."</td>";
echo "<td>".@round($gbTotal*100.0/mysqli_num_rows($inPlay), 2)."%</td>";
echo "<td>".$ldTotal."</td>";
echo "<td>".@round($ldTotal*100.0/mysqli_num_rows($inPlay), 2)."%</td>";
echo "</tr>";
echo "<td>Hits %</td>";
echo "<td>".($hitpuTotal+$hitfbTotal+$hitgbTotal+$hitldTotal)."</td>";
echo "<td>".@round(($hitpuTotal+$hitfbTotal+$hitgbTotal+$hitldTotal)*100.0/($puTotal+$fbTotal+$gbTotal+$ldTotal), 2)."%</td>";
echo "<td>".($hitpuTotal)."</td>";
echo "<td>".@round($hitpuTotal*100.0/$puTotal, 2)."%</td>";
echo "<td>".($hitfbTotal)."</td>";
echo "<td>".@round($hitfbTotal*100.0/$fbTotal, 2)."%</td>";
echo "<td>".($hitgbTotal)."</td>";
echo "<td>".@round($hitgbTotal*100.0/$gbTotal, 2)."%</td>";
echo "<td>".($hitldTotal)."</td>";
echo "<td>".@round($hitldTotal*100.0/$ldTotal, 2)."%</td>";
echo "</tr>";
echo "<td>Outs %</td>";

echo "</table>";
mysqli_close($conn);
?>
</body>
</html>
