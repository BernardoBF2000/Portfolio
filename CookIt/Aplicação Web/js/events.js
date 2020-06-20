$(document).ready(function () {

	$("#form-signup-submit").click(function () {

		var name = $("#form-signup #signup-name").val();
		var email = $("#form-signup #signup-email").val();
		var password = $("#form-signup #signup-password").val();

		loader.show();

		$.post(

		"ajax/signup.php",
		{
			"name": name,
			"email": email,
			"password": password
		},
		function (data, status) {

			loader.hide();

			if (status == "success") {
				
				$("#modal-container-signup").modal("hide");

				if (data == "connect_error") {

					modalAlert.display("Não foi possível estabelecer conexão.", "error");
				} else if (data == "email_registered") {

					modalAlert.display("Já existe uma conta com este email.", "warning");
				} else if (data == "query_error") {

					modalAlert.display("Ocorreu um erro.", "error");
				} else if (data == "send_email_failed") {

					modalAlert.display("Ocorreu um erro.", "error");
				} else if (data == "success") {

					modalAlert.display("Foi enviado um mail de verificação para o seu email.", "success");
				}
			}
		});
	});

	$("#form-login-submit").click(function () {

		var email = $("#login-email").val();
		var password = $("#login-password").val();
		
		loader.show();
		
		$.post(
		
		"ajax/login-check.php",
		{
			"email": email,
			"password": password
		},
		function (data, status) {
			
			loader.hide();

			var submit = true;
			
			if (status == "success") {

				$("#modal-container-login").modal("hide");
				
				if (data == "connect_error") {

					modalAlert.display("Não foi possível estabelecer conexão.", "error");
					submit = false;
				} else if (data == "not_validated") {

					modalAlert.display("Esta conta ainda não foi confirmada.", "warning");
					submit = false;
				} else if (data == "authentication_failed") {

					modalAlert.display("Email ou palavra-passe errada.", "warning");
					submit = false;
				} else if (data == "query_error") {

					modalAlert.display("Ocorreu um erro", "error");
					submit = false;
                } else {

                    if (submit) {

                        $("#form-login").submit();
					}
				}
			}
		});
	});

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
	initializeSummernote();

	var navbarHeight = $("#navbar").height();

	$("#form-create-title-btn").click(function() {

		$("html, body").animate({scrollTop: $("#form-create-title").offset().top - (navbarHeight * 2)}, 1000);
	});

	$("#form-create-ingredients-btn").click(function() {

		$("html, body").animate({scrollTop: $("#form-create-ingredients").offset().top - (navbarHeight * 2)}, 1000);
	});

	$("#form-create-steps-btn").click(function() {

		$("html, body").animate({scrollTop: $("#form-create-steps").offset().top - (navbarHeight * 2)}, 1000);
	});

	$("#form-create-config-btn").click(function() {

		$("html, body").animate({scrollTop: $("#form-create-config").offset().top - (navbarHeight * 2)}, 1000);
	});

	function reorderSteps () {
		$('#steps-container .step-div').each(function (index) {
			var label = $(this).find('.step-title');
			label.text('Passo ' + (index + 1));
		});
	}

	$("#form-create-add-step").click(function () {
		var obj = '<div class="form-group step-div"><div><label class="step-title">Passo</label><button type="button" style="width: 100%;" class="btn btn-default form-create-remove-step" onclick="removeStep(this);"><span class="glyphicon glyphicon-trash"></span> Remover Passo</button></div><textarea class="summernote" name="step[]"></textarea></div>';
		$('#steps-container').append(obj);
		initializeSummernote();
		reorderSteps();
	});

	$("#form-create-public-yes").click(function () {

		$("#form-create-public").val(1);
		$("#form-create-public-yes").attr("class", "btn btn-yes-active");
		$("#form-create-public-no").attr("class", "btn btn-no");
	});

	$("#form-create-public-no").click(function () {

		$("#form-create-public").val(0);
		$("#form-create-public-yes").attr("class", "btn btn-yes");
		$("#form-create-public-no").attr("class", "btn btn-no-active");
	});

	$("#form-create-save").click(function () {

		$("#form-create").submit();
	});

	$('#btn-favorite').click(function () {

		$.post(

			"ajax/add-remove-favorites.php",
			{
				"user" : $(this).data('user'),
				"recipe" : $(this).data('id')
			},
			function (result) {

				if (result == "add") {

					$('#btn-favorite').html('<span class="glyphicon glyphicon-heart"></span>');
					$('#btn-favorite').attr('data-original-title', 'Remover dos Favoritos');
				} else if (result == "remove") {

					$('#btn-favorite').html('<span class="glyphicon glyphicon-heart-empty"></span>');
					$('#btn-favorite').attr('data-original-title', 'Adicionar aos Favoritos');
				}
			}
		);
	});

	$('#mqSubmit').click(function () {

		$.post(

			"ajax/submitQuestion.php",
			{
				"email" : $('#mqEmail').val(),
				"subject" : $('#mqSubject').val(),
				"question" : $('#mqQuestion').val()
			},
			function (response) {

				$('#makeQuestion').modal('hide');

				if (response == "connectionFailed") {

					modalAlert.display("Não foi possível estabelecer conexão!", "error");
				} else if (response == "queryFailed") {

					modalAlert.display("Ocorreu um erro!", "error");
				} else if (response == "success") {

					modalAlert.display("Será enviada uma resposta para o seu email!", "success");
				}
			}
		);
	});

	$('#lcSubmit').click(function () {

		$.post(

			"ajax/submitComment.php",
			{
				"email" : $('#lcEmail').val(),
				"rating" : $('#lcRating').val(),
				"comment" : $('#lcComment').val()
			},
			function (response) {

				$('#leaveComment').modal('hide');

				if (response == "connectionFailed") {

					modalAlert.display("Não foi possível estabelecer conexão!", "error");
				} else if (response == "queryFailed") {

					modalAlert.display("Ocorreu um erro!", "error");
				} else if (response == "success") {

					modalAlert.display("Obrigado pela sua colaboração!", "success");
				}
			}
		);
	});

	$('#fbSubmit').click(function () {

		$.post(

			"ajax/submitBug.php",
			{
				"email" : $('#fbEmail').val(),
				"bug" : $('#fbBug').val()
			},
			function (response) {

				$('#foundBug').modal('hide');

				if (response == "connectionFailed") {

					modalAlert.display("Não foi possível estabelecer conexão!", "error");
				} else if (response == "queryFailed") {

					modalAlert.display("Ocorreu um erro!", "error");
				} else if (response == "success") {

					modalAlert.display("Obrigado pela sua colaboração!", "success");
				}
			}
		);
	});
});
