<?php namespace cardback\utility;

// Permet de changer le titre de la page web
function changeTitle($title)
{
    // Prend le contenu actuel de la page
    $page = ob_get_contents();
    // Efface le contenu actuel de la page
    ob_end_clean();

    // Pattern regex qui prend la ligne du <title> dans le code HTML
    $pattern = "/<title>(.*?)<\/title>/";
    // Ligne qui permettra de remplacer celle du pattern
    $result = "<title>$title · cardback</title>";

    // On remplace chaque instance du patterne dans la page par le résultat voulu
    $page = preg_replace($pattern, $result, $page);

    // On affiche la page
    echo $page;
}

// Permet de rediriger à l'URL voulu
function redirect($url = "") {
    global $serverUrl;

    header("Location: ".$serverUrl."/".$url);
    exit();
}

// Vérifie que la syntaxe d'une adresse e-mail est valide
function checkEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Vérifie que la syntaxe d'un mot de passe est valide
function checkPassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&.+\\\\|\/\-^])[A-Za-z\d@$!%*#?&.+\\\\|\/\-^]{8,64}$/', $password);
}

// Vérifie que la syntaxe d'un nom est valide
function checkName($name) {
    return preg_match('/^[\dA-Za-z ,.\'-]{2,}$/', $name);
}