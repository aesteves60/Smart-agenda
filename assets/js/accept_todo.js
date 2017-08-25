$(function () {

	$('#accept_action_todo').on('click', function() {
		var id_element_todo = $('.modal-content').attr('id');
		var titre 			= $('#titre').attr('class');
		var description 	= $('#description').attr('class');

		$.ajax({
            url: BASE_URL+'Todo/Update_ia_todo',
            type: 'POST',
            dataType: 'html',
            data: {id_element_todo 	: id_element_todo,
            	accept 				: 1},
        })
            .done(function(data) {
                if(data != 'nok')
                {
                	$('#todo_name').val(titre);
					$('#todo_description').val(description);
					$('#modalAcceptTodo').modal('close');
                }
            })
            .fail(function() {
                verificationNotifications('{"notification":"error"}');
            })
            .always(function() {
            });
	});
	
	$('#decline_action_todo').on('click', function() {
	var id_element_todo = $('.modal-content').attr('id');

	$.ajax({
            url: BASE_URL+'Todo/Update_ia_todo',
            type: 'POST',
            dataType: 'html',
            data: {id_element_todo 	: id_element_todo,
            	accept 				: 0},
        })
            .done(function(data) {
                if(data != 'nok')
                {
					$('#modalAcceptTodo').modal('close');
                }
            })
            .fail(function() {
                verificationNotifications('{"notification":"error"}');
            })
            .always(function() {
            });
	});
	
});
