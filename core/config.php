<?php namespace cardback;

// URL du site
$serverUrl = "https://cardback.tech/";

// Informations générales du site
$serverTimezone = "Europe/Paris";
$serverLocale = "fr_FR.UTF-8";

// Informations de connexion à la base de donnée
$dbHost = "35.205.34.35";
$dbUser = "root";
$dbPassword = "@!hk-fpv-io2-2019!@";
$dbBase = "cardback";
$dbPort = "3306";

// Les différents thèmes
$themes = array(
    0 => "Informatique",
    1 => "Mathématiques",
    2 => "Géographie",
    3 => "Histoire",
    4 => "Langues",
    5 => "Divertissement",
    6 => "Autres"
);

// Les différentes difficultés
$difficulties = array(
    0 => "Facile",
    1 => "Moyen",
    2 => "Difficile"
);

// Fonction de configuration du site web (fuseau horaire, langage, session)
function configure() {
    global $serverTimezone;
    global $serverLocale;

    // Défini le fuseau horaire
    date_default_timezone_set($serverTimezone);
    // Défini le fichier de langage à utiliser
    setlocale(LC_TIME, $serverLocale);

    // Démarre une session si une session n'est pas déjà en cours
    if (!isset($_SESSION)) {
        session_start();
        session_regenerate_id();
    }
}

function getColor() {
    return isset($_COOKIE["color"]) ? $_COOKIE["color"] : "green";
}

function getTheme() {
    return isset($_COOKIE["theme"]) ? $_COOKIE["theme"] : "light";
}

function getUser() {
    if (isset($_SESSION["accountId"])) {
        // Si l'utilisateur est actuellement connecté (sont ID est présent dans la session)
        $result = \cardback\system\getAccount($_SESSION["accountId"]);

        if ($result[0] == 0) {
            // Si l'utilisateur est introuvable
            \cardback\system\disconnectAccount();
        } else {
            // Si l'utilisateur est trouvable
            return $result[1][0];
        }
    } else if (isset($_COOKIE["serverToken"])) {
        // Si l'utilisateur n'est pas connecté, mais qu'il possède un token de connexion
        $result = \cardback\system\connectWithAuthenticationToken();

        if ($result[0] == 0 || !isset($_SESSION["accountId"])) {
            // Si le token est invalide ou l'utilisateur introuvable
            \cardback\system\disconnectAccount();
        } else {
            // Si le token est valide et par conséquent l'utilisateur trouvable
            return \cardback\system\getAccount($_SESSION["accountId"])[1][0];
        }
    } else {
        return NULL;
    }
}