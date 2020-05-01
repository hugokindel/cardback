<?php namespace cardback;

// URL du site.
$serverUrl = "https://cardback.tech";

// Informations générales du site.
$serverTimezone = "Europe/Paris";
$serverLocale = "fr_FR.UTF-8";

// Informations de connexion à la base de donnée.
$dbHost = "35.205.34.35";
$dbUser = "root";
$dbPassword = "@!hk-fpv-io2-2019!@";
$dbBase = "cardback";
$dbPort = "3306";

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
    }
}