<?php
ini_set('upload_max_filesize', '300M');
ini_set('post_max_size', '300M');
ini_set('max_input_time', 700);
ini_set('max_execution_time', 700);
$UDirectory = $_GET['directory'];
$target_path  = $UDirectory . "/";
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
 echo "The file ".  basename( $_FILES['uploadedfile']['name']).
 " has been uploaded";
} else{
 echo "There was an error uploading the file, please try again!";
}
?>