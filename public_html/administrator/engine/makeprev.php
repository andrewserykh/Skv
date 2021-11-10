<?php
include('initdb.php'); 
include('resize.php'); 
//$pic_path="../../pics/";
$res=mysql_query("select pic FROM pic");
if ($res) while ($img=mysql_fetch_array($res)){
	createpreview($pic_path.$img[pic],312);
	createpreview($pic_path.$img[pic],90);
}
header("Location: table.php?tbl=pic&mp=$res");
?>