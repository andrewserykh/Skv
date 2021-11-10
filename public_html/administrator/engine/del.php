<?

if (isset($_GET['tbl'])) foreach ($_GET as $name=>$val) if ($name!="id") $gets.="&$name=$val";

$tbl = $_GET['tbl'];
$id=$_GET['id'];

include('initdb.php');

mysql_query("DELETE FROM $tbl WHERE id=$id");
header("Location: table.php?tbl=".$tbl.$gets);
?>