<?php
$rels['subgroup2']='subgroup';	$rels['subgroup3']='subgroup';	
$selector_vals=array();
function get_rel_tbl($fld_n){   
global $rels;
$pos=strpos($fld_n,'_id');
$tbl="".substr($fld_n,0,$pos); 
if (isset($rels[$tbl])) $tbl=$rels[$tbl];
return $tbl;
}

function GetRelFldById($id,$fld_n){
$ret="not define"; 
$tbl=get_rel_tbl ($fld_n);
$res=mysql_query("select * from $tbl where id=$id");
//echo "select * from $tbl where id=$id";
if (mysql_num_rows($res)>0)  $r=mysql_fetch_array($res);
$ret=$r[title]; // title field
//if ($tbl=='shini_model') $ret=$r[mtitle];  // vss exc

return $ret;

}
//echo GetRelFldById(139,"user_id");

function GetRelNamesArray($fld_n){
	global $tbl,$ed_year,$ed_mark; 
$ret=array();
$tbl0=get_rel_tbl ($fld_n);

if ($tbl0=='vseries') { $add='where 1 ';
 if ($ed_year) $add.=" and year_url='$ed_year' ";
  if ($ed_mark) $add.=" and vmark_id=$ed_mark ";
}
if ($tbl0=='vmark') { //$add='where ok=1 ';
 
}

if ((strpos($fld_n,"_id")>0)):
//echo "select * from $tbl0 $add order by id";
	$res=mysql_query("select * from $tbl0 $add order by id"); 
	while ($r=mysql_fetch_array($res)) {	
		$ret[$r[0]]=$r[title]; 	
	}
else: // enum field
	$res=mysql_query("show columns from $tbl where field='$fld_n'"); 
	$r=mysql_fetch_array($res);
	$tmpvals=explode("'",$r[1]);         // get values of enum field     
	$ni=round(count($tmpvals)/2)-1;
	for ($i=0; $i<$ni;$i++)  $ret[$i]=$tmpvals[$i+$i+1];	
endif;
return $ret;
}

function echo_selector ($fld_n,$value,$id){
	global $tbl, $selector_vals;
		if (!isset ($selector_vals[$fld_n])) $selector_vals[$fld_n]=GetRelNamesArray($fld_n); // buffering selector array
	    $vals=$selector_vals[$fld_n];		
		$enum=!(strpos($fld_n,"_id")>0); $w='105px'; if (!$enum && $fld_n!=='vtype_id' && $fld_n!=='vseries_id') $w='215px'; ?>
         <select style="width:<?=$w?>" onChange="update_model('<?=$fld_n?>',this.value,<?=$id?>)" name="<?=$fld_n?>"> <option value="">---</option>
		<?	foreach ($vals as $key=>$val){   
				$sel=''; echo "1".$val;
				  if ($enum) $post_val=$val ; else $post_val=$key;  // id if  use rel. table
				 if (($enum)&&($val==$value))  $sel="selected";
			// if ($id==0 && ($key==0)) $sel="selected"; // 'selected ' adds if vals are defaullt one
				  if ($key==$value && $value!=null) $sel="selected";  // 'selected ' adds if vals are equal     	          
			  echo "<option value='$post_val' $sel >$val</option>";
            }
         echo('</select>'."\n");
}	

function get_prod_id(){
}

function update_from_csv(){	
	$fp = fopen ("himb.csv","r");
    $brand="another"; $k=7;
while ($str = fgets($fp)) if (($str!=="")&&(strpos($str,";;;;")===false)&& (strpos($str,"роизводи")===false)){
    $cells= explode(';',$str); 
	$k++; //if ($k>400) break; //--
	    if ($cells[0]=="") continue;
		
		for ($j=4;$j<12;$j++) {$cells[$j]=str_replace(',','.',$cells[$j]);} // change , to . float format in mysql
		$sql="INSERT INTO `product` 
		(`id` ,`csv_art` ,`title` ,`descr` ,`kg_m3` ,
     `mera` ,`in_box` ,`price` ,`w_item` ,`v_item` ,`short_title`)
	VALUES (
NULL , '$cells[12]', '$cells[2]' , '$cells[0]', '', 
'', $cells[3] , '$cells[4]', '$cells[8]','$cells[9]','$cells[2]' ) 
ON DUPLICATE KEY UPDATE price='$cells[4]', short_title='$cells[2]',in_box='$cells[3]', w_item='$cells[8]',v_item='$cells[9]' ;";
//->$cells[1]
	echo "строка $k - process <br>";
	if (mysql_query($sql)) echo " OK ";
	echo "<br>";
		
			//echo "add cat $sql<br>"; //".GetPrice($cells[4],$k,1)."
    }
fclose ($fp);	
}

function load_from_csv(){	
	$fp = fopen ("tmp.csv","r");
    $k=0;
while ($str = fgets($fp)) if ($str!=="")
{	$k++;
    $cells= explode(';',$str);	
	    if (($cells[0]=="") || ($k==3)) continue;
		if ($k==1) {$tbl=$cells[0]; continue;}
		$sql="";
		//$sql_ins="INSERT INTO $tbl";
		foreach ($cells as $i=>$val) if ($i>=0){
		if ($k==2) {$fldn[$i]=trim($val);	continue;	}	
			if ($fldn[$i]){
				$val=trim($val);
				//if (substr($fldn,0,3)=='add') $fldn[$i]='add_p';	
				if ($i!=5 && $i!=6 && $i!=18 && $i!=19) $val=str_replace(",",".", $val);
				$val=str_replace("#r","\r", $val);
				$val=str_replace("#n","\n", $val);	
				if ($fldn[$i]=='art') {  if ($cells[4]<100) $cells[4]='0'.$cells[4];
					$val=substr($val,-4,4);	$val=$cells[7].$cells[8].'-'.$cells[3].$cells[4].'-'.$val;
				    $key=$val;
				}
				$sql.=" `$fldn[$i]`='$val',";
			}
		}
		 $sql=rtrim($sql,',');//$sql[strlen($sql)-1]=" "; // cut ,
	// $sql.="  "; //echo $sql;
	echo "строка $k - updating <br>";
	$sql="INSERT INTO $tbl SET $sql ON DUPLICATE KEY UPDATE $sql;";
	//echo $sql;
	if (mysql_query($sql)) echo " <b>OK</b> "; else { if (mysql_errno()==1062) echo "<b style='color:red'>$cells[0] | $cells[1] | $key | Ошибка! Ключ неуникален.</b>";} 
	echo "<br>";			
    }

fclose ($fp);	
}

function cut_id($qs){  // query string
  $p=strpos($qs,'&id');
  return $s=substr($qs,0,$p); 
}

function get_param_names($tbl,$type_id){  //params names
	global $param_names;
	$res=mysql_query("select prms from $tbl where id=$type_id");
	//echo "select prms from $tbl where id=$type_id";
	$r=mysql_fetch_array($res);
    $prms=explode('|',$r[prms]);	$k=0;
	foreach ($prms as $item) {$k++; $param_names["param$k"]=$item;}
}	

?>