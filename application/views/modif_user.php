<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="s12 col">
		<div id="alert-modif" class="alert-box in-panel " style="display: none;">
			<p style="margin: 0">ok</p>
			<i class="fa fa-times close" onclick="removeBlock('alert-modif')"></i>
		</div>
		<div class="panel">		
			<h2>Modification du profil</h2>
			<div class="input-field s10 m4 col">
				<i class="fa fa-envelope prefix"></i>
				<input type="text" id="email_modif" name="mail" value="<?= $user['email']; ?>" />
				<label for="mail">Email</label>
			</div>
			
			<div class="row clear"></div>

			<div class="input-field s10 m4 col">
				<i class="fa fa-key prefix"></i>
				<input type="password" id="password_modif" name="password" />
				<label for="password">Mot de passe</label>
			</div>
			<div class="input-field s10 m4 col">
				<i class="fa fa-key prefix"></i>
				<input type="password" id="repassword_modif" name="repassword" />
				<label for="repassword">Réecrire mot de passe</label>
			</div>
			
			<div class="row clear"></div>
			
			<div class="input-field s10 m4 col">
				<i class="fa fa-address-card-o prefix"></i>
				<input type="text" id="surnom_modif" name="surname" value="<?= $user['surnom']; ?>" />
				<label for="surname">Surnom</label>
			</div>
			<div class="s6 offset-s3 col text-center">
				<input type="submit" id="valide_modif" class="button mg-20" value="Valider">
			</div>

			<div class="row clear"></div>
		</div>
	</div>

	<div class="s12 col">
		<div class="panel">

			<h4>Supprimer mon compte</h4>

			<p>
				Si vous souhaitez supprimer votre compte, et toutes les données liées à celui-ci, vous pouvez le faire en <a href="<?= base_url(); ?>Account/delete_user">cliquant ici</a>.
				<br />
				<small>Attention, cette action est irréversible !</small>
			</p>


			<div class="row clear"></div>

		</div>
	</div>


						
<script src="<?= asset_url(); ?>js/modif_user.js"></script>	