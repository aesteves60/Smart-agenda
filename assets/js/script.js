$( document ).ready(function() {
	if(localStorage.getItem("sideNav") == "80") retractSideNav(true);
	if(localStorage.getItem('theme') == "dark"){
		$('body').addClass(localStorage.getItem('theme'));
		$('#choix-theme').prop('checked', true);
	}
	

	//Correction de la sidebar fixed si écran trop petit (dépasse en bas dans ce cas)
	var hauteur_fenetre = $(window).height();
	scroll_auth = false;

	if( hauteur_fenetre < 880 || $('.container > div').height() > 880 || ( hauteur_fenetre < 980 && $('.fixed').height() > 730 ) ){
		$('.fixed').css('position', 'relative');
		
	} else scroll_auth = true;

	fixedSidebar();

	$('select').material_select();
	$('.modal').modal();
	Materialize.updateTextFields();

	$('.fa-times.close').on('click', function(event) {
		removeBlock(this);
	});

	date_heure('#div_');

});

/**
 * Grid-light theme for Highcharts JS
 * @author Torstein Honsi
 */
$(function () {

	$(".open-sidenav-left").sideNav();

	$(".retract-sidenav-left").on('click', function(){ retractSideNav(); });
	$(".retract-sidenav-left").on('mouseover', function(){ iconRetractSideNav(true); });
	$(".retract-sidenav-left").on('mouseleave', function(){ iconRetractSideNav(false); });


	$('.datepicker').pickadate({
		selectMonths: true, // Creates a dropdown to control month
		selectYears: 10, // Creates a dropdown of 10 years to control year
		format: 'dd/mm/yyyy',
		closeOnSelect: true,

		monthsFull: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
		monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'],
		weekdaysFull: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
		weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],

		today: 'Auj.',
		clear: 'Vider',
		close: 'Fermer'

	});


	$('.timepicker').pickatime({
		default: 'now', // Set default time
		fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
		twelvehour: false, // Use AM/PM or 24-hour format
		donetext: 'OK', // text for done-button
		cleartext: 'Vider', // text for clear-button
		canceltext: 'Annuler', // Text for cancel-button
		autoclose: true, // automatic close timepicker
		ampmclickable: true // make AM PM clickable
	});

});


function removeBlock(block){
	$("#"+block).hide(200);
}

function fixedSidebar(){

	if(scroll_auth == true){
		var top = $(window).scrollTop();

		if(top > 155){
			$('.fixed').css('top', '10px');
		}
		else {
			$('.fixed').css('top', 'auto');
		}
	}

}

function retractSideNav(retract){

	if(retract != null){ 
		_do = true;
	}
	else {
		_do = false;
	}

	sideNav 	= $("#slide-out-left");
	container 	= $('#container');
	li_nav_after 	= $('.side-nav .collapsible-header');

	//Si supperieur a 64rem (css materialize pour tablettes)
	if( ($(window).width() / parseFloat($("body").css("font-size")) ) > '64'){
		if(sideNav.css("width") == '280px' || _do == true){
			sideNav.addClass('minimize');
			container.addClass('maximize');
			li_nav_after.addClass('no-after');

			localStorage.setItem("sideNav", "80");
		}
		else {
			sideNav.removeClass('minimize');
			container.removeClass('maximize');
			li_nav_after.removeClass('no-after');

			localStorage.setItem("sideNav", "280");
		}
	} else {
		localStorage.removeItem("sideNav");
	}

}

function iconRetractSideNav(_do){

	retract_icon = $('.retract-sidenav-left i');

	if(localStorage.getItem("sideNav") == "80"){
		if(_do == true){
			retract_icon.removeClass('fa-bars fa-arrow-left');
			retract_icon.addClass('fa-arrow-right');
		}
		else {
			retract_icon.removeClass('fa-arrow-right');
			retract_icon.addClass('fa-bars');
		}
	}
	else {
		if(_do == true){
			retract_icon.removeClass('fa-bars fa-arrow-right');
			retract_icon.addClass('fa-arrow-left');
		}
		else {
			retract_icon.removeClass('fa-arrow-left');
			retract_icon.addClass('fa-bars');
		}
	}
}



//Fonction de switch du thème du dashboard
function switchTheme(){
	if($('body').hasClass('dark')){
		$('body').removeClass('dark');
		localStorage.setItem('theme', '');
		$('#choix-theme').removeAttr('checked');
	}
	else {
		$('body').addClass('dark');
		localStorage.setItem('theme', 'dark');
		$('#choix-theme').prop('checked', true);
	}
}


/***** NOTIFICATIONS *****/

/* Utilisation : 
*	1 : Faire un appel ajax (avec comme retour "datas" par exemple)
* 	2 : Faire un appel de "verificationNotifications()" avec les datas
* 	3 : Si les datas sont une JSON et contiennent une variable "notification" : laisser la magie s'opérer
*/

function verificationNotifications(data){
	if(isJson(data) && JSON.parse(data).hasOwnProperty('notification')){
		$.ajax({
			method: "GET",
			url: BASE_URL+"Index/verificationNotifications",
			data: { erreur : JSON.parse(data).notification }
		})
		.done(function( message ) {

			message = jQuery.parseJSON(message);
			notification(message.class, message.message, 4000);

		});

		return false;
		
	} else if(isJson(data)) {
		return JSON.parse(data);
	} else {
		return true;
	}
}

function notification(type, message, delais){

	//Délais d'affichage par défaut d'une notification
	if (delais == null) {
		delais = 3000;
	}

	//Couleur du texte	
	if (type == 'error') {
		color = 'red';
	}
	else if (type == 'good') {
		color = 'green';
	}
	else if (type == 'warning') {
		color = 'orange';
	}
	else {
		color = 'white';
	}


	if(message != null){
		//Notification via les "toast" de Materialize
		//(Affichage d'une notif flottante sur la droite de l'écran ou en pied de page si petit écran)
		Materialize.toast('<span class="'+color+'">'+message+'</span>', delais);
	}

}

function isJson(item) {
    item = typeof item !== "string"
        ? JSON.stringify(item)
        : item;

    try {
        item = JSON.parse(item);
    } catch (e) {
        return false;
    }

    if (typeof item === "object" && item !== null) {
        return true;
    }

    return false;
}

function ValidateEmail(mail) 
{
 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
  {
    return (true)
  }
    return (false)
}
showed=0;
function alertChampsObligatoire(elmnt){
	if(showed!=1) {
        elmnt.css('background', 'bisque');
        notification('error', 'Champs Obligatoire non renseigné: ', '5000');
        champsObligatoireNotGood = 1;
        showed = 1;
    }
	return "";
}
function alertDateError(){
	notification('error','Erreur dans les dates !','5000');
	return "";
}

function date_heure(id)
{
        date = new Date;
        annee = date.getFullYear();
        moi = date.getMonth();
        mois = new Array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        j = date.getDate();
        jour = date.getDay();
        jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        date_result = jours[jour]+' '+j+' '+mois[moi]+' '+annee;
        heure_result = h+':'+m+':'+s;
        $(id+'date').text(date_result);
       	$(id+'heure').text(heure_result);
        setTimeout('date_heure("'+id+'");','1000');
        return true;
}