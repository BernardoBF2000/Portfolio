class ModalAlert {

	display (text, status) {

		if (status == "success") {

			$("#modal-alert-title").text("Sucesso");
			$(".modal-alert .modal-header").css("background-color", "var(--success-color)");
			$(".modal-alert .modal-footer").css("background-color", "var(--success-color)");
		} else if (status == "warning") {

			$(".modal-alert .modal-header").css("background-color", "var(--warning-color)");
			$(".modal-alert .modal-footer").css("background-color", "var(--warning-color)");
			$("#modal-alert-title").text("Aviso");
		} else if (status == "error") {

			$(".modal-alert .modal-header").css("background-color", "var(--error-color)");
			$(".modal-alert .modal-footer").css("background-color", "var(--error-color)");
			$("#modal-alert-title").text("Erro");
		}

		$("#modal-alert-body").text(text);
		$("#modal-container-alert").modal("show");
	}
}