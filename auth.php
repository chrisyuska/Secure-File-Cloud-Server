<?PHP

//validate user
$qry = "SELECT * FROM secure_file_cloud WHERE Username='".$user."'";
$result = mysql_query($qry);

//get user info for encrypting
if ($result) {
  if (mysql_num_rows($result) == 1) {
    //user exists
    $row = mysql_fetch_array($result);
    $password = $row['Password'];
    $nonce = $row['Nonce'];
  } else {
    //user doesn't exist
    die("Query failed");
  }
} else {
  die("Query failed");
}

?>
