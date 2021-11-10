<?
header('Content-type: text/html; charset=utf-8');
include("../initdb.php");
$id=$_GET[id]; $sid=$_GET[sid]; 

$res2=mysql_query("select similar from vmodel where id=$id");
	$r2=mysql_fetch_array($res2);
    $sim_array=explode(' ',$r2[similar]);	//print_r( $sim_array);
	$key=array_search($sid,$sim_array);
	
if ($key){ //delete
	unset($sim_array[$key]);
	$sim=implode(" ",$sim_array);
	$sql="update vmodel set similar='$sim' where id=$id";
	mysql_query($sql);	
}
else{  //adding 
	$sql="update vmodel set similar=concat(similar,' ','$sid') where id=$id";
	mysql_query($sql);
}	
?>