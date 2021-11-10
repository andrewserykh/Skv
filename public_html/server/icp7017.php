<?
//***Модуль опроса ICP 7017 MODBUS TCP 4 канала
$debug = 1;

$TimeoutInsertDatabase=50; //секунд
//---
ini_set('date.timezone', 'Asia/Krasnoyarsk');
require_once("../administrator/engine/initdb.php");
require_once dirname(__FILE__) . '/Phpmodbus/ModbusMasterTcp.php';

$sql0 = "SELECT * FROM `setup_plc`";
$res0 = mysql_query($sql0);
while ($r0 = mysql_fetch_array($res0)):
	echo $r0['title']." ".$r0['addr'];

    $ip=$r0['addr'];

    // Create Modbus object
    $modbus = new ModbusMasterTcp("$ip");

    try {
        $recData = $modbus->readMultipleInputRegisters(1, 0, 12);
    }
    catch (Exception $e) {
        echo "!!error";
        exit;
    }

    id ($debug) for ($i=0;$i < count($recData); $i++) print dechex($recData[$i]).' '; //Packet dump
    

    $val_hex2 = array(); // объявляем массив для INT
    $val_hex2[0] = hexdec($recData[0]);
    $val_hex2[1] = hexdec($recData[1]);
    $value = PhpType::bytes2signedInt($val_hex2);
    echo "<h3>INT</h3>\n";
    echo $value . "</br>";

    $val_hex2[0] = hexdec($recData[2]);
    $val_hex2[1] = hexdec($recData[3]);
    $value = PhpType::bytes2signedInt($val_hex2);
    echo "<h3>INT</h3>\n";
    echo $value . "</br>";


endwhile;


?>