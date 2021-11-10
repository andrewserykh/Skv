<? 
$url='table.php?'.$_SERVER[QUERY_STRING]; 
$url=str_replace("&p=$p",'',$url);   //  need to cut last get '&p='

if (!$res_c){
	$qry_c="SELECT count(*) FROM $tbl $where"; // count number of records

	$res_c=mysql_query($qry_c); if ($res_c) {$r=mysql_fetch_row($res_c); $p_max=floor($r[0] / $on_page); if ($r[0] % $on_page ==0 ) $p_max--; } // 
	
}	
if ($p!=0){ ?>
<li><a href="<?=$url?>">|< Первая</a></li>
<li><a href="<?=$url."&p=".($p-1)?>"><< Пред.</a></li>
<? }

if (isset($p_max) && $p!=$p_max){?>
<li><a href="<?=$url."&p=".($p+1)?>">След. >></a></li>
<li><a href="<?=$url."&p=$p_max"?>">Последняя >|</a></li>
<?
} ?>