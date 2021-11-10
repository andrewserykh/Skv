<?include("top.php");?>

<script language="javascript" type="text/javascript" src="translit.js"></script>
<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
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


<div class="caption">Добавление записи</div>
<form onSubmit="return check(this);" enctype="multipart/form-data" name="form1" method="post" action=""> 

<table width="95%" align="center"><tr><td>
<script language="javascript" type="text/javascript" src="valid.js"></script>
<script type="text/javascript" src="translit.js"></script>
<? 
if (isset($_GET['tbl'])) foreach ($_GET as $name=>$val) $gets.="&$name=$val";  // transfer vals by _GET

if (isset($_POST['tbl'])):  //  сохранение новых полей
	//////if ($tbl=='vmodel') $_POST[title]=$_POST[title]." ($_POST[year])";  //vl
	$sql="INSERT INTO $tbl VALUES( NULL,"; 
	foreach ($_POST as $name=>$val) {
	  if (substr($name,0,strlen("date_"))=="date_") {
			$sql.=" '".date('Y-m-j', strtotime($val))."',"; //если поле называется date_.....
			$name="skip"; //пропускаем следующий switch
	  }
	  switch ($name){
		default:
			$sql.=" '$val',";
		break;
		case "date":
			$sql.=" '".date('Y-m-j', strtotime($val))."',";
		break;
		case "sub":
		break;
		case "tbl":
		break;
		case "skip":
		break;
	  } //switch
	} //foreach

	foreach ($_FILES as $key=>$file)  {  
		$nfn=date("ymdHis").$key.".jpg";  //uploading files (pic)		                     
		if (($file['name']!=='')&& (strpos(strtoupper($file['name']),'.JP'))  )	 {
			if (move_uploaded_file($file['tmp_name'],$pic_path.$nfn)) chmod($pic_path.$nfn,0777);			
			else echo ("<div class='error'>Ошибка при загрузке файла".$file['name'].". Попробуте еще раз</div>");
		}
	  	if (($file['name']!=='')&& (strpos(strtoupper($file['name']),'.PNG')) ) {
  	    		$nfn=date("ymdHis").$key.".png";
	    		if (move_uploaded_file($file['tmp_name'],$pic_path.$nfn)) chmod($pic_path.$nfn,0777);			
	    		else echo ("<div class='error'>Ошибка при загрузке файла".$file['name'].". Попробуте еще раз</div>");
	  	}

		$sql.=" '".$nfn."',";
	}		

	$sql[strlen($sql)-1]=" "; // cut ,
	$sql.="); ";  

	$res=mysql_query($sql); 
	$get_s='';
?>
<div class="barrer"></div>
<ul class="tools-menu">
	<li><a href="table.php?tbl=<?=$tbl.$gets?>">Вернуться к списку</a></li>
	<li><a href="add.php?tbl=<?=$tbl.$gets?>">Добавить следующую</a></li>
</ul>
<?
	if ($res) echo "<div class='barrer'></div><div class='success' style='width:320px;'>Запись успешно добавлена</div>"; else echo "<div class='error' style='width:640px;'>Ошибка обновления: ".$sql."</div>";
	exit;
endif;
?>
<div class="barrer"></div>
<ul class="tools-menu">
	<li><a href="table.php?tbl=<?=$tbl.$gets?>">Отмена</a></li>
	<input type="submit" name="sub" value="Сохранить запись">
</ul>

<?
$tbl=$_GET['tbl'];
if (!isset($tbl)) $tbl=$tbl_default; 
//include('initnames.php');
//include('sql.php');

$qry="SHOW COLUMNS FROM ".$tbl;
$res=mysql_query($qry);
$row=mysql_fetch_row($res);  // w/o Id

$qr="SELECT * FROM ".$tbl;
 $result=mysql_query($qr);
 $datarow=mysql_fetch_row($result);  // !! call once cause working with only one record  id=$id
	 
 $bgcolor=" bgcolor=\"#F3F3F3\""; 
// echo "<h2>$tblnms[$tbl]</h2><br>";
 if ($id!=0)   echo "Редактирование записи № ".$id; else echo '<div class="barrer"></div><div class="label">Создание новой записи:</div>';
 
 
 ?>	  	 

