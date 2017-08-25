
$(function() {
	$('#valide_group').on('click', function(e) {

		e.preventDefault();

     	var idGroupeSelect	= $("#list_groupinput").val(); 

   		if(idGroupeSelect!=null && idGroupeSelect!=""){
			$("#form_modif_groupSelect").attr("action", "modif_groupSelect/"+idGroupeSelect);
			$('#form_modif_groupSelect').submit();
        			
		} else {
			notification('error', 'Veuillez sélectionner un groupe', 5000);	
		}

	});
 
});
