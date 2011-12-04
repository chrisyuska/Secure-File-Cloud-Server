<?php

require('db_connect.php');
require('MCrypt.class.php');

//get user connected and corresponding nonce
$user = mysql_real_escape_string($_GET['user']);

include_once('auth.php');

$mcrypt = new MCrypt($password);

$user_nonce = $mcrypt->decrypt($_GET['nonce']);

include_once('updateNonce.php');

$filename = 'filecloud/' . basename( $mcrypt->decrypt($_GET['filename']));

if( file_exists( $filename ) ) {
  $finfo = finfo_open( FILEINFO_MIME );
  header('Content-Disposition: attachment; filename= ' . $mcrypt->encrypt(basename($filename)));
  header( 'Content-Type: ' . finfo_file( $finfo, $filename ) );
  header( 'Content-Length: ' . filesize( $filename ) );
  header( 'Expires: 0' );
  header( 'digest: ' . md5_file($filename));
  header( 'nonce: ' . $mcrypt->encrypt($nonce)); 
  finfo_close( $finfo );

  /**
  * Now clear the buffer, read the file and output it to the browser.
  */
  ob_clean( );
  flush( );
  echo $mcrypt->encrypt(file_get_contents($filename));
  exit;
}

header( 'HTTP/1.1 404 Not Found' );

echo "File not found";
exit;

?>

