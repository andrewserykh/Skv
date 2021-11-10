<?
include('initdb.php');  

$count=0; $sql0='SELECT `url` AS `url` FROM `googlesheets` WHERE `id`='.$_POST[googlesheet];
$res0=mysql_query($sql0);
while ($r0=mysql_fetch_array($res0)) $url=$r0[url];

$return = 1;
$charset_in = "UTF-8";
$charset = "UTF-8";

include("process_parse.php");

?>