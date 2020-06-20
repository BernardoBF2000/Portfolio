var loader = new Loader("loader-container");
var modalAlert = new ModalAlert();

$(window).on("load", function () {

	loader.hide();

	var navbarHeight = $("#navbar").height();
	$(".nav-compensator").css("margin-top", navbarHeight + 25 + "px");
	$("#form-create-nav").css("top", navbarHeight + "px");

	$('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
});

function readURL (input) {

	if (input.files && input.files[0]) {

		var reader = new FileReader();

		reader.onload = function(e) {

			$("#image-preview").attr("src", e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}

function editStep (id) {

	var text = $('#step-in-'+id).val();
	$('#btn-save-step').attr('onclick', 'saveStep('+id+')');
	$('#modal-container-text-editor').modal('show');
	$("#text-editor").summernote('code', text);
}

function saveStep(id) {

	$('#step-in-'+id).val($('#text-editor').summernote('code'));
	$('#modal-container-text-editor').modal('hide');
}