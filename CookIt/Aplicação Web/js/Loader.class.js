class Loader {

	constructor (id) {

		this.selector = "#" + id;
	}

	hide () {

		$(this.selector).animate({opacity: "0"}, 250, function () {

			$(this).css("display", "none");
		});
	}

	show () {

		$(this.selector).css("display", "block");
		$(this.selector).animate({opacity: "1"}, 250);
	}
}