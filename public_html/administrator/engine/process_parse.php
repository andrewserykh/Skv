<?
ini_set("memory_limit", "256M"); //максимальное количество оперативной памяти предоставляемого пользовательскому аккаунту виртуальным хостингом

/*
Загрузка таблицы из Google.Таблицы

Необходимые параметры:

$url - ссылка на опубликованную таблицу Google
$charset_in - кодировка таблицы (по умолчанию UTF-8)
$charset - кодировка сайта
$return - необходимо ли выходить в панель администратора по завершению

*/
if (!isset($charset_in)) $charset_in = "UTF-8";
if (!isset($charset)) $charset = "UTF-8";

//$url='https://docs.google.com/spreadsheets/d/1V2xQETasoNXLr5uQ7sCZ3d7ac4-jDvGSYq5VYaRZha0/pubhtml';
//---->$url='https://docs.google.com/spreadsheets/d/1pEbeffL4o4wBiCcB0yp8ciQvjRYUj6aiz_xX9s-VLmQ/pubhtml';

//include_once("initdb.php");
include_once("resize.php");
require('simple_html_dom.php');
error_reporting( E_ERROR );

$price_max=0;
$area_max=0;
$rooms_max=0;
$stage_max=0;

$sql0="TRUNCATE TABLE  `objects`"; $res0=mysql_query($sql0);

$html = file_get_html($url);
$table = $html->find('table', 0);
$rowData = array();

foreach($table->find('tr') as $row) {
	$flight = array();
	foreach($row->find('td') as $cell) {
		if (strlen($cell->innertext)>0) {
		$flight[] = iconv($charset_in, $charset, $cell->innertext);
		} else {
		$flight[] = "-";
		}
	}

	foreach($row->find('th') as $cell) $flight[] = iconv($charset_in, $charset, $cell->innertext);
	$rowData[] = $flight;
}

$maxHeight = count( $rowData );
$maxWidth = max( array_map( 'count',  $rowData ) );

$tableTemplate = array();

$posyHeader = 0;

if ($maxHeight>3){
  for ($j = 0; $j <= 3; $j++){
    for ($i = 0; $i <= ($maxWidth-1); $i++) { 
	$tableHead = trim(mb_convert_case($rowData[$j][$i], MB_CASE_LOWER, $charset));
	$tableHead = str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($tableHead)); //убираем перевод строки
	if ( $tableHead=="жк" ) { $tableTemplate[$i]='complex'; $posyHeader = $j; }
	if ( $tableHead=="адрес" ) { $tableTemplate[$i]='addr'; $posyHeader = $j; }
	if ( $tableHead=="район" ) { $tableTemplate[$i]='region'; $posyHeader = $j; }
	if ( $tableHead=="комнаты" ) { $tableTemplate[$i]='rooms'; $posyHeader = $j; }
	if ( $tableHead=="этаж" ) { $tableTemplate[$i]='stage'; $posyHeader = $j; }
	if ( $tableHead=="площадь" ) { $tableTemplate[$i]='area'; $posyHeader = $j; }
	if ( $tableHead=="цена" ) { $tableTemplate[$i]='price'; $posyHeader = $j; }
	if ( $tableHead=="срок сдачи" ) { $tableTemplate[$i]='finish'; $posyHeader = $j; }
	if ( $tableHead=="отделка" ) { $tableTemplate[$i]='decore'; $posyHeader = $j; }
	if ( $tableHead=="юр/физ" ) { $tableTemplate[$i]='urfiz'; $posyHeader = $j; }
	if ( $tableHead=="застройщик" ) { $tableTemplate[$i]='developer'; $posyHeader = $j; }
    } //for i
  } //for j
} //if height

//foreach ($tableTemplate as $a=>$b) echo $a."-".$b."<br>";

