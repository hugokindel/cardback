<html lang="fr">
<head>
    <!-- Titre de la page -->
    <title><?php echo 'Bienvenue' ?> · cardback</title>

    <!-- Informations générales -->
    <meta charset="utf-8">

    <!-- Favicon -->
    <meta name="theme-color" content="#FFFFFF">
    <link rel="icon" type="image/png" sizes="32x32" href="/res/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/res/favicon/favicon-16x16.png">

    <!-- Feuille de style -->
    <link rel="stylesheet" href="/res/style/utility/normalize.css">
    <link rel="stylesheet" href="/res/style/base.css">
    <link rel="stylesheet" href="/res/style/sf-pro-rounded.css">
    <link rel="stylesheet" href="/res/style/components.css">
    <?php
    echo '<link rel="stylesheet" href="/res/style/page/home-disconnected.css">';
    ?>
</head>

<body>
<?php
require "page/home-disconnected.php";
?>
</body>
</html>
