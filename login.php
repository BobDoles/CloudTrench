<?
ob_start(); // Initiate the output buffer
mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("Schooledcloud") or die(mysql_error());
echo "\n";
//Login check
$Email = $_POST['email'];
$Password = $_POST['password'];
$CookieEmail = $_COOKIE['Email'];
$CookiePassword = $_COOKIE['Password'];
//echo $Email . $Password;
if($CookieEmail != null)
{
$dPassword = null;
$result = mysql_query("SELECT * FROM Users WHERE Email='$CookieEmail'");
while($row = mysql_fetch_array($result))
  {
	$dPassword = $row['Password'];
  }
  if($dPassword == $CookiePassword)
  {
   header('Location: http://cloudtrench.com/user.php');
  }
  else
  {
  $dPassword = null;
  }
}
if($Email != null || $Email != "" || $Email != " ")
{
$dPassword = null;
$result = mysql_query("SELECT * FROM Users WHERE Email='$Email'");
while($row = mysql_fetch_array($result))
  {
	$dPassword = $row['Password'];
	$dDirectory = $row['directory'];
  }
if($Password == $dPassword && $Password != null && $Password != "")
{
setcookie("Email", $Email, time()+3600);  /* expire in 1 hour */
setcookie("Password", $Password, time()+3600);  /* expire in 1 hour */
setcookie("Directory", $dDirectory, time()+3600);  /* expire in 1 hour */
header('Location: http://cloudtrench.com/user.php');
echo 'data="true"';
echo "\n";
echo 'directory="' . $dDirectory . '"';
}
else
{
//echo 'data="Incorrect information"';
}
echo "\n";
}
?>
<!DOCTYPE html>
<html>
<title>Co-Lab the social cloud</title>
<link rel="stylesheet" type="text/css" href="CoLabCSS.css" />
<header><a href='login.php'>Login</a> / <a href='register.php'>Register</a></header>
<br>
<body>
<div id="container">
	<div id="header">
		<img src="CoLab.png">
	</div>
	<div id="body">
		<br>
		<center>
		<form action="login.php" id="login_area" method="POST">
		Login<br>
		Email: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="email" value="" id="email" name="email"> <br>
		Password:<input type="password" value="" id="password" name="password"> <br>
		<input type="submit" value="Login" id="submit">
		</form>
		</center>
	</div>
	<div id="footer">
	</div>
</div>
</body>
</html>
<?
ob_end_flush(); // Flush the output from the buffer
?>