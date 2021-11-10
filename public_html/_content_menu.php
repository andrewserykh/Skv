<aside class="sidebar ">
    <div class="scrollbar">

        <ul class="navigation">
            <?
            $sql1='SELECT * FROM `topmenu` WHERE `url` LIKE ("root")'; $res1=mysql_query($sql1); while ($r1=mysql_fetch_array($res1)) $root_id=$r1[id];
            $sql1='SELECT * FROM `topmenu` WHERE `topmenu_id`='.$root_id.' AND `topmenu`.`access`<='.$_USERACCESS.' ORDER BY `sort`';
            $res1=mysql_query($sql1);
            while ($r1=mysql_fetch_array($res1)):
                $current=""; if ($par[0]==$r1[url]) { $current=' active'; }
                if ($r1[url]!="root"&&$r1[sort]!=0){
                    if($r1[url]!="/") $slash="/"; ?>

                    <li class="navigation__<?=$current;?>">
                        <a href="<?=$slash0;?><?=$r1[url];?>"><i class="<?=$r1[icon];?>"></i><?=$r1[title];?></a>

                        <?	$sql2='SELECT * FROM `topmenu` WHERE `topmenu_id`='.$r1[id].' ORDER BY `sort`';
                        $res2=mysql_query($sql2);
                        if (mysql_num_rows($res2) > 0){?>

                            <ul class="dropdown-menu">

                                <?		while ($r2=mysql_fetch_array($res2)): // class="active"?>

                                    <li><a href="/<?=$r2[url];?>"><?=$r2[title];?></a></li>

                                <?		endwhile; ?>

                            </ul>

                        <?	}	?>

                    </li>

                <?		}
            endwhile; ?>
        </ul>
    </div>
</aside>
