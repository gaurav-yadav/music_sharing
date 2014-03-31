<?php
include 'index.html';
$conn_error = 'Could not connect.';

$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '';
$mysql_db ='ita';
@mysql_connect($mysql_host, $mysql_user, $mysql_pass) or die($conn_error);
@mysql_select_db($mysql_db) or die($conn_error );



$fname=$_POST['song'];
$producer=$_POST['producer'];
$singer=$_POST['singer'];
$file = file_get_contents("./$fname", true);
//echo $file;
$hash= md5($file);

$query ="INSERT INTO producer VALUES('$fname','$hash','$producer','$singer')" or die( "value errors");
$x=substr($file,38,8);
echo "<br>";
echo "the substr is" , $x;
echo "<br>";
if($x=='producer')
{
echo 'dupliate entry';
}
else
{
if($query_run=mysql_query($query))
  {
  
  //add deTAILS TO TXN DB ALSO TO GET PAYMENTS..
  $query ="INSERT INTO txn VALUES('$fname','$hash',0,'','')" or die( "value errors");
   if($query_run=mysql_query($query)){
  echo '<script type="text/javascript">
		alert("Song Added");
		</script>
		';
		echo "hi";
	}
	else
	{
	echo "unable to insert into txn";
	}
	}
	else
	
	{
	echo '<script type="text/javascript">
		alert("song not Added");
		</script>
		';
		echo "no hi";
	}
	echo "<br>";
	
$new="  <---producer";
$hash.=$new;
$hash.=$file;
	echo "<br>";
//echo $hash;
	echo "<br>";
	file_put_contents($fname, $hash);
	}
?>