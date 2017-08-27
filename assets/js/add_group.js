var utilisateurSelect = {};

$(function() {
	$('#valide_add_group').on('click', function() {
		group_name=$('#group_name').val();
		famille=$("#group_famille").is(':checked') ? 1 : 0;

		$("#listBox2 option").each(function(i)
		{
			// Add $(this).val() to your list
			utilisateurSelect[i]=$(this).val();
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
							verificationNotifications('{"notification":"good_add_groupe"}');
						})
						.fail(function() {
							console.log("error");
							verificationNotifications('{"notification":"error"}');

						})
						.always(function() {
							console.log
						});
						("complete");
				}else{
					verificationNotifications('{"notification":"error_groupe_users"}');
				}
		}else{
			verificationNotifications('{"notification":"error_groupe_nom"}');
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