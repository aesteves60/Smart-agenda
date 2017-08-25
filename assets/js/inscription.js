$(document).ready(function($) {
	var trouve = true;
	$('#confirme').on('click', function(e) {
		e.preventDefault();
		var mail = $('#mail').val();
		var password = $('#password').val();
		var repassword = $('#repassword').val();
		var surname = $('#surname').val();
		if(surname!=""&&surname!=null){
			if(password!=""&&password!=null){
				if(repassword==password){
					if(mail!=""&&mail!=null&&ValidateEmail(mail)){
                        mailNotExist(mail,password,surname);
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
	function mailNotExist(mail,password,surname) {

        $.ajax({
            url: BASE_URL+'Account/mailNotExist',
            type: 'POST',
            dataType: 'html',
            data: { mail : mail },
        })
        .done(function(data) {
            if(data==0) { // test s'il existe un mail identique 0 => pas de mail pareil
                setUser(mail, password, surname);
            } else {
                verificationNotifications('{"notification":"error_email_address"}');
            }
        })
        .fail(function() {
            verificationNotifications('{"notification":"error"}');
        })
        .always(function() {
        });
    }
	function setUser(mail,password,surname){
		$.ajax({
			url: BASE_URL+'Account/inscription',
			type: 'POST',
			dataType: 'html',
			data: {
				mail: mail,
				password: password,
				surname: surname
			},
		})
		.done(function(data) {
			if(data.lenght!=0){
            	verificationNotifications('{"notification":"good_add_user"}');
            	location.href = BASE_URL+'Login/index';
			}
		})
		.fail(function() {
			verificationNotifications('{"notification":"error"}');
		})
		.always(function() {
		});
	}
});