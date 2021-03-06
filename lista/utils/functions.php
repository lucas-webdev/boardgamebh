<?php
date_default_timezone_set('America/Sao_Paulo');
function pdo_connect_mysql()
{
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'bgbh';
    $DATABASE_PASS = 'p9R@o9';
    $DATABASE_NAME = 'bgbh_com_br';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to database!');
    }
}
function template_header($title)
{
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <head>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-187241035-1"></script>
            <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            
            gtag('config', 'UA-187241035-1');
            </script>

            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=G-1K2MBCJ50J"></script>
            <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-1K2MBCJ50J');
            </script>

            <script data-ad-client="ca-pub-3851012828743137" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    
            <title>$title</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <meta property="og:title" content="BoardgameBH [BGBH]">
            <meta property="og:site_name" content="BoardgameBH [BGBH]">
            <meta property="og:url" content="http://www.bgbh.com.br/lista/">
            <meta property="og:description"
                content="Lista de Trocas & Vendas do portal BoardgameBH">
            <meta property="og:type" content="website">
            <meta property="og:image" content="http://bgbh.com.br/images/og-image.jpg">
            <meta property="og:image:secure_url" content="http://bgbh.com.br/images/og-image.png">

            <!-- fonts -->
            <link
                href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&family=Roboto:wght@100;300;400;500;700;900&display=swap"
                rel="stylesheet">
            <link rel="preconnect" href="https://fonts.gstatic.com">

            <link rel="icon" type="image/png" href="https://lucascmedeiros.com.br/bgbh/favicon.ico"/>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
            <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

            <link rel="stylesheet" href="http://www.bgbh.com.br/public/css/styles.css">
        </head>
        <body>
        <div class="site-wrapper listaTrocasVendas">
        <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark" id="mainNavbar">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="/lista">
                    <img src="/public/images/logo_bgbh/bgbh-com-sombra.png" width="30" height="30" class="d-inline-block align-top mr-1" alt="">
                    <span class="navbarLogoText ms-2">BoardgameBH</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link fw-bold fs-7" href="/">SITE</a>
                        </li>
                        <li class="nav-item">
                            <a class="visualizar-lista nav-link fw-bold fs-7" href="/lista">VISUALIZAR LISTA <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="adicionar-jogo nav-link fw-bold fs-7" href="/lista/adicionar-jogo.php">ADICIONAR JOGO</a>
                        </li>
                        <li class="nav-item">
                            <a class="remover-jogo nav-link fw-bold fs-7" href="/lista/remover-jogo.php">REMOVER JOGO</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <section class="py-4 banner-ads--center container-fluid">
            <div class="col-12 d-none d-md-flex justify-content-center">
                <a href="/rifa-brazil-imperial/" target="_blank"
                    onclick="ga('send', 'event', 'Rifa Brazil', 'click-banner-site');">
                    <img class="img-fluid banner-ads-90" src="/public/images/banners/728x90/banner-BRAZIL.png"
                        alt="banner Rifa Brazil" />
                </a>
            </div>
            <div class="col-12 d-flex d-md-none justify-content-center" id="banner-ads-mobile">
                <a href="" target="_blank">
                    <img class="banner-ads-270" src="" alt="banner" />
                </a>
            </div>
        </section>
        <main class="container-fluid p-3 py-4">
EOT;
}
function template_footer()
{
    $today = date("Y-m-d H:i:s");
    echo <<<EOT
    </main>
    <footer>
    <div class="col-12 text-center"> © BGBH 2020 - Todos os direitos reservados </div>
    </footer>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script>
    $(function() {
        new bootstrap.Popover(document.body, {
            selector: '.has-popover',
            trigger: 'focus',
            html: true
          });
    });
    $('.celular').mask('(00) 0 0000-0000');
    $('.dinheiro').mask('#.##0,00', {reverse: true});
    $('.data').mask('00/00/0000');

    function randomizeBanners() {
        const bannerAds = $('#banner-ads-mobile a');
        const sources = [
            {
                img: "<img src='/public/images/banners/728x90/banner-BRAZIL.png' alt='Sorteio Brazil Imperial' />",
                link: "http://www.bgbh.com.br/sorteio-brazil-imperial"
            }
        ];

        const index = Math.floor(Math.random() * sources.length);

        bannerAds[0].href = sources[index].link;
        bannerAds[0].innerHTML = sources[index].img;

    };

    randomizeBanners();

    </script>
    
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.1.2/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/8.1.2/firebase-analytics.js"></script>

    <script>
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    var firebaseConfig = {
        apiKey: "AIzaSyDSkax_bQZESW9EJf3lsWcScjVG3W1RglI",
        authDomain: "site-bgbh.firebaseapp.com",
        projectId: "site-bgbh",
        storageBucket: "site-bgbh.appspot.com",
        messagingSenderId: "55901407241",
        appId: "1:55901407241:web:31b7dfb0296a5e8b6b50d8",
        measurementId: "G-SZ4NX75M8X"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
    </script>
    </body>
    </html>
EOT;
}

function formatCellphone($phone)
{
    return "55" . preg_replace('/[- )(]/', '', $phone);
}

function diffDaysFromToday($date)
{
    $compareDate = new DateTime($date);
    $now = new DateTime();

    return $compareDate->diff($now)->format("%a");
}

function dateInRange($startDate, $endDate, $date)
{
    // Convert to timestamp
    $start_ts = strtotime($startDate);
    $end_ts = strtotime($endDate);
    $user_ts = strtotime($date);

    // Check that user date is between start & end
    return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

function printWishlist($wishlist)
{
    if (strpos($wishlist, "http") === false)
        return $wishlist;

    return "<a href='" . $wishlist . "' target='_blank'>" . $wishlist . "</a>";
}
