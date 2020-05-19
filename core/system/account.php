<?php namespace cardback\system;
/**
 * Ce fichier contient les fonctions utilitaires relatives au système de compte.
 */

use function cardback\database\delete;
use function cardback\database\insert;
use function cardback\database\select;
use function cardback\database\selectMaxId;
use function cardback\database\update;
use function cardback\utility\redirect;

/**
 * Fonction interne pour vérifier si un compte existe.
 *
 * @param string $email E-mail.
 * @return bool Si il existe ou non.
 */
function _checkAccountExists($email) {
    $result = select("users",
        "id",
        "WHERE email = '$email'");

    return $result[0] == 1;
}

/**
 * Crée un compte.
 *
 * @param string $email E-mail.
 * @param string $password Mot de passe.
 * @param string $firstName Prénom.
 * @param string $lastName Nom.
 * @return array Résultat.
 */
function createAccount($email, $password, $firstName, $lastName) {
    global $db;

    $email = mysqli_real_escape_string($db, $email);

    if (_checkAccountExists($email)) {
        return [0, "Un compte lié à cette adresse e-mail existe déjà."];
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $firstName = mysqli_real_escape_string($db, $firstName);
    $lastName = mysqli_real_escape_string($db, $lastName);
    $creationDate = date("Y-m-d");

    insert("users",
        "email, password, firstName, lastName, creationDate, lastConnectionDate",
        "'$email', '$password', '$firstName', '$lastName', '$creationDate', '$creationDate'");

    return [1];
}

/**
 * Crée un token d'authentification.
 * Un token est composé de deux parties:
 * - Une partie correspondant à un identifiant unique généré par le serveur.
 * - Une partie correspondant à des informations spécifique à l'utilisateur et son navigateur.
 * Pour qu'un token soit valide et permettre la connexion, les deux parties doivent être ensembles.
 *
 * @param string $userId ID d'utilisateur.
 */
function createAuthenticationToken($userId) {
    $serverToken = uniqid("", TRUE);
    $userToken = md5($_SERVER['HTTP_USER_AGENT'] .  $_SERVER['REMOTE_ADDR']);

    insert(
        "connectionTokens",
        "serverToken, userToken",
        "'$serverToken', '$userToken'");

    $tokenId = selectMaxId("connectionTokens")[1];

    insert(
        "userConnectionTokens",
        "userId, tokenId",
        "'$userId', '$tokenId'");

    setcookie("serverToken", $serverToken, time() + 2592000, "/", null, false, true);
}

/**
 * Supprime un token d'authentification.
 */
function removeAuthenticationToken() {
    if (isset($_COOKIE['serverToken'])) {
        $serverToken = $_COOKIE['serverToken'];

        delete("connectionTokens", "WHERE serverToken = '$serverToken'");
    }

    unset($_COOKIE['serverToken']);
    setcookie('serverToken', null, -1, '/');
}

/**
 * Connecte un compte par ses données d'authentification.
 *
 * @param string $email E-mail.
 * @param string $password Mot de passe.
 * @return array Résultat.
 */
function connectWithCredentials($email, $password) {
    global $db;

    $email = mysqli_real_escape_string($db, $email);

    $result = select("users",
        "id, password, keepConnected",
        "WHERE email = '$email'");

    if ($result[0] == 0) {
        return [0, "Aucun compte n'est lié à cette adresse e-mail.", "email"];
    } else if (!password_verify($password, $result[1][0]["password"])) {
        return [0, "Mot de passe incorrect.", "password"];
    }

    $lastConnectionDate = date("Y-m-d");
    $userId = $result[1][0]["id"];
    $password = $result[1][0]["password"];

    update("users",
        "lastConnectionDate = '$lastConnectionDate'",
        "WHERE id = '$userId'");

    if ($result[1][0]["keepConnected"] == 1) {
        createAuthenticationToken($userId);
    }

    return connectAccount($userId);
}

/**
 * Connecte un compte par un token d'authentification.
 *
 * @return array Résultat.
 */
function connectWithAuthenticationToken() {
    $serverToken = $_COOKIE["serverToken"];

    $connectionToken = select("connectionTokens",
        "",
        "WHERE serverToken = '$serverToken'");

    if ($connectionToken[0] == 0) {
        return [0, "Token serveur invalide"];
    }

    $userToken = md5($_SERVER['HTTP_USER_AGENT'] .  $_SERVER['REMOTE_ADDR']);

    if ($connectionToken[1][0]["userToken"] != $userToken) {
        return [0, "Token utilisateur invalide"];
    }

    $connectionTokenId = $connectionToken[1][0]["id"];

    $userConnectionToken = select("userConnectionTokens",
        "",
        "WHERE tokenId = '$connectionTokenId'");

    if ($userConnectionToken[0] == 0) {
        return [0, "Lien user-token invalide"];
    }

    $userId = $userConnectionToken[1][0]["userId"];

    $user = select("users",
        "id, password",
        "WHERE id = '$userId'");

    if ($user[0] == 0) {
        return [0, "Utilisateur invalide"];
    }

    return connectAccount($user[1][0]["id"]);
}

/**
 * Connecte un compte (utilisé dans les deux méthodes précédentes).
 *
 * @param string $id ID du compte.
 * @return array Résultat.
 */
function connectAccount($id) {
    $_SESSION["signedIn"] = TRUE;
    $_SESSION["accountId"] = $id;

    session_regenerate_id();

    return [1, "Connecté avec succès"];
}

/**
 * Déconnecte un compte, si il est connecté.
 */
function disconnectAccount() {
    unset($_SESSION["signedIn"]);
    unset($_SESSION["accountId"]);

    removeAuthenticationToken();
    session_regenerate_id();
}

/**
 * Supprime un compte.
 *
 * @param string $userId Identifiant du compte.
 */
function removeAccount($userId) {
    $result = getAllPacksOfUser($userId);

    if ($result[0] == 1) {
        foreach ($result[1] as $pack) {
            removePack($pack["id"]);
        }
    }

    delete("users", "WHERE id = '$userId'");

    disconnectAccount();
}

/**
 * Retourne les données d'un compte.
 *
 * @param string $userId ID du compte.
 * @return array Résultat.
 */
function getAccount($userId) {
    $result = select(
        "users",
        "",
        "WHERE id = '$userId'");

    if ($result[0] == 0) {
        return $result;
    }

    $result[1][0]["name"] = $result[1][0]["firstName"]." ".$result[1][0]["lastName"];

    return $result;
}

/**
 * Retourne tous les comptes.
 *
 * @return array Résultat.
 */
function getAllAccounts() {
    $result = select(
        "users",
        "",
        "");

    if ($result[0] == 1) {
        for ($i = 0; $i < count($result[1]); $i++) {
            $result[1][$i]["type"] = 2;
        }
    }

    return $result;
}

/**
 * Met à jour le nom/prénom d'un compte.
 *
 * @param string $userId ID du compte.
 * @param string $firstName Prénom.
 * @param string $lastName Nom.
 */
function updateAccountName($userId, $firstName, $lastName) {
    global $db;

    $firstName = mysqli_real_escape_string($db, $firstName);
    $lastName = mysqli_real_escape_string($db, $lastName);

    update("users",
        "firstName = '$firstName', lastName = '$lastName'",
        "WHERE id = '$userId'");
}

/**
 * Met à jour l'e-mail d'un compte.
 *
 * @param string $userId ID du compte.
 * @param string $email E-mail.
 */
function updateAccountMail($userId, $email) {
    global $db;

    $email = mysqli_real_escape_string($db, $email);

    update("users",
        "email = '$email'",
        "WHERE id = '$userId'");
}

/**
 * Met à jour la description d'un compte.
 *
 * @param string $userId ID du compte.
 * @param string $description Description.
 */
function updateAccountDescription($userId, $description) {
    global $db;

    $description = mysqli_real_escape_string($db, $description);

    update("users",
        "description = '$description'",
        "WHERE id = '$userId'");
}

/**
 * Met à jour le mot de passe d'un compte.
 *
 * @param string $userId ID du compte.
 * @param string $password Mot de passe.
 */
function updateAccountPassword($userId, $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);

    update("users",
        "password = '$password'",
        "WHERE id = '$userId'");
}

