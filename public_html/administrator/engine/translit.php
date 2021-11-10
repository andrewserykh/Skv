
<?
function Convert($string)
{
  $string = strtolower($string);
  $string = translit($string);
  $patterns = array("/&/", "/!/", "/\//", "/@/", "/`/", "/\"/", "/:/", "/\*/", "/%/", "/#/", "/'/", "/\?/", "/\s/");
  $replacement = "_";
  return preg_replace($patterns, $replacement, $string);
}




  

  function translit($st)  { 
	$smbls=array(',','.','"',"'",'{','}','(',')','#','@','$','~','*','^','&',';',':','/','+','=');
	  foreach ($smbls as $smb) $st=str_replace($smb,'',$st);
	$st=strtolower($st);  
    $st=strtr($st,"абвгдеёзийклмнопрстуфхъыэ ",
    "abvgdeeziyklmnoprstufh6ie_");
    $st=strtr($st,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ ",
    "ABVGDEEZIYKLMNOPRSTUFH6IE_");
    $st=strtr($st,  array(
                        "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", 
                        "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya",
                        "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH",
                        "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",
                        "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye" )
             );

  

    return $st;

  }


// translit('ваВААААпрлъ   )*^$# ;;;');
 set_time_limit (900);
include ("top.php");
$res=mysql_query("select id,title from vmodel where NOT isNull(title)  ");
	$k=0;
while ($r=mysql_fetch_array($res)){ $k++;
	$new_url=translit($r[title]);
	echo "updating '# $r[id] $r[title]' URL to <b>'$new_url'</b> ";
	if ($res2=mysql_query("update vmodel set url='$new_url' where id=$r[id]")) echo ' Ok'
	?><br><?
}	
	echo " Обработано: $k";
	
	
	
	
	
	
	
	
	
?>