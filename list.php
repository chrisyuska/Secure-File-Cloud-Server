<?PHP 

$start = "filecloud/"; 
$handle = opendir($start); 
$fullStart = "http://chrisyuska.com/cse651/".$start; 

# Making an array containing the files in the current directory: 
while ($folder = readdir($handle)) 
{ 
    $folders[] = $folder; 
} 
closedir($handle); 

# subtract two for . and ..
$num = count($folders) - 2;

$retstr = "<results status=\"success\" count=\"$num\">";

#echo the files 
foreach ($folders as $folder) { 
    if ($folder != "." && $folder != "..") {
        $size = stat($start.$folder);
	$size = $size[7];
        $retstr .= "<result><name>$folder</name><location>$fullStart$folder</location><size>$size</size></result>";
    }
} 
    $retstr .= "</results>";

    echo $retstr;
?>
