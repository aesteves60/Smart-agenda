<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row mg-top-50" style="padding-left: -280px !important;">
	<div class="s12 m10 offset-m1 col">
		<div class="panel">

		<h2 class="text-center">Groupe : <?php echo $UsersGroup[0]['nom']?></h2>

			<div class="s12 m5 col">
				<div class="subject-info-box-1">
				<label>Membres disponibles</label>
					<select multiple class="form-control browser-default" id="listBox1">
					<?php
						$i=0;
						if($UsersNotGroup == NULL)
						{

						}else{
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
						if($UsersGroup == NULL)
						{

						}else{
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
				<span class="button alert-inverted mg-5" id="delete_groupeSelect">Supprimer</span>
			</div>
				

			<div class="row clear"></div>
		</div>
	</div>
</div>

<script src="<?= asset_url(); ?>js/modif_groupSelect.js"></script>
<script src="<?= asset_url(); ?>js/jquery.selectlistactions.js"></script>