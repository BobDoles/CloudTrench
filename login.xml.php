<?php
//Make the content type xml using headers
header("Content-Type:text/xml");
mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("Schooledcloud") or die(mysql_error());
echo '<?xml version="1.0" encoding="utf-8"?><loginstatuas';
echo "\n";
//Login check
$Email = $_GET['email'];
$Password = $_GET['password'];
$dPassword = null;
$result = mysql_query("SELECT * FROM Users WHERE Email='$Email'");
while($row = mysql_fetch_array($result))
  {
	$dPassword = $row['Password'];
	$dDirectory = $row['directory'];
  }
if($Password == $dPassword && $Password != null && $Password != "")
{
echo 'data="true"';
echo "\n";
echo 'directory="' . $dDirectory . '"';
}
else
{
echo 'data="Incorrect information"';
}
echo "\n";
?>
/>