<?PHP

require('MCrypt.class.php');

$mcrypt = new MCrypt("Buckeyes12345678");

$filename = 'filecloud/second.txt';

echo $mcrypt->encrypt('test.foo');
echo "\r\n\r\n";

//echo file_get_contents($filename);
//echo $mcrypt->encrypt(file_get_contents($filename));

//echo "\r\n\r\n";
//echo file_get_contents('filecloud/first.txt');
?>
