<?php
$userId = "";
if (isset($_SESSION['user'])) $userId = $_SESSION['user'];
?>
<input type="hidden" id="userId" value="<?php echo $userId; ?>">

<div class="modal fade" id="makeQuestion" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-controller="makeQuestionCtrl">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					Fazer uma Pergunta
				</h4>
			</div>

			<div class="modal-body">
				<form role="form" id="formMakeQuestion" name="formMakeQuestion" novalidate>
					<div class="form-group">
						<label for="mqEmail">Email</label>
						<input type="email" id="mqEmail" name="mqEmail" ng-model="mqEmailMdl" class="form-control" autocomplete="email" required dir-email>
						<p class="help-block">
							<span class="invalid-field" ng-show="formMakeQuestion.mqEmail.$error.required">Email obrigatório.</span>
							<span class="invalid-field" ng-show="formMakeQuestion.mqEmail.$error.invalidEmail">Email inválido.</span>
							<span class="valid-field" ng-show="formMakeQuestion.mqEmail.$valid">Email válido.</span>
						</p>
					</div>

					<div class="form-group">
						<label for="mqSubject">Assunto</label>
						<input type="text" id="mqSubject" name="mqSubject" ng-model="mqSubjectMdl" class="form-control" autocomplete="off" required>
						<p class="help-block">
							<span class="invalid-field" ng-show="formMakeQuestion.mqSubject.$error.required">Preenchimento obrigatório.</span>
						</p>
					</div>

					<div class="form-group">
						<label for="mqQuestion">Questão</label>
						<textarea id="mqQuestion" name="mqQuestion" ng-model="mqQuestionMdl" class="form-control" rows="5" style="height: unset;" required></textarea>
						<p class="help-block">
							<span class="invalid-field" ng-show="formMakeQuestion.mqQuestion.$error.required">Preenchimento obrigatório.</span>
						</p>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="mqSubmit" ng-disabled="formMakeQuestion.mqEmail.$error.required || formMakeQuestion.mqEmail.$error.invalidEmail || formMakeQuestion.mqSubject.$error.required || formMakeQuestion.mqQuestion.$error.required">
					<span class="glyphicon glyphicon-send"></span> Enviar
				</button>
			</div>
		</div>
	</div>		
</div>

<div class="modal fade" id="leaveComment" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-controller="leaveCommentCtrl">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					Deixar Comentário/Sugestão
				</h4>
			</div>

			<div class="modal-body">
				<form role="form" id="formLeaveComment" name="formLeaveComment" novalidate>
					<div class="form-group">
						<label for="lcEmail">Email</label>
						<input type="email" id="lcEmail" name="lcEmail" ng-model="lcEmailMdl" class="form-control" autocomplete="email" required dir-email>
						<p class="help-block">
							<span class="invalid-field" ng-show="formLeaveComment.lcEmail.$error.required">Email obrigatório.</span>
							<span class="invalid-field" ng-show="formLeaveComment.lcEmail.$error.invalidEmail">Email inválido.</span>
							<span class="valid-field" ng-show="formLeaveComment.lcEmail.$valid">Email válido.</span>
						</p>
					</div>

					<div class="form-group">
						<label for="lcRating">Avaliação</label><br>
						<div class="btn-group">
							<button type="button" class="btn btn-rating" id="rating1" ng-click="setRating(1)" ng-mouseleave="ratingMouseLeave()" ng-mouseenter="ratingMouseEnter(1)"><span class="glyphicon glyphicon-star-empty"></span></button>
							<button type="button" class="btn btn-rating" id="rating2" ng-click="setRating(2)" ng-mouseleave="ratingMouseLeave()" ng-mouseenter="ratingMouseEnter(2)"><span class="glyphicon glyphicon-star-empty"></span></button>
							<button type="button" class="btn btn-rating" id="rating3" ng-click="setRating(3)" ng-mouseleave="ratingMouseLeave()" ng-mouseenter="ratingMouseEnter(3)"><span class="glyphicon glyphicon-star-empty"></span></button>
							<button type="button" class="btn btn-rating" id="rating4" ng-click="setRating(4)" ng-mouseleave="ratingMouseLeave()" ng-mouseenter="ratingMouseEnter(4)"><span class="glyphicon glyphicon-star-empty"></span></button>
							<button type="button" class="btn btn-rating" id="rating5" ng-click="setRating(5)" ng-mouseleave="ratingMouseLeave()" ng-mouseenter="ratingMouseEnter(5)"><span class="glyphicon glyphicon-star-empty"></span></button>

							<input type="hidden" id="lcRating" name="lcRating" ng-model="lcRatingMdl" required>
						</div>
						<p class="help-block">
							<span class="invalid-field" ng-show="formLeaveComment.lcRating.$error.required">Diga-nos a sua avaliação da plataforma.</span>
						</p>
					</div>

					<div class="form-group">
						<label for="lcComment">Comentário/Sugestão</label>
						<textarea id="lcComment" name="lcComment" ng-model="lcCommentMdl" class="form-control" rows="5" style="height: unset;" required></textarea>
						<p class="help-block">
							<span class="invalid-field" ng-show="formLeaveComment.lcComment.$error.required">Preenchimento obrigatório.</span>
						</p>
					</div>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="lcSubmit" ng-disabled="formLeaveComment.lcEmail.$error.required || formLeaveComment.lcEmail.$error.invalidEmail || formLeaveComment.lcRating.$error.required || formLeaveComment.lcComment.$error.required">
					<span class="glyphicon glyphicon-send"></span> Enviar
				</button>
			</div>
		</div>
	</div>
</div>