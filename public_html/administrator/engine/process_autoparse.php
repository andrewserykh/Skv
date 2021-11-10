<?
/*
Автозагрузка данных из Google.Таблицы
*/

include('initdb.php');  

$count=0; $sql0='SELECT * FROM `googlesheets_setup`';
$res0=mysql_query($sql0);
while ($r0=mysql_fetch_array($res0)) $sheet_id = $r0[googlesheets_id];

$count=0; $sql0='SELECT `url` AS `url` FROM `googlesheets` WHERE `id`='.$sheet_id ;
$res0=mysql_query($sql0);
while ($r0=mysql_fetch_array($res0)) $url=$r0[url];

$return = 0;
$charset_in = "UTF-8";
$charset = "UTF-8";

include("process_parse.php");

?>