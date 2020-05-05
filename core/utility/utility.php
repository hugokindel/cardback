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
    return preg_match('/^(?=.*[a-z\x{00E0}-\x{00F6}\x{00F8}-\x{00FC}])(?=.*[A-Z\x{00C0}-\x{00D6}\x{00D8}-\x{00DC}])(?=.*\d)(?=.*[\x21-\x2F\x3A-\x40\x5B-\x60\x7B-\x7E])[A-Z\x{00C0}-\x{00D6}\x{00D8}-\x{00DC}a-z\x{00E0}-\x{00F6}\x{00F8}-\x{00FC}\d\x21-\x2F\x3A-\x40\x5B-\x60\x7B-\x7E]{8,64}$/u', $password);
}

// Vérifie que la syntaxe d'un nom est valide
function checkName($name) {
    return preg_match('/^[\dA-Za-z\x{00E0}-\x{00F6}\x{00F8}-\x{00FC}\x{00C0}-\x{00D6}\x{00D8}-\x{00DC} ,.\'\-]{2,}$/u', $name);
}

function getFormatedDate($date) {
    return strftime("%e %B %G", strtotime($date));
}

function getAnonymousName($firstName, $lastName, $hideFirstName, $hideLastName) {
    if ($hideFirstName == 1 && $hideLastName == 1) {
        return substr($firstName, 0, 1).".".substr($lastName, 0, 1).".";
    } else if ($hideFirstName == 1) {
        return substr($firstName, 0, 1).". ".$lastName;
    } else if ($hideLastName == 1) {
        return $firstName." ".substr($lastName, 0, 1).".";
    } else {
        return $firstName." ".$lastName;
    }
}

function getAnonymousNameFromAccount($account) {
    return getAnonymousName($account["firstName"], $account["lastName"], $account["hideFirstName"], $account["hideLastName"]);
}