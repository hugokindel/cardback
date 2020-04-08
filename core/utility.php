<?php
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

function redirectToBase() {
    global $baseUrl;

    header("Location: ".$baseUrl);
    exit();
}

function redirectToHome() {
    global $baseUrl;

    header("Location: ".$baseUrl."/home");
    exit();
}

function redirectToEditor($packId) {
    global $baseUrl;

    header("Location: ".$baseUrl."/editor?id=".$packId);
    exit();
}

function checkEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function checkPassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,64}$/', $password);
}

function checkName($name) {
    return preg_match('/^[\dA-Za-z ,.\'-]{3,}$/', $name);
}