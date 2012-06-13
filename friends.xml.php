<?php
//Make the content type xml using headers
header("Content-Type:text/xml");
mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("Schooledcloud") or die(mysql_error());
echo '<?xml version="1.0" encoding="utf-8"?><friends';
echo "\n";


$Directory = $_GET['directory'];
$dFriends = null;
$result = mysql_query("SELECT * FROM Users WHERE directory='$Directory'");
while($row = mysql_fetch_array($result))
  {
	$dFriends = $row['Friends'];
  }
  
  $FriendArray = explode(":", $dFriends);
  $x = count($FriendArray);
  $y = 0;
  while($x > $y)
  {
  echo 'id' . $y . '="';
  echo $FriendArray[$y];
  echo '"';
  echo "\n";
  $y++;
  }
  echo 'id' . $y . '="._EOF_."';
  echo "\n";
?>
/>