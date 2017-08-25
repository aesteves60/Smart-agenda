<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		
		<div class="row mg-top-50" style="padding-left: -280px !important;">

			<div class="s10 m8 l4 offset-l3 col">

				<div class="panel">

					<div id="alert-box" class="alert-box in-panel <?= $notification['class']; ?>" <?php if($notification == NULL) echo 'style="display: none;"'; ?>>
						<p style="margin: 0"><?= $notification['message']; ?></p>
						<i class="fa fa-times close" onclick="removeBlock('alert-box')"></i>
					</div>

					<h2 class="text-center">Inscription</h2>

					<form class="row">
						<div class="input-field s10 offset-s1 m8 offset-m2 col">
							<i class="fa fa-user prefix"></i>
							<input type="text" id="mail" name="mail" />
							<label for="mail">Email</label>
						</div>
						<div class="input-field s10 offset-s1 m8 offset-m2 col">
							<i class="fa fa-key prefix"></i>
							<input type="password" id="password" name="password" />
							<label for="password">Mot de passe</label>
						</div>
						<div class="input-field s10 offset-s1 m8 offset-m2 col">
							<i class="fa fa-key prefix"></i>
							<input type="password" id="repassword" name="repassword" />
							<label for="repassword">Confirmer le mot de passe</label>
						</div>
						
						<div class="input-field s10 offset-s1 m8 offset-m2 col">
							<i class="fa fa-address-card-o prefix"></i>
							<input type="text" id="surname" name="surname" />
							<label for="surname">Pseudo</label>
						</div>
						<div class="s8 offset-s2 col text-center">
							<input type="submit" id="confirme" class="button mg-20" value="Confimer">
							<a class="button inverted mg-20" href="<?= base_url(); ?>login">Connexion</a>
						</div>

					</form>

				</div>

			</div>

		</div>
						
<script src="<?= asset_url(); ?>js/inscription.js"></script>	