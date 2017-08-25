<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row mg-top-50" style="padding-left: -280px !important;">
	<div class="s12 m10 offset-m1 col">
		<div class="panel">
			<h2 class="text-center">Ajouter un groupe</h2>
				
				<div class="row input-field">
					<input type="checkbox" name="group_famille" id="group_famille">
					<label for="Group_Famille">Ce groupe est une famille ?</label></br>
				</div>

				<label for="nom_group">Entrez le nom du groupe</label>
				<input type="text" name="group_name" id="group_name" />


				<div class="s12 m5 col">
					<div class="subject-info-box-1">
					<label>Membres disponibles</label>
						<select multiple class="form-control browser-default" id="listBox1">
							<?php
							$i=0;
							if($users == NULL)
							{

							}else{

								foreach ($users as $row){
									$user_temp[]=$row;
		    						echo "<option value=".$user_temp[$i]['email'].">".$user_temp[$i]['surnom']."</option>";
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
						echo "<option value='".$this->data['user']['email']."'>".$this->data['user']['surnom']."</option>";
						?>
					</select>
				</div>
				
				<div class="s6 offset-s3 col text-center">
					<input type="submit" id="valide_add_group" class="button mg-20" value="Valider">
				</div>
				
			<div class="row clear"></div>
		</div>
	</div>
</div>

<script src="<?= asset_url(); ?>js/add_group.js"></script>	
<script src="<?= asset_url(); ?>js/jquery.selectlistactions.js"></script>