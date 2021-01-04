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

	/* RANDOMIZAR BANNERS */
	function randomizeBanners() {
		const bannerCenter = $('#banner-ads-center a');
		const bannerFooter = $('#banner-ads-footer a');
		const footerSources = [
			{
				img: "images/banners/banner_90games.png",
				link: "http://90games.com.br/"
			},
			{
				img: "images/banners/banner-tabulovers.png",
				link: "https://tabulovers.wixsite.com/tabulovers"
			},
		];

		const centerSources = [
			{
				img: "images/banners/banner_timemachine_500x270.png",
				link: "https://www.catarse.me/timemachinerocket"
			}
		];
		const centerIndex = 0;
		const footerIndex = Math.floor(Math.random() * footerSources.length);

		bannerCenter[0].href = centerSources[centerIndex].link;
		bannerCenter[0].children[0].src = centerSources[centerIndex].img;

		console.log(footerIndex);

		bannerFooter[0].href = footerSources[footerIndex].link;
		bannerFooter[0].children[0].src = footerSources[footerIndex].img;

	};

	randomizeBanners();

	/* CONTADOR REGRESSIVO */
	// let timer;
	// clearInterval(timer);

	// timer = setInterval(function () {

	// 	const _segundo = 1000;
	// 	const _minuto = _segundo * 60;
	// 	const _hora = _minuto * 60;
	// 	const _dia = _hora * 24;

	// 	const atual = new Date();
	// 	const fim = new Date("2021-01-04 00:00:00");

	// 	const diferenca = fim - atual;

	// 	const dias = Math.floor(diferenca / _dia);
	// 	const horas = Math.floor((diferenca % _dia) / _hora);
	// 	const minutos = Math.floor((diferenca % _hora) / _minuto);
	// 	const segundos = Math.floor((diferenca % _minuto) / _segundo);

	// 	document.getElementById('counter').innerHTML = dias + ' dias, ';
	// 	document.getElementById('counter').innerHTML += horas + 'h ';
	// 	document.getElementById('counter').innerHTML += minutos + 'min ';
	// 	document.getElementById('counter').innerHTML += segundos + 'seg';

	// }, 1000);


})(jQuery);