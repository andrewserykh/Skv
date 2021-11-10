<?
function modUserAccess_check ($level) //$level - Уровень доступа страницы
{
    global $_USERACCESS;
    if ($_USERACCESS < $level) { //для закрытых разделов контроль уровня доступа
        include("page_403.php");
        return(false);
    }
    return(true);
}
?>