<?
include_once("initdb.php");
include_once("resize.php");
require('simple_html_dom.php');
error_reporting( E_ERROR );

$sql0="TRUNCATE TABLE  `objects`"; $res0=mysql_query($sql0);

$sql0="TRUNCATE TABLE  `decore`"; $res0=mysql_query($sql0);

$sql0="TRUNCATE TABLE  `developer`"; $res0=mysql_query($sql0);

$sql0="TRUNCATE TABLE  `finish`"; $res0=mysql_query($sql0);

$sql0="TRUNCATE TABLE  `objects`"; $res0=mysql_query($sql0);

$sql0="TRUNCATE TABLE  `region`"; $res0=mysql_query($sql0);

$sql0="TRUNCATE TABLE  `rooms`"; $res0=mysql_query($sql0);

$sql0="TRUNCATE TABLE  `urfiz`"; $res0=mysql_query($sql0);

//$sql0="TRUNCATE TABLE  `complex`"; $res0=mysql_query($sql0); // �� �������, ��� ��� ������ ����������� �� - ����������� �������

header("Location: form_googlesheets.php?truncated=1");

?>


