<?include("top.php");?>
	<link rel="stylesheet" href="ui.datepicker.css" type="text/css" media="screen" />
	
	<script type="text/javascript" src="translit.js"></script>
	<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
/*
fontselect,separator,
	theme_advanced_buttons1_add : "fontsizeselect",
	theme_advanced_buttons2_add_before: "search,replace,separator", 
*/
	mode : "specific_textareas",
	textarea_trigger : "convert_this",
	theme : "advanced",
	language : "ru_utf8",
	plugins : "table,advhr,advimage,advlink,preview,contextmenu",
	theme_advanced_buttons2_add_before : "cut,copy,paste,separator",
	theme_advanced_buttons2_add : "preview,separator,forecolor,backcolor",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "drupalbreak,advhr",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	content_css : "user.css",
	plugin_insertdate_dateFormat : "%d.%m.%Y",
	plugin_insertdate_timeFormat : "%H:%M:%S",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	external_link_list_url : "example_data/example_link_list.js",
	external_image_list_url : "example_data/example_image_list.js",
	flash_external_list_url : "example_data/example_flash_list.js"
});
</script>
	
<?
$qs=cut_id($_SERVER[QUERY_STRING]);
if (isset($_POST['id'])):  //  сохранение новых полей
$sql="UPDATE $tbl SET ";
	foreach ($_POST as $name=>$val) {
	  if (substr($name,0,strlen("date_"))=="date_") {
			$sql.=" `$name`='".date('Y-m-j', strtotime($val))."',"; //если поле называется date_.....
			$name="skip"; //пропускаем следующий switch
	  }

	  switch ($name){
		default:
			$sql.=" `$name`='$val',";
		break;
		case "date":
			$sql.=" `$name`='".date('Y-m-j', strtotime($val))."',";
		break;
		case "sub":
		break;
		case "tbl":
		break;
		case "id":
		break;
		case "cbox_":
		break;
		case "skip":
		break;
	  } // switch
	}
	foreach ($_FILES as $key=>$file) {
	  if ($file[size]>0) {  $nfn=date("ymdHis").$key.".jpg";  //uploading files (pic)		                     
	  if (($file['name']!=='')&& (strpos(strtoupper($file['name']),'.JP')) ) {
	    if (move_uploaded_file($file['tmp_name'],$pic_path.$nfn)) chmod($pic_path.$nfn,0777);			
	    else echo ("<div class='error'>Ошибка при загрузке файла".$file['name'].". Попробуте еще раз</div>");
	  }
	  if (($file['name']!=='')&& (strpos(strtoupper($file['name']),'.PNG')) ) {
  	    $nfn=date("ymdHis").$key.".png";
	    if (move_uploaded_file($file['tmp_name'],$pic_path.$nfn)) chmod($pic_path.$nfn,0777);			
	    else echo ("<div class='error'>Ошибка при загрузке файла".$file['name'].". Попробуте еще раз</div>");
	  }
	  $sql.=" `$key`='$nfn',";
	  }
	}
	$sql[strlen($sql)-1]=" "; // cut ,
	 $sql.=" WHERE id =$id "; //echo $sql;

	$res=mysql_query($sql);
	if ($res){ 
		echo "<div class='success'>Запись успешно обновлена</div>";
		sleep(1); ?><script type="text/javascript">location.replace('<?="table.php?$qs"?>'); </script><?
	}	
	else{
		echo "<div class='error'>Ошибка обновления данных.</div>";
		if (mysql_errno()==1062) echo "<div class='error'>Ключ неуникален.</div>";
		echo '<div class="barrer"></div><ul class="tools-menu"><li><a href="table.php?tbl='.$tbl.'">Возврат к списку</a></li></ul>';
	}	
	//sleep(3); header("Location: $SERVER_NAME/table.php?tbl=$tbl"); 	
	exit;
endif;

$qry="SHOW COLUMNS FROM ".$tbl;
$res=mysql_query($qry);

if ($dup):  // copy row if mode copy
	$sql=""; 
	while ($row=mysql_fetch_row($res)) if ($row[0]!=='id') $sql.="`$row[0]`,";
	$sql[strlen($sql)-1]=" "; // cut ,
	$sql="INSERT INTO $tbl ($sql) select $sql from $tbl where id='$id'";	
	$res1=mysql_query($sql);
    if ($res) { $res1=mysql_query("SELECT LAST_INSERT_ID()");
				$r=mysql_fetch_array($res1);
				$id=$r[0];
				$cop='(копии)';  // copy made successfull
	}
endif;	

mysql_data_seek($res,1); // w/o Id    exception for him baza