$j=0;
foreach ($rowData as $row => $tr) {
	$i=0;
	$addSQL = array(); //содержит данные строки добавляемой в базу
	foreach ($tr as $td) {
		if (isset($tableTemplate[$i]) && strlen($td)>0 && $j>$posyHeader) {
			$pattern  =  '/\r\n|\r|\n/u';
			$addSQL[$tableTemplate[$i]] = str_replace("\n", ' ', strip_tags($td) ); // удаляем спецсимволы и переводы строки
			$i++;
		}
	}


foreach ($addSQL as $q=>$w) {
	if ($q=='stage') {
		$stage = $w;
		if (strpos($stage,"/")>0){
			$stagenum = substr($stage,0,strpos($stage,"/"))*1;
			if (strpos($stage,",")>0) $stagenum = substr($stage,0,strpos($stage,","))*1;
		} else {
			$stagenum = $stage*1;
		}
		if ($stage_max<$stagenum && $stagenum<40) $stage_max=$stagenum;
	}
	if ($q=='area') {
		$area=str_replace(",",".",$w);
		if ($area_max<$area && $area<300) $area_max=round($area)+1;

	}
	if ($q=='price') {
		$price=($w*1);
		if ($price>20000000) $price=0; // максимальный верх цены
		if (is_int($price)) if ($price_max<$price) $price_max=$price;
	}

	if ($q=='complex'){
		$sql0="INSERT INTO `complex` (`title`) VALUES ('".$w."');";
		$res0=mysql_query($sql0);
		$complex=$w;
	}
	
	if ($q=='addr'){
		$sql0="INSERT INTO `addr` (`title`) VALUES ('".$w."');";
		$res0=mysql_query($sql0);
		$addr=$w;
	}

	if ($q=='decore'){
		$sql0="INSERT INTO `decore` (`title`) VALUES ('".$w."');";
		$res0=mysql_query($sql0);
		$decore=$w;
	}

	if ($q=='finish'){
		$sql0="INSERT INTO `finish` (`title`) VALUES ('".$w."');";
		$res0=mysql_query($sql0);
		$finish=$w;
	}

	if ($q=='region'){
		$sql0="INSERT INTO `region` (`title`) VALUES ('".$w."');";
		$res0=mysql_query($sql0);
		$region=$w;
	}

	if ($q=='rooms'){
		$number = str_replace("ст","0",$w)*1;
		$number = str_replace("к","",$w)*1;
		$sql0="INSERT INTO `rooms` (`title`,`number`) VALUES ('".$w."','".$number."');";
		$res0=mysql_query($sql0);
		$rooms=$w;
		if ($rooms_max<$number && $number<8) $rooms_max=$number;
	}

	if ($q=='developer'){
		$sql0="INSERT INTO `developer` (`title`) VALUES ('".$w."');";
		$res0=mysql_query($sql0);
		$developer=$w;
	}
	
	if ($q=='urfiz'){
		$sql0="INSERT INTO `urfiz` (`title`) VALUES ('".$w."');";
		$res0=mysql_query($sql0);
		$urfiz=$w;
	}

	if ($q=='developer'){
		$title = $addr;
		$sql0="
INSERT INTO `objects` (
`id`,
`title` ,
`complex_id` ,
`addr_id` ,
`region_id` ,
`rooms_id` ,
`stage` ,
`stagenum`,
`area` ,
`price` ,
`finish_id` ,
`decore_id` ,
`urfiz_id` ,
`developer_id`
)
VALUES (
NULL,
'$title',
(SELECT `id` FROM `complex` WHERE `title` LIKE('$complex')),
(SELECT `id` FROM `addr` WHERE `title` LIKE('$addr')),
(SELECT `id` FROM `region` WHERE `title` LIKE('$region')),
(SELECT `id` FROM `rooms` WHERE `title` LIKE('$rooms')),
'$stage',
'$stagenum',
'$area',
'$price',
(SELECT `id` FROM `finish` WHERE `title` LIKE('$finish')),
(SELECT `id` FROM `decore` WHERE `title` LIKE('$decore')),
(SELECT `id` FROM `urfiz` WHERE `title` LIKE('$urfiz')),
(SELECT `id` FROM `developer` WHERE `title` LIKE('$developer'))
);
		";
if ( strlen($addr)>1 ) $res0=mysql_query($sql0); //проверка есть ли полезные данные в строке
	} // addr

} //foreach addSQL

	$j++;
}

$price_max=(ceil($price_max/1000000)*1000);
$area_max=(ceil($area_max/100)*100);
//$sql0="UPDATE `filter` SET `price_max` = '$price_max' WHERE  `filter`.`id` =1;"; $res0=mysql_query($sql0);
$sql0="UPDATE `filter` SET `stage_max` = '$stage_max' WHERE  `filter`.`id` =1;"; $res0=mysql_query($sql0);
$sql0="UPDATE `filter` SET `rooms_max` = '$rooms_max' WHERE  `filter`.`id` =1;"; $res0=mysql_query($sql0);
//$sql0="UPDATE `filter` SET `area_max` = '$area_max' WHERE  `filter`.`id` =1;"; $res0=mysql_query($sql0);

//$maxWidth
//$maxHeight
//$price_max
//$stage_max
//$rooms_max
//$area_max

if ($return>0) header("Location: form_googlesheets.php?mw=".$maxWidth."&mh=".$maxHeight."&p=".$price_max."&s=".$stage_max."&r=".$rooms_max."&a=".$area_max);

?>
