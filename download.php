<?php

require('db_connect.php');
require('MCrypt.class.php');

//get user connected
$user = mysql_real_escape_string($_GET['user']);

include_once('auth.php');

$mcrypt = new MCrypt($password);

$filename = 'filecloud/' . basename( $_GET['filename'] );

if( file_exists( $filename ) ) {
  $finfo = finfo_open( FILEINFO_MIME );
  header( 'Content-Disposition: attachment; filename= ' . basename( $filename ) );
  header( 'Content-Type: ' . finfo_file( $finfo, $filename ) );
  header( 'Content-Length: ' . filesize( $filename ) );
  header( 'Expires: 0' );
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

