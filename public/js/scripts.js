$(function() {
    const footerSources = [{
            img: "<img class='banner-ads-270' src='public/images/banners/500x270/banner_90games.png' alt='Loja 90 Games' />",
            link: "http://90games.com.br/"
        },
        {
            img: "<img class='banner-ads-270' src='public/images/banners/500x270/banner-tabulovers.png' alt='Tabulovers' />",
            link: "https://www.instagram.com/tabulovers/"
        },
    ];
    const centerSources = [{
        img: "<img class='img-fluid banner-ads-90' src='public/images/banners/728x90/banner_draftosaurus_em_breve.png' alt='Torneio Draftosaurus' />",
        link: "#"
    }];

    function randomizeBannerFooterDuplo() {
        const bannerFooterDuplo = $('#banner-ads--footer-duplo a');
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
        randomizeBannerUnico("#banner-ads--center-unico a", centerSources);
        // banner footer, unico
        randomizeBannerUnico("#banner-ads--footer-unico a", footerSources);
        // banners footer, duplo
        randomizeBannerFooterDuplo();
    };

    randomizeBanners();

    
	new bootstrap.Popover(document.body, {
		selector: '.has-popover'
	  });
})