/**
 * Met à jour un compte.
 *
 * @param string $userId ID du compte.
 * @param string $email E-mail.
 * @param string $firstName Prénom.
 * @param string $lastName Nom.
 * @param string $description Description.
 */
function updateAccount($userId, $email, $firstName, $lastName, $description) {
    updateAccountMail($userId, $email);
    updateAccountName($userId, $firstName, $lastName);
    updateAccountDescription($userId, $description);
}

/**
 * Cache le prénom.
 *
 * @param string $userId ID du compte.
 * @param bool $hide Définit si on cache ou non.
 */
function hideFirstName($userId, $hide) {
    update("users",
        "hideFirstName = ".($hide ? "1" : "0"),
        "WHERE id = '$userId'");
}

/**
 * Cache le nom.
 *
 * @param string $userId ID du compte.
 * @param bool $hide Définit si on cache ou non.
 */
function hideLastName($userId, $hide) {
    update("users",
        "hideLastName = ".($hide ? "1" : "0"),
        "WHERE id = '$userId'");
}

/**
 * Cache dans les recherches.
 *
 * @param string $userId ID du compte.
 * @param bool $hide Définit si on cache ou non.
 */
function hideInSearch($userId, $hide) {
    update("users",
        "hideInSearch = ".($hide ? "1" : "0"),
        "WHERE id = '$userId'");
}

