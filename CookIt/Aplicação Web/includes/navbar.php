<nav class="navbar navbar-inverse navbar-fixed-top" id="navbar" role="navigation">
	<div class="navbar-header">
					 
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			 <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
		</button>
	</div>
				
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li>
				<button class="btn btn-default" onclick="window.location.href='?p=home';">
					<span class="glyphicon glyphicon-cutlery"></span> Todas as Receitas
				</button>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<?php

				if ($user->authenticated()) {

					?>
					<li class="dropdown">
						<button  class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-glass"></span> Minhas Receitas <strong class="caret"></strong>
						</button>
						<ul class="dropdown-menu">
							<li>
								<a href="?p=create" id="navbar-btn-create">Criar Nova Receita</a>
							</li>
							<li>
								<a href="?p=myrecipes">Minhas Receitas</a>
							</li>
							<li>
								<a href="?p=favorites">Receitas Favoritas</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span> <?php echo $user->name(); ?> <strong class="caret"></strong>
						</button>
						<ul class="dropdown-menu">
							<li>
								<a href="?p=logout">Fechar Sessão</a>
							</li>
						</ul>
					</li>
					<?php
				} else {

					?>
					<li>
						<button class="btn btn-default" data-toggle="modal" data-target="#modal-container-login">
							<span class="glyphicon glyphicon-log-in"></span> Iniciar Sessão
						</button>
					</li>
					<li>
						<button class="btn btn-default" data-toggle="modal" data-target="#modal-container-signup">
							<span class="glyphicon glyphicon-user"></span> Criar Conta
						</button>
					</li>
					<?php
				}

			?>
		</ul>
	</div>

</nav>