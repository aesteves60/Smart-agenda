var utilisateurSelect = {};

$(function() {
	$('#GroupeSelect').hide();
	$('#list_group').on('change', function(e) {
		var idGroupeSelect	= $("#list_group").val(); 

		/*if(idGroupeSelect != ''){
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
		}*/

   		if(idGroupeSelect!=null && idGroupeSelect!=""){
			$("#form_modif_groupSelect").attr("action", "modif_groupSelect/"+idGroupeSelect);
			$('#form_modif_groupSelect').submit();
        			
		} else {
			notification('error', 'Veuillez sélectionner un groupe', 5000);	
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
