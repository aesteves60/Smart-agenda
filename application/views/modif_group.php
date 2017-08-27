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
				<span class="button alert-inverted mg-5" id="delete_groupe">Supprimer</span>
			</div>

			<div id="GroupeSelect">			
				<div class="s12 m5 col">
					<div class="subject-info-box-1">
					<label>Membres disponibles</label>
						<select multiple class="form-control browser-default" id="listBox1">
						<?php
							$i=0;
							if($UsersNotGroup != NULL)
							{
								foreach ($UsersNotGroup as $row)
								{
									$userNotGroup_temp[]=$row;
			    					echo "<option value=".$userNotGroup_temp[$i]['email'].">".$userNotGroup_temp[$i]['surnom']."</option>";
			    					$i++;
			    				}
							}
						?>
						</select>
					</div>
				</div>

				<div class="s12 m2 col">
					<input type='button' id='btnAllRight' value='>>' class="button mg-20" /><br />
					<input type='button' id='btnRight' value='>' class="button mg-20" /><br />
					<input type='button' id='btnLeft' value='<' class="button mg-20" /><br />
					<input type='button' id='btnAllLeft' value='<<' class="button mg-20" /><br />
				</div>

				<div class="s12 m5 col">
					<label>Membres du groupe sélectionnés</label>
					<select multiple class="form-control browser-default" id="listBox2">
						<?php
							$i=0;
							if($UsersGroup != NULL)
							{
								foreach ($UsersGroup as $row)
								{
									$UsersGroup_temp[]=$row;
			    					echo "<option value=".$UsersGroup_temp[$i]['email'].">".$UsersGroup_temp[$i]['surnom']."</option>";
			    					$i++;
			    				}
							}
						?>
					</select>
				</div>

				<div class="s6 offset-s3 col text-center">
					<input type="submit" id="valide_groupSelect" class="button mg-20" value="Valider">
				</div>
			</div>
			<div class="row clear"></div>	
		</div>
	</div>
</div>


<script src="<?= asset_url(); ?>js/modif_group.js"></script>
<script src="<?= asset_url(); ?>js/jquery.selectlistactions.js"></script>