/**
 * Cache le prénom.
 *
 * @param string $userId ID du compte.
 * @param string $value Définit si on garde connecté ou non.
 */
function keepConnected($userId, $value) {
    update("users",
        "keepConnected = ".($value ? "1" : "0"),
        "WHERE id = '$userId'");
}

/**
 * Cherche un compte.
 *
 * @param string $name Nom du compte.
 * @return array Résultat.
 */
function searchAccount($name) {
    return select("users",
        "",
        "WHERE
	        (hideFirstName = 1 AND hideLastName = 1 AND
		        CONCAT(SUBSTRING(firstName,1,1),'.',SUBSTRING(lastName,1,1),'.') LIKE '$name%') OR
	        (hideFirstName = 1 AND hideLastName = 0 AND
		        CONCAT(SUBSTRING(firstName,1,1),'. ',lastName) LIKE '$name%') OR
	        (hideFirstName = 0 AND hideLastName = 1 AND
		        CONCAT(firstName,' ',SUBSTRING(lastName,1,1),'.') LIKE '$name%') OR
	        (hideFirstName = 0 AND hideLastName = 0 AND
		        CONCAT(firstName,' ',lastName) LIKE '$name%')");
}

/**
 * Vérifie si un compte est actuellement connecté ou non.
 *
 * @param bool $connected Définit si on veux qu'il soit connecté ou non.
 */
function checkAccountConnection($connected) {
    if ($connected) {
        if (!isset($_SESSION["signedIn"]) || (isset($_SESSION["signedIn"]) && $_SESSION["signedIn"] == FALSE)) {
            redirect();
        }
    } else {
        if (isset($_SESSION["signedIn"]) && $_SESSION["signedIn"] == TRUE) {
            redirect("home");
        }
    }
}

/**
 * Vérifie si un compte est administrateur ou non.
 */
function checkAccountAdministration() {
    global $account;

    if ($account["admin"] != 1) {
        redirect("403");
    }
}