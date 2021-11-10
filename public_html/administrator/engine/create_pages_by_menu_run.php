<?include("top.php");?>

<div class="caption">Создание Страниц по пунктам Меню - Выполнено</div>
<div class="barrer"></div>
<div class="caption">Данные занесены в таблицу Страницы</div>

<table class="bordered">
 <thead>
   <tr>
     <th>Номер</th>
     <th>Пункт меню</th>
     <th>Url</th>
     <th>Действие</th>
   </tr>
 </thead>
 <tbody>

<?
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
?>  
  <tr>
    <td><?=$count;?></td>
    <td><?=$r0[title];?></td>
    <td><?=$r0[url];?></td>
    <?if ($exist==1) { echo '<td style="color: green;">Страница уже создана</td>'; } else 
	{ 
	  $sql2="
INSERT INTO `page` (`id`, `title`, `url`, `text`, `sort`, `in_menu`, `menutitle`, `types_id`) 
VALUES (NULL, '".$r0[title]."', '".$r0[url]."', 'Текст ".$r0[title]."', NULL, '1', '".$r0[title]."', '1');
";
	  $res2=mysql_query($sql2);

	  echo '<td style="color: darkred;"><b>Запись добавлена!<b></td>'; 
	} ?>
  <tr>
<?
  }
endwhile; 
?>

 </tbody>
</table>

<?	include("foot.php");	?>