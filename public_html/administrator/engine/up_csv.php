<?
include('top.php');
//update_from_csv(); exit;
if (isset($upfile)){
$uploaddir="";
	if (strpos(strtolower($_FILES['upfile']['name']),'csv')>0){
	  if (move_uploaded_file($_FILES['upfile']['tmp_name'], $uploaddir.'himb.csv'))  { 
	    echo ("���� ".$_FILES['upfile']['name']." ������� ��������. ���� ��������� ������...<br><br>"); 
	    update_from_csv();
	 }
	  else if ($upfile) echo ("������ ��� �������� ����� ".$_FILES['upfile']['name'].". ��������� ��� ���<br>");
	} else echo ("�������� ������ ����� ". $_FILES['upfile']['name'].". ������ CSV!");
}
else
{
?>
	<h2>�������� ������ �� ������</h2>
 <p align="left">�������� ���� �����-����� � ������� (CSV):
	<form name="form1" enctype="multipart/form-data" method="post" action="">
   <p> <input type="file" name="upfile">  </p>
   <p><input name="Submit" type="submit" value="��������"></p>
</form>
<?}?>