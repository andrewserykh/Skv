<?
function get_img_name ($fn,$w){ //???  no fact
	$dir=dirname($fn); 
$part=explode(".",basename($fn));
$new_fn=$dir.'/'.$part[0].$new_w.'.'.$part[1];
	return $new_fn;
}

// createpreview_w(name,width,class,id,quality,id,on_click,title);

function createpreview_w($fn,$new_w=150,$class='',$q=90,$id='',$on_click='',$title=''){  // filename, new width, quality   create img preview and returns it`s html
 if (file_exists($fn))
 {
	 if (filesize($fn)> 700000)  return "";
$dir=dirname($fn); 
$part=explode(".",basename($fn));
$new_fn=$dir.'/'.$part[0].$new_w.'.'.$part[1];
if (!file_exists($new_fn)&&file_exists($fn)&&($part[1])):

	$old = imageCreateFromJpeg($fn);
	$w = imageSX($old); $h = imageSY($old); 
	$k=$w / $new_w;
	$w_new=round($w/$k);$h_new=round($h/$k);
	$new = imageCreateTrueColor($w_new, $h_new);
	imagecopyresampled($new, $old, 0, 0, 0, 0, $w_new, $h_new, $w, $h); //imageCopyResized
	imageJpeg($new,$new_fn,$q);
	chmod($new_fn,0777);
	imageDestroy($old); imageDestroy($new);
	
endif;	
   if ($on_click)   $on_click=" onClick ='$on_click' ";
   if ($class)   $class=" class ='$class' ";
   if ($title) $title=" title='$title'";
return '<img id="'.$id.'" border=0 src="/'.$new_fn.'" '.$class.$on_click.$title.'>';

 }  else return "<img src='/img/nophoto.jpg' title='$fn' width='$new_w'>";
}

// createpreview_h(name,width,height,class,id,id,on_click,title,quality);

function createpreview_h($fn,$new_w,$new_h,$class='',$id='',$on_click='',$title='',$q=90){
 if (file_exists($fn))
 {
	 if (filesize($fn)> 700000)  return "";
$dir=dirname($fn); 
$part=explode(".",basename($fn));
$new_fn=$dir.'/'.$part[0].$new_h.'.'.$part[1];
if (!file_exists($new_fn)&&file_exists($fn)&&($part[1])):

	$old = imageCreateFromJpeg($fn);
	$w = imageSX($old); $h = imageSY($old);
	$k=$h / $new_h;
	$h_new=round($h/$k);
	$w_new=round($w/$k); $x=0;
		$new = imageCreateTrueColor($new_w, $new_h);
		$white = imagecolorallocate($new, 255, 255, 255);	
		imagefill($new,0, 0,$white);
		$x=round(($new_w-$w_new)/2);
	imagecopyresampled($new, $old, $x, 0, 0, 0, $w_new, $h_new, $w, $h); //imageCopyResized
	imageJpeg($new,$new_fn,$q);
	chmod($new_fn,0777);
	imageDestroy($old); imageDestroy($new);
	
endif;	
   if ($on_click)   $on_click=" onClick ='$on_click' ";
   if ($class)   $class=" class ='$class' ";
   if ($title) $title=" title='$title'";
return '<img id="'.$id.'" border=0 src="/'.$new_fn.'" '.$class.$on_click.$title.'>';


 }  else return "<img src='/img/nophoto.jpg' title='$fn' width='$new_w'>";
}


// this version not crop  only auto size  h and w  with filled white

// createpreview(name,width,quality,id,on_over,title,height,lowsrc);

function createpreview($fn,$new_w=150,$q=90,$id='',$on_over='',$title='',$new_h=150,$lowsrc=''){  // filename, new width, quality   create img preview and returns it`s html
 if (file_exists($fn) && strpos($fn,'.')>-1 )
 {
	
$dir=dirname($fn); 
$part=explode(".",basename($fn));
 $new_fn=$dir.'/'.$part[0].$new_w.'.'.$part[1];
if (!file_exists($new_fn)&&file_exists($fn)&&($part[1])):

	$old = imageCreateFromJpeg($fn);
	$w = imageSX($old); $h = imageSY($old);
	$k=$w / $new_w;
	$w_new=round($w/$k);$h_new=round($h/$k); $x=0;
	if ($h_new>$new_h) {//  resize by height
		$k=$h / $new_h;
		$w_new=round($w/$k);$h_new=round($h/$k);
		$new = imageCreateTrueColor($new_w, $h_new);
		$white = imagecolorallocate($new, 255, 255, 255);	imagefill($new,0, 0,$white);
		$x=round(($new_w-$w_new)/2);
	}	
	else $new = imageCreateTrueColor($w_new, $h_new);
	imagecopyresampled($new, $old, $x, 0, 0, 0, $w_new, $h_new, $w, $h); //imageCopyResized
	imageJpeg($new,$new_fn,$q);
	chmod($new_fn,0777);
	imageDestroy($old); imageDestroy($new);
	
endif;	
   if ($on_over)   $on_over=" onmouseover ='$on_over' ";
   if ($title) $title=" title='$title'";
   if ($lowsrc) $lowsrc=" lowsrc='$lowsrc'";
return '<img id="'.$id.'" border=0 src="/'.$new_fn.'" '.$on_click.$title.$lowsrc.'>';

	} else return "<img src='/jpg/nofoto.jpg' title='$fn' width='$new_w' height='$new_h'>";
}

// createimg(Name,Width,Height,Id,Class,On_Over,Title,LowSrc,Alt,Quality);

function createimg($fn,$new_w=150,$new_h=150,$id='',$class='',$style='',$on_over='',$title='',$lowsrc='',$alt='',$q=90){
 if (file_exists($fn) && strpos($fn,'.')>-1 )
 {
	
$dir=dirname($fn); 
$part=explode(".",basename($fn));
 $new_fn=$dir.'/'.$part[0].$new_w.'.'.$part[1];
if (!file_exists($new_fn)&&file_exists($fn)&&($part[1])):

	$old = imageCreateFromJpeg($fn);
	$w = imageSX($old); $h = imageSY($old);
	$k=$w / $new_w;
	$w_new=round($w/$k);$h_new=round($h/$k); $x=0;
	if ($h_new>$new_h) {//  resize by height
		$k=$h / $new_h;
		$w_new=round($w/$k);$h_new=round($h/$k);
		$new = imageCreateTrueColor($new_w, $h_new);
		$white = imagecolorallocate($new, 255, 255, 255);	imagefill($new,0, 0,$white);
		$x=round(($new_w-$w_new)/2);
	}	
	else $new = imageCreateTrueColor($w_new, $h_new);
	imagecopyresampled($new, $old, $x, 0, 0, 0, $w_new, $h_new, $w, $h); //imageCopyResized
	imageJpeg($new,$new_fn,$q);
	chmod($new_fn,0777);
	imageDestroy($old); imageDestroy($new);
	
endif;	
   if ($on_over)   $on_over=" onmouseover ='$on_over' ";
   if ($title) $title=" title='$title'";
   if ($lowsrc) $lowsrc=" lowsrc='$lowsrc'";
return '<img id="'.$id.'" class="'.$class.'" style="'.$style.'" border=0 src="/'.$new_fn.'" '.$on_click.$title.$lowsrc.' alt="'.$alt.'">';

	} else return "<img src='/jpg/nophoto.jpg' id='".$id."' class='".$class."' title='$fn' width='$new_w' height='$new_h'>";
}

?>