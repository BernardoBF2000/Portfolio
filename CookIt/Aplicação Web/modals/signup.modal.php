<div class="modal fade" id="modal-container-signup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					Criar Conta
				</h4>
			</div>
			<div class="modal-body">
				<form role="form" id="form-signup" name="formSignup" novalidate>
					<div class="form-group">
						 
						<label for="signup_name">
							Nome
						</label>
						<input type="text" class="form-control" id="signup-name" name="name" ng-model="nameMdl" autocomplete="name" required>
						<p class="help-block">
							<span class="invalid-field" ng-show="formSignup.name.$error.required">Nome obrigatório.</span>
							<span class="valid-field" ng-show="formSignup.name.$valid">Nome válido.</span>
						</p>
					</div>

					<div class="form-group">
						 
						<label for="signup_email">
							Endereço de Email
						</label>
						<input type="email" class="form-control" id="signup-email" name="email" ng-model="email" autocomplete="email" required dir-email>
						<p class="help-block">
							<span class="invalid-field" ng-show="formSignup.email.$error.required">Email obrigatório.</span>
							<span class="invalid-field" ng-show="formSignup.email.$error.invalidEmail">Email inválido.</span>
							<span class="valid-field" ng-show="formSignup.email.$valid">Email válido.</span>
						</p>
					</div>

					<div class="form-group">
						 
						<label for="signup_password">
							Palavra-Passe
						</label>
						<input type="password" class="form-control" id="signup-password" name="password" ng-model="password" autocomplete="off" minlength="8" required>
						<p class="help-block">
							<span class="invalid-field" ng-show="formSignup.password.$error.required">Palavra-Passe obrigatória.</span>
							<span class="invalid-field" ng-show="formSignup.password.$error.minlength">Palavra-Passe requer no mínimo 8 caracteres.</span>
							<span class="valid-field" ng-show="formSignup.password.$valid">Palavra-Passe válida.</span>
						</p>
					</div>

					<div class="form-group">
						 
						<label for="signup_password_repeat">
							Repetir Palavra-Passe
						</label>
						<input type="password" class="form-control" id="signup-password-repeat" name="passwordrepeat" ng-model="passwordrepeat" autocomplete="off" minlength="8" required match-password="password">
						<p class="help-block">
							<span class="invalid-field" ng-show="formSignup.password.$error.required">Palavra-Passe obrigatória.</span>
							<span class="invalid-field" ng-show="formSignup.password.$error.minlength">Palavra-Passe requer no mínimo 8 caracteres.</span>
							<span class="invalid-field" ng-show="formSignup.passwordrepeat.$error.passwordMatch">Palavras-Passe não correspondem.</span>
							<span class="valid-field" ng-show="formSignup.passwordrepeat.$valid">Palavras-Passe correspondem.</span>
						</p>
					</div>
				</form>
			</div>
			<div class="modal-footer">

				<button type="button" class="btn btn-default" id="form-signup-submit" ng-disabled="formSignup.name.$error.required || formSignup.email.$error.required || formSignup.email.$error.email || formSignup.password.$error.required || formSignup.password.$error.minlength || passwordrepeat != password">
					<span class="glyphicon glyphicon-user"></span> Criar Conta
				</button>
			</div>
		</div>

	</div>
				
</div>