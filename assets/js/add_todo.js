var nbchar=0;
$(function() {

	// Validation d'un mémo
	$('#listeMemos .checkTodo').on('click', function(){

		var element = this;
		var id_element_todo = $(element).parents('li.memo').attr('id').split('_')[1];
		var valide = ($(element).hasClass('green') ? 0 : 1); 

		$.ajax({
			url 	 : BASE_URL+'TODO/valide_todo',
			type 	 : 'POST',
			data 	 : {
				todo_valide : valide,
				id_element_todo : id_element_todo
			},
		})
		.done(function(data) {
			if(data != 'nok'){				
				if(valide == 1){
					notification('good', 'Mémo validé !', 3000);
					$(element).addClass('green');
				} else {
					notification('good', 'Mémo dévalidé !', 3000);
					$(element).removeClass('green');
				}
			} else {
				notification('error', 'Une erreur est survenue.', 5000);
			}
		})
		.fail(function() {
			notification('error', 'Une erreur est survenue.', 5000);
		});
	});	

	$('#listeMemos .favoriTodo').on('click', function(){
		var element = this;
		var id_todo = $(element).parents('.memo_title').next('.memo_desc').attr('id').split('_')[1];
		var favori = ($(element).hasClass('yellow') ? 0 : 1); 

		$.ajax({
			url 	 : BASE_URL+'TODO/favori_todo',
			type 	 : 'POST',
			data 	 : {
				todo_favori : favori,
				id_todo : id_todo
			},
		})
		.done(function(data) {
			if(data != 'nok'){				
				if(favori == 1){
					notification('good', 'Mémo ajouté aux favoris !', 3000);
					$(element).addClass('yellow');
				} else {
					notification('good', 'Mémo retiré des favoris !', 3000);
					$(element).removeClass('yellow');
				}
			} else {
				notification('error', 'Une erreur est survenue.', 5000);
			}
		})
		.fail(function() {
			notification('error', 'Une erreur est survenue.', 5000);
		});

	});	

	//onclick sur la croix (x)
	$('#listeMemos .removeTodo').on ('click', function(){

		var element = this;
		var id_element_todo = $(element).parents('li.memo').attr('id').split('_')[1];
		var id_todo = $(element).parents('.memo_desc').attr('id').split('_')[1];

		$.ajax({
			url 	 : BASE_URL+'TODO/delete_todo',
			type 	 : 'POST',
			data 	 : {id_todo : id_todo,
				id_element_todo : id_element_todo
			},
		})
		.done(function(data) {
			if(data != 'nok'){		
				$(element).parents('li.memo').remove();
				notification('good', 'Mémo supprimé !', 3000);
			} else {
				notification('error', 'Une erreur est survenue.', 5000);
			}
		})
		.fail(function() {
			notification('error', 'Une erreur est survenue.', 5000);
		});	
	});

	//click sur l'image edit pour modification
    $('#listeMemos .editTodo').on('click', function() {
    	var element = this;
    	//alert($(element).parents('.memo_desc').children('#text_memo_desc').text());

    	$(element).parents('.memo_desc').children('#modifTodo').css("display","block");
 		$(element).parents('.memo_desc').children('#modifTodo').children('#text_todo_modif').val($(element).parents('.memo_desc').children('#text_memo_desc').text());
    	$(element).parents('.memo_desc').children('#text_memo_desc').css("display","none");
    	$(element).parents('#icone_memo_desc').css("display","none");	
    });  

    $('#modifTodo .button').on('click', function() {
    	if($(this).prev('#text_todo_modif').val() != '')
    	{	
    		var element = this;
    		var name = $(this).parents('.memo_desc').prev('.memo_title').children('#text_memo_title').children('span').text();
    		var description= $(this).prev('#text_todo_modif').val();
    		var id_element_todo = $(this).parents('li.memo').attr('id').split('_')[1];

	    	$.ajax({
				url 	 : BASE_URL+'TODO/update_todo',
				type 	 : 'POST',
				data 	 : {
					todo_name		 : name,
					todo_description : description,
					id_element_todo	 : id_element_todo
				},
			})
			.done(function(data) {
				if(data != 'nok'){				
					notification('good', 'Mémo modifié !', 3000);
					$(element).parents('.memo_desc').children('#text_memo_desc').css("display","block");
    				$(element).parents('.memo_desc').children('#icone_memo_desc').css("display","block");
    				$(element).parents('.memo_desc').children('#modifTodo').css("display","none");
 					$(element).parents('.memo_desc').children('#text_memo_desc').text($(element).prev('#text_todo_modif').val());
				} else {
					notification('error', 'Une erreur est survenue.', 5000);
				}
			})
			.fail(function() {
				notification('error', 'Une erreur est survenue.', 5000);
			});
		}else{
			notification('error', 'Veuillez remplir le champs description', 5000);
		}
    });

	// Create a new list item when clicking on the "Add" button
	$('#add_todo').on('click', function() {
		var name 		= $('#todo_name').val();
		var description = $('#todo_description').val() 


		if(name != ""&& name !=null)
		{
			if(description != ""&& description !=null)
			{
				$.ajax({
					url 	 : BASE_URL+'TODO/add_todo',
					type 	 : 'POST',
					data 	 : {
						todo_name		 : name,
						todo_description : description,
					},
				})
				.done(function(data) {
					if(data != 'nok'){				
						var id = data.split('_');
						notification('good', 'Mémo crée !', 3000);
						var li=$("#listeMemos").append('<li class="memo" id="memo_'+id[1]+'"');
						li.append('<div class="collapsible-header memo_title">\
									<div class="s8 col" id="text_memo_title">\
										<span>'+name+'</span>\
									</div>\
									<div class="s4 col">\
										<span class="float-right checkTodo">\
											<i class="fa fa-check tooltipped" data-position="right" data-delay="50" data-tooltip="Valider ce mémo"></i>\
										</span>\
										<span class="float-right favoriTodo">\
											<i class="fa fa-star tooltipped" data-position="right" data-delay="50" data-tooltip="Ajouter ce mémo au favori"></i>\
										</span>\
									</div>\
								</div>');
						li.append('<div class="collapsible-body row memo_desc" id="desc_'+id[0]+'">\
									<div class="input-field s12 col right-align" id="modifTodo" style="display:none">\
										<input type="text" name="text_todo_modif" id="text_todo_modif" />\
										<input type="submit" id="Valid_Modif_todo" class="button" value="Valider">\
									</div>\
									<div class="s10 m11 col" id="text_memo_desc">'+description+'</div>\
									<div class="s2 m1 col" id="icone_memo_desc"><div class="float_right">\
									<div class="editTodo">\
										<i class="fa fa-pencil" data-tooltip="Editer ce mémo"></i>\
									</div>\
									<div class="removeTodo">\
										<i class="fa fa-times" data-tooltip="Supprimer ce mémo"></i>\
									</div>');
						li.append('</div>\
							</div>\
						</div>\
					</li>');

					} else {
						notification('error', 'Une erreur1 est survenue.', 5000);
					}
				})
				.fail(function() {
					notification('error', 'Une erreur2 est survenue.', 5000);
				});
				//idem pour les id 
			} else{
				notification('error', 'Merci de remplir une description pour ce mémo', 5000);		
			}
		} else {
			notification('error', 'Merci de donner un titre au mémo', 5000);		
		}
		$('#todo_name').val('');
		$('#todo_description').val('');

	});


	$('#todo_name').on('keyup',function(){
    	var name = $('#todo_name').val();
    	nbchar++;
      	if(name.length>=3 && nbchar>=3){
    		nbchar=0;
            $.ajax({
                url: BASE_URL+'Todo/chercheSimilaire',
                type: 'POST',
                data: {name: name},
            })
            .done(function(data) {
                if(data.indexOf('nok') == -1){
					var data = data.split('_');
                	notification('warning', 'Un mémo similaire a été détécté', 5000);
                	$('#modalAcceptTodo').modal('open');
					$('#modalAcceptTodo #Modaltext').html('Voulez-vous accepter la proposition du todo avec le titre <span id="titre" class="'+data[2]+'"> "'+data[2]+'" </span> et la description <span id="description" class="'+data[3]+'"> "'+data[3]+'" </span> ?');
					$('.modal-content').attr('id',data[1]);
                }else{
                }
            })
            .fail(function() {
                //verificationNotifications('{"notification":"error"}');
            })
            .always(function() {
            });
		}
	});
});