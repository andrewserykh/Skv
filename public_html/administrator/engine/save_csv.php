<?
include("initdb.php");
if (!isset($_GET[tbl])) $tbl=$tbl_default;
include("sql.php");
include('initnames.php');
$where='';
if (isset($_GET)){  //  prepare where query if get sets
	$sql='';
	foreach ($_GET as $name=>$val) if (($name!="oby")&&($name!="tbl")&&($name!="p")) $sql.=" $name='$val' and";
    if ($sql) $sql=substr($sql,0,-4);   // cut last AND
   	if ($sql) $where=" where $sql";
}
//if (!isset($oby)) {$oby='Id'; if ($tbl!=='product') $oby='`sort` desc';}
$oby='id';
if ($tbl=='product') $oby='subgroup_id,substr(art,-4)';
$qry="SELECT * FROM $tbl $where ORDER BY $oby "; 
$buf='';
header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$tbl$val.csv");		
		$res=mysql_query($qry);
		$num_flds=mysql_num_fields($res);
		echo "$tbl;";
		for ($i=1 ;$i< $num_flds; $i++) echo ';';
		echo "\n";
		for ($i=0 ;$i< $num_flds; $i++) echo mysql_field_name($res,$i).';';   
		echo "\n";
		for ($i=0 ;$i< $num_flds; $i++) echo $fld_name[$i].';';
		echo "\n";
		while ($row = mysql_fetch_array($res)) {	// do not print empty 			
			for ($i=0;$i<$num_flds;$i++) {
			$f_typ=mysql_field_type($res,$i);
			$text=$row[$i];	//$search=array("\r", "\n");
			if ($i!=5 && $i!=6 && $i!=18 && $i!=19) $text=str_replace(".",",", $text);
			$text=str_replace("\r","#r", $text);
			$text=str_replace("\n","#n", $text);
			if ($tbl=='product' && $i==2) $text=substr($text,-4,4);
			echo $text; 
			   if ($i<$num_flds-1) echo ';';
			}			
		    echo "\n";		
		}
?>