<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PV011</title>
    <style>
    html,
    body {
        height: 100%;
    }
    .wrapper {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }
    main {
        flex: 1 1 auto;
    }
    footer {
        border-top: 1px solid gray;
        margin: 10px 0 10px;
        padding: 10px 0 10px;
    }
    </style>
</head>
<body>
    <h1>PHP</h1>
    <a href="/basics">Введение в  РНР</a><br />
    <a href="/fundamentals">Основы РНР</a><br />
    <a href="/layout">Шаблонизация</a><br />

    <!-- Render body -->
    <?php
    switch( $path_parts[1] ) { // [1] - первая непустая часть (суть контроллер)
        case '' :
        case 'index'        : include "index.php";        break;
        case 'basics'       : include "basics.php";       break;
        case 'fundamentals' : include "fundamentals.php"; break;
        case 'layout'       : include "layout.php";       break;
        default             : include "404.php";
    }
    ?>

    <?php 
    $currentYear = date("Y");
    include "footer.php" 
    ?>
</body>
</html>