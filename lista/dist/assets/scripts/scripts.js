$(function () {
    function randomizeBanners() {
        const bannerAds = $('#banner-ads-mobile a');
        const sources = [
            {
                img: '<img class="banner-ads-270" src="http://www.bgbh.com.br/images/banners/banner_timemachine_500x270.png" alt="Time Machine Rocket" />',
                link: 'https://www.catarse.me/timemachinerocket'
            },
            {
                img: '<img class="banner-ads-270" src="http://www.bgbh.com.br/images/banners/banner_90games.png" alt="Loja 90 Games" />',
                link: 'http://90games.com.br/'
            },
            {
                img: '<img class="banner-ads-270" src="http://www.bgbh.com.br/images/banners/banner-tabulovers.png" alt="Tabulovers" />',
                link: 'https://tabulovers.wixsite.com/tabulovers'
            },
        ];

        const index = Math.floor(Math.random() * sources.length);

        bannerAds[0].href = sources[index].link;
        bannerAds[0].innerHTML = sources[index].img;

    };

    randomizeBanners();
})();