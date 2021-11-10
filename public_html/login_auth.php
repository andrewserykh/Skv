<?
$page_logged="/";
include_once("administrator/engine/initdb.php");

$user_ean = $_POST['ean'];
$username_income = $_POST['username'];
$userid_income = $_POST['userid'];
$password_income = $_POST['password'];

if(strlen($user_ean)==13){
$sql0="SELECT `user`.`id` FROM `user` WHERE `user`.`ean` LIKE('".$user_ean."')";
$res0=mysql_query($sql0); $count=0;
while ($r0=mysql_fetch_array($res0)) { $count++; $userid = $r0[id]; }
} //user_ean==13
if($count==0){
$sql0="SELECT `user`.`id`, `user`.`password` FROM `user` WHERE `user`.`username` LIKE('".$username_income."')";
if ($userid_income>0) $sql0="SELECT `user`.`id`, `user`.`password` FROM `user` WHERE `user`.`id`=".$userid_income;
$res0=mysql_query($sql0);
while ($r0=mysql_fetch_array($res0)) { $pwd = $r0[password]; $userid = $r0[id]; }
//$password_income = md5(md5(trim($_POST['password']))); //шифрование пароля
} else {
$password_income=$pwd="ean_login";
}

if ($password_income==$pwd) {
  $hash = md5(generateCode(10));
  $sql0="UPDATE `user` SET `user`.`hash`='".$hash."' WHERE `user`.`id`=".$userid;
  $res=mysql_query($sql0);
  SetCookie("id", $userid, time()+60*60*24*30);
  SetCookie("hash", $hash, time()+60*60*24*30);
  $sql = "INSERT INTO `user_login`(`id`,`date`, `user_id`) VALUES(NULL,NOW(),".$userid.");";
  $res=mysql_query($sql);
}

header("location: ".$page_logged);

function generateCode ($length=16)
{
    $chars = "abcdef0123456789"; 
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length)
        $code .= $chars[mt_rand(0,$clen)];
    return $code; 
}
?>