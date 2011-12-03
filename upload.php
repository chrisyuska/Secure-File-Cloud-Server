<?php

require('db_connect.php');
require('MCrypt.class.php');

//get user connected
$user = mysql_real_escape_string($_GET['user']);

include_once('auth.php');

$mcrypt = new MCrypt($password);

$filename = $mcrypt->decrypt($_FILES['uploadedfile']['name']);

$target_path = "filecloud/" . basename($filename);

//first, check hash to ensure integrity
if (md5($mcrypt->decrypt(file_get_contents($_FILES['uploadedfile']['tmp_name']))) == $_SERVER['HTTP_DIGEST']) {
  if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    $decrypted = $mcrypt->decrypt(file_get_contents($target_path));
    //echo $decrypted;
    file_put_contents($target_path, $decrypted);
    echo $mcrypt->encrypt(basename( $filename)." has been uploaded");
  } else{
    echo $mcrypt->encrypt("There was an error uploading the file, please try again!");
  }
} else {
  //integrity has been lose
  echo "Hashes didn't match";
}

?>

