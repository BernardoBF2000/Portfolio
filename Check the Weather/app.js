// APIs
// OpenWeatherMap
const OPEN_WEATHER_LINK = "http://api.openweathermap.org/data/2.5/";
const OPEN_WEATHER_APPID = "f9c3ac783a77df9aabc2d3278a405f16";
var OPEN_WEATHER_UNITS = localStorage.getItem("units_format") != null ? localStorage.getItem("units_format") : "metric";
const OPEN_WEATHER_LANG = "pt";

const TEMPERATURE_SYMBOL = { "metric": "&#176;C", "imperial": "&#176;F" };
const SPEED_SYMBOL = { "metric": "m/s", "imperial": "mph" };

// Google Places
const MAP = new google.maps.Map(document.getElementById("map"), {

    center: { lat: 0.0, lng: 0.0 },
    zoom: 12
});
const PLACES_SERVICE = new google.maps.places.PlacesService(MAP);
const SEARCH_AUTOCOMPLETE = new google.maps.places.Autocomplete(document.getElementById("search-input"), { types: ["(cities)"] });

// Chart.js
const CANVAS = document.getElementById("forecast-chart").getContext("2d");
const FORECAST_CHART = Chart.Line(CANVAS, {

    data: {
        labels: [],
        datasets: [{
            label: "Temperatura",
            data: [],
            backgroundColor: "rgba(0, 0, 0, 0)",
            borderColor: "rgba(0, 0, 0, 1)",
            borderWidth: 1
        },{
            label: "Temperatura máxima",
            data: [],
            backgroundColor: "rgba(0, 0, 0, 0)",
            borderColor: "rgba(255, 0, 0, 1)",
            borderWidth: 1
        },{
            label: "Temperatura mínima",
            data: [],
            backgroundColor: "rgba(0, 0, 0, 0)",
            borderColor: "rgba(0, 0, 255, 1)",
            borderWidth: 1
        }]
    },
    options: {
        showLines: true,
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true,
                }
            }],
            xAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true,
                }
            }]
        }
    }
});

var FORECAST_DATA = [];
var FORECAST_DAYS = [];

var SECTION = "homepage";
var USER_POSITION = {};

const MONTHS = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];

function formatDate(unixTimestamp, timezoneShift) {

    var date = new Date((unixTimestamp + (timezoneShift != null ? timezoneShift : 0)) * 1000);
    if(timezoneShift != null) var tz = new Date(Math.abs(timezoneShift) * 1000);

    if(timezoneShift != null) {

        if(timezoneShift < 0) shift = " GMT -"; else shift = " GTM +";
        shift += tz.getUTCHours() >= 10 ? tz.getUTCHours() : "0" + tz.getUTCHours();
        shift += ":";
        shift += tz.getUTCMinutes() >= 10 ? tz.getUTCMinutes() : "0" + tz.getUTCMinutes();
    } else shift = "";

    output = date.getUTCHours() >= 10 ? date.getUTCHours() : "0" + date.getUTCHours();
    output += ":";
    output += date.getUTCMinutes() >= 10 ? date.getUTCMinutes() : "0" + date.getUTCMinutes();
    output += " " + MONTHS[date.getUTCMonth()] + " " + date.getUTCDate() + shift;

    return output;
}

function formatDay(unixTimestamp) {

    var date = new Date((unixTimestamp) * 1000);
    var output = MONTHS[date.getUTCMonth()] + " " + date.getUTCDate();
    return output;
}

