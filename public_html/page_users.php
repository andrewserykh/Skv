<? //универсальный код отображения страницы с добавлением, редактированием, удалением записей (1.0a)

modUserAccess_check(9);

include_once("mod_strings.php");

//---определение исходных данных
$title_view_table="Спортсмены стрелкового комплекса";
$icon_view_table="zwicon-users";
$sql_view_table="
SELECT
    `user`.`id` AS `id`,
    `user`.`title` AS `title`,
    `user`.`username` AS `username`,
    `user`.`password` AS `password`,
    `user_access`.`id` AS `user_access_id`
  FROM `user`,`user_access` WHERE
    `user`.`user_access_id`=`user_access`.`id` AND
    `user_access`.`id`=1
  ORDER BY `user`.`id` DESC;
";

$title_view_detail="Редактирование профиля пользователя";
$icon_view_detail="zwicon-users";
$sql_view_detail="
 SELECT
    `user`.`id` AS `id`,
    `user`.`title` AS `title`,
    `user`.`username` AS `username`,
    `user`.`password` AS `password`,
    `user_access`.`id` AS `user_access_id`
  FROM `user`,`user_access` WHERE
    `user`.`id`=$_GET[id] AND
    `user`.`user_access_id`=`user_access`.`id`
  ORDER BY `user`.`id` DESC;
";

$title_add_item="Добавление нового спортсмена";
$icon_add_item="zwicon-user-plus";
$sql_main_table="user"; //для создания/удаления записей

//дальше лучше ничего не трогать, все работало хорошо (СМОТРЕТЬ ТОЛЬКО ДЛЯ РЕДАКТИРОВАНИЯ ШАБЛОНА html)
//---
if (isset($_GET["id"])) { //получен id, значит открыть запись в режиме редактирования
    ViewDetail($sql_view_detail, $title_view_detail, $icon_view_detail); //передан id пользователя, значит окно редактирования профиля
}
elseif (isset($_GET["additem"])) { //добавление новой записи
    ViewAddItem($sql_main_table, $title_add_item, $icon_add_item);
}
elseif (isset($_GET["delete_item_id"])) { //удаление записи
    mysql_query("DELETE FROM $sql_main_table WHERE id=".$_GET["delete_item_id"]);
    ViewList($sql_view_table, $title_view_table, $icon_view_table); //вывод таблицы
}
else { //отображение таблицы согласно запросу
    if (isset($_POST["mysql_edit_item"])) { //если есть на входе POST массив, то обновляем запись
        foreach ($_POST as $key => $value) {
            if ($key == "mysql_table_name") $table = $value;
            elseif ($key == "id") $id = $value;
            elseif ($key == "mysql_edit_item") echo "";
            else $strs[$key] = $value;
        } //foreach
        $sql = "UPDATE `" . $table . "` SET ";
        foreach ($strs as $key => $value) $sql = $sql . " `" . $key . "`='" . $value . "',";
        $sql = substr($sql, 0, -1);//удаление последнего символа ,
        $sql = $sql . " WHERE `id`=" . $id;
        $res = mysql_query($sql);
    }//isset POST

    if (isset($_POST["mysql_new_item"])) { //если есть на входе POST массив, то обновляем запись
        foreach ($_POST as $key => $value) {
            if ($key == "mysql_table_name") $table = $value;
            elseif ($key == "id") $id = $value;
            elseif ($key == "mysql_new_item") echo "";
            else $strs[$key] = $value;
        }//foreach
        sqlar_insert($table,$strs); //добавить запись
    }//isset POST

    ViewList($sql_view_table, $title_view_table, $icon_view_table); //вывод таблицы
}

