<div class="modal fade" id="modal-container-login" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form method="post" action="?p=authenticate" role="form" id="form-login" name="formLogin" novalidate>
			<div class="modal-content">
				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="glyphicon glyphicon-remove"></span>
					</button>
					<h4 class="modal-title" id="myModalLabel">
						Iniciar Sessão
					</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
							 
						<label for="signup_email">
							Endereço de Email
						</label>
						<input type="email" class="form-control" id="login-email" name="email" autocomplete="email" <?php if (isset($_COOKIE["email"])) { echo 'value="'.$_COOKIE["email"].'"'; } ?>>
					</div>

					<div class="form-group">
							 
						<label for="signup_password">
							Palavra-Passe
						</label>
						<input type="password" class="form-control" id="login-password" name="password" autocomplete="off">
					</div>

					<div class="checkbox">
							 
						<label>
							<input type="checkbox" name="remenberme" <?php if (isset($_COOKIE["email"])) { echo 'checked'; } ?>>&nbsp;Lembrar-me
						</label>
					</div>
					
				</div>
				<div class="modal-footer">

					<button class="btn btn-default" id="form-login-submit">
						<span class="glyphicon glyphicon-log-in"></span> Iniciar Sessão
					</button>
				</div>
			</div>
		</form>

	</div>
				
</div>