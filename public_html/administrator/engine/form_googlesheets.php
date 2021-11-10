<?include("top.php");?>
<?
/*
(form_googlesheets) ---> (prepare_parse) ---> (process_parse.php)
		   \__
		      (process_truncate.php)
								mysql: [googlesheets]<----id----[googlesheets_setup]
*/
?>

<div class="caption">Загрузка данных Goolge.Таблицы</div>
<div class="barrer"></div>

<?
if ($_GET[mw]>0){ // загрузка выполнена
?>
<div class="success">
<h1>Загрузка данных выполнена успешно!</h1>
</div> 
<div class="barrer"></div>

<div class="info">
<h2>Информация:</h2>
<table>
<tr><td>Столбцов:</td><td><?=$_GET[mw];?></td></tr>
<tr><td>Строк:</td><td><?=$_GET[mh];?></td></tr>
<tr><td>Max цены:</td><td><?=$_GET[p];?> (тыс.руб.)</td></tr>
<tr><td>Max этаж:</td><td><?=$_GET[s];?></td></tr>
<tr><td>Max кол-во комнат:</td><td><?=$_GET[r];?></td></tr>
<tr><td>Max площадь:</td><td><?=$_GET[a];?> м<sup>2</sup></td></tr>
</table>
</div> 
<div class="barrer"></div>
<? } 

if($_GET[truncated]==1) { ?>
<div class="error">
<h1>Данные связанны таблиц объектов недвижимости стерты!</h1>
</div> 
<div class="barrer"></div>


<? } ?>

<form onSubmit="" method="post" action="prepare_parse.php">
<ul class="tools-menu">
<h4>Выберите источник данных:</h4>
  <li>
<select id="googlesheet" name="googlesheet">
<?
$count=0; $sql0='SELECT * FROM `googlesheets`';
$res0=mysql_query($sql0);
while ($r0=mysql_fetch_array($res0)): ?>
<option value="<?=$r0[id];?>"><?=$r0[title];?></option>
<? endwhile; ?>
</select>
  </li>
</ul>

<div class="barrer"></div>
<ul class="tools-menu">
  <li>
<input type="submit" id="sub" name="sub" value="Выполнить загрузку данных"></li>
</ul>
<div class="barrer"></div>

<ul class="tools-menu">
<h4>Дополнительные возможности:</h4>
	<li><a href="table.php?tbl=googlesheets">Настройка ссылок на Таблицы.Google</a></li>
	<li><a href="table.php?tbl=googlesheets_setup">Настройки модуля загрузки</a></li>
	<li><a  onclick='return confirm("Данные базы будут безвозвратно удалены?")' href="process_truncate.php" style="background: #990000;">Стереь базу данных объектов</a></li>
</ul>

<div style="padding-bottom: 400px;"></div>

<?include("foot.php");?>