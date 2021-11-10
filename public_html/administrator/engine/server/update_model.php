<?
header('Content-type: text/html; charset=utf-8');
include("../initdb.php");
$value=$_GET[value]; $id=$_GET[id]; $fldn=$_GET[fldn]; //$model=$_GET[model];
 $sql="update vmodel set $fldn='$value' where id=$id";
 mysql_query($sql);	
?>