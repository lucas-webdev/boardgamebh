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
            <script async src="https://www.googletagmanager.com/gtag/js?id=G-SJZZ67VE3C"></script>
            <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            
            gtag('config', 'G-SJZZ67VE3C');
            </script>
            <title>$title</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <meta property="og:title" content="BoardgameBH [BGBH]">
            <meta property="og:site_name" content="BoardgameBH [BGBH]">
            <meta property="og:url" content="http://www.bgbh.com.br/jogos-colaboradores/">
            <meta property="og:description"
                content="Lista de Trocas & Vendas do portal BoardgameBH">
            <meta property="og:type" content="website">
            <meta property="og:image" content="http://bgbh.com.br/images/og-image.jpg">
            <meta property="og:image:secure_url" content="http://bgbh.com.br/images/og-image.png">

            <link rel="icon" type="image/png" href="https://lucascmedeiros.com.br/bgbh/favicon.ico"/>
            <link href="http://bgbh.com.br/lista/dist/assets/styles/style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
            <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,500&display=swap" rel="stylesheet">
        </head>
        <body>
        <section class="banner-ads">
            <div class="col-12 d-flex justify-content-center">
                <a href="/" target="_blank">
                    <img class="banner-ads-270" src="/images/logo_preto.png" alt="banner" />
                </a>
            </div>
        </section>
        <main class="container-fluid p-3 py-4">
EOT;
}
function template_footer()
{
    echo <<<EOT
    </main>
    <footer>
    <div class="col-12 text-center"> © BGBH 2020 - Todos os direitos reservados </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
    <script>
    $(function() {
        $('[data-toggle="popover"]').popover({
            html: true
        });
    });
    $('.celular').mask('(00) 0 0000-0000');
    $('.dinheiro').mask('#.##0,00', {reverse: true});
    $('.data').mask('00/00/0000');
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
