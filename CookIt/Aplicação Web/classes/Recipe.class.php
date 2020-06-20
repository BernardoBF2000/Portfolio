<?php

	class Recipe {

		function __construct () {

			require 'connection.php';
			$this->conn = new mysqli($db["host"], $db["user"], $db["password"], $db["database"]);
			$this->conn->set_charset("utf8");
		}

		function create ($data) {

			if ($data['title'] != "" && $data['ingredients'] != "" && count($data['step']) > 0) {

				$valid = 1;
			} else {

				$valid = 0;
			}

			if($data['edit'] != "") {

				$query = "
					UPDATE recipes SET
						title = '".$data['title']."',
						dificulty = '".$data['dificulty']."',
						time_drt = '".$data['time_drt']."',
						category = '".$data['category']."',
						robot = '".$data['robot']."',
						ingredients = '".$data['ingredients']."',
						public = '".$data['public']."',
						lst_chg_date = NOW(),
						valid = '".$valid."'
					WHERE id = ".$data['edit']
				;
			} else {

				$query = "
					INSERT INTO recipes (
						title,
						dificulty,
						time_drt,
						category,
						robot,
						ingredients,
						public,
						user_id,
						lst_chg_date,
						valid
					) VALUES (
						'".$data['title']."',
						'".$data['dificulty']."',
						'".$data['time_drt']."',
						'".$data['category']."',
						'".$data['robot']."',
						'".$data['ingredients']."',
						'".$data['public']."',
						'".$_SESSION['user']."',
						NOW(),
						'".$valid."'
					)
				";
			}

			try {

				$this->conn->query($query);
				if ($data['edit'] != "") {

					$recipe_id  = $data['edit'];
				} else {

					$rid_query = $this->conn->query("SELECT MAX(id) FROM recipes WHERE user_id = '".$_SESSION['user']."'");
					$rid_result = $rid_query->fetch_array(MYSQLI_ASSOC);
					$recipe_id = $rid_result['MAX(id)'];
				}

				$this->conn->query("DELETE FROM steps WHERE recipe_id = ".$recipe_id);
				$i = 1;
				foreach ($data['step'] as $key) {

					$this->conn->query("INSERT INTO steps (step_n, value, recipe_id) VALUES ('".$i."', '".$key."', '".$recipe_id."')");
					$i++;
				}

				if (is_uploaded_file($_FILES['image']['tmp_name']) || file_exists($_FILES['image']['tmp_name'])) {
					$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
					move_uploaded_file($_FILES['image']['tmp_name'], 'D:/wamp64/www/dev/img/'.$recipe_id.".".$ext);
					$this->conn->query("UPDATE recipes SET img_path = '".$recipe_id.".".$ext."' WHERE id = ".$recipe_id);
				}

				?><script>window.location.href = '?p=home'</script><?php
			} catch (Exception $e) {
			
				//
			}
		}

		function show ($sit) {

			if ($sit == "home") {

				$search_in = 'all';

				?>
				<div class="row nav-compensator">
					<div class="col-md-12 title">
						<span>TODAS AS RECEITAS</span>
					</div>
				</div>
				<?php
			} elseif ($sit == 'favorites') {

				$user_secret = $this->conn->query("SELECT password FROM users WHERE id = ".$_SESSION['user'])->fetch_array(MYSQLI_ASSOC);
				$search_in = 'favorites<'.$_SESSION['user'].':'.$user_secret['password'].'>';

				?>
				<div class="row nav-compensator">
					<div class="col-md-12 title">
						<span>RECEITAS FAVORITAS</span>
					</div>
				</div>
				<?php
			} elseif ($sit == 'myrecipes') {

				$user_secret = $this->conn->query("SELECT password FROM users WHERE id = ".$_SESSION['user'])->fetch_array(MYSQLI_ASSOC);
				$search_in = 'myrecipes<'.$_SESSION['user'].':'.$user_secret['password'].'>';

				?>
				<div class="row nav-compensator">
					<div class="col-md-12 title">
						<span>MINHAS RECEITAS</span>
					</div>
				</div>
				<?php
			}

			?>

			<div class="row" ng-controller="listRecipesCtrl">
				<input type="hidden" id="searchIn" ng-model="searchInMdl" ng-init="searchInMdl = '<?php echo $search_in; ?>'">

				<div class="col-md-12" style="background-color: var(--dark-color);">
					<div class="row">
						<div class="col-md-3">
							<input type="text" class="form-control" id="searchBarTitle" placeholder="Nome da Receita" ng-model="searchBarTitleMdl" ng-change="updateRecipes()">
						</div>

						<div class="col-md-3">
							<input type="text" class="form-control" id="searchBarRobot" placeholder="Robô" ng-model="searchBarRobotMdl" ng-change="updateRecipes()">
						</div>

						<div class="col-md-3">
							<select class="form-control" id="searchBarCategories" ng-init="searchBarCategoriesMdl = searchBarCategoriesMdl || categories[0].value" ng-options="category.value as category.name for category in categories" ng-model="searchBarCategoriesMdl" ng-change="updateRecipes()"></select>
						</div>

						<div class="col-md-3">
							<div class="row">
								<div class="col-md-4">
									<div class="div-details">Ordenar por:</div>
								</div>

								<div class="col-md-8">
									<select class="form-control" id="searchBarOrderBy" ng-init="searchBarOrderByMdl = searchBarOrderByMdl || orderOptions[3].value" ng-options="orderOption.value as orderOption.name for orderOption in orderOptions" ng-model="searchBarOrderByMdl" ng-change="updateRecipes()"></select>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12 title" ng-show="recipes.length < 1">
					<span style="color: var(--error-color);">NÃO HÁ RECEITAS PARA APRESENTAR</span>
				</div>

				<div class="col-md-3" ng-repeat="recipe in recipes">
					<a href="?p=recipe_details&id={{recipe.id}}">
						<div class="recipe">
							<div style="overflow: hidden;"><div class="img-container" style="background-image: url('{{recipe.imgPath}}');"></div></div>
							<div class="recipe-caption">
								<p class="title" align="center" data-toggle="tooltip" title="{{recipe.title}}">{{recipe.title}}</p>
								<div class="recipe-prop">
									<div style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
										<span class="glyphicon glyphicon-cutlery"></span>
										{{recipe.category}}
									</div>
									<div style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
										<span class="glyphicon glyphicon-time"></span>
										{{recipe.timeDrt}}
									</div>
									<div style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
										<span class="glyphicon glyphicon-fire" ng-repeat="i in nFireIcon(recipe.dificulty) track by $index"></span>
										{{recipe.dificulty}}
									</div>
									<div style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
										<span class="glyphicon glyphicon-flash"></span>
										{{recipe.robot}}
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-12" style="background-color: var(--dark-color); margin-bottom: 15px;" align="center" ng-show="recipes.length > 0 && pagination.numPages > 1">
					<button type="button" class="btn btn-default" ng-disabled="pagination.currentPage - 5 < 1" ng-click="setPage('fastbackward', 0);"><span class="glyphicon glyphicon-chevron-left"></span><span class="glyphicon glyphicon-chevron-left"></span></button>
					<button type="button" class="btn btn-default" ng-disabled="pagination.currentPage == 1"><span class="glyphicon glyphicon-chevron-left" ng-click="setPage('backward', 0);"></span></button>
					<button type="button" class="btn btn-default" ng-repeat="i in nPagination(pagination.numPages) track by $index" ng-class="pagination.currentPage == paginationButtons[$index] ? 'active' : ''" ng-click="setPage('static', paginationButtons[$index]);">{{ paginationButtons[$index] }}</button>
					<button type="button" class="btn btn-default" ng-disabled="pagination.currentPage == pagination.numPages" ng-click="setPage('forward', 0);"><span class="glyphicon glyphicon-chevron-right"></span></button>
					<button type="button" class="btn btn-default" ng-disabled="pagination.currentPage + 5 > pagination.numPages" ng-click="setPage('fastforward', 0);"><span class="glyphicon glyphicon-chevron-right"></span><span class="glyphicon glyphicon-chevron-right"></span></button>
				</div>
			</div>
			<?php
		}

		function details ($id) {

			$x = $this->conn->query("SELECT user_id FROM recipes WHERE id = ".$id)->fetch_array(MYSQLI_ASSOC);
			if (isset($_SESSION['user']) && $x['user_id'] == $_SESSION['user']) {

				$query = "
					SELECT
						title,
						dificulty,
						time_drt,
						category,
						robot,
						ingredients,
						img_path,
						user_id,
						lst_chg_date,
						id
					FROM recipes
					WHERE id = ".$id
				;
			} else {

				$query = "
					SELECT
						title,
						dificulty,
						time_drt,
						category,
						robot,
						ingredients,
						img_path,
						user_id,
						lst_chg_date,
						id
					FROM recipes
					WHERE public = 1
					AND valid = 1
					AND id = ".$id
				;
			}

			$res_query = $this->conn->query($query);

			if ($res_query->num_rows > 0) {

				$row = $res_query->fetch_array(MYSQLI_ASSOC);

				?>
				<div class="row nav-compensator">
					<div class="col-md-12 title">
						<span><?php if($row['title']!="") echo $row['title']; else echo "Sem Título"; ?></span>
					</div>
				</div>

				<?php
				if($row['img_path'] != 'default.jpg') {
					?>
					<div class="row" style="margin-bottom: 20px;">
						<div class="col-md-12" align="center">
							<img src="img/<?php echo $row['img_path']; ?>" class="img-responsive" style="max-height: 500px; max-width: 100%; box-shadow: 0px 0px 5px var(--dark-color);">
						</div>
					</div>
					<?php
				}
				?>

				<div class="row" id="recipe-details-nav">
					<div class="col-lg-2" style="padding: 0px;">
						<?php
						$author_query = $this->conn->query("SELECT name FROM users WHERE id = ".$row['user_id']);
						$author_res = $author_query->fetch_array(MYSQLI_ASSOC);
						?>
						<div class="div-details">Autor: <?php echo $author_res['name']; ?></div>
					</div>

					<div class="col-lg-2" style="padding: 0px;">
						<div class="div-details">
							<span class="glyphicon glyphicon-cutlery"></span>
							<?php
								switch ($row['category']) {
									case 'side_dish': echo 'Acompanhamentos'; break;
									case 'drinks': echo 'Bebidas'; break;
									case 'cakes_cookies': echo 'Bolos e Biscoitos'; break;
									case 'food_entrances_salads': echo 'Entradas e Saladas'; break;
									case 'jellies_jams': echo 'Geleias, Doces e Compotas'; break;
									case 'sauces_spices': echo 'Molhos e Temperos'; break;
									case 'breads': echo 'Pães'; break;
									case 'meat_dishes': echo 'Pratos de Carne'; break;
									case 'fish_seafood_dishes': echo 'Pratos de Peixe e Marisco'; break;
									case 'vegetarian_food': echo 'Pratos Vegetarianos'; break;
									case 'salty_pies_pizzas': echo 'Salgados, Tartes e Pizzas'; break;
									case 'snacks': echo 'Snacks e Aperitivos'; break;
									case 'desserts': echo 'Sobremesas'; break;
									case 'soups': echo 'Sopas'; break;
									default: echo 'Sem Categoria'; break;
								}
							?>
						</div>
					</div>

					<div class="col-lg-2" style="display: grid; grid-template-columns: auto auto; padding: 0px;">
						<div class="div-details">
							<?php
								if ($row['dificulty'] == "easy") {
									echo '<span class="glyphicon glyphicon-fire"></span> Fácil';
								} elseif ($row['dificulty'] == "medium") {
									echo '<span class="glyphicon glyphicon-fire"></span><span class="glyphicon glyphicon-fire"></span> Médio';
								} elseif ($row['dificulty'] == "hard") {
									echo '<span class="glyphicon glyphicon-fire"></span><span class="glyphicon glyphicon-fire"></span><span class="glyphicon glyphicon-fire"></span> Difícil';
								} else {
									echo '<span class="glyphicon glyphicon-fire"></span> Indefinido';
								}
							?>
						</div>

						<div class="div-details">
							<span class="glyphicon glyphicon-time"></span>
							<?php
								if ($row['time_drt'] != "0") {
									echo $row['time_drt']." min";
								} else {
									echo "Indefinido";
								}
							?>
						</div>
					</div>

					<div class="col-lg-2" style="padding: 0px;">
						<div class="div-details">
							<span class="glyphicon glyphicon-flash"></span>
							<?php
							if ($row['robot'] != "") {
								echo $row['robot'];
							} else {
								echo "Sem Robô";
							}
							?>
						</div>
					</div>

					<div class="col-lg-2" style="padding: 0px;">
						<div class="div-details">
							<span class="glyphicon glyphicon-pushpin"></span>
							<?php
							echo date("d-m-Y", strtotime($row['lst_chg_date']));
							?>
						</div>
					</div>
						
					<div class="col-lg-2" style="padding: 0px; display: grid; grid-template-columns: auto auto <?php if(isset($_SESSION['user'])) { echo 'auto'; } if (isset($_SESSION['user']) && $row['user_id'] == $_SESSION['user']) { echo ' auto';  } ?>;">
						<button class="btn-form-create" data-toggle="tooltip" data-placement="top" onclick="window.open('createpdf.php?id=<?php echo $id; ?>', '_blank');" title="Gerar PDF">
							<span class="glyphicon glyphicon-file"></span>
						</button>

						<button class="btn-form-create" data-toggle="tooltip" data-placement="top" onclick="window.location.href = 'createpdf.php?id=<?php echo $id; ?>&d=d';" title="Descarregar">
							<span class="glyphicon glyphicon-download-alt"></span>
						</button>

						<?php
						if (isset($_SESSION['user'])) {

							$fav_query = $this->conn->query("SELECT * FROM favorites WHERE user_id = ".$_SESSION['user']." AND recipe_id = ".$id);
							$fav_chk = $fav_query->num_rows;

							if ($fav_chk == 0) {
								$tooltip_title = "Adicionar aos Favoritos";
							} else {
								$tooltip_title = "Remover dos Favoritos";
							}
								
							?>
							<button class="btn-form-create" id="btn-favorite" data-user="<?php echo $_SESSION['user']; ?>" data-id="<?php echo $id; ?>" data-toggle="tooltip" title="<?php echo $tooltip_title; ?>">
								<?php
								if ($fav_chk == 0) {
									echo '<span class="glyphicon glyphicon-heart-empty"></span>';
								} else {
									echo '<span class="glyphicon glyphicon-heart"></span>';
								}
								?>
							</button>
							<?php

							if ($row['user_id'] == $_SESSION['user']) {
								?>
								<button class="btn btn-form-create" data-toggle="tooltip" title="Editar Receita" onclick="window.location.href = '?p=edit&id=<?php echo $row['id']; ?>'">
									<span class="glyphicon glyphicon-pencil"></span>
								</button>
								<?php
							}
						}
						?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12 subtitle">
						<span>Ingredientes</span>
					</div>
				</div>

				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<span style="font-size: 18px;"><?php echo $row['ingredients']; ?></span>
					</div>
					<div class="col-md-1"></div>
				</div>

				<div class="row">
					<div class="col-md-12 subtitle">
						<span>Procedimento</span>
					</div>
				</div>

				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<?php
						$res_steps = $this->conn->query("SELECT step_n, value FROM steps WHERE recipe_id = ".$row['id']." ORDER BY step_n ASC");

						while ($row_step = $res_steps->fetch_array(MYSQLI_ASSOC)) {

							?>
							<div align="center">
								<span style="font-weight: bold; font-size: 18px;">Passo <?php echo $row_step['step_n']; ?></span>
								<hr>
							</div>

							<div style="margin-bottom: 50px;">
								<span style="font-size: 16px;"><?php echo $row_step['value']; ?></span>
							</div>
							<?php
						}
						?>
					</div>
					<div class="col-md-1"></div>
				</div>
				<?php
			}
		}
	}

?>