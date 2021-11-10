<? 
$_LOGGED=1;
$_USERACCESS=999;

$sql0="
SELECT 
`user`.`title` AS `userfullname`,
`user`.`username` AS `name`,
`user`.`hash` AS `hash`,
`user_access`.`value` AS `access`
FROM `user`,`user_access` 
WHERE 
`user`.`user_access_id`=`user_access`.`id` AND
`user`.`id`=".$_COOKIE['id'];
$res0=mysql_query($sql0);
while ($r0=mysql_fetch_array($res0)) {
	$hash_db = $r0[hash];
	$_USERNAME=$r0[name];
	$_USERACCESS=$r0[access];
	$_USERFULLNAME = $r0[userfullname];
}
if($hash_db==$_COOKIE['hash']&&isset($_COOKIE['hash'])) $_LOGGED=1;
if($_LOGGED==0) include("login_fail.php");
include_once("mod_useraccess.php"); //Контроль уровня доступа
?>

