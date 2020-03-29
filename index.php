<?php
$database = mysqli_connect("35.205.34.35", "root", "root", "cardback");

if (!$database) {
    echo mysqli_connect_error();
}

require_once "core/utility.php";

$link = isset($_GET["link"]) ? "page/".$_GET['link'] : "page/welcome";

if (!file_exists($link.".php")) {
    $link = "page/404";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Titre de la page -->
    <title>cardback</title>

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
    if (file_exists("res/style/".$link.".css")) {
        echo '<link rel="stylesheet" href="/res/style/'.$link.'.css">';
    }
    ?>
</head>

<body>
<?php
require $link.".php";
?>
</body>
</html>
<?php
mysqli_close($database);
?>