$(function() {
	$('#valide_modif').on('click', function() {
		email_modif=$('#email_modif').val();
		surnom_modif=$('#surnom_modif').val();
		password_modif=$('#password_modif').val();
		repassword_modif=$('#repassword_modif').val();

		if(surnom_modif!="" && surnom_modif!=null){

			if(password_modif!="" && password_modif!=null){

				if(repassword_modif == password_modif){

					if(email_modif!="" && email_modif!=null && ValidateEmail(email_modif)){
						//envoie ajax
						$.ajax({
							url 	 : BASE_URL+'Account/modif_user',
							type 	 : 'post',
							dataType : 'html',
							data 	 : {
								email_modif : email_modif, 
								surnom_modif: surnom_modif,
								password_modif : password_modif
							},
						})
						.done(function(data) {
							verificationNotifications('{"notification":"good_edit"}');
						})
						.fail(function() {
							verificationNotifications('{"notification":"error"}');
						});
					} else {
						verificationNotifications('{"notification":"error_email_address"}');
					}
				} else {
					verificationNotifications('{"notification":"error_password_different"}');
				}
			} else {
				verificationNotifications('{"notification":"error_password"}');
			}
		} else {
			verificationNotifications('{"notification":"error_pseudo"}');
		}

	});

});

