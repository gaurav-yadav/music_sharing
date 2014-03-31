<?php
include 'main.html';
$conn_error = 'Could not connect.';

$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '';
$mysql_db ='ita';
@mysql_connect($mysql_host, $mysql_user, $mysql_pass) or die($conn_error);
@mysql_select_db($mysql_db) or die($conn_error );

$fname=$_POST['img'];
$mail=$_POST['mail'];
$pwd=$_POST['pwd'];
//READ THE FILE
$file = file_get_contents("./$fname", true);
//STEPS CHECK IF PRODUCER OR CUSTOMER OR NONE
$x=substr($file,38,8);//a hash .. find who's?
if($x=='producer')//----------------------PRODUCER TO CUSTOMER----------------------
{
echo 'producer';
$str=$mail;
$str.=$pwd;
$hash =md5($str);
echo $hash;
$chash=$hash; ///save hsh to update tble..

//add mail +pwd hash to file and save 
$new="  <---customer";
$hash.=$new;
$hash.=$file;
file_put_contents($fname, $hash);
//done

$x1=substr($file,0,32);
$query="SELECT `hash`,`amt` from txn WHERE `hash`='$x1'";
echo "<br>the value of x1 is" ,$x1;
if($query_run=mysql_query($query))
  {
  echo "found  producer hash in txn table";
		//PAY PRODUCER.. update db
		//GET PREV BAL FOR THAT HASH ADD 100 TO IT PASS TO UPDATE ..---------------------------------------->
		$query="SELECT `amt` FROM txn where `hash`='$x1'"; //RUN THE QUERY AFTER THIS,..  SA,ME FOR OTHER 3 BELOW
		$query_run=mysql_query($query);
		while($query_row=mysql_fetch_assoc($query_run))
	{
		$amt=$query_row['amt'];
		}
		$amt=$amt+100;
		$query="UPDATE  `txn` SET  `amt` ='$amt' WHERE  `hash` ='$x1'";
		if($query_run=mysql_query($query))
			{
			echo "  <br>updated txn table producer is paid<br>  ";
			}
			else
			{
			echo "cannot update";
			}
		//INSERT NEW CUSTOMER DETAILS IN TXN
$query="INSERT INTO `txn`(`sname`, `hash`, `amt`, `umail`, `upwd`) VALUES ('$fname','$chash',0,'$mail','$pwd')";
		if($query_run=mysql_query($query))
			{
			echo "  <br>updated txn table customer is created<br>  ";
			}
			else
			{
			echo "cannot create new customer";
			}
  }
  else
  {
  echo "cant get hash";
  }
//new row for current owner with tag
}
else if($x=='customer')//--------------------------------------CUSTOMER-CUSTOMER------------------
{

echo 'customer';
echo "<br>";

//add to txn both producer and cutomer
$chash=substr($file,0,32);
$phash=substr($file,46,32);

$query="SELECT `amt` FROM txn where `hash`='$chash'";
$query_run=mysql_query($query);
		while($query_row=mysql_fetch_assoc($query_run))
	{
		$amt=$query_row['amt'];
		}
		$amt=$amt+25;
$query="UPDATE  `txn` SET  `amt` ='$amt' WHERE  `hash` ='$chash'"; 
		if($query_run=mysql_query($query))
			{
			echo "  <br>updated txn table customer commision is paid<br>  ";
			}
			else
			{
			echo "cannot update";
			}
			
			//producer paid
			$query="SELECT `amt` FROM txn where `hash`='$phash'";
			$query_run=mysql_query($query);
		while($query_row=mysql_fetch_assoc($query_run))
	{
		$amt=$query_row['amt'];
		}
		$amt=$amt+75;
			
$query="UPDATE  `txn` SET  `amt` ='$amt' WHERE  `hash` ='$phash'";
		if($query_run=mysql_query($query))
			{
			echo "  <br>updated txn table producer is paid his 75 %<br>  ";
			}
			else
			{
			echo "cannot update";
			}			
			
			

$filenew=substr($file,46);

$str=$mail;
$str.=$pwd;
$hash =md5($str);
//create new row for new customer in txn
$query="INSERT INTO `txn`(`sname`, `hash`, `amt`, `umail`, `upwd`) VALUES ('$fname','$hash',0,'$mail','$pwd')";
		if($query_run=mysql_query($query))
			{
			echo "  <br>updated txn table customer is created<br>  ";
			}
			else
			{
			echo "cannot create new customer";
			}

echo "<br>";
echo $hash;
echo "<br>";
//append file string to hash
$new="  <---customer";
$hash.=$new;
$hash.=$filenew;
$print=substr($hash,0,92);
file_put_contents($fname, $hash);
//$print=substr($hash,0,792);
echo "<br>";
echo "the starting of file is now " , $print;
echo "<br>";
//customer part replace hash with mail + pwd hash
}
else
{
echo 'illegal';
//illegal copy
}

/*

//$file1=$_POST['img'];
$mail.=$pwd;
$h2=md5($mail);

$file = file_get_contents("./$fname", true);
//echo $file;
$hash= md5($file);
$fname2=$fname;
$fname2.=$hash;
//$hash=md5($fname)
$query ="INSERT INTO acc VALUES('$hash','$fname','$fname2')" or die( "value errors");
$query="SELECT `hash`,`name` FROM `acc` WHERE `hash`='$hash'";

if($query_run=mysql_query($query))
  {
 echo '<fieldset >
	<table  border="1">
	<tr>
    <th><label for="hash">hash</label></th>
    <th ><label for="name"> Name</label></th>
	</tr>';
	
	while($query_row=mysql_fetch_assoc($query_run))
	{
		$hash=$query_row['hash'];
		$name=$query_row['name'];
		echo '<tr>
    <td><label for="cid">'.$hash.'</label></td>
    <td ><label for="name">'.$name.'</label></td>
	</tr>';
		
	}
	echo '</table>
	</fieldset>';
	
	echo "your unique hash ", $h2;
	//echo $file1;
  }
  
	
	*/

?>