// NAVEGAÇÃO
async function toSection(params) {

    SECTION = params.target;

    $("#forecast, #map").addClass("d-none");
    if(params.target != "favourites" && params.target != "homepage") $("#results-section").addClass("d-none");
    if(params.target != "city-details") $("#city-details-section").addClass("d-none");
    if(params.target != "no-results") $("#no-results").addClass("d-none");
    if(params.target != "error") $("#error").addClass("d-none");
    $("#navbar .custom-pagination").remove();

    // FAVORITOS
    if(params.target == "favourites") {

        $("#results").empty().append($(document.createElement("p")).addClass("h2 text-center").append("Favoritos"));
        $("#results-section").removeClass("d-none");

        var fav = [];
        if(localStorage.getItem("fav") != null) fav = JSON.parse(localStorage.getItem("fav"));

        if(fav.length > 0) {

            var numPages = fav.length > 12 ? Math.ceil(fav.length / 12) : 1;
            var page = params.page != null ? params.page : 0;

            $("#navbar .custom-pagination").remove();
            if(numPages > 1) {

                $("#navbar").append($(document.createElement("div")).addClass("btn-group custom-pagination"));
                for(var i = 0; i < numPages; i++) {

                    $("#navbar .custom-pagination").append(
                        $(document.createElement("button"))
                            .attr("type", "button")
                            .addClass("btn btn-primary p-2 page-btn" + (page == i ? " active" : ""))
                            .attr("data-page", i)
                            .append(i + 1)
                    );
                }
            }

            var citiesIds = "";
            for(var i = page * 12; i < fav.length && i < (page + 1) * 12; i++) {

                if(citiesIds != "") citiesIds += ",";
                citiesIds += fav[i];
            }

            var cityData = await getSeveralCityCurrentWeatherByIds(citiesIds);

            if(cityData.cnt > 0) {

                for(var i = 0; i < cityData.cnt; i++) {
        
                    if(i % 3 == 0) $("#results").append($(document.createElement("div")).addClass("row"));
                    $("#results .row:last-child").append(
                        $(document.createElement("div"))
                            .addClass("col-md-4 my-2 animated d-none")
                            .addCityCard(cityData.list[i], false)
                            .removeClass("d-none").addClass("fadeInLeft")
                    );
                }
            } else toSection({ target: "error" });
        } else toSection({ target: "no-results" });
    // DETALHES DA CIDADE
    } else if(params.target == "city-details") {

        $("#city-details").empty();
        $("#city-details, #map").clearAnimation();

        var cityData = {};
        if(params.type == "id") cityData = await getCityCurrentWeatherById(params.id);
        else if(params.type == "keyword") cityData = await getCityCurrentWeatherByCityName(params.keyword);

        if(cityData.cod == "200") {
            $("#city-details").attr("data-id", cityData.id);

            var uv = await getUVIndex(cityData.coord.lat, cityData.coord.lon);
            if(uv.value != null) cityData.UVIndex = uv.value;
            $("#city-details").addCityCard(cityData, true);
            MAP.setCenter({lat: cityData.coord.lat, lng: cityData.coord.lon});
            MAP.setZoom(12);
            initChart(cityData.id);

            $("#city-details-section").removeClass("d-none");
            $("#city-details").addClass("fadeInLeft");
            $("#map").removeClass("d-none").addClass("fadeInRight");
        } else toSection({ target: "no-results" });
    // ERRO
    } else if(params.target == "no-results" || params.target == "error") {

        $("#" + params.target).clearAnimation();
        $("#" + params.target).removeClass("d-none");
        $("#" + params.target).addClass("fadeInUp");
    // PÁGINA INICIAL
    } else {

        var cityData = null;
        if(USER_POSITION.lat != null && USER_POSITION.lon != null) cityData = await getCityCurrentWeatherInCircle(USER_POSITION.lat, USER_POSITION.lon);
        else cityData = await getSeveralCityCurrentWeatherByIds("2643743,5128581,2147714,2267095,2988507");

        if(cityData.list != null && cityData.list.length > 0) {
            
            $("#results").empty();
            if(USER_POSITION.lat != null && USER_POSITION.lon != null) $("#results").append($(document.createElement("p")).addClass("h2 text-center").append("Perto de si"));
            $("#results-section").removeClass("d-none");
                
            var repeatedCities = [];
            for(var i = 0; ; ) {
                    
                if(cityData.list[i] != null) {
                        
                    if(repeatedCities.includes(cityData.list[i].name)) cityData.list.splice(i, 1);
                    else {
                            
                        repeatedCities.push(cityData.list[i].name);
                        i++;
                    }
                } else break;
            }
            cityData.count = repeatedCities.length;
                
            for(var i = 0; i < cityData.count; i++) {
                    
                if(i % 3 == 0) $("#results").append($(document.createElement("div")).addClass("row"));
                $("#results .row:last-child").append(
                    $(document.createElement("div"))
                        .addClass("col-md-4 my-2 animated d-none")
                        .addCityCard(cityData.list[i], false)
                        .removeClass("d-none").addClass("fadeInLeft")
                    )
            }
        } else toSection({ target: "error" });
    }
}

