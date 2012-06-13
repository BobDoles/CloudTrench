<?php
mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("Schooledcloud") or die(mysql_error());
$Email = $_GET['email'];
$Password = $_GET['password'];
$Directory = md5(rand(0, 70) . rand(0, 70) . $Email . rand(0, 70) . rand(0, 70) . $Email);
echo $Directory;
mysql_query("INSERT INTO Users (id, Email, Password, LoginKey, ExpireKey, directory, Friends, Misc, Groups) VALUES ('', '$Email', '$Password', '', '', '$Directory', '', '', '')");
mkdir($Directory ."/" , 0777);
echo "User registered";
?>