$qr="SELECT * FROM ".$tbl." Where id='$id'";
 $result=mysql_query($qr);
 $datarow=mysql_fetch_array($result);  // !! call once cause working with only one record  id=$id     row
 $ed_year=$datarow[year]; $ed_mark=$datarow[vmark_id];// series filter exception
?>
 <div class="caption">Редактирование записи</div>
 <div class="barrer"></div>
 <div class="label"><?echo ($datarow[1]." <u>Id=".$id."</u>");?></div>
<?
 
 
?>
<script language="javascript" type="text/javascript" src="valid.js"></script>
	<br>
	
<form <?if ($tbl!='vmodel'):?>onSubmit="return check(this);"<?endif;?> name="form1" enctype="multipart/form-data" method="post" action=""> 
<div class="barrer"></div>
<ul class="tools-menu">
	<li><a href="javascript:history.go(-1)">Отмена</a></li>
	<input type="submit" name="sub" value="Сохранить запись">
</ul>


<input type="hidden" name="tbl" value="<?=$tbl?>">
<input type="hidden" name="id" value="<?=$id?>">
<div class="editlist">
<table>
<?
if ($tbl=='aaa') $z=226; else $z=0;
$bgcolor=" bgcolor=\"#F3F3F3\"";
  for  ($j=1;$j< mysql_num_fields($result)-$z; $j++) 
  { 
$sql_fn=mysql_field_name($result,$j);
if (substr($sql_fn,0,5)=='param' && ($tbl=="amodel" ||  $tbl=="tmodel" || $tbl=="zmodel") ){   //exception for  params
	if ($param_names[$sql_fn]) $fld_name[$j]=$param_names[$sql_fn];  
	else continue;
}	
if ($tbl="vmodel" || $tbl="tmodel" || $tbl="tbrand" || $tbl="ttypes" || $tbl="vmark") if ($sql_fn=='url') $add_js=' id="url"'; elseif ($sql_fn=='title') $add_js='onkeyup="oJS.strTranslit(this)"'; elseif (strpos($sql_fn,'_tags')>0) $add_js='id="tags"'; elseif  ($sql_fn=='pdf') $add_js=' id="pdf"'; elseif  ($sql_fn=='video') $add_js=' id="video"';
if ($sql_fn=='ya_pogoda') $valid_max=" "; else $valid_max="convert_this='true'";
if ($datarow[$j]) $chkd='checked'; else $chkd='';	 
$vals=array();
$row=mysql_fetch_row($res);

$sql_fl=mysql_field_len($result,$j);

echo("<tr $bgcolor>");
echo ("<td>&nbsp;<div class='label'>".$fld_name[$j]."</div></td>");
$subst=substr($row[1],0,4);

$tmpvals=explode("'",$row[1]);         // get values of enum field     BAD TO PUT THIS INTO 
$ni=round(count($tmpvals)/2)-1;
for ($i=0; $i<$ni;$i++)  	$vals[$i]=$tmpvals[$i+$i+1];
if (strpos($sql_fn,"_id")>0)  $vals=GetRelNamesArray($sql_fn);
if ($sql_fn=="title")  $fld_ln='120'; else $fld_ln='45';
echo("<td>");
  if (($subst=="enum") || (strpos($sql_fn,"_id")>0)) {
         echo('<select '.$ttl.' name='. mysql_field_name($result,$j).'> <option value="">---</option>');
			foreach ($vals as $key=>$val){   
				$sel='';
				 if  ($subst=="enum") $post_val=$val ; else $post_val=$key;  // id if  use rel. table
				 if (($subst=="enum")&&($val==$datarow[$j])) $sel="selected";
				  if ($key==$datarow[$j] && $datarow[$j]!=null) $sel="selected";  // 'selected ' adds if vals are equal     	          
			  echo "<option value='$post_val' $sel >$val</option>";
            }
         echo('</select>'."\n");  			
   }  else   
	if (substr($sql_fn,0,3)=='png'){
		if ($fst) echo '<input type="hidden" name="MAX_FILE_SIZE" value="2048000">';   
		echo "<input type='file' name=$sql_fn accept='image/png'>";  $fst=0;
	} else
	if (substr($sql_fn,0,3)=='pic'){ 
		if ($fst) echo '<input type="hidden" name="MAX_FILE_SIZE" value="2048000">';   
		echo "<input type='file' name=$sql_fn accept='image/jpeg'>";  $fst=0;
	} else
		
	if ($subst=="date"){
		if (date('j.m.Y', strtotime($datarow[$j]))=="1.01.1970") {
			echo('<input class="datepicker" '.$ttl.' type="text" size=45 maxlength ='.$sql_fl.' name= "' . $sql_fn.'" value="" >');
		} else {
			echo('<input class="datepicker" '.$ttl.' type="text" size=45 maxlength ='.$sql_fl.' name= "' . $sql_fn.'" value="'.( date('j.m.Y', strtotime($datarow[$j])) ).'" >');
		}
	}
	else
	if ($subst=="tiny"){
		echo('<input type=checkbox '.$chkd.' onChange="cbox('.$j.');" name= "cbox_" value="'.$datarow[$j].'" >');
		echo('<input type=hidden id="hid'.$j.'"  name= "' .$sql_fn.'" value="'.$datarow[$j].'" >');
	} else
	if ($subst=="text") {
		if($datarow[$j][0]!="{"){
		  echo '</td></tr>';
		  echo '<tr><td colspan="2">';
		  echo '<textarea '.$ttl.' class="ckeditor" cols="80" id="editor1" name="'.$sql_fn.'" rows="10">'.$datarow[$j].'</textarea>';
		  echo '<br/>';
		} else {
		  echo('<input '.$ttl.' type="text" name= "' . $sql_fn.'" value="'.$datarow[$j].'" >');
		  echo '<br/>';
		}
	} else {		
            echo('<input  '.$add_js.' '.$ttl.' type="text" size='.$fld_ln.' maxlength ='.$sql_fl.' name= "' . $sql_fn.'" value="'.htmlspecialchars($datarow[$j]).'" >');
	}
	if (strpos($sql_fn,"_tags")>0){ 
		$qr2="SELECT * FROM ".$_GET['tbl']."_tags";
		$re2=mysql_query($qr2);
		while ($r2=mysql_fetch_array($re2)):
		 $js="document.getElementById('tags').value=document.getElementById('tags').value+' ".$r2[tag]."'; return false;";
		 echo '<a href="#" onclick="'.$js.'" style="color:#fff;background:#364d95;padding:2px;">'.$r2[title].'</a>';
		 echo ' ';
		endwhile;
	}
	if ($sql_fn=="url"){
		$count=0;
		$sql0='SELECT * FROM `page` ORDER BY `sort`';
		$res0=mysql_query($sql0);


		while ($r0=mysql_fetch_array($res0)):
		  $count++;
		  $sql1='SELECT * FROM `page` WHERE `url` LIKE ("'.$r0[url].'")';
		  $res1=mysql_query($sql1);
		  $exist=0;
		  while ($r1=mysql_fetch_array($res1)) $exist=1;
		   if($r0[url]!="root"){
		 	$js="document.getElementById('url').value='".$r0[url]."'; return false;";

		 	echo '<a href="#" onclick="'.$js.'" style="font-size:9px; color:#fff;background:#364d95;padding:2px;">'.$r0[url].'</a>';
		 	echo ' ';
		   }
		endwhile;

    }
      if ($sql_fn=="pdf"){
		$pathpdf="../../pdf"; //путь к папке на диске
		$count=0;
		$dir = opendir($pathpdf);
		while($file = readdir($dir)):
		  if ((is_file($pathpdf."/".$file)) && $file != '.' && $file != '..') { 
		    $js="document.getElementById('pdf').value='".$file."'; return false;";
		    echo '<a href="#" onclick="'.$js.'" style="color:#fff;background:#364d95;padding:2px;">'.$file.'</a>';
		    echo ' ';
		    $count++;
		  }
		endwhile;
	} //if pdf
	if ($sql_fn=="video"){
		$pathpdf="../../video"; //путь к папке на диске
		$count=0;
		$dir = opendir($pathpdf);
		while($file = readdir($dir)):
		  if ((is_file($pathpdf."/".$file)) && $file != '.' && $file != '..') { 
		    $js="document.getElementById('video').value='".$file."'; return false;";
		    echo '<a href="#" onclick="'.$js.'" style="color:#fff;background:#364d95;padding:2px;">'.$file.'</a>';
		    echo ' ';
		    $count++;
		  }
		endwhile;
	} //if video

	echo("</td>\n");
	echo('</tr>');
  if ($bgcolor=="") $bgcolor=" bgcolor=\"#F3F3F3\""; else $bgcolor="";
 }
   ?>
   </table>  
</div>
<!--<input type="reset" name="reset" title="123 " value="Заново">-->
</form>
 <?if (!$subgroup_id && $datarow[subgroup_id]) $sbgr='&subgroup_id='.$datarow[subgroup_id];?> 

<?include("foot.php");?>