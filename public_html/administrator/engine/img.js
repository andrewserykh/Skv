
function InsertIMG(obj,event){  //working properly in IE and FF  Insert BR on enter
 if (event.keyCode==13){

	imgwin = window.open('imgloader/i.html','window2',
   'resizable=no,width=900,height=700');
alert(imgwin.i.src);
 var cursorPos = null;
	if (document.selection){
	    var range = document.selection.createRange();
		range.moveStart('textedit', -1);
		cursorPos = range.text.length;
	}
	else cursorPos = obj.selectionStart;
	//alert("cursor " + cursorPos);
	s1=obj.value.substr(0,cursorPos);
    s2=obj.value.substring(cursorPos);
	obj.value=s1+'<img align=left src="">'+s2;
 }
 }