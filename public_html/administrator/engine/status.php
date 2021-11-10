<?php
include('initdb.php'); 
$car=$_POST[car];
$in='(';
foreach ($_POST as $name=>$val) if (($name!="sub")&&($name!="car")) $in.="$val,";
$in.=')';	$in=str_replace(',)',')',$in);
//echo $in;
$res=mysql_query($sql); 
mysql_query("update orders set car_id=$car where id in $in");
header("Location: table.php?tbl=orders");
?>