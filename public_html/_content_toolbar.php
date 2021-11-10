<header class="header">
    <div class="navigation-trigger d-xl-none" data-sa-action="aside-open" data-sa-target=".sidebar">
        <i class="zwicon-hamburger-menu"></i>
    </div>

    <div class="logo d-none d-sm-inline-flex">
        <a href="/"><?=$settings["sitename"];?></a>
    </div>



    <ul class="top-nav">
        <li class="d-xl-none"><a href="" data-sa-action="search-open"><i class="zwicon-search"></i></a></li>

        <li class="dropdown top-nav__notifications">
            <a href="" data-toggle="dropdown" class="top-nav__notify">
                <i class="zwicon-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu--block">
                <div class="dropdown-header">
                    Системный журнал

                    <div class="actions">
                        <a href="" class="actions__item zwicon-checkmark-square" data-sa-action="notifications-clear"></a>
                    </div>
                </div>

                <div class="listview listview--hover">
                    <div class="listview__scroll scrollbar">
<?
$sql0 = 'SELECT * FROM `syslog` WHERE 1 ORDER BY id DESC LIMIT 10';
$res0 = mysql_query($sql0);
while ($r0 = mysql_fetch_array($res0)): ?>
                        <a href="" class="listview__item">
                            <div class="listview__content">
                                <div class="listview__heading"><?=$r0[title];?></div>
                                <p><?=(date('j.m.Y H:i:s', strtotime($r0[time])));?></p>
                            </div>
                        </a>
<?endwhile;?>




                    </div>

                    <div class="p-1"></div>
                </div>
            </div>
        </li>

    </ul>

    <div class="clock d-none d-md-inline-block">
        <div class="time">
            <span class="time__hours"></span>
            <span class="time__min"></span>
            <span class="time__sec"></span>
        </div>
    </div>
</header>