<?PHP

//specify database connection
$con = mysql_connect("localhost","cse651","Buckeyes");

//if can't make connection, die
if (!$con)
{
        die('Could not connect: ' . mysql_error());
}

//select database
mysql_select_db("apps", $con);

?>
