<?php

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
  readfile( $filename );
  exit;
}

header( 'HTTP/1.1 404 Not Found' );

echo "File not found";
exit;

?>

