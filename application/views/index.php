<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<div class="row">

		<div class="s12 m8 col">
			<div class="panel">

				<h1>Bienvenue sur SmartAgenda</h1>

				<div style="width: 100%; height: 250px; background: url('<?= asset_url(); ?>img/agenda1.jpg') no-repeat center;">
					&nbsp;
				</div>

                <h3>SmartAgenda, un agenda intelligent et pratique.</h3>

			</div>
		</div>

		<div class="s12 m4 col">
			<div class="panel">

				<h2 class="text-center">Connexion</h2>

				<form method="post" action="<?= base_url(); ?>login" method="post" class="row">

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

					<div class="s8 offset-s2 col text-center">
						<input type="submit" name="submit" class="button mg-20" value="Connexion">
						<a class="button inverted mg-20" href="Account/inscription">Inscription</a>
					</div>

				</form>

				<div class="row clear"></div>

			</div>
			<div class="row clear"></div>
		</div>

	</div>