// função para filtrar a pesquisa do utilizador
function search(keyword) {

    PLACES_SERVICE.findPlaceFromQuery(
        {
            query: keyword,
            fields: ['place_id']
        },
        function(results, status) {

            if(status === google.maps.places.PlacesServiceStatus.OK) {

                PLACES_SERVICE.getDetails(
                    { placeId: results[0].place_id },
                    async function(place, status) {
                        
                        if(status == google.maps.places.PlacesServiceStatus.OK) {
                            
                            if(place.address_components != null) {

                                for(var i = 0; i < place.address_components.length; i++) {

                                    if(place.address_components[i].types.includes("country")) {
                                        
                                        keyword = keyword.split(",")[0];
                                        keyword += "," + place.address_components[i].short_name;
                                    }
                                }
                            }
                            toSection({ target: "city-details", type: "keyword", keyword: keyword });
                        } else if(status === google.maps.places.PlacesServiceStatus.ZERO_RESULTS) toSection({ target: "no-results" }); else toSection({ target: "error" });
                    }.bind(this)
                );
            } else if(status === google.maps.places.PlacesServiceStatus.ZERO_RESULTS) toSection({ target: "no-results" }); else toSection({ target: "error" });
        }
    );
}

function getCityPhoto(keyword, target) {

    PLACES_SERVICE.findPlaceFromQuery(
        {
            query: keyword,
            fields: ['place_id']
        },
        function(results, status) {
            
            if(status === google.maps.places.PlacesServiceStatus.OK) {
                
                PLACES_SERVICE.getDetails(
                    { placeId: results[0].place_id },
                    function(place, status) {
                        
                        if(status == google.maps.places.PlacesServiceStatus.OK) {

                            if(place.photos != null && place.photos[0] != null) $(target).attr("style", "background-image: url(" + place.photos[0].getUrl() + ");");
                            else $(target).remove();
                        }
                    }.bind(this)
                );
            }
        }
    );
}

async function getCityCurrentWeatherById(id) {

    var response = await fetch(OPEN_WEATHER_LINK + "weather?appid=" + OPEN_WEATHER_APPID + "&id=" + id + "&units=" + OPEN_WEATHER_UNITS + "&lang=" + OPEN_WEATHER_LANG)
    var data = await response.json();
    return data;
}

async function getSeveralCityCurrentWeatherByIds(ids) {

    var response = await fetch(OPEN_WEATHER_LINK + "group?appid=" + OPEN_WEATHER_APPID + "&id=" + ids + "&units=" + OPEN_WEATHER_UNITS + "&lang=" + OPEN_WEATHER_LANG);
    var data = await response.json();
    return data;
}

async function getCityCurrentWeatherByCityName(keyword) {

    var response = await fetch(OPEN_WEATHER_LINK + "weather?q=" + keyword + "&appid=" + OPEN_WEATHER_APPID + "&units=" + OPEN_WEATHER_UNITS + "&lang=" + OPEN_WEATHER_LANG);
    var data = await response.json();
    return data;
}

async function getCityCurrentWeatherInCircle(lat, lon) {

    var response = await fetch(OPEN_WEATHER_LINK + "find?appid=" + OPEN_WEATHER_APPID + "&lat=" + lat + "&lon=" + lon + "&cnt=10&units=" + OPEN_WEATHER_UNITS + "&lang=" + OPEN_WEATHER_LANG);
    var data = await response.json();
    return data;
}

