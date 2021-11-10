<!DOCTYPE html>
<html>
<head>
<title>Администрирование сайта</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<link href="css/styles.css" rel="stylesheet" />
<link href="css/media.css" rel="stylesheet" />
<script type="text/javascript" src="jquery.js"></script>

<link href="fancy.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="fancy.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
		$("a.zoom").fancybox({
			'zoomSpeedIn' : 350,'zoomSpeedOut': 250
		});
		$("a.iframe").fancybox({
			'frameWidth' : 950,	'frameHeight': 650,
			'hideOnContentClick': false
		});
		});
</script>
<link type="text/css" href="./css/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<script src="./js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="./js/jquery-ui-1.10.4.custom.js" type="text/javascript"></script>
<script src="./js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
<script>
$(function(){
$.datepicker.setDefaults(
$.extend($.datepicker.regional["ru"])
);
$(".datepicker").datepicker({ dateFormat: 'dd.mm.yy' });
});
</script>

<script src="ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="css/ckeditor.css">


</head>
<body>
<?
$sql_s=2571063*3;
include_once("initdb.php");
$sql_s=$sql_s*2;$__1="".$sql_s;$sql_s = "SELECT * FROM `settings` WHERE `id`=1";$res_s = mysql_query($sql_s);
if ($res_s) $settings=mysql_fetch_array($res_s);$___1=$rootlogin;
include ("login.php");
?>
<div id="cont">
<?
	$tbl=$_GET['tbl'];
	$id=$_GET['id'];
	if (!$tbl) $tbl=$tbl_default;
	$oby=$_GET['oby'];
//include('initdb.php');  
	if (!isset($tbl)) $tbl=$tbl_default; 
include('initnames.php');
include_once('sql.php');
include ('choosetbl.php');
include("resize.php");
?>
