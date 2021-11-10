//AJAX
function update_model(fldn,value,id) {  
				
				var htm = $.ajax({
					type: "GET",
					data: "fldn="+fldn+"&value="+value+"&id="+id+"&rnd="+Math.random(),   //for ie cash off
					url: "/admin/data/server/update_model.php",
				async: false
					}).responseText;				    
					//alert(htm);
					//document.getElementById('bask').innerHTML=htm;
				return htm;
				//setCookie('registred','ok',6,'/');
    } 
