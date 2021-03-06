$(function() {
	var nbFrape = 0;
	$('#valid_event').on('click', function() {
		/*
		 On récupére tous les champs du formulaire d'insertion d'évenement 
		 On test les champs Obligatoire pour ceux qui le sont
		*/
		 info = {};
		 champsObligatoireNotGood = 0;
		 info['nom']=$('#event_name').val()==""?alertChampsObligatoire($('#event_name')):$('#event_name').val();
		 info['description'] =$('#event_description').val(); 
		 var dateDeb = $('#event_date_deb').val();
		 var timeDeb = $('#event_time_deb').val();
		 info['date_deb'] = getTimeStamp(dateDeb,timeDeb);
		 var dateFin = $('#event_date_fin').val();
		 var timeFin = $('#event_time_fin').val();
		 info['date_fin'] = getTimeStamp(dateFin,timeFin);
		 showed=0;
		 if(champsObligatoireNotGood==0){
		 	if(info['date_fin']<info['date_deb']){
		 		alertDateError();
		 		return;
		 	}
			 //info['id_lieu'] = $('#event_id_lieu').val()==""?1:$('#event_id_lieu').val();
            info['lieu_cp']     = $('#lieu_cp').val();
            info['lieu_ville']  = $('#lieu_ville').val();
            info['rappel']      = $('#event_rappel').val();
            info['public']      = $('#event_public').val();
            if($('#event_recurrence').is(':checked')){
               info['type_recurrence']  = $("#recurrence option:selected").val();
               info['nb_recurrence']    = $("#nb_recurrence option:selected").val();
            }

            info['id_agenda']    =$('#agenda_group').val() == ""?alertChampsObligatoire($('#agenda_group')):$('#agenda_group').val();
            info['id_evenement'] = $('#id_evenement').val();
			 //On Lancera que si tout les champs obligatoire sont ok

			if(info['id_evenement'] != '' && info['id_evenement'] != null){
				var URL = BASE_URL+'Event/editEvent';
                var notification = 'L\'évenement à été modifié';
			} else {
				var URL = BASE_URL+'Event/addEvent';
                var notification = 'L\'évenement à été crée';

			}

			$.ajax({
				url: URL,
				type: 'POST',
				data : {tab : info},
			})
			.done(function(data) {   
                data = JSON.parse(data);
				//notification('good', notification, 3000);

                if(info['id_evenement'] != '' && info['id_evenement'] != null){
                	$('#calendar').fullCalendar('renderEvent', {
                		id: data.id_event,
                		title: info['nom'],
                        start: getDateEvent(dateDeb,timeDeb),
                        end: getDateEvent(dateFin,timeFin)
                	});
                }
                $('#modalAddEvent').modal('close'); 
                //location.reload();
			})
			.fail(function() {
				notification('error', 'Une erreur est survenue lors de l\'ajout à l\'agenda.', 5000);
			})
			.always(function() {
			});
		}else{
			champsObligatoireNotGood=0;
		}
		detected=false;

		});

    //on click sur add event vidage des champs et masquage button supprimer
    $('.add_event').on('click', function() {
        $( '#div_champ_event input:text').each(function() {
            $(this).val('');
        });
        $('#event_description').val('');
        $('#delete_event').hide();
    });

    $('#event_name').on('keyup',function(){
    	autocomplete(this);
	});

    $('#search').on('keyup',function(){
        autocomplete(this);
    });


    $('#delete_event').on('click', function() {
        var event_id = $('#id_evenement').val();
        $.ajax({
            url: BASE_URL+'Event/deleteEvent',
            type: 'POST',
            dataType: 'html',
            data: {id_event : event_id},
        })
        .done(function(data) {
            $('#calendar').fullCalendar('removeEvents', event_id);
            verificationNotifications('{"notification":"good_edit"}');
        })
        .fail(function() {
            verificationNotifications('{"notification":"error"}');
        });

        $('#modalAddEvent').modal('close');
    });

    /*$('#share_event').on('click', function() {
        var event_id = $('#id_evenement').val();
        
        var share_link = BASE_URL+Event/get?share=
        $('modalShareEvent #link').append(share_link);

        $('#modalShareEvent').modal('open');
    });*/

    $('#event_recurrence').on('click', function() {
        if($('#event_recurrence').is(':checked') == true){
            $('#block_recurrence').show();
        } else {
            $('#block_recurrence').hide();
        }
    }); 
    
    $('#recurrence').on('change', function() {
        var recurenceSelect  = $("#recurrence option:selected").val();

        $('#nb_recurrence').empty();

        if(recurenceSelect=='allJours') {
           $('#nb_recurrence').append('<option value="1">Un jour</option>'); 
           $('#nb_recurrence').append('<option value="2">Deux jour</option>'); 
           $('#nb_recurrence').append('<option value="3">Trois jour</option>'); 
           $('#nb_recurrence').append('<option value="4">Quatre jour</option>'); 
           $('#nb_recurrence').append('<option value="5">Cinq jour</option>'); 
           $('#nb_recurrence').append('<option value="6">Six jour</option>'); 
           $('#nb_recurrence').append('<option value="7">Une semaine</option>'); 
           $('#nb_recurrence').append('<option value="14">Deux semaine</option>'); 
           $('#nb_recurrence').append('<option value="21">Trois semaine</option>'); 
           $('#nb_recurrence').append('<option value="28">Quatre semaine</option>'); 
           $('#nb_recurrence').material_select();

        }else if(recurenceSelect=='Semaine'){
            $('#nb_recurrence').append('<option value="1">Une semaine</option>'); 
            $('#nb_recurrence').append('<option value="2">Deux semaine</option>'); 
            $('#nb_recurrence').append('<option value="3">Troi semaine</option>'); 
            $('#nb_recurrence').append('<option value="4">1 Mois</option>'); 
            $('#nb_recurrence').append('<option value="8">2 Mois</option>'); 
            $('#nb_recurrence').append('<option value="12">3 Mois</option>'); 
            $('#nb_recurrence').append('<option value="16">4 Mois</option>'); 
            $('#nb_recurrence').material_select();

        }else if(recurenceSelect=='Mois'){
            $('#nb_recurrence').append('<option value="1">1 Mois</option>'); 
            $('#nb_recurrence').append('<option value="2">2 Mois</option>'); 
            $('#nb_recurrence').append('<option value="3">3 Mois</option>'); 
            $('#nb_recurrence').append('<option value="4">4 Mois</option>'); 
            $('#nb_recurrence').append('<option value="5">6 Mois</option>'); 
            $('#nb_recurrence').append('<option value="12">1 An</option>'); 
            $('#nb_recurrence').append('<option value="24">2 Ans</option>'); 
            $('#nb_recurrence').material_select();

        }
    });

    function affichePropositionEvent(nom){
        $('#modalAddEvent').modal('open');
        $.ajax({
            url: BASE_URL+'Event/getEventByNom',
            type: 'POST',
            dataType: 'JSON',
            data: {event_nom: nom
            },
        })
        .done(function(data) {
            $('#event_name').val(data.nom);
            $('#event_description').val(data.description);
            $('#lieu_cp').val(data.lieu_cp);
            $('#lieu_ville').val(data.lieu_ville);
            $('#id_evenement').val('');
            if(event.rappel == 1){
                $('#event_rappel').prop('checked', true);
            }
            $("#agenda_group option[value="+data.id_agenda+"]").prop('selected', true);
            $('#agenda_group').material_select();

        })
        .fail(function() {
            verificationNotifications('{"notification":"error"}');
        })
        .always(function() {
        });
    }

    var event_nom = {};
    function autocomplete(element){
        var titre = $(element).val();
        nbFrape ++;
        if (titre.length > 1 && nbFrape >= 1) {
            nbFrape = 0;
            $.ajax({
                url: BASE_URL + 'Event/chercheSimilaire',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    titre: titre
                },
            })
            .done(function (reponse) {
                if (reponse) {
                    //var json = $.parseJSON(reponse);
                    //event_id = ArrayReponse[0].id;
                     for (var i=0;i<reponse.length;i++)
                    {
                        event_nom[reponse[i].nom]="http://ictadmin.com.au/images/page_art/fa-globe_256_20_0077bb_none.png";
                    }
                    $('input.autocomplete').autocomplete({
                        data: event_nom,
                        limit: 5, // The max amount of results that can be shown at once. Default: Infinity.
                        onAutocomplete: function(val) {
                            affichePropositionEvent(val);
                        },
                        minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
                    });
                }
            })
            .fail(function () {
                //verificationNotifications('{"notification":"error"}');
            })
            .always(function () {
            });
        }
    }

});



function getTimeStamp(myDate,myHours){
	if(myDate&&myHours){
		myDate=myDate.split("/");
		myHours = myHours.split(':');
		return(new Date(myDate[2],myDate[1]-1,myDate[0],myHours[0],myHours[1]).getTime()/1000);
	}else if(myDate){ //si vide alors toute la journéee
        myDate=myDate.split("/");
        return (new Date(myDate[2],myDate[1]-1,myDate[0]).getTime()/1000);   
    }else{
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth(); //January is 0!
        var yyyy = today.getFullYear();
        return (new Date(yyyy,mm,dd).getTime()/1000);
    }
}

function getDateEvent(myDate,myHours){

    if(myDate&&myHours){
        myDate=myDate.split("/");
        myHours = myHours.split(':');
        return myDate[2]+'-'+myDate[1]+'-'+myDate[0]+'T'+myHours[0]+':'+myHours[1]+':00';
    }
}