<?
//добавить в case . после слова, чтобы значение переменной переводилось в строку, на случай если там число.
switch ($tbl."."){
	case "topmenu.": ?>
<div class="info">
Главный пункт меню должен содержать пустое поле url
</div> 
<?
$count=0;$sql0='SELECT * FROM `topmenu` WHERE `url` LIKE("root")';
$res0=mysql_query($sql0);
while ($r0=mysql_fetch_array($res0)){$count++;}
if ($count==0){?>

<div class="alert">
Таблица должна содержать Корневой пункт с url равным root, 
для пунктов меню первого уровня указать в свойство Родитель = Корневой пункт
</div> 
<br><br><br><br><br><br>
<ul class="tools-menu">
	<li><a style="background: #ff4f52;" href="live_topmenu_create.php">Создать Корневой пункт</u></a></li>
</ul>
<? } ?>
<div style="padding-bottom: 130px;"></div>
	<? break;
	default:
	break;
}

?>