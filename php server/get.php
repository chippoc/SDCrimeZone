<?php
if (isset($_GET['lat']) && isset($_GET['lng'])) {
  $lat = $_GET['lat'];
  $lng = $_GET['lng'];
  $rad = 1;
  if (isset($_GET['rad'])) {
	$rad = $_GET['rad'];
  }
  
  if (is_numeric($lat) && is_numeric($lng) && is_numeric($rad)) {
	$link = mysql_connect('mysql.gardenmetrics.com', 'skyl', 'skyl1234');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('sdcrimezone');
	$query = "SELECT address, bcccode as bcc, year, longitude as lng, latitude as lat, (3959 * acos(cos(radians($lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($lng) ) + sin(radians($lat)) * sin(radians(latitude)))) AS distance FROM Incidents HAVING distance < $rad";
	$result = mysql_query($query);
	
	if (!$result) {
	  $message  = 'Invalid query: ' . mysql_error() . "\n";
	  $message .= 'Whole query: ' . $query;
	  die($message);
	}
	else {
	  $rows = array();
	  while($r = mysql_fetch_assoc($result)) {
		$rows[] = $r;
	  }
	  print json_encode($rows);
	}
  }
}
?>
  </body>
</html>