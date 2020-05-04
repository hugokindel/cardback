<?php
// Importe tout le contenu nécessaire au fonctionnement du site
require_once "core/core.php";

// Configure le site
cardback\configure();
// Connecte la base de donnée
cardback\database\connect();

// Défini la page à charger
$link = isset($_GET["link"]) ? "page/".$_GET['link'] : "page/welcome";

// Si elle n'existe pas
if (!file_exists($link.".php")) {
    // On défini la page à charger en tant que page 404
    $link = "page/404";
}

$account = NULL;

if (isset($_SESSION["accountId"])) {
    $account = \cardback\system\getAccount($_SESSION["accountId"])[1][0];
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
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $serverUrl ?>/res/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $serverUrl ?>/res/favicon/favicon-16x16.png">

    <!-- Feuille de style -->
    <link rel="stylesheet" href="<?php echo $serverUrl ?>/res/style/utility/normalize.css">
    <link rel="stylesheet" href="<?php echo $serverUrl ?>/res/style/sf-pro-rounded.css">
    <link rel="stylesheet" href="<?php echo $serverUrl ?>/res/style/base.css">
    <link rel="stylesheet" href="<?php echo $serverUrl ?>/res/style/component.css">

    <?php
    // Si le fichier de style pour cette page existe
    if (file_exists("res/style/".$link.".css")) {
        // On le charge
        echo '<link rel="stylesheet" href="'.$serverUrl.'/res/style/'.$link.'.css">';
    }
    ?>
</head>
<body>
    <script>
        let baseUrl = "<?php echo $serverUrl ?>";
    </script>

    <?php
    // Charge la page voulu
    require $link.".php";
    ?>

    <script src="<?php echo $serverUrl ?>/res/script/component.js"></script>
</body>
</html>

<?php
cardback\database\disconnect();
?>