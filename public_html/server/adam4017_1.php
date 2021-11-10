<?
//***Модуль опроса modbus устройства (2.0)
$debug = 0;
$SerialName = "COM1";
$SerialBaud = 9600;
$SerialByte = 8;
$SerialPrty = "none";
$SerialStop = 1;

$ModbusAddr = 1;
$ModbusFunction = 3;
$ModbusStart = "0001";
$ModbusLength = 4;

$TimeoutInsertDatabase=50; //секунд
//---
ini_set('date.timezone', 'Asia/Krasnoyarsk');
require_once("../administrator/engine/initdb.php");
require 'PhpSerialModbus.php';
$modbus = new PhpSerialModbus;
$modbus->deviceInit($SerialName,$SerialBaud,$SerialPrty,$SerialByte,$SerialStop,'none');
$modbus->deviceOpen();
$modbus->debug = false;
$result=$modbus->sendQuery($ModbusAddr,$ModbusFunction,$ModbusStart,$ModbusLength);

if (count($result)==$ModbusLength*2) { //получено 8 байт
	foreach ($result as $key=>$value) {
	  $value = hexdec($value); //данные получены в шестнадцатеричном виде, преобразуем в десятичное число
	  $sql0 = "SELECT time,value FROM raw_adam4017_1 WHERE channel=$key ORDER BY time DESC LIMIT 1;";
  	  $res0 = mysql_query($sql0);
	  $value_pre=0; $time_pre=0;
  	  while ($r0 = mysql_fetch_array($res0)):
		$value_pre = $r0['value'];
		$time_pre = $r0['time'];
	  endwhile;
	  if (($value_pre!=$value)||((strtotime(date("Y-m-d H:i:s"))-strtotime($time_pre))>$TimeoutInsertDatabase)){ //пишем в базу, только если величина изменилась
  	    $sql = "INSERT INTO `raw_adam4017_1` (`id`,`time`,`channel`,`value`) VALUES (NULL,NOW(),$key,$value);";
	    $res = mysql_query($sql);
	  }//value!=pre
	  if ($debug) echo $key."=".$value."<br>\r\n";
	}
} //count==
if (count($result)==1) if($result==0) { //обработка ситуации отсутствия связи с устройством
	$sql = 'INSERT INTO `syslog` (`id`,`title`,`time`) VALUES (NULL,"Предупреждение! Нет ответа от устройства '.$SerialName.', адрес:'.$ModbusAddr.'",NOW());';
	$res = mysql_query($sql);
	echo date("m.d.y")." ".date("H.i.s")." Warning! No answer from ".$SerialName.", mb addr:".$ModbusAddr.". Check wire connection.\r\n";
}
$modbus->deviceClose();
?>