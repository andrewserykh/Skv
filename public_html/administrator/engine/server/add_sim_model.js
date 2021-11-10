//AJAX
function add_sim_model(id,sid) {				
				var htm = $.ajax({
					type: "GET",
					data: "id="+id+"&sid="+sid+"&rnd="+Math.random(),   //for ie cash off
					url: "/admin/data/server/add_sim_model.php",
				async: false
					}).responseText;				    
					//alert(htm);					
				return htm;				
    } 
