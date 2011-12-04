<?php

require('db_connect.php');
require('MCrypt.class.php');

//get user connected
$user = mysql_real_escape_string($_GET['user']);

include_once('auth.php');

$mcrypt = new MCrypt($password);

$user_nonce = $mcrypt->decrypt($_SERVER['HTTP_NONCE']);

//NOTE: always updating currently (aka will be buggy if attacked or comm dropped)
include_once('updateNonce.php');

$filename = $mcrypt->decrypt($_FILES['uploadedfile']['name']);

$target_path = "filecloud/" . basename($filename);

//first, check hash to ensure integrity
if (md5($mcrypt->decrypt(file_get_contents($_FILES['uploadedfile']['tmp_name']))) == $_SERVER['HTTP_DIGEST']) {
  if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    $decrypted = $mcrypt->decrypt(file_get_contents($target_path));
    file_put_contents($target_path, $decrypted);
    echo $mcrypt->encrypt(basename( $filename)." has been uploaded".$nonce);
  } else{
    echo $mcrypt->encrypt("There was an error uploading the file, please try again!".$nonce);
  }
} else {
  //integrity has been lose
  echo "Hashes didn't match".$nonce;
}

?>

