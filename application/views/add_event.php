	<div id="modalAddEvent" class="modal modal-fixed-footer">
		<div class="modal-content" id="div_champ_event">

			<div class="row input-field">
				<input type="text" name="event_name" id="event_name" class="autocomplete">
				<label for="event_name">Nom de l'évènement</label>
			</div>

			<div class="row input-field">
				<textarea class="materialize-textarea" id="event_description" name="event_description"></textarea>
				<label for="event_description">Déscription de l'évènement</label>
			</div>

			<div class="row">
				<div class="s6 col">
					<div class="row input-field">
						<input type="text" id="event_date_deb" name="event_date_deb" class="datepicker" value="" placeholder="" />
						<label for="event_date_deb">Date de début</label>
					</div>
					<div class="row input-field">
						<input type="text" id="event_time_deb" name="event_time_deb" class="timepicker" value="" />
						<label for="event_time_deb">Heure de début</label>
					</div>
				</div>
				<div class="s6 col">
					<div class="row input-field">
						<input type="text" id="event_date_fin" name="event_date_fin" class="datepicker" value="" placeholder="" />
						<label for="event_date_fin">Date de fin</label>
					</div>
					<div class="row input-field">
						<input type="text" id="event_time_fin" name="event_time_fin" class="timepicker" value="" />
						<label for="event_time_fin">Heure de fin</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="input-field s7 m4 col">
					<input type="text" class="validate" name="lieu_cp" id="lieu_cp" pattern="\d{2} \d{3}|\d{5}" value="" onchange="load_api_getVille(this);" />
					<label for="lieu_cp" >Code postal</label>
				</div>

				<div class="input-field s10 m7 col">
					<input name="lieu_ville" id="lieu_ville" class="validate" />
					<label for="lieu_ville" >Ville</label>
				</div>

				<div class="input-field s2 m1 col hide" id="icon_chargement_ville">
					<i class="fa fa-spinner fa-pulse fa-fw"></i>
					<span class="sr-only">Chargement...</span>
				</div>
			</div>

			<div class="row input-field">
				<select id="agenda_group">
					<?php if(is_array($agendas) && count($agendas) >= 1){
					$i=0;
					foreach ($agendas as $agenda){
						echo '<option value="'.$agenda['id_agenda'].'">'.$agenda['nom'].'</option>';
  					}
  				}else{
  					echo "<option value='' disabled selected>Vous n'avez pas d'autre agenda enregistré. Créez-en un !</option>";
  					}?>
				</select>
				<label for="agenda_group">Choisissez votre Agenda</label>
			</div>

			<div class="row input-field">
				<input class="filled-in" type="checkbox" name="event_rappel" id="event_rappel">
				<label for="event_rappel">Rappel</label>
			</div>
			<div class="row input-field">
				<input class="filled-in" type="checkbox" name="event_public" id="event_public">
				<label for="event_public">Evènement public</label>
			</div>
			<div class="row input-field">
				<input class="filled-in" type="checkbox" name="event_recurrence" id="event_recurrence">
				<label for="event_recurrence">Evènement récurrent</label>
			</div>

			<div id="block_recurrence" class="row input-field hidden_not_imp">
				<div class="s12 m6 col">
					<select name="recurrence" id="recurrence">
						<option value="allJours">Tous les jours</option>
						<option value="Semaine">Tous les semaines</option>
						<option value="Mois">Tous les mois</option>
					</select>
					<label for="recurrence">Récurrence</label>
				</div>

				<div class="s12 m6 col">
					<select name="nb_recurrence" id="nb_recurrence">
						<option value="1">Un jour</option> 
       					<option value="2">Deux jour</option>
          				<option value="3">Trois jour</option>
           				<option value="4">Quatre jour</option> 
           				<option value="5">Cinq jour</option> 
           				<option value="6">Six jour</option> 
           				<option value="7">Une semaine</option> 
          				<option value="14">Deux semaine</option> 
           				<option value="21">Trois semaine</option> 
           				<option value="28">Quatre semaine</option> 
					</select>
					<label for="nb_recurrence">Répéter durant</label>
				</div>

			</div>

			<input type="hidden" id="id_agenda" name="id_agenda" value="<?= $this->session->userdata("Agenda")["id_agenda"]; ?>" />
			<input type="hidden" id="id_evenement" name="id_evenement" value="" />		

		</div>

		<div class="modal-footer text-right row">
			<span class="button alert-inverted float-left hidden_not_imp" id="delete_event">Supprimer</span>
			<span class="button tertiary float-left hidden_not_imp mg-left-5" id="share_event">Partager</span>
			<input type="button" id="valid_event" name="valid_event" value="Enregistrer" class="button" />
			<span class="modal-action modal-close button secondary">Fermer</span>
		</div>
	</div>

	<script src="<?= asset_url(); ?>js/insert_event.js"></script>
	<script src="<?= asset_url(); ?>js/script_adresse.js"></script>	