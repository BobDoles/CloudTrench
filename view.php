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
	$dGroups = $row['Groups'];
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
			Front page
			</div>
			<div class="useractions" onClick="location.href='http://cloudtrench.com/user.php?action=upload'">
			Upload
			</div>
			<div class="useractions" onClick="location.href='http://cloudtrench.com/user.php?action=friends'">
			Friends
			</div>
			<div class="useractions" onClick="location.href='http://cloudtrench.com/user.php?action=groups'">
			Groups
			</div>
			<br>
			<br>
			<?
			//Content for the group/user/posts go here
			echo '<div class="viewcontainer">';
			if($_GET['page'] == "user")
			{
			if($_GET['action'] == "accept")
			{
			//First check if friend sent request, if yes then accept and add to both user's tables
			//Get id of user
			$rId = $_GET['e'];
			$result = mysql_query("SELECT * FROM Users WHERE Email='$rId'");
			while($row = mysql_fetch_array($result))
			  {
				$rdId = $row['id'];
				$rdMisc = $row['Misc'];
				$rdFriends = $row['Friends'];
			  }
			  echo $rdId;
			  $x = 0;
			  $uRequests = explode(":", $dMisc);
			  $y = count($uRequests);
			  $true = 0;
			  while($x < $y && $true == 0)
			  {
			  if($uRequests[$x] == $rdId)
			  {
			  $true = 1;
			  }
			  $x++;
			  }
			  if($true == 1)
			  {
				//User has recieved request from new friend
				$x = 0;
				$CleanUpUser = explode(":", $dMisc);
				$y = count($CleanUpUser);
				while($x < $y)
				{
				echo $dMisc;
				//Add every id to the list other than the new friend
				if($CleanUpUser[$x] != $rdId && $CleanUpUser[$x] != "")
				{
					//User's new list complete
					$NewMisc = $NewMisc . ":" . $CleanUpUser[$x];
				}
				$x++;
				}
				echo "<br>";
				echo $NewMisc;
				echo "<br>";
				//Friend doesn't need that list
				//Update user's Misc list
				mysql_query("UPDATE Users SET Misc='$NewMisc' WHERE id='$dId'");
				//We need to update both friends lists
				$dNewFriendsList = $dFriends . ":" . $rdId;
				mysql_query("UPDATE Users SET Friends='$dNewFriendsList' WHERE id='$dId'");
				$rdNewFriendsList = $rdFriends . ":" . $dId;
				mysql_query("UPDATE Users SET Friends='$rdNewFriendsList' WHERE id='$rdId'");
				//Done.
				echo "New friend added";
			  }
			  else
			  {
			  echo "Friend has not sent you a friend request";
			  }
			}
			}
			else if($_GET['page']=="comments")
			{
			if($_GET['id'] != null && $_GET['id'] != "" && $_GET['id'] != " ")
			{
				$TId = $_GET['id'];
				$result = mysql_query("SELECT * FROM Files WHERE id='$TId'");
			while($row = mysql_fetch_array($result))
			  {
				$rdId = $row['id'];
				$rdMisc = $row['Misc'];
				$rdFriends = $row['Friends'];
			  }
			}
			}
			echo '</div>';
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