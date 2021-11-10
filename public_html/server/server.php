<?
/**
 * Консольный сервер
 * ---
 * в Windows происходит зависание fread serial порта, для инициализации таймаута использовать
 * утилиту serialto com1, которая устанавливает таймауты чтения/записи = 500
 * Такие вот дела.
 **/                                 
$Task=array();
//***Зона настраиваемых параметров сервера***
$PathToPhp = "c:\\xampp\\php\\php.exe"; //путь до php.exe

array_push($Task,"icp7017.php"); //опрос контроллера ICPDAS-7071, modbus адрес 01
//array_push($Task,"adam4017_1.php"); //опрос контроллера Adam-4017+, modbus адрес 01

$SerialNeed = false;   //будет ли идти опрос по последовательным портам
$SerialPorts = "com1"; //перечень используемых портов: com1 [com2] [com3] [com7]

$TimeSleep_s = 5; //тайимер ожидания после итерации (секунд)
$TimeSleep_us = 500000; //таймер ожидания после итерации (микросекунды) 500000 = 1/2 секунды
//--- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- --- 
echo " - Hello!\r\n - Looking for task files......";
$err=0;
foreach ($Task as $key=>$value) $err+=!file_exists($value);
echo ($err==0?'[done]':'[FAIL]');
echo "\r\n";

echo " - Initialization mySQL database...";
require_once("../administrator/engine/initdb.php");
echo "...[done]\r\n";

echo " - mySQL checking required tables...";
//*** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** Инициализация базы данных
        $sqlCheck = "SHOW TABLES LIKE 'raw_icp7017'";
        $resCheck = mysql_query($sqlCheck);
        $countCheck = 0;
        while ($rCheck = mysql_fetch_array($resCheck)) $countCheck++;
        if($countCheck==0) {
	  echo " +raw_icp7017 ... ";
          $sqlCheck = "
  	  CREATE TABLE `raw_icp7071` (
	    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
	    `time` datetime NOT NULL COMMENT 'время',
	    `ch0` int(11) NOT NULL COMMENT 'канал 1',
	    `ch1` int(11) NOT NULL COMMENT 'канал 2',
	    `ch2` int(11) NOT NULL COMMENT 'канал 3',
	    `ch3` int(11) NOT NULL COMMENT 'канал 4',	    
	    PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	";
        mysql_query($sqlCheck);
	} //count==0
//*** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** 
echo "...[done]\r\n";

if ($SerialNeed) {
    echo " - Initialzation Serial port rx/tx timeouts..";
    exec("serialto " . $SerialPorts);
    echo "..[done]\r\n";
}
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
set_time_limit(0); // это чтоб не свалился по таймауту (оно же в php.ini настраивается)

$log = fopen("server.log","a");
fwrite ($log,"\r\n");
echo "***Server started.\r\n";
echo " - Task count: ".count($Task).".\r\n";
echo " - Dear friend, look at server.log file for details.\r\n";

fwrite ($log,date("m.d.y")." ".date("H.i.s")." Server console startup.\r\n");
fclose ($log);

$sql = 'INSERT INTO `syslog` (`id`,`title`,`time`) VALUES (NULL,"Сервер запущен (количество задач:'.count($Task).')",NOW());';
$res = mysql_query($sql);

while (true) {
  echo " - Iteration..\r\n";
  foreach ($Task as $key=>$value){
    try {
    	echo " - Executing task: ".$value." .. "; 
  	exec($PathToPhp." -f ".$value." >>server.log");
  	echo "[done]\r\n";
    } catch (Exception $e) {
        //реализовать запись ошибки в log
        $log = fopen("server.log","a");
        fwrite ($log,date("m.d.y")." ".date("H.i.s")."!!! Error: ".$e->getMessage()."\r\n");
        fclose($log);
    }//try
  }//foreach
  echo " - Sleep ".($TimeSleep_s==0?$TimeSleep_us.' us':$TimeSleep_s.' s')."..\r\n";
  sleep($TimeSleep_s); //s
  if ($TimeSleep_s==0) usleep($TimeSleep_us); //us
} //while true
$log = fopen("server.log","a");
fwrite ($log,date("m.d.y")." ".date("H.i.s")." Server console shutdown.\r\n");
fclose ($log);
echo "***Server shut down.\r\n";
?>