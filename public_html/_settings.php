<?
$sql0 = "SELECT * FROM `settings` WHERE `id`=1";
$res0 = mysql_query($sql0);
if ($res0) $settings=mysql_fetch_array($res0);
?>