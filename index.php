<?php
// Importe tout le contenu nécessaire au fonctionnement du site
require_once "core/core.php";

// Configure le site
cardback\configure();
// Connecte la base de donnée
cardback\database\connect();

// Défini la page à charger
$link = isset($_GET["link"]) ? "page/".$_GET['link'] : "page/welcome";

// Vérifie si la page à charger existe dans les fichiers du site
if (!file_exists($link.".php")) {
    // Si elle n'existe pas, on défini la page à charger en tant que page "404"
    $link = "page/error/404";
}

// Retourne l'utilisateur actuel de cette session (ou NULL s'il n'y en a pas)
$account = cardback\getUser(); // TODO: rename to user
// Retourne le thème actuel (soit par les cookies, soit par défaut)
$theme = cardback\getTheme();
// Retourne la couleur d'accentuation actuelle (soit par les cookies, soit par défaut)
$color = cardback\getColor();
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
    // Vérifie si il existe une fiche de style pour la page à charger dans les fichiers du site
    if (file_exists("res/style/".$link.".css")) {
        // Si oui, on la charge
        echo '<link rel="stylesheet" href="'.$serverUrl.'/res/style/'.$link.'.css">';
    }
    ?>

    <!-- Feuille de style du thème -->
    <link rel="stylesheet" href="<?php echo $serverUrl ?>/res/style/theme/<?php echo $theme; ?>.css">
    <!-- Feuille de style de la couleur d'accentuation -->
    <link rel="stylesheet" href="<?php echo $serverUrl ?>/res/style/color/<?php echo $color; ?>.css">
</head>
<body>
    <script>
        // Définit une variable globale utilisé dans le JavaScript du site
        let baseUrl = "<?php echo $serverUrl ?>";
    </script>

    <?php
    // Charge la page du site demandé
    require $link.".php";
    ?>

    <!-- Charge le JavaScript nécessaire pour quelques éléments graphiques du site -->
    <script src="<?php echo $serverUrl ?>/res/script/component.js"></script>
</body>
</html>

<?php
// Déconnecte la base de donnée
cardback\database\disconnect();
?>