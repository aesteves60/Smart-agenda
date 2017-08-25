<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="row">
		
		<div class="s12 m8 col">
			<div class="panel">

				<h3>Mes Mémos</h3>

				<ul id="listeMemos" class="collapsible" data-collapsible="expandable">
				
				<?php
				if($todo != NULL && is_array($todo)) {
					foreach ($todo as $row) {
				?>
					<li class="memo" id="memo_<?= $row['id_element_todo']; ?>">
						<div class="collapsible-header memo_title">
							<div class="s8 col" id="text_memo_title">
								<span><?= $row['titre']; ?></span>
							</div>
							<div class="s4 col">
								<span class="float-right checkTodo <?= (($row['valide'] == TRUE) ? 'green' : NULL); ?>">
									<i class="fa fa-check tooltipped" data-position="right" data-delay="50" data-tooltip="Valider ce mémo"></i>
								</span>
								<span class="float-right favoriTodo <?= (($row['favori'] == TRUE) ? 'yellow' : NULL); ?>">
									<i class="fa fa-star tooltipped" data-position="right" data-delay="50" data-tooltip="Ajouter ce mémo au favori"></i>
								</span>
							</div>
						</div>
						<div class="collapsible-body row memo_desc" id="desc_<?= $row['id_todo']; ?>">
							<div class="input-field s12 col right-align" id="modifTodo" style="display:none">
								<input type="text" name="text_todo_modif" id="text_todo_modif" />
								<input type="submit" id="Valid_Modif_todo" class="button" value="Valider">
							</div>

							<div class="s10 m11 col" id="text_memo_desc"><?= $row['description']; ?></div>
							<div class="s2 m1 col" id="icone_memo_desc">
								<div class="float_right">
									<div class="editTodo">
										<i class="fa fa-pencil" data-tooltip="Editer ce mémo"></i>
									</div>
									<div class="removeTodo">
										<i class="fa fa-times" data-tooltip="Supprimer ce mémo"></i>
									</div>
								</div>
							</div>
							
						</div>
					</li>
				<?php 
					}
				}
				?>

				</ul>

			</div>
		</div>

		<div class="s12 m4 col">
			<div class="panel">

				<h3>Ajout d'un Mémo</h3>

				<div class="row">
					<div id="title" class="header input-field s12 m6 col">
						<input type="text" name="todo_name" id="todo_name" />
						<label for="todo_name">Titre</label>
					</div>

					<div class="input-field s12 col">
						<textarea class="materialize-textarea" name="todo_description" id="todo_description" row="3"></textarea>
						<label for="todo_description">Contenu</label>
					</div>

					<div class="input-field s12 col right-align">
						<input type="submit" id="add_todo" class="button" value="Ajouter">
					</div>

				</div>

			</div>
		</div>


	</div>

	<script src="<?= asset_url(); ?>js/add_todo.js"></script>	



