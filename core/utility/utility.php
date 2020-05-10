<?php namespace cardback\utility;
/**
 * Ce fichier contient les fonctions utilitaires.
 */

/**
 * Change le title de la page.
 *
 * @param string $title Titre.
 */
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

/**
 * Redirigie à l'URL voulu.
 *
 * @param string $url URL.
 */
function redirect($url = "") {
    global $serverUrl;

    header("Location: ".$serverUrl.$url);
    exit();
}

/**
 * Vérifie la validité d'un email.
 *
 * @param string $email Email.
 * @return bool Résultat.
 */
function checkEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Vérifie la validité d'un mot de passe.
 *
 * @param string $password Mot de passe.
 * @return bool Résultat.
 */
function checkPassword($password) {
    return preg_match(
            '/^(?=.*[a-z\x{00E0}-\x{00F6}\x{00F8}-\x{00FC}])(?=.*[A-Z\x{00C0}-\x{00D6}\x{00D8}-\x{00DC}])(?=.*\d)(?=.*[\x21-\x2F\x3A-\x40\x5B-\x60\x7B-\x7E])[A-Z\x{00C0}-\x{00D6}\x{00D8}-\x{00DC}a-z\x{00E0}-\x{00F6}\x{00F8}-\x{00FC}\d\x21-\x2F\x3A-\x40\x5B-\x60\x7B-\x7E]{8,64}$/u', $password);
}

/**
 * Vérifie la validité d'un nom.
 *
 * @param string $name Nom.
 * @return bool Résultat.
 */
function checkName($name) {
    return preg_match(
            '/^[\dA-Za-z\x{00E0}-\x{00F6}\x{00F8}-\x{00FC}\x{00C0}-\x{00D6}\x{00D8}-\x{00DC} ,.\'\-]{2,}$/u', $name);
}

/**
 * Retourne une date formaté.
 *
 * @param string $date Date.
 * @return string Résultat.
 */
function getFormatedDate($date) {
    return strftime(
            "%e %B %G", strtotime($date));
}

/**
 * Retourne un nom de manière anonyme.
 *
 * @param string $firstName Prénom.
 * @param string $lastName Nom.
 * @param string $hideFirstName Définit si on cache le prénom.
 * @param string $hideLastName Définit si on cache le nom.
 * @return string Résultat.
 */
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

/**
 * Retourne un nom de manière anonyme.
 *
 * @param array $account Un compte.
 * @return string Résultat.
 */
function getAnonymousNameFromAccount($account) {
    return getAnonymousName($account["firstName"], $account["lastName"], $account["hideFirstName"], $account["hideLastName"]);
}

/**
 * Retourne n nombres aléatoires entre min et max.
 *
 * @param int $n Nombre de chiffres.
 * @param int $min Valeur minimale.
 * @param int $max Valeur maximale.
 * @param bool $canHaveSameValue Définit si on peut avoir les même valeurs plusieurs fois ou non.
 * @return array Résultat.
 */
function getNRandomNumbers($n, $min, $max, $canHaveSameValue = TRUE) {
    $i = 0;
    $array = [];

    while ($i < $n) {
        $number = rand($min, $max);
        $same = FALSE;

        if (!$canHaveSameValue) {
            foreach ($array as $j) {
                if ($j == $number) {
                    $same = TRUE;
                    break;
                }
            }
        }

        if (!$same) {
            $array[$i] = $number;
            $i++;
        }
    }

    return $array;
}