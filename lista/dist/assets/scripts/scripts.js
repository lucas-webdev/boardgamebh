$(function () {
    $('[data-toggle="popover"]').popover({
        html: true
    });
    $(".popover-dismiss").popover({
        trigger: "click"
    });

    /* RANDOMIZAR BANNERS */
    function randomizeBanners() {
        const bannerAds = $('#banner-ads-mobile a');
        const sources = [
            {
                img: "http://www.bgbh.com.br/images/banners/banner_timemachine_500x270.png",
                link: "https://www.catarse.me/timemachinerocket"
            },
            {
                img: "http://www.bgbh.com.br/images/banners/banner_90games.png",
                link: "http://90games.com.br/"
            },
            {
                img: "http://www.bgbh.com.br/images/banners/banner-tabulovers.png",
                link: "https://tabulovers.wixsite.com/tabulovers"
            },
        ];

        const index = Math.floor(Math.random() * sources.length);

        console.log(index);

        bannerAds[0].href = sources[index].link;
        bannerAds[0].children[0].src = sources[index].img;

    };

    randomizeBanners();
})();