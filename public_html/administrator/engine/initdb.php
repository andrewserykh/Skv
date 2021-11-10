<?
if (version_compare(PHP_VERSION, '7.0.0','>=')) //возврат поддержки mysql для php версии > 7.0
{

    function mysql_connect($server,$username,$password,$new_link=false,$client_flags=0) {
        $GLOBALS['mysql_oldstyle_link']=mysqli_connect($server,$username,$password);
        return $GLOBALS['mysql_oldstyle_link'];
    }

    function mysql_pconnect($server,$username,$password,$new_link=false,$client_flags=0) {
        $GLOBALS['mysql_oldstyle_link']=mysqli_connect($server,$username,$password);
        return $GLOBALS['mysql_oldstyle_link'];
    }

    function mysql_query($sql,$link=NULL) {
        if ($link==NULL) $link=$GLOBALS['mysql_oldstyle_link'];
        return mysqli_query($link,$sql);
    }

    function mysql_fetch_row($res) {
        return mysqli_fetch_row($res);
    }

    function mysql_fetch_assoc($res) {
        return mysqli_fetch_assoc($res);
    }

    function mysql_fetch_array($res) {
        return mysqli_fetch_array($res);
    }

    function mysql_fetch_object($res,$classname='stdClass',$params=array()) {
        return mysqli_fetch_object($res,$classname,$params);
    }

    function mysql_affected_rows($link=NULL) {
        if ($link===NULL) $link=$GLOBALS['mysql_oldstyle_link'];
        return mysqli_affected_rows($link);
    }

    function mysql_insert_id($link=NULL) {
        if ($link===NULL) $link=$GLOBALS['mysql_oldstyle_link'];
        return mysqli_insert_id($link);
    }

    function mysql_select_db($database_name,$link=NULL) {
        if ($link==NULL) $link=$GLOBALS['mysql_oldstyle_link'];
        return mysqli_select_db($link,$database_name);
    }

    function mysql_errno($link=NULL) {
        if ($link===NULL) $link=$GLOBALS['mysql_oldstyle_link'];
        return mysqli_errno($link);
    }

    function mysql_error($link=NULL) {
        if ($link===NULL) $link=$GLOBALS['mysql_oldstyle_link'];
        return mysqli_error($link);
    }

    function mysql_num_rows($res) {
        return mysqli_num_rows($res);
    }

    function mysql_free_result($res) {
        return mysqli_free_result($res);
    }

    function mysql_close($link) {
        return mysqli_close($link);
    }

    function mysql_real_escape_string($sql,$link=NULL) {
        if ($link===NULL) $link=$GLOBALS['mysql_oldstyle_link'];
        return mysqli_real_escape_string($link,$sql);
    }

    function mysql_get_server_info($link=NULL) {
        if ($link===NULL) $link=$GLOBALS['mysql_oldstyle_link'];
        return mysqli_get_server_info($link);
    }

    function mysql_set_charset ($charset, $link_identifier = NULL) {
        if ($link===NULL) $link=$GLOBALS['mysql_oldstyle_link'];
        return mysqli_set_charset($link, $charset);
    }


} //поддержка mysql_connect

$dbhost = "localhost";
$dbname = "skv";
$dblogin = "root";
$dbpass = "root";

$pic_path="../../jpg/";
$pic_path2='../../jpg2/';
$tbl_default="page"; 
$on_page=50;
$rootlogin = "root";

$link = mysql_connect($dbhost,$dblogin,$dbpass);
mysql_select_db($dbname);

mysql_query("SET character_set_client = utf8");
mysql_query("SET character_set_connection = utf8");
mysql_query("SET character_set_results = utf8");

$img_dir="/upload/";
$onpage=20;
$salt=100000;
function GetShortStr($s,$lmax=180){	
$l=strlen($s);
	if ($l>$lmax)	{
		$k=$lmax;
		while (($s[$k]!==' ')&&($k>0)) $k--;
		$s=substr($s,0,$k-$l).'...'; 
	}
return strip_tags($s);
}

function GetFDate($date){
		$month01 = 'января';$month02 = 'февраля';$month03 = 'марта';$mouns04 = 'апреля';$month05 = 'мая';$month06 = 'июня';
		$month07 = 'июля';$month08 = 'августа';$month09 = 'сентября';$month10 = 'октября';$month11 = 'ноября';$month12 = 'декабря';
	$a=split('-',$date);
	return $a[2].' '.${'month'.$a[1]}.' '.$a[0].' г';
}

?>
