var utilisateurSelect = {};


 $(function() {
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
                                id_groupeSelect : id_groupeSelect},
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

    $('#delete_groupeSelect').on('click', function() {
;
        var url = window.location.href;
        var segments = url.split( '/' );
        var id_groupeSelect = segments[6];


        if(utilisateurSelect!=null && utilisateurSelect!="")
        {
            //envoie ajax
            $.ajax({
                        url     : BASE_URL+'Account/delete_group',
                        type    : 'post',
                        dataType: 'html',
                        data    :{id_groupe : id_groupeSelect},
                    })
                .done(function(data) {
                    notification('good', 'Groupe supprimé', 3000);
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