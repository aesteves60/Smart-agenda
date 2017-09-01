<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="row">

		<div class="s12 col ">
			<div class="panel" >
			<label>Choix agenda afficher</label>
			<div class="row"></div>
				<?php if(is_array($datas['agendas']) && count($datas['agendas']) >= 1){
					$i=0;
					foreach ($datas['agendas'] as $agenda){
						if($agenda['afficher'] == 1){
							echo"<div id='".$datas['agendas'][$i]['id_agenda']."' name='".$datas['color'][$i]."_b'  class='chip ".$datas['color'][$i]."_b'>";
	    					echo $agenda['nom'];
	  						echo"</div>";
	  						$i++;
	  					}else{
	  						echo"<div id='".$datas['agendas'][$i]['id_agenda']."' name='".$datas['color'][$i]."_b'  class='chip'>";
	    					echo $agenda['nom'];
	  						echo"</div>";
	  						$i++;

	  					}
  					}
  				}else{
  					echo "<p>Vous n'avez pas d'autre agenda enregistré. Créez-en un !</p>";
  					}?>
			</div>
		</div>

		<div class="s12 col ">
			<div class="panel">
			<div class="row clear"></div>

				<div id='calendar'></div>

				<div class="row clear"></div>

			</div>
			<div class="row clear"></div>
		</div>

	</div>


<!-- 		<div class="s12 m6 col ">
			<div class="panel">
				<h3>Choix de l'agenda</h3>

				<div class="s12 col">
				<?php if(is_array($datas['agendas']) && count($datas['agendas']) > 1){ ?>
					<select name="selectAgenda" id="selectAgenda">
						<?php foreach ($datas['agendas'] as $agenda) { ?>
							<option value="<?= $agenda['id_agenda']; ?>"><?= $agenda['nom']; ?></option>
						<?php } ?>
					</select>
				<?php } else { ?>
					<p>Vous n'avez pas d'autre agenda enregistré. Créez-en un !</p>
				<?php } ?>
				</div>

				<div class="clear"></div>

			</div>
		</div> -->

		<div class="s12 m6 col ">
			<div class="panel">

				<h3>Nouvel agenda</h3>					
					
				<form method="POST" action="" id="form_createAgenda" class="row">

					<div class="s6 col input-field">
						<input type="text" name="nom" id="nom" required />
						<label for="nom">Nom de l'agenda</label>
					</div>

					<div class="s6 col input-field">
						<input type="text" name="description" id="description" />
						<label for="description">Description</label>
					</div>

					<div class="s6 col input-field">
						<input type="checkbox" name="public" id="public" class="filled-in" />
						<label for="public">Public</label>
					</div>

					<div class="s6 col">
						<a id="save_createAgenda" class="button mg-top-15 right">Créer</a>
					</div>

				</form>

				<div class="clear"></div>
			</div>
		</div>

	</div>
	<div class="fixed-action-btn add_event">
    <a class="btn-floating red-alert" href="#modalAddEvent">
      <i class="fa fa-plus"></i>
    </a>
  </div>


<script>

	$(document).ready(function() {	
 		//$('.chips').material_chip();

		$('#calendar').fullCalendar({
			locale: 'fr',
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,listWeek'
			},
			defaultDate: '<?= date('Y-m-d'); ?>',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			timezone: "<?php echo 'UTC+'.date('Z')/3600; ?>",
			events: 
				<?php echo $datas["events"]?>,
			eventClick: function(event, element) {
				updateEvent(event);
			}
			
		});
	
	});

</script>

<script src="<?= asset_url(); ?>js/modif_agenda.js"></script>