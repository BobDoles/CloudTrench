<?
ob_start(); // Initiate the output buffer
mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("Schooledcloud") or die(mysql_error());
echo "\n";
//Login check
$Email = $_COOKE['Email'];
$Password = $_COOKIE['Password'];
$Directory = $_COOKIE['Directory'];
//echo $Email . $Password;
$dPassword = null;
$result = mysql_query("SELECT * FROM Users WHERE Password='$Password'");
while($row = mysql_fetch_array($result))
  {
	$dDirectory = $row['directory'];
	$dFriends = $row['Friends'];
	$dId = $row['id'];
	$dMisc = $row['Misc'];
  }
  if($Directory != $dDirectory)
{
echo $Directory . " not equal to " . $dDirectory;
echo 'Error: Incorrect directory.<br>Sorry, please log in again <a href="login.php">here</a>';
die();
}
echo "\n";
?>
<!DOCTYPE html>
<html>
<title>Co-Lab the social cloud</title>
<link rel="stylesheet" type="text/css" href="CoLabCSS.css" />
<header>Your account</header>
<br>
<body>
<div id="container">
	<div id="header">
		<img src="CoLab.png">
	</div>
	<div id="body">
		<br>
		<center>
		Cloudtrench User Area <br>
		</center>
		<br>
		<br>
		<div class="filebox">
		<div class="useractions" onClick="location.href='http://cloudtrench.com/home.php'">
		<center>Front page</center>
		</div>
		<div class="useractions" onClick="location.href='http://cloudtrench.com/user.php?action=upload'">
		<center>Upload</center>
		</div>
		<div class="useractions" onClick="location.href='http://cloudtrench.com/user.php?action=friends'">
		<center>Friends</center>
		</div>
		<div class="useractions" onClick="location.href='http://cloudtrench.com/user.php?action=groups'">
		<center>Groups</center>
		</div>
		<br>
		<br>
		<?
		//Front page algorithm
		$time = date("Y-m-d H:i:s");
		$time = strtotime($time);
		$time = $time - 3600;
		$x = 0;
		$stop = 0;
		$result = mysql_query("SELECT * FROM Groups ORDER BY score DESC");
		while($row = mysql_fetch_array($result))
		  {
			if($x<20)
			{
			echo '<div class="file"><img src="http://upload.wikimedia.org/wikipedia/commons/b/be/Aiga_uparrow_inv.gif" width="20" height="20"><a href="/';
			$uFileLocations = $row['id'];
			$uFileName = $row['title'];
			$uUp = $row['up'];
			$uDown = $row['down'];
			$uDate = $row['date'];
			
			$Rating = 800/(($uUP + $uDown) + $uUp);
			echo $uFileLocations;
			echo '">' . $uFileName . "</a>";
			echo '</div> ';
			$x++;
			}
			else
			{
			$stop = 1;
			}
		  }
		  //End of front page algorithm
		?>
		</div>
	</div>
	<div id="footer">
	</div>
</div>
</body>
</html>
<?
ob_end_flush(); // Flush the output from the buffer
?>