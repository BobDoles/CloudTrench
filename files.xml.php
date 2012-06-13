<?php
header("Content-Type:text/xml");
$UDirectory = $_GET['directory'];

mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("Schooledcloud") or die(mysql_error());
echo '<?xml version="1.0" encoding="utf-8"?><files';
echo "\n";

// open this directory 
$myDirectory = opendir($UDirectory);

// get each entry
while($entryName = readdir($myDirectory)) {
	$dirArray[] = $entryName;
}

// close directory
closedir($myDirectory);

//	count elements in array
$indexCount	= count($dirArray);

// sort 'em
sort($dirArray);

// loop through the array of files and print them all
for($index=0; $index < $indexCount; $index++) {
        if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
		echo 'id' . $index . '="';
		echo "$dirArray[$index]";
		echo '"';
		echo "\n";
		//print(filetype($dirArray[$index]));
	}
}
echo 'id' . $index . '="._EOF_."';
echo "\n";
?>
/>