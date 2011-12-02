<?PHP 

require('db_connect.php');
require('MCrypt.class.php');

//get user connected
$user = mysql_real_escape_string($_GET['user']);

include_once('auth.php');

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
