<?
require_once("administrator/engine/initdb.php");
ini_set('date.timezone', 'Asia/Krasnoyarsk');


$sql0 = 'SELECT * FROM `raw_icp7071`  ORDER BY id DESC LIMIT 1';
$res0 = mysql_query($sql0);
while ($r0 = mysql_fetch_array($res0)):
    echo $r0['ch0'].";".$r0['ch1'].";".$r0['ch2'].";".$r0['ch3'];
endwhile;

?>