async function getCityForecastWeatherByID(id) {

    var response = await fetch(OPEN_WEATHER_LINK + "forecast?appid=" + OPEN_WEATHER_APPID + "&id=" + id + "&units=" + OPEN_WEATHER_UNITS + "&lang=" + OPEN_WEATHER_LANG);
    var data = await response.json();
    return data;
}

async function getUVIndex(lat, lon) {

    var response = await fetch(OPEN_WEATHER_LINK + "uvi?appid=" + OPEN_WEATHER_APPID + "&lat=" + lat + "&lon=" + lon + "&units=" + OPEN_WEATHER_UNITS + "&lang=" + OPEN_WEATHER_LANG);
    var data = await response.json();
    return data;
}

async function initChart(cityId) {

    $("#forecast").addClass("d-none");
    $("#forecast-day-nav").empty();
    FORECAST_DATA = await getCityForecastWeatherByID(cityId);
    FORECAST_DAYS = [];

    if(FORECAST_DATA.cod == "200") {

        for(var i = 0; i < FORECAST_DATA.list.length; i++) {

            var day = formatDay(FORECAST_DATA.list[i].dt);

            var repeated = 0;
            for(var x = 0; x < FORECAST_DAYS.length && repeated == 0; x++) {

                if(FORECAST_DAYS[x].day_txt == day) repeated = 1;
            }

            if(repeated == 0) FORECAST_DAYS.push({ day_txt: day, item: i });
        }

        for(var i = 0; i < FORECAST_DAYS.length; i++) {

            $("#forecast-day-nav").append(
                $(document.createElement("button"))
                    .attr("type", "button")
                    .addClass("btn btn-md btn-primary forecast-day-btn")
                    .attr("data-item", FORECAST_DAYS[i].item)
                    .append("<img class=\"img-fluid\" src=\"icons/" + FORECAST_DATA.list[FORECAST_DAYS[i].item].weather[0].icon + "_100px.png\" style=\"max-width: 50px;\"><br>")
                    .append(FORECAST_DAYS[i].day_txt)
            );
        }
        $(".forecast-day-btn:first-child").addClass("active");

        clearForecastChart();
        for(var i = 0; i < FORECAST_DATA.list.length && i < 8; i++) {
            
            FORECAST_CHART.data.labels.push(formatDate(FORECAST_DATA.list[i].dt, null));
            FORECAST_CHART.data.datasets[0].data.push(FORECAST_DATA.list[i].main.temp);
            FORECAST_CHART.data.datasets[1].data.push(FORECAST_DATA.list[i].main.temp_max);
            FORECAST_CHART.data.datasets[2].data.push(FORECAST_DATA.list[i].main.temp_min);
        }
        FORECAST_CHART.update();

        $("#forecast").removeClass("d-none");
        $("#forecast").addClass("fadeIn");
    }
}

function clearForecastChart() {
    
    FORECAST_CHART.data.labels = [];
    FORECAST_CHART.data.datasets[0].data = [];
    FORECAST_CHART.data.datasets[1].data = [];
    FORECAST_CHART.data.datasets[2].data = [];
    FORECAST_CHART.update();
}

function updateForecastChart(item) {

    item = Number(item);
    if(item + 8 > FORECAST_DATA.list.length) item = FORECAST_DATA.list.length - 8;
    clearForecastChart();
    FORECAST_CHART.data.datasets[0].label = "Temperatura";
    for(var i = item; i < FORECAST_DATA.list.length && i < (item + 8); i++) {
        
        FORECAST_CHART.data.labels.push(formatDate(FORECAST_DATA.list[i].dt, null));
        FORECAST_CHART.data.datasets[0].data.push(FORECAST_DATA.list[i].main.temp);
        FORECAST_CHART.data.datasets[1].data.push(FORECAST_DATA.list[i].main.temp_max);
        FORECAST_CHART.data.datasets[2].data.push(FORECAST_DATA.list[i].main.temp_min);
    }
    FORECAST_CHART.update();
}

