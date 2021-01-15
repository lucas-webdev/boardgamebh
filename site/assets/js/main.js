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


	const footerSources = [
		{
			img: "<img class='banner-ads-270' src='images/banners/banner_90games.png' alt='Loja 90 Games' />",
			link: "http://90games.com.br/"
		},
		{
			img: "<img class='banner-ads-270' src='images/banners/banner-tabulovers.png' alt='Tabulovers' />",
			link: "https://www.instagram.com/tabulovers/"
		},
		{
			img: "<img class='banner-ads-270' src='images/banners/banner_kardnarok_500x270.png' alt='Kardnarok' />",
			link: "https://www.catarse.me/kardnarok"
		},
	];
	const centerSources = [
		{
			img: "<img src='images/banners/banner_timemachine_500x270.png' alt='Time Machine Rocket' />",
			link: "https://www.catarse.me/timemachinerocket"
		}
	];

	function randomizeBannerFooterDuplo() {
		const bannerFooterDuplo = $('#banner-ads-footer-duplo a');
		const nums = new Set();

		while (nums.size !== 2) {
			nums.add(Math.floor(Math.random() * footerSources.length));
		}

		const firstBanner = footerSources[[...nums][0]];
		const secondBanner = footerSources[[...nums][1]];

		bannerFooterDuplo[0].href = firstBanner.link;
		bannerFooterDuplo[0].innerHTML = firstBanner.img;

		bannerFooterDuplo[1].href = secondBanner.link;
		bannerFooterDuplo[1].innerHTML = secondBanner.img;
	}

	function randomizeBannerUnico(selector, sources) {
		const bannerElement = $(selector);
		const index = Math.floor(Math.random() * sources.length);

		bannerElement[0].href = sources[index].link;
		bannerElement[0].innerHTML = sources[index].img;
	}

	/* RANDOMIZAR BANNERS */
	function randomizeBanners() {
		// banner central, unico
		randomizeBannerUnico("#banner-ads-center a", centerSources);
		// banner footer, unico
		randomizeBannerUnico("#banner-ads-footer a", footerSources);
		// banners footer, duplo
		randomizeBannerFooterDuplo();
	};

	randomizeBanners();
	ga('send', 'event', 'Home', 'view');

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