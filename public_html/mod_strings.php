<?
//Собственные функции работы со строками

function modStrings_substr($page_content, $str_before, $str_after) { //Вырезает подстроку начиная с строки и заканчивая строкой
    $idx_fr = strpos($page_content,$str_before);
    $idx_to = strpos($page_content,$str_after,strpos($page_content,$str_before)+strlen($str_before));
    $res = substr($page_content,$idx_fr+strlen($str_before),$idx_to-($idx_fr+strlen($str_before)));
    return ($res);
}

function modStrings_cuthead($string, $substring) {
    $idx_fr = strpos($string, $substring);
    $length = (strlen($string) - $idx_fr)-strlen($substring);
    $cut = substr($string, $idx_fr + strlen($substring),$length);
    return($cut);
}


?>