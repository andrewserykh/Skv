<?
include_once("initdb.php");

$count=0;
$sql0='SELECT * FROM `topmenu` WHERE `url` LIKE("root")';
$res0=mysql_query($sql0);
while ($r0=mysql_fetch_array($res0)){$count++;}

if ($count==0){
  $sql0="INSERT INTO `topmenu` (`id`, `title`, `url`, `descr`, `topmenu_id`, `sort`) VALUES (NULL, 'Корневой пункт', 'root', NULL, NULL, '0');";
  $res0=mysql_query($sql0);
}

header("Location: /administrator/engine/table.php?tbl=topmenu");
?>