<input type="hidden" name="tbl" value="<?=$tbl?>">
<div class="editlist">
<table border="1" cellpadding="3">
<? $fst=0; 
  for  ($j=1;$j< mysql_num_fields($result); $j++) 
  {
	$vals=array(); $def_value='';
	 if ($bgcolor=="") $bgcolor=" bgcolor=\"#F3F3F3\""; else $bgcolor="";
	echo "<tr $bgcolor>";
	$row=mysql_fetch_row($res);
	$sql_fn=mysql_field_name($result,$j);
	
	if ($tbl="vmodel" || $tbl="tmodel" || $tbl="tbrand" || $tbl="ttypes" || $tbl="vmark") if ($sql_fn=='url') $add_js=' id="url"'; elseif ($sql_fn=='title') $add_js='onkeyup="oJS.strTranslit(this)"'; elseif (strpos($sql_fn,'_tags')>0) $add_js='id="tags"'; elseif  ($sql_fn=='pdf') $add_js=' id="pdf"'; elseif  ($sql_fn=='video') $add_js=' id="video"';

	$sql_fl=mysql_field_len($result,$j);	
	if ($fld_null[$j]=='NO') $ttl=' title="заполнить"'; else $ttl='';  // not NULL field
	echo ('<td><div class="label">&nbsp;'.$fld_name[$j].'</div></td>');
	$subst=substr($row[1],0,4);
	$curvalstr=$fld_dflt[$j];//$datarow[$j];  // else sets default db values
	$tmpvals=explode("'",$row[1]);         // get values of enum field     BAD TO PUT THIS INTO 
	$ni=round(count($tmpvals)/2)-1;
	for ($i=0; $i<$ni;$i++)  	$vals[$i]=$tmpvals[$i+$i+1];
	if (strpos($sql_fn,"_id")>0 )  $vals=GetRelNamesArray($sql_fn);
    asort($vals);	
if ($sql_fn=="title")  $fld_ln='120'; else $fld_ln='45';
echo("<td>");
	if (isset($_GET[$sql_fn])) $def_value=$_GET[$sql_fn]; // set def_value from _GET if exists
    if ($def_value){ echo "<input type='hidden' name=$sql_fn value=$def_value>".$vals[$def_value]."</TD></TR>"; continue;}
	$valid='';
	if ($sql_fn=='size' || $sql_fn=='qntbysize') $valid='onChange="valid_size(this)"'; // правильность ввода рамеров

	if ($subst=='date') $curvalstr=date("j.m.Y");
	if ($subst=='int(') $valid='onChange="valid_int(this)"'; // check for int type
  
	if ($sql_fn=='sum') $valid=' onKeyDown="return false" style="background:gray" '; // check for int type
		
	if ($subst=='blob')	{
		   ?>список:<br>
			   <input type="hidden" name=<?=$sql_fn?> ><br>	   
		   <?		   
	   }   
else	   

switch ($subst){
  case "enum":
         echo("<select ".$ttl.' name='. mysql_field_name($result,$j).'>'); //<option value="0">---</option>
			
		    foreach ($vals as $key=>$val){   
				$sel='';
				  if  ($subst=="enum") $post_val=$val ; else $post_val=$key;  // id if  use rel. table
				  if (($key==0)||$key==$def_value ) $sel="selected"; // 'selected' adds if key=0 vals is defaullt
				  
				  if ($key==$curvalstr) $sel="selected";  // 'selected ' adds if vals are equal     	          
			  echo "<option value='$post_val' $sel >$val</option>";
            }
         echo('</select>'."\n");  			
  break;
  case "text":
	echo '</td></tr>';
	echo '<tr><td colspan="2">';
	echo '<textarea class="ckeditor" cols="80" id="editor1" name="'.$sql_fn.'" rows="10">'.$curvalstr.'</textarea>';
	echo '<br/>';
  break;
  case "tiny":
	echo('<input type=checkbox '.$chkd.' onChange="cbox('.$j.');" name= "cbox_" value="'.$datarow[$j].'" >');
	echo('<input type=hidden id="hid'.$j.'"  name= "' .$sql_fn.'" value="'.$datarow[$j].'" >');
  break;
  case "date":
	echo('<input class="datepicker" '.$ttl.' type="text" size=45 maxlength ='.$sql_fl.' name= "' . $sql_fn.'" value="'.$curvalstr.'" >');
  break;
  default:
	if (substr($sql_fn,0,3)=='png'){
		if ($fst) echo '<input type="hidden" name="MAX_FILE_SIZE" value="2048000">';   
		echo "<input type='file' name=$sql_fn accept='image/png'>";  $fst=0;
	}  else
	if (substr($sql_fn,0,3)=='pic'){ 
		if ($fst) echo '<input type="hidden" name="MAX_FILE_SIZE" value="2048000">';   
	      	echo "<input type='file' name=$sql_fn accept='image/jpeg'>";  $fst=0;
	} else {
		if (strpos($sql_fn,"_id")>0) {
         echo("<select ".$ttl.' name='. mysql_field_name($result,$j).'>'); //<option value="0">---</option>
			
		    foreach ($vals as $key=>$val){   
				$sel='';
				  if  ($subst=="enum") $post_val=$val ; else $post_val=$key;  // id if  use rel. table
				  if (($key==0)||$key==$def_value ) $sel="selected"; // 'selected' adds if key=0 vals is defaullt
				  
				  if ($key==$curvalstr) $sel="selected";  // 'selected ' adds if vals are equal     	          
			  echo "<option value='$post_val' $sel >$val</option>";
            }
         echo('</select>'."\n");  			
		} else {
		echo('<input  '.$add_js.' '.$ttl.' type="text" size='.$fld_ln.' maxlength ='.$sql_fl.' name= "' . $sql_fn.'" value="'.$curvalstr.'" >');
		}
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
		$sql0='SELECT * FROM `topmenu` ORDER BY `sort`';
		$res0=mysql_query($sql0);
		while ($r0=mysql_fetch_array($res0)): 
		  $count++;
		  $sql1='SELECT * FROM `page` WHERE `url` LIKE ("'.$r0[url].'")';
		  $res1=mysql_query($sql1);
		  $exist=0;
		  while ($r1=mysql_fetch_array($res1)) $exist=1;
		   if($r0[url]!="root"){
		 	$js="document.getElementById('url').value='".$r0[url]."'; return false;";
		 	echo '<a href="#" onclick="'.$js.'" style="color:#fff;background:#364d95;padding:2px;">'.$r0[url].'</a>';
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

  break;
}
  echo("</td>\n");
  echo('</tr>');
   
 }   // need to add  auto input size and time type
?>
 </table>
</div>
</form>
</td></tr></Table>
</body>
<?include("foot.php");?>
