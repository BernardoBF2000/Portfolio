var app = angular.module('cookit', ['ngPassword', 'ngAnimate']);

app.directive("dirEmail", function () {

	return {

		require: "ngModel",
		link: function (scope, element, attr, mCtrl) {

			function signupEmailValidation (value) {

				var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
				if (!re.test(value)) {

					mCtrl.$setValidity("invalidEmail", false);
				} else {

					mCtrl.$setValidity("invalidEmail", true);
				}
				return value;
			}
			mCtrl.$parsers.push(signupEmailValidation);
		}
	};
});

app.controller("makeQuestionCtrl", function ($scope, $http) {

	var id = document.getElementById('userId');

	if (id.value != "") {

		$http.get(

			"ajax/getEmail.php?id=" + id.value
		).then(function (response) {

			$scope.mqEmailMdl = response.data;
		});
	}
});

app.controller("leaveCommentCtrl", function ($scope, $http) {

	var id = document.getElementById('userId');

	if (id.value != "") {

		$http.get(

			"ajax/getEmail.php?id=" + id.value
		).then(function (response) {

			$scope.lcEmailMdl = response.data;
		});
	}

	var rating = 0;

	$scope.ratingMouseEnter = function (n) {

		for (var i = 1; i <= 5; i++) {

			if (i <= n) $('#rating' + i).html('<span class="glyphicon glyphicon-star"></span>');
			else $('#rating' + i).html('<span class="glyphicon glyphicon-star-empty"></span>');
		}
	}

	$scope.ratingMouseLeave = function () {

		for (var i = 1; i <= 5; i++) {

			if (i <= rating) $('#rating' + i).html('<span class="glyphicon glyphicon-star"></span>');
			else $('#rating' + i).html('<span class="glyphicon glyphicon-star-empty"></span>');
		}
	}

	$scope.setRating = function (n) {
		
		rating = n;
		$scope.lcRatingMdl = rating;
		$('#lcRating').val(rating);
	}
});

app.controller("foundBugCtrl", function ($scope, $http) {

	var id = document.getElementById('userId');

	if (id.value != "") {

		$http.get(

			"ajax/getEmail.php?id=" + id.value
		).then(function (response) {

			$scope.fbEmailMdl = response.data;
		});
	}
});

app.controller('listRecipesCtrl', function ($scope, $http, $window) {

	$scope.searchBarTitleMdl = '';
	$scope.searchBarRobotMdl = '';
	$scope.categories = [
		{ name: 'Todas as Categorias', value: 'all' },
		{ name: 'Sem Categoria', value: 'uncategorized' },
		{ name: 'Acompanhamentos', value: 'side_dish' },
		{ name: 'Bebidas', value: 'drinks' },
		{ name: 'Bolos e Biscoitos', value: 'cakes_cookies' },
		{ name: 'Entradas e Saladas', value: 'food_entrances_salads' },
		{ name: 'Geleias, Doces e Compotas', value: 'jellies_jams' },
		{ name: 'Molhos e Temperos', value: 'sauces_spices' },
		{ name: 'Pães', value: 'breads' },
		{ name: 'Pratos de Carne', value: 'meat_dishes' },
		{ name: 'Pratos de Peixe e Marisco', value: 'fish_seafood_dishes' },
		{ name: 'Pratos Vegetarianos', value: 'vegetarian_food' },
		{ name: 'Salgados, Tartes e Pizzas', value: 'salty_pies_pizzas' },
		{ name: 'Snacks e Aperitivos', value: 'snacks' },
		{ name: 'Sobremesas', value: 'desserts' },
		{ name: 'Sopas', value: 'soups' }
	];
	$scope.orderOptions = [
		{ name: 'Título A-Z', value: 'title:asc' },
		{ name: 'Título Z-A', value: 'title:desc' },
		{ name: 'Mais Antigo', value: 'lst_chg_date:asc' },
		{ name: 'Mais Recente', value: 'lst_chg_date:desc' }
	];
	$scope.pagination = {
		numPages: 0,
		currentPage: 1
	};
	$scope.paginationButtons = [];

	$scope.updateRecipes = function () {

		$http.get(

			"ajax/listRecipes.php?in=" + $scope.searchInMdl + "&cat=" + $scope.searchBarCategoriesMdl + "&title=" + $scope.searchBarTitleMdl + "&robot=" + $scope.searchBarRobotMdl + "&order=" + $scope.searchBarOrderByMdl + "&current_page=" + $scope.pagination.currentPage
		).then(function (response) {

			$scope.recipes = response.data.recipes;
			$scope.pagination = response.data.pagination;

			$scope.setPaginationButtons();

			$('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
		});
	}

	$scope.setPage = function (method, page) {

		if (method == 'fastbackward') $scope.pagination.currentPage -= 5;
		else if (method == 'backward') $scope.pagination.currentPage -= 1;
		else if (method == 'static') $scope.pagination.currentPage = page;
		else if (method == 'forward') $scope.pagination.currentPage += 1;
		else if (method == 'fastforward') $scope.pagination.currentPage += 5;

		$scope.updateRecipes();
	}

	$scope.setPaginationButtons = function () {

		if ($scope.pagination.numPages < 6) {

			for (var i = 0; i < $scope.pagination.numPages; i++) $scope.paginationButtons[i] = (i + 1);
		} else {

			if ($scope.pagination.currentPage - 2 == -1 || $scope.pagination.currentPage - 2 == 0) {
				for (var i = 0; i < 5; i++) $scope.paginationButtons[i] = (i + 1);
			} else if ($scope.pagination.currentPage + 2 == $scope.pagination.numPages + 1 || $scope.pagination.currentPage + 2 == $scope.pagination.numPages + 2) {
				for (var i = 4; i > -1; i--) $scope.paginationButtons[i] = ($scope.pagination.numPages + (i - 4));
			} else {
				$scope.paginationButtons[0] = ($scope.pagination.currentPage - 2);
				$scope.paginationButtons[1] = ($scope.pagination.currentPage - 1);
				$scope.paginationButtons[2] = $scope.pagination.currentPage;
				$scope.paginationButtons[3] = ($scope.pagination.currentPage + 1);
				$scope.paginationButtons[4] = ($scope.pagination.currentPage + 2);
			}
		}
	}

	$scope.nFireIcon = function (x) {

		if (x == 'Fácil') return new Array(1);
		else if (x == 'Médio') return new Array(2);
		else if (x == 'Difícil') return new Array(3);
		else return new Array(1);
	}

	$scope.nPagination = function (n) {

		if ($scope.pagination.numPages < 6) return new Array(n);
		else return new Array(5);
	}

	$window.onload = function (e) {

		$scope.updateRecipes();
	}
});