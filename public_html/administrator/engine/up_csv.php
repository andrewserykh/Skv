<?
include('top.php');
//update_from_csv(); exit;
if (isset($upfile)){
$uploaddir="";
	if (strpos(strtolower($_FILES['upfile']['name']),'csv')>0){
	  if (move_uploaded_file($_FILES['upfile']['tmp_name'], $uploaddir.'himb.csv'))  { 
	    echo ("Файл ".$_FILES['upfile']['name']." успешно загружен. Идет обработка данных...<br><br>"); 
	    update_from_csv();
	 }
	  else if ($upfile) echo ("Ошибка при загрузке файла ".$_FILES['upfile']['name'].". Попробуте еще раз<br>");
	} else echo ("Неверный формат файла ". $_FILES['upfile']['name'].". Только CSV!");
}
else
{
?>
	<h2>Загрузка файлов на сервер</h2>
 <p align="left">Выберите файл прайс-листа в формате (CSV):
	<form name="form1" enctype="multipart/form-data" method="post" action="">
   <p> <input type="file" name="upfile">  </p>
   <p><input name="Submit" type="submit" value="Закачать"></p>
</form>
<?}?>