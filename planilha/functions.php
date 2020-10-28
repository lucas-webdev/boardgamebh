<?php
date_default_timezone_set('America/Sao_Paulo');
function pdo_connect_mysql()
{
    $DATABASE_HOST = 'mysql.lucascmedeiros.com.br';
    $DATABASE_USER = 'lucascmedeirBGBH';
    $DATABASE_PASS = 'f2C-e5';
    $DATABASE_NAME = 'lucascmedeiroscombrbgbh';
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
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>$title</title>
            <link rel="icon" type="image/png" href="https://lucascmedeiros.com.br/bgbh/favicon.ico"/>
            <link href="dist/assets/styles/style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
            <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,700;0,900;1,500&display=swap" rel="stylesheet">
        </head>
        <body>
        <nav class="navbar navbar-expand-sm navbar-dark">
            <a class="navbar-brand" href="/bgbh">
                <img src="dist/assets/images/logo_com_sombra.png" width="30" height="30" class="d-inline-block align-top" alt="">
                BoardgameBH
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/bgbh">Site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/bgbh/planilha">Planilha <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/bgbh/planilha/create.php">Incluir jogos</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="container-fluid p-3 py-4">
    EOT;
}
function template_footer()
{
    echo <<<EOT
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
    </body>
    </html>
    EOT;
}

function formatCellphone($phone)
{
    return preg_replace('/[- )(]/', '', $phone);
}

function diffDaysFromToday($date)
{
    $compareDate = new DateTime($date);
    $now = new DateTime();

    return $compareDate->diff($now)->format("%a");
}

function printWishlist($wishlist)
{
    if (strpos($wishlist, "http") === false)
        return $wishlist;

    return "<a href='" . $wishlist . "' target='_blank'>" . $wishlist . "</a>";
}
