function getCP(id_input){
	cp = $(id_input).val();

	var regExp = /^0[0-9].*$/

	if(regExp.test(cp)){
		cp = parseInt(cp,10);
		if(cp.toString().length == 4){
			cp = "0"+cp;
		}
		return cp;
	} else {
		return parseInt(cp, 10);
	}

	return parseInt(cp,10);
}

$( document ).ready(function() {

	id_input = 'input#lieu_ville';

	if($(id_input).val() == '')
		$(id_input).attr('disabled', true);
	else {
		cp = getCP(id_input);
		$(id_input).attr('data-cp', cp);
	}

	$('input#lieu_cp').on("change keyup touchmove", function() {
		load_api_getVille(this);
	});

});



function load_api_getVille(element){
	if(element.value.length == 5) api_getVille('', $(element).attr('id')); else api_getVille('empty', $(element).attr('id'));
}



function api_getVille(action, id_input){

	$('.icon_chargement_ville').removeClass('hide');

	if(id_input != null && id_input != ''){
		var res = id_input.split("_"); 
		ville_input = res[0]+'_ville';
		id_input = 'input#'+id_input;
	}
	else {
		return false;
	}
		

	if(action != null && action != ''){
		if (action == 'empty')
			$('input#'+ville_input).empty();

		return;
	}

	cp = getCP(id_input);

	if(cp != null && cp != 'undefined' && !($(id_input).attr('data-cp') == cp) ){

		$(id_input).removeAttr('data-cp');

		$.ajax({
			method: "GET",
			url: "https://datanova.legroupe.laposte.fr/api/records/1.0/search/?dataset=laposte_hexasmal&row=-1&facet=nom_de_la_commune&facet=code_postal&facet=ligne_5",
			data: {
				'q' : cp,
				'exclude.code_commune_insee' : cp
			}
		})
		.done(function( villes ) {

			$('select#'+ville_input).empty();

			if(villes.nhits == 0){
				$('select#'+ville_input).material_select('destroy');
				$('select#'+ville_input).replaceWith('<input type="text" name="'+ville_input+'" id="'+ville_input+'" value="" required class="validate"/>');

				$('input#'+ville_input).removeAttr('disabled');
				
			}

			else{

				$('input#'+ville_input).replaceWith('<select name="'+ville_input+'" id="'+ville_input+'" required class="validate"></select>');

				$(id_input).attr('data-cp', cp);

				/*$.each(villes.records, function(v, ville){
					if(ville.fields.ligne_5 != null && ville.fields.ligne_5 != '' ){
						$('select#'+ville_input).append('<option value="'+ville.fields.ligne_5+'">'+ville.fields.ligne_5+'</option>');
					}
					else { 
						$('select#'+ville_input).append('<option value="'+ville.fields.nom_de_la_commune+'">'+ville.fields.nom_de_la_commune+'</option>');
					}
				});*/
				$.each(villes.facet_groups[0].facets, function(v, ville){
					$('select#'+ville_input).append('<option value="'+ville.name+'">'+ville.name+'</option>');
				});

				$('select#'+ville_input).material_select();
			}

			$('.icon_chargement_ville').addClass('hide');

		})
		.fail(function(fail) {

			$('select#'+ville_input).material_select('destroy');
			$('select#'+ville_input).replaceWith('<input type="text" name="'+ville_input+'" id="'+ville_input+'" value="" required class="validate" />');

			$('input#'+ville_input).removeAttr('disabled');
			
			$('.icon_chargement_ville').addClass('hide');
	
		});	

		
		
	}
	else return false;

}