<? 
$dbhost = "localhost";$dbname = "velopoisk"; $dblogin = "root"; $dbpass = "";
$bdvp=mysql_pconnect($dbhost,$dblogin,$dbpass);  //velopoisk

$dbhost = "localhost";$dbname = "u13339"; $dblogin = "root"; $dbpass = "";
$bdvs=mysql_pconnect($dbhost,$dblogin,$dbpass);  //velostrana

exec("mysqldump --user=root --password= --add-drop-table u13339 velomodel>/$DOCUMENT_ROOT/db_dump.sql");
?>