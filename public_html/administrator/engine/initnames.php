<?
$qr="SHOW full columns FROM $tbl";
 $res=mysql_query($qr); 
 if ($res) 
  for  ($j=0;$j< mysql_num_rows($res); $j++) 
  {
 $row=mysql_fetch_array($res);

 $fld_name[$j]=$row[8]; //comment from field DB 
 $fld_dflt[$j]=$row['Default']; //default value of the field
 $fld_null[$j]=$row['Null']; //Null   yes/no
 $fld_field[$j]=$row[0];
  }

$tblnms=array(
    'page'=>'Страницы',
    'topmenu'=>'Меню',
    'types'=>'Типы',
    'user_access'=>'Доступ',
    'user'=>'Пользователи'
);


$tbl_ext2=array(
);

?>