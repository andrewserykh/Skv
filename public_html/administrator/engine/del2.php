<?php
include('initdb.php'); 
$in='(';
foreach ($_POST as $name=>$val) if (($name!="sub")&& $name!="tbl") $in.="$val,";
$in.=')';	$in=str_replace(',)',')',$in);
$sql="delete from $tbl where id in $in"; 
$res= mysql_query($sql);
header("Location: table.php?tbl=$tbl");
?>