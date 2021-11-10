<?include("top.php");?>

<div class="caption">Создание Страниц по пунктам Меню</div>
<div class="barrer"></div>
<div class="validation">
Выполяемое действие автоматически создаст записи в таблице <b>Страницы</b>
</div> 

<div class="barrer"></div>

<ul class="tools-menu">
	<li><a href="create_pages_by_menu_run.php">Выполнить действие</a></li>
	<? include("listpages.php"); ?>
</ul>


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
    <?if ($exist==1) { echo "<td>Страница для этого пункта уже существует, действие не требуется</td>"; } else { echo "<td><b>Страница будет создана<b></td>"; } ?>
  <tr>
<?
  }
endwhile; 
?>

 </tbody>
</table>

<?	include("foot.php");	?>