<?php namespace cardback;

// URL du site
$serverUrl = "http://cardback.test";

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