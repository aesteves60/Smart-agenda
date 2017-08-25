var utilisateurSelect = {};

$(function() {
	$('#valide_add_group').on('click', function() {
		group_name=$('#group_name').val();
		famille=$("#group_famille").is(':checked') ? 1 : 0;

		$("#listBox2 option").each(function(i)
		{
			// Add $(this).val() to your list
			utilisateurSelect[i]=$(this).val();
			console.log(utilisateurSelect);
			//console.log(i);
		});

		if(group_name!=""&&group_name!=null)
		{
				if(utilisateurSelect!=null&&utilisateurSelect!="")
				{
					//envoie ajax
					$.ajax({
								url 	: BASE_URL+'Account/add_group',
								type 	: 'post',
								dataType: 'html',
								data 	:{group_name 	: group_name,
									famille 			: famille,
									utilisateurSelect 	: utilisateurSelect
								},
							})
						.done(function(data) {
							console.log("success");
							notification('good', 'Groupe crée !', 3000);
						})
						.fail(function() {
							console.log("error");
						})
						.always(function() {
							console.log
						});
						("complete");
				}else{
					notification('error', 'Personne n\'est affecté  ce groupe', 5000);	
				}
		}else{
			notification('error', 'Remplissez un Nom', 5000);
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