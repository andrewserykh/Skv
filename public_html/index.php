<?
include_once("administrator/engine/initdb.php"); //инициализация БД
include_once("administrator/engine/resize.php"); //работа с изображениями
error_reporting( E_ERROR );

$params = $_GET[params];
$params=rtrim($params,'/');
$par=explode('/',$params);
$pg=$par[0];
if ($pg=="") $pg="main";

include ("_settings.php");
include ("_top.php");
include ("_content.php");
include ("_footer.php");
?>