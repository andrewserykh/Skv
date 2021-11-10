<?php

require_once dirname(__FILE__) . '/Phpmodbus/ModbusMasterTcp.php';

$ip="192.168.255.1";

// Create Modbus object
$modbus = new ModbusMasterTcp("$ip");

try {
    //$recData = $modbus->readMultipleRegisters(1, 0x22d, 50);
    $recData = $modbus->readMultipleInputRegisters(1, 0, 12);
}
catch (Exception $e) {
    echo "!!error";
    exit;
}

for ($i=0;$i < count($recData); $i++)
{
    print dechex($recData[$i]).' ';
}

/*
$value[2] = $recData[0];
$value[3] = $recData[1];
$value[0] = $recData[2];
$value[1] = $recData[3];
echo "<h3>REAL to Float</h3>\n";
echo PhpType::bytes2float($value) . "</br>";
*/

$val_hex2 = array(); // объявляем массив для INT
$val_hex2[0] = hexdec($recData[0]);
$val_hex2[1] = hexdec($recData[1]);
$value = PhpType::bytes2signedInt($val_hex2);
echo "<h3>INT</h3>\n";
echo $value . "</br>";



return 0;
?>