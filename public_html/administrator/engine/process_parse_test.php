<?
ini_set("memory_limit", "256M");

echo "started..<br>";

if (!isset($charset_in)) $charset_in = "UTF-8";
if (!isset($$charset)) $charset = "UTF-8";

require('simple_html_dom.php');
echo "1. require (simple_dom.php)..ok<br>";

//$url = "https://docs.google.com/spreadsheets/d/1V2xQETasoNXLr5uQ7sCZ3d7ac4-jDvGSYq5VYaRZha0/pubhtml"; //моя версия таблицы

$url = "https://docs.google.com/spreadsheets/d/1ia4RZDHhuSC8dfsIOGk5OLg_kSn0_cGT6BmJeAoNrsA/pubhtml"; //?gid=0&single=true

echo "1a. url:".$url."<br>";

$html = file_get_html($url);
//$html = get_curl($url);

echo "2. file_get_html..ok<br>";

echo "2a. html count ".strlen($html)."<br>";

$table = $html->find('table', 0);
echo "3. find(table)..ok<br>";


$rowData = array();
echo "4. init array..ok<br>";

echo "5. foreach.....";
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
echo "..ok<br>";

echo "array count ".count($rowData)."<br>";


echo "6. done.<br>";


$maxHeight = count( $rowData );
$maxWidth = max( array_map( 'count',  $rowData ) );

echo "<hr>";
echo "max Height: ".$maxHeight."<br>";
echo "max Width: ".$maxWidth."<br>";

$tableTemplate = array();

$posyHeader = 0;

if ($maxHeight>3){
  for ($j = 0; $j <= 3; $j++){
    for ($i = 0; $i <= ($maxWidth-1); $i++) { 
	$tableHead = trim(mb_convert_case($rowData[$j][$i], MB_CASE_LOWER, $charset));
	$tableHead = str_replace(array("\r\n", "\r", "\n"), '',  strip_tags($tableHead)); //убираем перевод строки
echo "[".$tableHead."], ";

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

echo "<hr>Table headers:<br>";
foreach ($tableTemplate as $a=>$b) echo $a."-".$b."<br>";



/*
foreach (){
}
*/

function get_curl($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Encoding: gzip,deflate'));
	curl_setopt($ch, CURLOPT_ENCODING, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$html = curl_exec($ch);
	return $html;
}
?>