
$(function() {

	$('#selectAgenda').on('change', function() {
		changeAgenda();
	});

	$('#save_createAgenda').on('click', function(e) {
		e.preventDefault();
		createAgenda();
	});
	$('.chip').on('click', function(e) {
		var id_agenda	= $(this).attr("id");
		var couleur 	= $(this).attr("name");
		var affiche;
		if($(this).hasClass(couleur))
		{
			$(this).removeClass(couleur);
			affiche = 0;
		}else{
			$(this).addClass(couleur);
			affiche = 1;
		}

		$.ajax({
			url 	 : BASE_URL+'Index/setAgendaAfficher',
			type 	 : 'POST',
			data 	 : {
				id_agenda 	: id_agenda,
				affiche 	: affiche
			},
		})
		.done(function(data) {
			location.reload();
		})
		.fail(function() {
			verificationNotifications('{"notification":"error"}');
		});
	});

});


function changeAgenda(){

	var id_agenda = $("#selectAgenda").val(); 

	if(id_agenda != null && id_agenda != ""){
		
		$.ajax({
			url 	 : BASE_URL+'Index/changeAgenda',
			type 	 : 'POST',
			data 	 : {
				id_agenda : id_agenda
			},
		})
		.done(function(data) {
			notification('good', 'Agenda affiché modifié !', 3000);
			location.reload();
		})
		.fail(function() {
			verificationNotifications('{"notification":"error"}');
		});

	} else {
		notification('error', 'Veuillez sélectionner un agenda', 5000);	
	}

}


function createAgenda(){

	var datas = $('#form_createAgenda').serialize();

	$.ajax({
		method: "POST",
		url: BASE_URL+"Index/addAgenda",
		data: {
			datas : datas
		}
	})
	.done(function(data) {	
		notification('good', 'Agenda créé !', 3000);
		//location.reload();
	})
	.fail(function(data) {
		notification('error', 'Une erreur est survenue durant l\'enregistement de l\'agenda.', 4000);
	});	


}

function updateEvent(event){

	$.ajax({
		method: "POST",
		url: BASE_URL+"Event/getEvent",
		data: {
			id_event : event.id
		}
	})
	.done(function(data) {	

		var event = JSON.parse(data);
		
		$('#event_name').val(event.nom);
		$('#event_description').val(event.description); 

		var date_deb = new Date(event.date_deb*1000);
		
		hours = date_deb.getHours();
		minutes = "0" + date_deb.getMinutes();
		time_deb = hours + ':' + minutes.substr(-2);
		date_deb = date_deb.getUTCDate()+"/"+(date_deb.getMonth() + 1)+"/"+date_deb.getFullYear();

		var date_fin = new Date(event.date_fin*1000);

		hours = date_fin.getHours();
		minutes = "0" + date_fin.getMinutes();
		time_fin = hours + ':' + minutes.substr(-2);
		date_fin = date_fin.getUTCDate()+"/"+(date_fin.getMonth() + 1)+"/"+date_fin.getFullYear();

		$('#event_date_deb').val(date_deb);
		$('#event_time_deb').val(time_deb);
		$('#event_date_fin').val(date_fin);
		$('#event_time_fin').val(time_fin);
		$('#lieu_cp').val(event.lieu_cp);
		$('#lieu_ville').val(event.lieu_ville);
		if(event.rappel == 1){
			$('#event_rappel').prop('checked', true);
		}
		
		$('#id_evenement').val(event.id_evenement);
		$('#id_agenda').val(event.id_agenda);

		$('#delete_event').show();
		$('#share_event').show();

		$('#modalAddEvent').modal('open');

	})
	.fail(function(data) {
		notification('error', 'Une erreur est survenue.', 4000);
	});	

}