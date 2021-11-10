<div id="header">
	<div class="container">
		<h1><a href="table.php?tbl=page">Администратор</a></h1>&nbsp
		<a hraf="logout.php" style="font-size: 7px;" class="version"><?include("version.php");?></a>&nbsp&nbsp&nbsp
		<a href="tools.php"><img src="img/setup.png"/></a>
        <a HREF="#nul" ONCLICK="window.open('ckeditor/kcfinder/browse.php?langCode=ru ','','Toolbar=1,Location=0,Directories=0,Status=0,Menubar=0,Scrollbars=0,Resizable=0,Width=900,Height=600');"><img src="img/filemanager.png"/></a>
        <a href="logout.php"><img src="img/logout.png"/></a>
		<a hraf="logout.php" style="font-size: 9px;" class="user"><?=$_COOKIE['auth'];?></a>
		<div id="nav">
			<ul>
<?
$res=mysql_query("SHOW tables"); 
if (strpos($PHP_SELF,'table.php')>1000)
{ ?>
	<select id="s" onChange='document.location.href="http://<?=$SERVER_NAME.$PHP_SELF?>?tbl="+document.getElementById("s").value'>
	<? while ($row=mysql_fetch_row($res)) {
	     if ($row[0]==$tbl) $sel="selected"; else $sel="";	
	     echo "<option value=$row[0] $sel>". $tblnms[$row[0]]." </option>";
	   } ?>
	</select>	<?
}

mysql_data_seek($res, 0);
while ($row=mysql_fetch_row($res))  
	if ($tblnms[$row[0]] && $row[0]!=='vmark' && $row[0]!=='vtype' &&$row[0]!=='vmodel' &&$row[0]!=='vseries'){
		if ($row[0]==$tbl) $sel=' class="active"'; else $sel='';
		?>
				<li <? echo $sel; ?>><a href="<? echo ("table.php?tbl=".$row[0]);?>"><? echo ($tblnms[$row[0]]); ?></a></li>
<?	}  	?>
			</ul>
		</div>
	</div>
</div>

<? if (isset($tbl_ext)) { ?>
<div id="header">
  <div class="container">
	<div id="nav">
	<ul>
<?
if (isset($tbl_ext)) foreach ($tbl_ext as $name=>$val) {
	if ($name==$tbl) $sel=' class="active"'; else $sel='';
	echo '<li '.$sel.'><a href="table.php?tbl='.$name.'">'.$val.'</a></li>';
}
?>
	</ul>
	</div>
  </div>
</div>
<? } ?>

<? if (isset($tbl_ext2)) { ?>
<div id="header">
  <div class="container">
	<div id="nav">
	<ul>
<?
if (isset($tbl_ext2)) foreach ($tbl_ext2 as $name=>$val) {
	if ($name==$tbl) $sel=' class="active"'; else $sel='';
	echo '<li '.$sel.'><a href="table.php?tbl='.$name.'">'.$val.'</a></li>';
}
?>
	</ul>
	</div>
  </div>
</div>
<? } ?>

<div id="header-bottom"></div>

<?
IF (strpos($REQUEST_URI,'table.php')>0):
	if (isset($sim)) $sims="&sim=$sim";
	if ($tbl=='vmodel1' ){?>
	<p>| <a href="table.php?tbl=<?=$tbl?>">Все</a> | <?
	$vals=GetRelNamesArray('vseries_id');
	$res=mysql_query("select id from vseries");
		while ($row=mysql_fetch_array($res)) {
			if (isset($ztype_id)) if ($row[0]==$ztype_id) $sel="style='font-weight: bold'"; else $sel="";	
			echo "<a href='table.php?tbl=$tbl&vseries_id=$row[id]' $sel> ".$vals[$row[id]]." </a> | ";
		}  
	}
	
	if ($tbl=='vmodel' || $tbl=='vseries'){?>
	<p>| <a href="table.php?tbl=<?=$tbl?>">Все</a> | <?
	if (isset($vmark_id)) $gid="&vmark_id=$vmark_id"; else $gid='';
	
	$yget='year'; if ($tbl=='vseries') $yget='year_url';
	$y=2003;
		while ($y<2012) { $y++;
			if (isset($year)) if ($y==$year) $sel2="style='font-weight: bold' "; else $sel2="";
			if (isset($year_url)) if ($y==$year_url) $sel2="style='font-weight: bold' "; else $sel2="";
			echo "<a href='table.php?tbl=$tbl$gid&$yget=$y$sims' $sel2 > ".$y."  </a> | ";
		}  
	}
	
	
	if ($tbl=='zmodel' ){?>
	<p>| <a href="table.php?tbl=<?=$tbl?>">Все</a> | <?
	$vals=GetRelNamesArray('ztype_id');
	$res=mysql_query("select id from ztype where ok=1");
		while ($row=mysql_fetch_array($res)) {
			if (isset($ztype_id)) if ($row[0]==$ztype_id) $sel="style='font-weight: bold'"; else $sel="";	
			echo "<a href='table.php?tbl=$tbl&ztype_id=$row[id]' $sel> ".$vals[$row[id]]." </a> | ";
		}  
	}
ENDIF;	
?>