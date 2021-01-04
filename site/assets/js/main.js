/*
	ZeroFour by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
*/

(function ($) {

	var $window = $(window),
		$body = $('body');

	// Breakpoints.
	breakpoints({
		xlarge: ['1281px', '1680px'],
		large: ['981px', '1280px'],
		medium: ['737px', '980px'],
		small: [null, '736px']
	});

	// Play initial animations on page load.
	$window.on('load', function () {
		window.setTimeout(function () {
			$body.removeClass('is-preload');
		}, 100);
	});

	// Dropdowns.
	$('#nav > ul').dropotron({
		offsetY: -22,
		mode: 'fade',
		noOpenerFade: true,
		speed: 300,
		detach: false
	});

	// Nav.

	// Title Bar.
	$(
		'<div id="titleBar">' +
		'<a href="#navPanel" class="toggle"></a>' +
		'<span class="title">' + $('#logo').html() + '</span>' +
		'</div>'
	)
		.appendTo($body);

	// Panel.
	$(
		'<div id="navPanel">' +
		'<nav>' +
		$('#nav').navList() +
		'</nav>' +
		'</div>'
	)
		.appendTo($body)
		.panel({
			delay: 500,
			hideOnClick: true,
			hideOnSwipe: true,
			resetScroll: true,
			resetForms: true,
			side: 'left',
			target: $body,
			visibleClass: 'navPanel-visible'
		});
	// let timer;
	// clearInterval(timer);

	// timer = setInterval(function () {

	// 	var _segundo = 1000;
	// 	var _minuto = _segundo * 60;
	// 	var _hora = _minuto * 60;
	// 	var _dia = _hora * 24;

	// 	var atual = new Date();
	// 	var fim = new Date("2021-01-04 00:00:00");

	// 	var diferenca = fim - atual;

	// 	var dias = Math.floor(diferenca / _dia);
	// 	var horas = Math.floor((diferenca % _dia) / _hora);
	// 	var minutos = Math.floor((diferenca % _hora) / _minuto);
	// 	var segundos = Math.floor((diferenca % _minuto) / _segundo);

	// 	document.getElementById('counter').innerHTML = dias + ' dias, ';
	// 	document.getElementById('counter').innerHTML += horas + 'h ';
	// 	document.getElementById('counter').innerHTML += minutos + 'min ';
	// 	document.getElementById('counter').innerHTML += segundos + 'seg';

	// }, 1000);


	// function daysDifference($startDate, $endDate) {
	// 	oneDay = 24 * 60 * 60 * 1000;
	// 	return Math.ceil(($endDate.getTime() - $startDate.getTime()) / oneDay);
	// }

	// const endDate = new Date("2021-01-04");
	// const today = new Date();
	// document.getElementById("contador").innerHTML = 'Faltam ' + daysDifference(today, endDate) + ' dias para o lançamento!';

})(jQuery);