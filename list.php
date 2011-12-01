<?PHP 

require('db_connect.php');
require('MCrypt.class.php');

//get user connected
$user = mysql_real_escape_string($_GET['user']);

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


$start = "filecloud/"; 
$handle = opendir($start); 
$fullStart = "http://chrisyuska.com/cse651/".$start; 

// Making an array containing the files in the current directory: 
while ($folder = readdir($handle)) 
{ 
  $folders[] = $folder; 
} 
closedir($handle); 

// subtract two for . and ..
$num = count($folders) - 2;

$retstr = "<results status=\"success\" count=\"$num\">";

// echo the files 
foreach ($folders as $folder) { 
  if ($folder != "." && $folder != "..") {
    $size = stat($start.$folder);
    $size = $size[7];
    $retstr .= "<result><name>$folder</name><location>$fullStart$folder</location><size>$size</size></result>";
  }
} 
  $retstr .= "</results>";
  $mcrypt = new MCrypt($password);
  //Encrypt
  $encrypted = $mcrypt->encrypt($retstr);

  echo $encrypted;

mysql_close($con);

?>
