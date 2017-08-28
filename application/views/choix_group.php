<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row mg-top-50" style="padding-left: -280px !important;">
	<div class="s12 m10 offset-m1 col">
		<div class="panel">
			<h2 class="text-center">Gérer les groupes</h2>
			<form id="form_modif_groupSelect" method="post" action="">
				 
				<div class="input-field s10 offset-s1 m8 offset-m2 col"> 

					<select name="id_groupe" id="list_group">
						<option value=""></option>

						<?php foreach ($groupes as $groupe) {
							echo "<option value='".$groupe['id_groupe']."'>".$groupe['nom']."</option>";
						} ?>
					</select>
					<label for="list_group">Choisissez votre groupe</label>

				</div>

			</form>
			<div class="s6 offset-s3 col text-center row">
				<a href="add_group " class="button inverted">Ajouter</a>
			</div>

			</div>
			<div class="row clear"></div>	
		</div>
	</div>
</div>


<script src="<?= asset_url(); ?>js/modif_group.js"></script>
<script src="<?= asset_url(); ?>js/jquery.selectlistactions.js"></script>