// EVENTOS
$(document).ready(function() {

    $(".units-btn[data-value='" + OPEN_WEATHER_UNITS + "']").addClass("active");
    toSection({ target: "homepage" });

    if(navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(
            function(position) {

                USER_POSITION = { lat: position.coords.latitude, lon: position.coords.longitude };
                toSection({ target: SECTION });
            }
        )
    }

    // pesquisa
    $(document).on("submit", "#search-form", function(event) {

        if($("#search-input").val() != "") search($("#search-input").val());
        event.preventDefault();
    });

    $(document).on("click", ".forecast-day-btn", function() {

        $(".forecast-day-btn").removeClass("active");
        $(this).addClass("active");
        updateForecastChart($(this).attr("data-item"));
    });

    // página principal
    $(document).on("click", "#btn-home", function() { toSection({ target: "homepage" }); });

    // favoritos
    $(document).on("click", "#btn-favourites", function() { toSection({ target: "favourites" }); });

    // paginação
    $(document).on("click", ".page-btn", function() { toSection( { target: SECTION, page: $(this).attr("data-page") }); });

    // Mudar unidades
    $(document).on("click", ".units-btn", async function() {

        OPEN_WEATHER_UNITS = $(this).attr("data-value");
        localStorage.setItem("units_format", OPEN_WEATHER_UNITS);
        $(".units-btn").removeClass("active");
        $(".units-btn[data-value='" + OPEN_WEATHER_UNITS + "']").addClass("active");

        if(SECTION == "city-details") toSection({ target: SECTION, type: "id", id: $("#city-details").attr("data-id") });
        else toSection({ target: SECTION });
    });

    // Ir para detalhes da cidade
    $(document).on("click", ".details-btn", async function() { toSection({ target: "city-details", type: "id", id: $(this).attr("data-id") }); });

    // butão para adicionar/remover dos favoritos
    $(document).on("click", ".fav-btn", function() {

        // carrega os favoritos
        var fav = [];
        if(localStorage.getItem("fav") != null) fav = JSON.parse(localStorage.getItem("fav"));

        var item = $(this).attr("data-id");

        if(fav.includes($(this).attr("data-id"))) {
            
            // remove dos favoritos
            fav.splice(fav.indexOf(item), 1);
            $(this).removeClass("fas");
            $(this).addClass("far");
        } else {
            
            // adiciona aos favoritos
            fav.push(item);
            $(this).removeClass("far").addClass("fas");
        }

        // guarda as alterações
        localStorage.setItem("fav", JSON.stringify(fav));

        if(SECTION == "favourites") toSection({ target: SECTION });
    });
});

// função para limpar as animações do elemento
(function($) {
    
    $.fn.clearAnimation = function() {
        
        this.removeClass("fadeIn fadeOut fadeInUp fadeOutUp fadeInDown fadeOutDown fadeInLeft fadeOutLeft fadeInRight fadeOutRight");
    }
})(jQuery);

