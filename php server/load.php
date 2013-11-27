<!DOCTYPE html>
<html>
  <head>
	<title>load</title>
  </head>
  <body>
<?php
$link = mysql_connect('localhost', 'skyl', 'skyl1234');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_select_db('sdcrimezone'); 

if ($handle = fopen("resources/complete.txt", "r")) {
    while (($data = fgetcsv($handle, 80, ","))) {
         $date = $data[0];
		 $time = $data[1];
		 $code = $data[2];
		 $address = $data[3];
		 $latitude = $data[4];
		 $longitude = $data[5];
		 $datetime = new DateTime($date . ' ' . $time);
		 $query1 = "INSERT into Incidents (Address, BccCode, Date, Latitude, Longitude, Year) ";
		 $query2 = "VALUES ('$address', '$code', '" . $datetime->format("Y-m-d H:i:s") . "', $latitude, $longitude, '2011')";
		 
		 $query = $query1 . $query2;
		 $result = mysql_query($query);
		 
		 if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		 }
		 else {
		  echo $query . "<br />\n";
		 }
    }
    fclose($handle);
}
mysql_close($link);
?>
  </body>
</html>