//далее функции отображения (РЕДАКТИРОВАТЬ ДЛЯ ВЕРСТКИ ШАБЛОНА ТУТ!)
//---
function ViewList($sql, $title, $icon)
{ //функция вывода таблицы согласно запросу
    global $pg; ?>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><i class="<?= $icon; ?>"></i> <?= $title; ?></h4>
                <div style="margin-top: -20px;">
                    <a href="<?= $pg; ?>?additem=1" class="btn btn-theme btn--icon"><i class="zwicon-user-plus"></i></a>
                </div>
                <h6></h6>

                <?
                //получаем колонки из запроса $sql
                $rows = explode(',', modStrings_substr($sql, "SELECT", "FROM"));
                //получаем массив таблица из запроса $sql
                $tables = explode(',', trim(str_replace("`", "", modStrings_substr($sql, "FROM", "WHERE"))));
                $resTable = mysql_query($sql);
                ?>
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <?
                        $cnt = 0;
                        foreach ($rows as $key => $value) {
                            $comment = (get_MySQL_COMMENT($tables, mysql_field_name($resTable, $cnt)));
                            if ($comment == "id") $comment = ""; ?>
                            <th><?= $comment; ?></th>
                            <?
                            $cnt++;
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <? while ($rT = mysql_fetch_array($resTable)): ?>
                        <tr>
                            <? foreach ($rT as $key => $value) {
                                if (!is_numeric($key)) {
                                    if ($key != "id") {
                                        if (substr($key, strlen($key) - strlen("_id")) == "_id") {
                                            $subkey = substr($key, 0, strlen($key) - strlen("_id"));
                                            $sqltemp = "SELECT `title` FROM `$subkey` WHERE `$subkey`.`id`=$value";
                                            $restemp = mysql_query($sqltemp);
                                            while ($rtemp = mysql_fetch_array($restemp)) $subtitle = $rtemp[title];
                                            echo "<td>".$subtitle . "</td>";
                                        } else {//_id
                                            echo "<td>".$rT[$key] . "</td>";
                                        }//!_id
                                    }//!=id
                                    if ($key == "id") { ?>
                                        <td>
                                            <a href="/<?= $pg; ?>?id=<?= $rT[id]; ?>" class="btn btn-theme btn--icon"><i
                                                        class="zwicon-user-circle"></i></a>
                                            <a href="<?=$pg?>?delete_item_id=<?=$rT[id];?>" onClick="return confirm('Подтвердите удаление?')" class="btn btn-theme btn--icon"><i class="zwicon-user-delete"></i></a>
                                        </td>
                                        <?
                                    }//==id
                                }//is_numeric
                            }//foreach?>
                        </tr>
                    <? endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?
    return;
} //function

function ViewDetail($sql, $title, $icon)
{ //вывод записи для редактирования
    global $pg; ?>
    <section class="content">
        <h1 class="card-title"><i class="<?= $icon; ?>"></i><?= $title; ?></h1>
        <form role="form" enctype="multipart/form-data" name="formedit" method="post" action="<?= $pg; ?>">
            <div style="margin-top: -20px;">
                <a href="/<?= $pg; ?>" class="btn btn-theme btn--icon"><i class="zwicon-back"></i></a>
                <button type="submit" class="btn btn-theme btn--icon"><i class="zwicon-tray-import"></i></button>
            </div>
            <br>
            <div class="card">
                <div class="card-body">

                    <div class="col-md-6">
                        <?
                        //получаем колонки из запроса $sql
                        $rows = explode(',', modStrings_substr($sql, "SELECT", "FROM"));
                        //получаем массив таблица из запроса $sql
                        $tables = explode(',', trim(str_replace("`", "", modStrings_substr($sql, "FROM", "WHERE"))));
                        $resTable = mysql_query($sql);
                        while ($rT = mysql_fetch_array($resTable)):
                            foreach ($rT as $key => $value) {
                                if (!is_numeric($key)) {
                                    $type = "text";
                                    if ($key == "id") $type = "hidden"; ?>
                                    <div class="form-group"> <?
                                        if (substr($key, strlen($key) - strlen("_id")) == "_id") {
                                            $subid = $value;
                                            $subkey = substr($key, 0, strlen($key) - strlen("_id"));
                                            echo '<label>' . get_MySQL_COMMENT($subkey, "title", 2) . '</label>';
                                            echo '<select disabled name="' . $key . '" class="form-control">';
                                            $sqltemp = "SELECT `id`,`title` FROM `$subkey`";
                                            $restemp = mysql_query($sqltemp);
                                            while ($rtemp = mysql_fetch_array($restemp)) {
                                                $selected = "";
                                                if ($subid == $rtemp[id]) $selected = "selected";
                                                echo "<option value='" . $rtemp[id] . "' " . $selected . ">" . $rtemp[title] . "</option>";
                                            }
                                            echo '</select>';
                                        } else {
                                            if ($type != "hidden" && $key != $subkey) echo "<label>" . get_MySQL_COMMENT($tables, $key) . "</label>";
                                            ?>
                                            <input name="<?= $key; ?>" value="<?= $value; ?>" type="<?= $type; ?>"
                                                   class="form-control">
                                        <? } //_ids
                                        ?>
                                    </div>
                                    <?
                                }//!is_numeric
                            }//foreach
                        endwhile;
                        ?>
                    </div>
                </div>
            </div>
            <input name="mysql_table_name" value="<?= $tables[0]; ?>" type="hidden"/>
            <input name="mysql_edit_item" value="1" type="hidden"/>
        </form>
    </section>

    <? return;
} //fuction

function ViewAddItem($table, $title, $icon)
{ //создание новой записи
    global $pg;
    $sql0 = "SELECT * FROM $table";
    $res0 = mysql_query($sql0);
    $r0 = mysql_fetch_array($res0);
    ?>
    <section class="content">
        <h1 class="card-title"><i class="<?= $icon; ?>"></i><?= $title; ?></h1>
        <form role="form" enctype="multipart/form-data" name="formedit" method="post" action="<?= $pg; ?>">
            <div style="margin-top: -20px;">
                <a href="/<?= $pg; ?>" class="btn btn-theme btn--icon"><i class="zwicon-back"></i></a>
                <button type="submit" class="btn btn-theme btn--icon"><i class="zwicon-tray-import"></i></button>
            </div>
            <br>
            <div class="card">
                <div class="card-body">

                    <div class="col-md-6">
                        <?
                        foreach ($r0 as $key => $value)
                            if (!is_numeric($key)) {
                                $type = "text";
                                if ($key == "id") $type = "hidden"; ?>
                                <div class="form-group"> <?
                                    if (substr($key, strlen($key) - strlen("_id")) == "_id") {
                                        $subid = $value;
                                        $subkey = substr($key, 0, strlen($key) - strlen("_id"));
                                        echo '<label>' . get_MySQL_COMMENT($subkey, "title", 2) . '</label>';
                                        echo '<select disabled name="' . $key . '" class="form-control">';
                                        $sqltemp = "SELECT `id`,`title` FROM `$subkey`";
                                        $restemp = mysql_query($sqltemp);
                                        while ($rtemp = mysql_fetch_array($restemp)) {
                                            echo "<option value='" . $rtemp[id] . "'>" . $rtemp[title] . "</option>";
                                        }
                                        echo '</select>';
                                    } else {
                                        if ($type != "hidden" && $key != $subkey) echo "<label>" . get_MySQL_COMMENT($table, $key) . "</label>";
                                        ?>
                                        <input name="<?= $key; ?>" type="<?= $type; ?>" class="form-control">
                                    <? } //_ids
                                    ?>
                                </div>
                                <?
                            }//!is_numeric
                        ?>
                    </div>
                </div>
            </div>
            <input name="mysql_table_name" value="<?= $table; ?>" type="hidden"/>
            <input name="mysql_new_item" value="1" type="hidden"/>
        </form>
    </section>

    <? return;
} //fuction

//далее идет зона служебных функций (НЕ РЕДАКТИРОВАТЬ)
//---
function get_MySQL_COMMENT($table, $fieldname)
{ //функция извлечения КОММЕНТАРИЯ КОЛОНКИ из базы (на входе массив таблиц из запроса)
    $comment = "";
    if (count($table) > 1) {
        foreach ($table as $key => $value) {
            $sql0 = "
SELECT COLUMN_COMMENT
FROM information_schema.`COLUMNS`
WHERE TABLE_NAME = '" . $value . "' AND COLUMN_NAME = '" . $fieldname . "'
";
            $res0 = mysql_query($sql0);
            while ($r0 = mysql_fetch_array($res0))
                if (strlen($r0[COLUMN_COMMENT]) > 0 && strlen($comment) == 0) {
                    $comment = $r0[COLUMN_COMMENT];
                }//strlen
        } //foreach
    } else {//count $table
        $sql0 = "
SELECT COLUMN_COMMENT
FROM information_schema.`COLUMNS`
WHERE TABLE_NAME = '" . $table . "' AND COLUMN_NAME = '" . $fieldname . "'
";
        $res0 = mysql_query($sql0);
        while ($r0 = mysql_fetch_array($res0))
            if (strlen($r0[COLUMN_COMMENT]) > 0 && strlen($comment) == 0) {
                $comment = $r0[COLUMN_COMMENT];
            }//strlen
    }//count($table)
    return $comment;
}

function sqlar_insert($table, $sqlar)
{ //функция создания новой записи в таблице
    $sql = "INSERT INTO `" . $table . "` (";
    foreach ($sqlar as $key => $value) $sql .= "`" . $key . "`,";
    $sql = substr($sql, 0, -1); //удаляем последнюю запятую
    $sql .= ") VALUES (";
    foreach ($sqlar as $key => $value) {
        if ($value == "NULL") {
            $sql .= $value . ",";
        } else {
            $sql .= "'" . $value . "',";
        }
    }
    $sql = substr($sql, 0, -1); //удаляем последнюю запятую
    $sql .= ");";

    $res = mysql_query($sql);
    $cur_id = mysql_insert_id();
    return ($cur_id);
}

?>
