<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Поиск</title>
</head>
<body bgcolor="#CCCCCC">
<?php
$id=$_GET['id'];
$tbl=$_GET['tbl'];
if (empty($tbl)) $tbl="main"; 
if (empty($id)) $id=0; 
//echo $id,"  ",$tbl;
include('connect.php');
include('globals.php');
$qry="SHOW COLUMNS FROM ".$tbl;
$res=mysql_query($qry);
//$row=mysql_fetch_row($res);  // w/o Id

$qr="SELECT * FROM ".$tbl." Where id=".$id;
 $result=mysql_query($qr);
 $datarow=mysql_fetch_row($result);  // !! call once cause working with only one record  id=$id
echo "Введите условия для поиска:";

echo ('<form name="form1" method="post" action="table.php?id='.$id.'&qry=search">');
echo('<table border="0">');
  for  ($j=0;$j<mysql_num_fields($result); $j++) 
  {
echo("<tr>");
$row=mysql_fetch_row($res);
if ($j==12)  continue;   //  w/o date
echo ("<td>".$fldname[mysql_field_name($result,$j)]."  </td>");
$subst=substr($row[1],0,4);
//if ($id==0) $curvalstr=""; else $curvalstr='"'.$datarow[$j].'"';  // else sets db values
$tmpvals=explode("'",$row[1]);         // get values of enum field     BAD TO PUT THIS INTO 
$ni=round(count($tmpvals)/2)-1;
for ($i=0; $i<$ni;$i++){
  	$vals[$i]=$tmpvals[$i+$i+1];
 }
echo("<td>");
  if ($subst=="enum") {
         echo('<select  name='. mysql_field_name($result,$j).' width=170>');
			echo ('<option>не важно</option>');
			for ($i=0;$i<$ni;$i++){
    	      echo ('<option>'.$vals[$i].'</option>');
             }
		 echo('</select>'); 
   }  else
        if ($subst=="tiny")
	      	echo('<input type="text" size=30 maxlength =200 name= "' . mysql_field_name($result,$j).'" value='.$curvalstr.' >');
        else   
            echo('<input type="text" size=11 maxlength =11 name= "' . mysql_field_name($result,$j).'" value='.$curvalstr.' >');
  echo("</td>");
  echo('</tr>');
}
   ?>
   </table>
<input type="reset" name="reset" value="Заново">
<input type="submit" name="Submit" value="Поиск >>"></form>

</body>
</html>
