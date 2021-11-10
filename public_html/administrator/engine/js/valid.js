//Проверяет, все ли обязательные поля заполнены
	function valid_int(obj) {
		if (obj.value.length)
	                if (( (obj.value*1)!=obj.value)){
						obj.style.background='rgb(255, 128, 128)'
	                   alert("Ошибка: "+obj.value+" - не число!");
						obj.value='';			
					}               
	}


function check(frm) {
	        err=0;
			for (i=0;i<frm.length;i++) {
//document.write(frm.elements[i].title.length);	
//alert(frm.elements[i].style.background)
	if (frm.elements[i].title.length>0)
					if (frm.elements[i].value.length==0){
					err=1; frm.elements[i].style.background='rgb(255, 128, 128)';
					}
			}
			if (err!==0){   
				alert("Заполните обязательные поля");
				return false;
			}	
		
                
	}



function get_enum_str(frm) {
	str='';
	       	for (i=0;i<frm.length;i++) if (frm.elements[i].value.length!==0){
				str=str+frm.elements[i].value+';';
			
	if (frm.elements[i].title.length>1000)
					if (frm.elements[i].value.length==0){
					 frm.elements[i].style.background='rgb(255, 128, 128)';
					}
			}		
			if (frm==form2) form1.sum.value=get_order_sum(form2); // update order sum
     return str;           
	}

function get_order_sum(frm) {
	sum=0;
	       	for (i=1;i<frm.length;i++) if (frm.elements[i].value.length!==0)
			 if ((i+1)%5==0){
				sum=sum+frm.elements[i].value*frm.elements[i-1].value;		
			}
     return sum;           
	}

function cbox(i){
	id='hid'+i;
	document.getElementById(id).value=Math.abs(document.getElementById(id).value-1);
}

function isNotMax(e){
       e = e || window.event;
      var target = e.target || e.srcElement;
       var code=e.keyCode?e.keyCode:(e.which?e.which:e.charCode)
     switch (code){
              case 13:
              case 8:
             case 9:
               case 46:
			case 37:
             case 38:
           case 39:
            case 40:
        return true;
      }
         return target.value.length <= target.getAttribute('maxlength');
 }
