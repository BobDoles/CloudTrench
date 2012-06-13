<?
ini_set('upload_max_filesize', '300M');
ini_set('post_max_size', '300M');
ini_set('max_input_time', 7000);
ini_set('max_execution_time', 7000);
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
	$dFiles = $row['UFiles'];
  }
  if($Directory != $dDirectory)
{
echo $Directory . " not equal to " . $dDirectory;
echo 'Error: Incorrect directory.<br />Sorry, please log in again <a href="login.php">here</a>';
die();
}
echo "\n";
?>
<!DOCTYPE html>
<html>
<title>Co-Lab the social cloud</title>
<link rel="stylesheet" type="text/css" href="CoLabCSS.css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
function win()
{
}
</script>
<header>Your account</header>
<br />
<body>
<div id="container">
	<div id="header">
		<img src="CoLab.png">
	</div>
	<div id="body">
		<br />
		<center>
		Cloudtrench User Area <br />
		</center>
		<br />
		<br />
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
		<br />
		<br />
		<?
		if($_GET['action']=="upload" || $_GET['action']==null)
		{
		$time = date("Y-m-d H:i:s");
		$time = strtotime($time);
		$Month = date("M");
		$Day = date("d");
		$Year = date("y");
		$Time = date("Hs");
		$EndCode = 0;
		$Month = $Month[0];
		$result = mysql_query("SELECT * FROM Files ORDER BY score DESC");
		while($row = mysql_fetch_array($result))
		  {
		  if($EndCode == 0)
		  {
			$fId = $row['id'];
			$EndCode = $fId;
		  }
		  }
		$FileCode = $Month . $Day . $Year . $EndCode;
		//echo $FileCode;
		echo '<form action="user.php" method="post" enctype="multipart/form-data"> <label for="file">Filename:</label> <input type="file" name="uploadedfile" id="file" /> <input type="submit" value="Upload" id="submit"> </form>';
		$target_path  = $Directory . "/";
		$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
		$filename = basename( $_FILES['uploadedfile']['name']);
		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
		 mysql_query("INSERT INTO Files (id, up, down, date, owner, file, filename, thread, score) VALUES ('', '0', '0', '$time', '$dId', '$target_path', '$filename', '', '0')");
		 $result = mysql_query("SELECT * FROM Files WHERE date='$time' AND owner='$dId' AND file='$target_path'");
		 while($row = mysql_fetch_array($result))
			{
				$dTFId = $row['id'];
			}
			$dFiles = $dTFId . ":" . $dFiles;
			mysql_query("UPDATE Users SET UFiles='$dFiles' WHERE id='$dId'");
		 echo "The file ".  basename( $_FILES['uploadedfile']['name']).
		 " has been uploaded";
		} else{
		 echo "There was an error uploading the file, please try again!";
		}
		}
		else if($_GET['action']=="friends")
		{
		echo "Friends";
		echo '<form action="/user.php?action=friends" method="post">';
		echo 'Enter friends email: <input type="text" id="Email" name="uEmail">';
		echo '<input type="submit" value="Invite friend" id="InviteFriend" name="InviteFriend">';
		echo '</form>';
		if($_POST['InviteFriend'])
		{
		echo "Email entered";
		$uEmail = $_POST['uEmail'];
		$result = mysql_query("SELECT * FROM Users WHERE Email='$uEmail'");
		while($row = mysql_fetch_array($result))
		  {
			$uId = $row['id'];
			$uMisc = $row['Misc'];
		  }
		  $uMisc = $uMisc . ":" . $dId;
		mysql_query("UPDATE Users SET Misc='$uMisc' WHERE Email='$uEmail'");
		}
		}
		?>
		<?
		if($_GET['action']=="upload" || $_GET['action']==null)
		{
		$dFilesT = explode(":", $dFiles);
		$NumberOfFiles = count($dFilesT);
		$x = 0;
		while($x < $NumberOfFiles)
		{
		$result = mysql_query("SELECT * FROM Files WHERE id='$dFilesT[$x]'");
		while($row = mysql_fetch_array($result))
		  {
			$uFileName = $row['filename'];
			$uFileLocation = $row['file'];
		  }
		if($uFileName != null && $uFileName != "" && $uFileName != " " && $uFileName != $uFileNameT)
		{
		echo '<div class="file"> <a href="';
		echo $uFileLocation;
		echo '">' . '<img src="http://cloudtrench.com/' . $uFileLocation . '" width="40px" height="40px" >' . $uFileName . '</a><br><a href="/view.php?page=comments&id=' . $dFilesT[$x] . '">comments</a>';
		$uFileNameT = $uFileName;
		echo '</div> ';
		}
		$x++;
		}
		}
		else if($_GET['action']=="friends")
		{
		$dFriendsT = explode(":", $dMisc);
		$NumberOfFriends = count($dFriendsT);
		$x = 0;
		while($x < $NumberOfFriends)
		{

		$result = mysql_query("SELECT * FROM Users WHERE id='$dFriendsT[$x]'");
		while($row = mysql_fetch_array($result))
		  {
			$uEmail = $row['Email'];
		  }
		if($uEmail != null && $uEmail != "" && $uEmail != " " && $uEmail != $uEmailT)
		{
		echo '<div class="file"> <a href="/view.php?page=user&action=accept&e=';
		echo $uEmail;
		echo '">' . $uEmail . "</a> Wants to be your friend";
		$uEmailT = $uEmail;
		echo '</div> ';
		}
		$x++;
		}


		$dFriends = explode(":", $dFriends);
		$NumberOfFriends = count($dFriends);
		$x = 0;
		while($x < $NumberOfFriends)
		{

		$result = mysql_query("SELECT * FROM Users WHERE id='$dFriends[$x]'");
		while($row = mysql_fetch_array($result))
		  {
			$uEmail = $row['Email'];
		  }
		 if($uEmail != null && $uEmail != "" && $uEmail != " " && $uEmail != $uEmailT)
		{ 
		echo '<div class="file"> <a href="/view.php?userid=';
		echo $dFriends[$x];
		echo '">' . $uEmail . "</a>";
		$uEmailT = $uEmail;
		echo '</div> ';
		}
		$x++;
		}
		}
		else if($_GET['action'] == "groups")
		{
		echo "Create group";
		echo '<form action="/user.php?action=groups" method="post">';
		echo 'Group name: <input type="text" id="uGroupName" name="uGroupName">';
		echo '<input type="submit" value="Create Group" id="CreateGroup" name="CreateGroup">';
		echo '</form>';
		if($_POST['CreateGroup'])
		{
		echo "Group name entered";
		$uGroupName = $_POST['uGroupName'];
		$time = date("Y-m-d H:i:s");
		$time = strtotime($time);
		mysql_query("INSERT INTO Groups (id, owner, members, up, down, score, title, description, files, date) VALUES ('', '$dId', '$dId', '0', '0', '0', '$uGroupName', '$uGroupName', '', '$time')");


		$result = mysql_query("SELECT * FROM Groups WHERE owner='$dId' AND date='$time'");
		while($row = mysql_fetch_array($result))
		  {
			$gId = $row['id'];
		  }
		  $uGroups = $dGroups . ":" . $gId;
		  mysql_query("UPDATE Users SET Groups='$uGroups' WHERE id='$dId'");
		}


		$dGroupsT = explode(":", $dGroups);
		$NumberOfGroups = count($dGroupsT);
		$x = 0;
		while($x < $NumberOfGroups)
		{

		$result = mysql_query("SELECT * FROM Groups WHERE id='$dGroupsT[$x]'");
		while($row = mysql_fetch_array($result))
		  {
			$uGroupI = $row['id'];
			$uGroupT = $row['title'];
			$uGroupD = $row['description'];
		  }
		if($uGroupI != null && $uGroupI != "" && $uGroupI != " " && $uGroupI != $uGroupIT)
		{
		echo '<div class="file"> <a href="/view.php?groupid=';
		echo $dGroupsT[$x];
		echo '">' . $uGroupT . "</a> ~ '$uGroupD'";
		$uGroupIT = $uGroupI;
		echo '</div> ';
		}
		$x++;
		}
		}
		?>
		</div>
</body>
	<div id="footer">
		<center>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="DSLPQ7NLC6H4N">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
		</center>
	</div>
</html>
<?
ob_end_flush(); // Flush the output from the buffer
?>