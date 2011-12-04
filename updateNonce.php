<?PHP

if ($user_nonce != $nonce) {
  //invalid query
  die("Query failed");
} else {
  //update nonce with hash of old+salt
  $qry = "UPDATE secure_file_cloud SET Nonce = '".md5($nonce."aAs329A0fh")."' WHERE Username='".$user."'";
  
  mysql_query($qry);
}

mysql_close($con);

$nonce = md5($nonce."aAs329A0fh");
?>
