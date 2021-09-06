$(function ()
{
    const footerSources = [{
        img: "<img class='banner-ads-270' src='public/images/banners/500x270/banner_90games.png' alt='Loja 90 Games' />",
        link: "https://90games.acervodejogos.com.br/",
        onClick: "ga('send', 'event', 'Banner Footer', 'click-banner-duplo', 'Loja 90 games');"
    },
    {
        img: "<img class='banner-ads-270' src='public/images/banners/500x270/banner-tabulovers.png' alt='Tabulovers' />",
        link: "https://www.instagram.com/tabulovers/",
        onClick: "ga('send', 'event', 'Banner Footer', 'click-banner-duplo', 'Tabulovers');"
    },
    ]
    const centerSources = [{
        img: "<img class='img-fluid banner-ads-90' src='/public/images/banners/728x90/banner-BRAZIL.png' alt='Sorteio Brazil Imperial' />",
        link: "/sorteio-brazil-imperial",
        onClick: "banner Brazil"
    }]

    function randomizeBannerFooterDuplo()
    {
        const bannerFooterDuplo = $('#banner-ads--footer-duplo a')
        const nums = new Set()

        while (nums.size !== 2)
        {
            nums.add(Math.floor(Math.random() * footerSources.length))
        }

        const firstBanner = footerSources[[...nums][0]]
        const secondBanner = footerSources[[...nums][1]]

        bannerFooterDuplo[0].href = firstBanner.link
        bannerFooterDuplo[0].innerHTML = firstBanner.img
        bannerFooterDuplo[0].setAttribute('onclick', firstBanner.onClick)

        bannerFooterDuplo[1].href = secondBanner.link
        bannerFooterDuplo[1].innerHTML = secondBanner.img
        bannerFooterDuplo[1].setAttribute('onclick', secondBanner.onClick)
    }

    function randomizeBannerUnico(selector, sources)
    {
        const bannerElement = $(selector)
        const index = Math.floor(Math.random() * sources.length)

        bannerElement[0].href = sources[index].link
        bannerElement[0].innerHTML = sources[index].img
    }

    /* RANDOMIZAR BANNERS */
    function randomizeBanners()
    {
        // banner central, unico
        // randomizeBannerUnico("#banner-ads--center-unico a", centerSources);
        // banner footer, unico
        randomizeBannerUnico("#banner-ads--footer-unico a", footerSources)
        // banners footer, duplo
        randomizeBannerFooterDuplo()
    };

    randomizeBanners()


    new bootstrap.Popover(document.body, {
        selector: '.has-popover'
    })

    // Buscar Posts Blog
    function loadPosts()
    {
        $.get('https://bgbh.com.br/blog/wp-json/wp/v2/posts?_embed', (posts) =>
        {
            $('#postsContent').empty()
            posts.map((post) =>
            {
                console.log(post)
                const excerpt = $(post.excerpt.rendered).text()
                $('#postsContent').append(`
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="d-flex align-items-center justify-content-center w-100">
                            <div class="card bg-transparent border-0">
                            <img
                                src="${post['_embedded']['wp:featuredmedia'][0]['source_url']}"
                                class="card-img-top" alt="${post.title.rendered}">
                            <div class="card-body text-center">
                                <h5 class="card-title text-white bold">${post.title.rendered}</h5>
                                <p class="card-text text-white">${excerpt}</p>
                                <a href="${post.link}" target="_blank" class="btn primaryButton">
                                    Ver post completo
                                </a>
                            </div>
                            </div>
                        </div>
                    </div>
                `)
            })
        })
    }

    if ($('#containerBlog').length) { loadPosts() }
})