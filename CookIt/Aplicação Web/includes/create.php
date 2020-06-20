<?php

if (isset($_SESSION['user'])) {

	if ($edit == 'true' && isset($_GET['id'])) {

		$query = "
			SELECT
				title,
				dificulty,
				time_drt,
				category,
				robot,
				ingredients,
				img_path,
				public
			FROM recipes
			WHERE user_id = ".$_SESSION['user']."
			AND id = ".$_GET['id']
		;

		$res_query = $conn->query($query);

		if ($res_query->num_rows > 0) {

			$row = $res_query->fetch_array(MYSQLI_ASSOC);

			$title = $row['title'];
			$dificulty = $row['dificulty'];
			$time_drt = $row['time_drt'];
			$category = $row['category'];
			$robot = $row['robot'];
			$ingredients = $row['ingredients'];
			$img_path = $row['img_path'];
			$public = $row['public'];
			$id = $_GET['id'];
		} else $edit = false;
	}

	?>
	<div class="row nav-compensator">
		<div class="col-md-12 title">
			<span>NOVA RECEITA</span>
		</div>
	</div>


	<div class="row" id="form-create-nav">
		<div class="col-md-12" style="display: grid; grid-template-columns: 20% 20% 20% 20% 20%; padding: 0px;">
			<div>
				<button class="btn-form-create" id="form-create-title-btn">Título</button>
			</div>

			<div>
				<button class="btn-form-create" id="form-create-ingredients-btn">Ingredientes</button>
			</div>

			<div>
				<button class="btn-form-create" id="form-create-steps-btn">Procedimento</button>
			</div>

			<div>
				<button class="btn-form-create" id="form-create-config-btn">Definições</button>
			</div>

			<div>
				<button class="btn-form-create" id="form-create-save">Guardar</button>
			</div>
		</div>
	</div>

	<div class="row" style="font-size: 20px; margin-top: 25px;">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<form method="post" action="?p=create-save" role="form" id="form-create" name="formCreate" runat="server" enctype="multipart/form-data" novalidate>
				<input type="hidden" name="edit" value="<?php if($edit==true) echo $id; ?>">
				<div id="form-create-title">
					<div class="subtitle">
						<span>Título</span>
					</div>

					<div class="form-group">
						<label for="form-create-name">
							Nome da Receita
						</label>
						<input type="text" class="form-control" id="form-create-name" name="title" value="<?php if($edit==true) echo $title; ?>">
					</div>

					<div class="form-group">
						<label for="form-create-image">
							Imagem
						</label>
						<input type="file" accept="image/*" class="form-control" id="form-create-image" name="image" onchange="readURL(this);">
						<img src="<?php if($edit==true) echo 'img/'.$img_path; else echo ''; ?>" width="50%" id="image-preview">
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="form-create-dificulty">
									Dificuldade
								</label>
								<select class="form-control" id="form-create-dificulty" name="dificulty">
									<option value="">-- Selecione uma opção --</option>
									<option value="easy" <?php if($edit==true && $dificulty=='easy') echo 'selected'; ?>>Fácil</option>
									<option value="medium" <?php if($edit==true && $dificulty=='medium') echo 'selected'; ?>>Médio</option>
									<option value="hard" <?php if($edit==true && $dificulty=='hard') echo 'selected'; ?>>Difícil</option>
								</select>
							</div>

							<div class="col-md-6">
								<label for="form-create-time">
									Tempo (min)
								</label>
								<input type="number" class="form-control" id="form-create-time" name="time_drt" min="0" value="<?php if($edit==true) echo $time_drt; ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="form-create-category">
									Categoria
								</label>
								<select class="form-control" id="form-create-category" name="category">
									<option value="uncategorized" <?php if($edit==true && $category=='uncategorized') echo 'selected'; ?>>Sem Categoria</option>
									<option value="side_dish" <?php if($edit==true && $category=='side_dish') echo 'selected'; ?>>Acompanhamentos</option>
									<option value="drinks" <?php if($edit==true && $category=='drinks') echo 'selected'; ?>>Bebidas</option>
									<option value="cakes_cookies" <?php if($edit==true && $category=='cakes_cookies') echo 'selected'; ?>>Bolos e Biscoitos</option>
									<option value="food_entrances_salads" <?php if($edit==true && $category=='food_entrances_salads') echo 'selected'; ?>>Entradas e Saladas</option>
									<option value="jellies_jams" <?php if($edit==true && $category=='jellies_jams') echo 'selected'; ?>>Geleias, Doces e Compotas</option>
									<option value="sauces_spices" <?php if($edit==true && $category=='sauces_spices') echo 'selected'; ?>>Molhos e Temperos</option>
									<option value="breads" <?php if($edit==true && $category=='breads') echo 'selected'; ?>>Pães</option>
									<option value="meat_dishes" <?php if($edit==true && $category=='meat_dishes') echo 'selected'; ?>>Pratos de Carne</option>
									<option value="fish_seafood_dishes" <?php if($edit==true && $category=='fish_seafood_dishes') echo 'selected'; ?>>Pratos de Peixe e Marisco</option>
									<option value="vegetarian_food" <?php if($edit==true && $category=='vegetarian_food') echo 'selected'; ?>>Pratos Vegetarianos</option>
									<option value="salty_pies_pizzas" <?php if($edit==true && $category=='salty_pies_pizzas') echo 'selected'; ?>>Salgados, Tartes e Pizzas</option>
									<option value="snacks" <?php if($edit==true && $category=='snacks') echo 'selected'; ?>>Snacks e Aperitivos</option>
									<option value="desserts" <?php if($edit==true && $category=='desserts') echo 'selected'; ?>>Sobremesas</option>
									<option value="soups" <?php if($edit==true && $category=='soups') echo 'selected'; ?>>Sopas</option>
								</select>
							</div>

							<div class="col-md-6">
								<label for="form-create-robot">
									Robô de Cozinha <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Deixe em branco se a receita não necessitar de nenhum robô de cozinha."></span>
								</label>
								<input type="text" class="form-control" id="form-create-robot" name="robot" value="<?php if($edit==true) echo $robot; ?>">
							</div>
						</div>
					</div>
				</div>

				<div id="form-create-ingredients">
					<div class="subtitle">
						<span>Ingredientes</span>
					</div>

					<div class="form-group">
						<textarea class="summernote" name="ingredients"><?php if($edit==true) echo $ingredients; ?></textarea>
					</div>
				</div>

				<div id="form-create-steps">
					<div class="subtitle">
						<span>Procedimento</span>
					</div>

					<script type="text/javascript">
						function removeStep (btn) {
							var x = btn.parentElement.parentElement;
							x.remove(x);
							$('#steps-container .step-div').each(function (index) {
								var label = $(this).find('.step-title');
								label.text('Passo ' + (index + 1));
							});
						}
					</script>
					<div id="steps-container">
						<?php
						if($edit == true) {
							$res_steps = $conn->query("SELECT value FROM steps WHERE recipe_id = ".$id." ORDER BY step_n ASC");

							while ($row_step = $res_steps->fetch_array(MYSQLI_ASSOC)) {

								?>
								<div class="form-group step-div">
									<div>
										<label class="step-title">Passo</label>
										<button type="button" style="width: 100%;" class="btn btn-default form-create-remove-step" onclick="removeStep(this);"><span class="glyphicon glyphicon-trash"></span> Remover Passo</button>
									</div>
									<textarea class="summernote" name="step[]"><?php echo $row_step['value']; ?></textarea>
								</div>
								<?php
							}
							?>
							<script type="text/javascript">
								$(document).ready(function () {
									function initializeSummernote () {
										$('.summernote').summernote({

											toolbar: [
												['style', ['bold', 'italic', 'underline', 'clear']],
												['font', ['strikethrough', 'superscript', 'subscript']],
												['fontsize', ['fontsize']],
												['color', ['color']],
												['para', ['ul', 'ol', 'paragraph']],
												['height', ['height']]
											],
											height: 200,
											disableResizeEditor: true,
											disableDragAndDrop: true
										});
									}
									function reorderSteps () {
										$('#steps-container .step-div').each(function (index) {
											var label = $(this).find('.step-title');
											label.text('Passo ' + (index + 1));
										});
									}
									initializeSummernote();
									reorderSteps();
								});
							</script>
							<?php
						}
						?>
					</div>

					<div class="form-group" id="form-create-add-step-container">
						<button type="button" style="width: 100%;" class="btn btn-default" id="form-create-add-step">
							<span class="glyphicon glyphicon-plus"></span> Adicionar Passo
						</button>
					</div>
				</div>

				<div id="form-create-config">
					<div class="subtitle">
						<span>Definições</span>
					</div>

					<div class="form-group">
						<label>
							Publicar Receita <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Independentemente da opção selecionada a receita será apenas visível para os outros utilizadores se o campo Ingredientes estiver preenchido e existir pelo menos um Passo"></span> <!-- !! -->
						</label>

						<div class="row">
							<?php
							if($edit == true && $public == '1') $btnPublic = 'yes';
							elseif($edit == true && $public == '0') $btnPublic = 'no';
							else $btnPublic = 'no';
							?>
							<div class="col-sm-6" style="padding: 0px;">
								<button type="button" style="width: 100%;" class="btn <?php if($btnPublic=='yes') echo 'btn-yes-active'; else echo 'btn-yes'; ?>" id="form-create-public-yes">
									Sim
								</button>
							</div>

							<div class="col-sm-6" style="padding: 0px;">
								<button type="button" style="width: 100%;" class="btn <?php if($btnPublic=='no') echo 'btn-no-active'; else echo 'btn-no'; ?>" id="form-create-public-no">
									Não
								</button>
							</div>

							<input type="hidden" value="<?php if($edit==true) echo $public; else echo '0'; ?>" id="form-create-public" name="public">
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-3"></div>
	</div>
	<?php

}

?>