var utilisateurSelect = {};

$(function() {
	$('#GroupeSelect').hide();
	$('#list_group').on('change', function(e) {
		var idGroupeSelect	= $("#list_group").val(); 

		if(idGroupeSelect != ''){
			$('#GroupeSelect').show();
			$.ajax({
                        url     : BASE_URL+'Account/modif_groupSelect/'+idGroupeSelect,
                        type    : 'post',
                        dataType: 'html',
                        data    :{id_groupeSelect : idGroupeSelect},
                    })
                .done(function(data) {
                	
                })
                .fail(function() {
                    verificationNotifications('{"notification":"error"}');
                })
                .always(function() {
                });
		}

   		/*if(idGroupeSelect!=null && idGroupeSelect!=""){
			$("#form_modif_groupSelect").attr("action", "modif_groupSelect/"+idGroupeSelect);
			$('#form_modif_groupSelect').submit();
        			
		} else {
			notification('error', 'Veuillez sélectionner un groupe', 5000);	
		}*/

	});
    $('#valide_groupSelect').on('click', function() {

        $("#listBox2 option").each(function(i)
        {
            // Add $(this).val() to your list
            utilisateurSelect[i]=$(this).val();
            //console.log(utilisateurSelect);
            //console.log(i);
        });
        var url = window.location.href;
        var segments = url.split( '/' );
        var id_groupeSelect = segments[6];
        //console.log(id_groupeSelect);

        if(utilisateurSelect!=null && utilisateurSelect!="")
        {
            //envoie ajax
            $.ajax({
                        url     : BASE_URL+'Account/valid_modifGroup',
                        type    : 'post',
                        dataType: 'html',
                        data    :{utilisateurSelect : utilisateurSelect,
                                id_groupeSelect 	: id_groupeSelect},
                    })
                .done(function(data) {
                    notification('good', 'Membres du groupe modifié !', 3000);
                })
                .fail(function() {
                    verificationNotifications('{"notification":"error"}');
                })
                .always(function() {
                });
        }else{
            notification('error', 'Personne n\'est affecté à ce groupe', 5000);   
        }
    });

    $('#btnRight').click(function (e) {
        $('select').moveToListAndDelete('#listBox1', '#listBox2');
        e.preventDefault();
    });
    $('#btnAllRight').click(function (e) {
        $('select').moveAllToListAndDelete('#listBox1', '#listBox2');
        e.preventDefault();
    });
    $('#btnLeft').click(function (e) {
        $('select').moveToListAndDelete('#listBox2', '#listBox1');
        e.preventDefault();
    });
    $('#btnAllLeft').click(function (e) {
        $('select').moveAllToListAndDelete('#listBox2', '#listBox1');
        e.preventDefault();
    });
});