// função para adicionar painel com informações sobre uma cidade
(function($) {

    $.fn.addCityCard = function(data, detail) {

        // inicializa o painel
        var card = $(document.createElement("div")).addClass("card");

        // Imagem
        if(detail) {
            card.append(
                $(document.createElement("div"))
                    .addClass("card-img-top city-photo")
                    .attr("id", "city-photo-" + data.id)
            );
            getCityPhoto(data.name, "#city-photo-" + data.id);
        }

        // inicializa o conteúdo do painel
        var body = $(document.createElement("div")).addClass("card-body");

        // verifica se está nos favoritos
        var fav = [];
        if(localStorage.getItem("fav") != null) fav = JSON.parse(localStorage.getItem("fav"));
        var star = $(document.createElement("i")).addClass("fav-btn fa-star").attr("data-id", data.id);
        if(fav.includes("" + data.id)) star.addClass("fas"); else star.addClass("far");

        // título
        body.append(
            $(document.createElement("h3"))
                .addClass("card-title")
                .append(
                    $(document.createElement("img"))
                        .addClass("flag-icon")
                        .attr("src", "flags/4x3/" + data.sys.country.toLowerCase() + ".svg")
                ).append(data.name)
                .append(star)
        );

        // data dos cálculos
        body.append(
            $(document.createElement("div"))
                .append(formatDate(data.dt, data.timezone != null ? data.timezone : data.sys.timezone))
        );

        // coordenadas
        body.append(
            $(document.createElement("small"))
                .addClass("d-block")
                .append("latitude: ")
                .append($(document.createElement("span")).addClass("text-muted").append(data.coord.lat))
                .append(" longitude: ")
                .append($(document.createElement("span")).addClass("text-muted").append(data.coord.lon))
        );

        // temperatura
        body.append("<hr>");
        body.append(
            $(document.createElement("div"))
                .addClass("row")
                .append(
                    $(document.createElement("div"))
                        .addClass("col-4 col-md-12 col-xl-4 text-center")
                        .append(
                            $(document.createElement("img"))
                                .addClass("img-fluid weather-icon")
                                .attr("src", "icons/" + data.weather[0].icon + "_100px.png")
                        )
                ).append(
                    $(document.createElement("div"))
                        .addClass("col-4 col-md-6 col-xl-4 text-right font-weight-bold h2 text-nowrap")
                        .append(Math.round(data.main.temp) + TEMPERATURE_SYMBOL[OPEN_WEATHER_UNITS])
                ).append(
                    $(document.createElement("div"))
                        .addClass("col-4 col-md-6 col-xl-4 text-right font-weight-bold")
                        .append(
                            $(document.createElement("h3")).addClass("text-nowrap")
                                .append(Math.round(data.main.temp_max) + TEMPERATURE_SYMBOL[OPEN_WEATHER_UNITS])
                        ).append(
                            $(document.createElement("h4")).addClass("text-nowrap")
                                .append(Math.round(data.main.temp_min) + TEMPERATURE_SYMBOL[OPEN_WEATHER_UNITS])
                        )
                )
        );

        if(data.main.humidity != null || data.main.sea_level != null || data.main.grnd_level != null || data.main.pressure != null || data.clouds.all != null) body.append("<hr>");

        // humidade
        if(data.main.humidity != null) body.append(
            $(document.createElement("div"))
                .addClass("row")
                .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Humidade"))
                .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(data.main.humidity + " %"))
        );

        // pressão atmosférica no mar
        if(data.main.sea_level != null) body.append(
            $(document.createElement("div"))
                .addClass("row")
                .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Pressão atmosférica (no mar)"))
                .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(data.main.sea_level + " hPa"))
        );

        // pressão atmosférica no solo
        if(data.main.grnd_level != null) body.append(
            $(document.createElement("div"))
                .addClass("row")
                .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Pressão atmosférica (no solo)"))
                .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(data.main.grnd_level + " hPa"))
        );

        // pressão atmosférica
        if(data.main.pressure != null) body.append(
            $(document.createElement("div"))
                .addClass("row")
                .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Pressão atmosférica"))
                .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(data.main.pressure + " hPa"))
        );

        // nebulosidade
        if(data.clouds.all != null) body.append(
            $(document.createElement("div"))
                .addClass("row")
                .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Nebulosidade"))
                .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(data.clouds.all + " %"))
        );

        // indice UV
        if(data.UVIndex != null) {

            var UVColor = "";
            if(data.UVIndex > 10) UVColor = " purple-text";
            else if(data.UVIndex > 7) UVColor = " red-text";
            else if(data.UVIndex > 5) UVColor = " orange-text";
            else if(data.UVIndex > 2) UVColor = " yellow-text";
            else UVColor = " green-text";
            body.append(
                $(document.createElement("div"))
                    .addClass("row")
                    .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Índice UV"))
                    .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted" + UVColor).append(data.UVIndex))
            );
        }

        if(detail) {

            // vento
            if(data.wind != null) {

                body.append("<hr>").append(
                    $(document.createElement("div"))
                        .addClass("row").append(
                            $(document.createElement("div")).addClass("col-12").append("Vento")
                        )
                );

                var wind = "";
                if(data.wind.deg != null) wind += "transform:rotate(" + data.wind.deg + "deg);";
                if(data.wind.speed != null) wind += "width:" + ((data.wind.speed * 10) + 50) + "px;";

                body.append(
                    $(document.createElement("div"))
                        .addClass("row")
                        .append(
                            $(document.createElement("div"))
                                .addClass("col-6 col-md-12 col-xl-6 text-center")
                                .append(
                                    $(document.createElement("img"))
                                        .addClass("wind-indicator")
                                        .attr("src", "icons/up_100px.png")
                                        .attr("style", wind)
                                )
                        ).append(
                            $(document.createElement("div"))
                                .addClass("col-6 col-md-12 col-xl-6 text-muted")
                                .append(data.wind.speed != null ? $(document.createElement("div")).append(data.wind.speed + " " + SPEED_SYMBOL[OPEN_WEATHER_UNITS]) : null)
                                .append(data.wind.deg != null ? $(document.createElement("div")).append(data.wind.deg + " &#176;") : null)
                        )
                );
            }

            // chuva
            if(data.rain != null || data.snow != null) body.append("<hr>");

            if(data.rain != null) {

                body.append(
                    $(document.createElement("div"))
                        .addClass("row")
                        .append($(document.createElement("div")).addClass("col-12").append("Chuva..."))
                );

                if(data.rain["1h"] != null) body.append(
                    $(document.createElement("div"))
                        .addClass("row")
                        .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Nas últimas 1h"))
                        .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(data.rain["1h"] + " mm<sup>3</sup>"))
                );

                if(data.rain["3h"] != null) body.append(
                    $(document.createElement("div"))
                        .addClass("row")
                        .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Nas últimas 3h"))
                        .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(data.rain["3h"] + " mm<sup>3</sup>"))
                );
            }

            // adiciona a neve
            if(data.snow != null) {

                body.append(
                    $(document.createElement("div"))
                        .addClass("row")
                        .append($(document.createElement("div")).addClass("col-12").append("Neve..."))
                );

                if(data.snow["1h"] != null) body.append(
                    $(document.createElement("div"))
                        .addClass("row")
                        .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Nas últimas 1h"))
                        .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(data.snow["1h"] + " mm<sup>3</sup>"))
                );

                if(data.snow["3h"] != null) body.append(
                    $(document.createElement("div"))
                        .addClass("row")
                        .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Nas últimas 3h"))
                        .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(data.snow["3h"] + " mm<sup>3</sup>"))
                );
            }

            // nascer/pôr do sol
            if(data.sys.sunrise != null || data.sys.sunset != null) body.append("<hr>");

            if(data.sys.sunrise != null) body.append(
                $(document.createElement("div"))
                    .addClass("row")
                    .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Nascer do sol"))
                    .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(formatDate(data.sys.sunrise, data.timezone)))
            );

            if(data.sys.sunset != null) body.append(
                $(document.createElement("div"))
                    .addClass("row")
                    .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6").append("Pôr do sol"))
                    .append($(document.createElement("div")).addClass("col-6 col-md-12 col-xl-6 text-muted").append(formatDate(data.sys.sunset, data.timezone)))
            );
        } else {

            body.append(
                $(document.createElement("div")).addClass("text-center").append(
                    $(document.createElement("button"))
                        .attr("type", "button")
                        .addClass("btn btn-md btn-primary details-btn")
                        .attr("data-id", data.id)
                        .append("Detalhes")
                )
            );
        }

        // adiciona o conteúdo ao painel
        card.append(body);

        this.append(card);
        return this;
    };
})(jQuery);
