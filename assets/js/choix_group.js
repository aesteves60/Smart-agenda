var utilisateurSelect = {};

$(function() {
    $('#valide_choix_group').on('click', function(e) {

        e.preventDefault();

        var idGroupeSelect  = $("#list_group").val(); 

        if(idGroupeSelect!=null && idGroupeSelect!=""){
            $("#form_choix_group").attr("action", "modif_group/"+idGroupeSelect);
            $('#form_choix_group').submit();
                    
        } else {
            notification('error', 'Veuillez sélectionner un groupe', 5000); 
        }

    });

});
