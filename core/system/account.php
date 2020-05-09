<?php namespace cardback\system;

function _checkAccountExists($email) {
    $result = \cardback\database\select("users",
        "id",
        "WHERE email = '$email'");

    return $result[0] == 1;
}

// Crée un compte
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

    \cardback\database\insert("users",
        "email, password, firstName, lastName, creationDate, lastConnectionDate",
        "'$email', '$password', '$firstName', '$lastName', '$creationDate', '$creationDate'");

    return [1];
}

function createAuthenticationToken($userId) {
    $serverToken = uniqid("", TRUE);
    $userToken = md5($_SERVER['HTTP_USER_AGENT'] .  $_SERVER['REMOTE_ADDR']);

    \cardback\database\insert(
        "connectionTokens",
        "serverToken, userToken",
        "'$serverToken', '$userToken'");

    $tokenId = \cardback\database\selectMaxId("connectionTokens")[1];

    \cardback\database\insert(
        "userConnectionTokens",
        "userId, tokenId",
        "'$userId', '$tokenId'");

    setcookie("serverToken", $serverToken, time() + 2592000, "/", null, false, true);
}

function removeAuthenticationToken() {
    if (isset($_COOKIE['serverToken'])) {
        $serverToken = $_COOKIE['serverToken'];

        \cardback\database\delete("connectionTokens", "WHERE serverToken = '$serverToken'");
    }

    unset($_COOKIE['serverToken']);
    setcookie('serverToken', null, -1, '/');
}

function connectWithCredentials($email, $password) {
    global $db;

    $email = mysqli_real_escape_string($db, $email);

    $result = \cardback\database\select("users",
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

    \cardback\database\update("users",
        "lastConnectionDate = '$lastConnectionDate'",
        "WHERE id = '$userId'");

    if ($result[1][0]["keepConnected"] == 1) {
        createAuthenticationToken($userId);
    }

    return connectAccount($userId);
}

function connectWithAuthenticationToken() {
    $serverToken = $_COOKIE["serverToken"];

    $connectionToken = \cardback\database\select("connectionTokens",
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

    $userConnectionToken = \cardback\database\select("userConnectionTokens",
        "",
        "WHERE tokenId = '$connectionTokenId'");

    if ($userConnectionToken[0] == 0) {
        return [0, "Lien user-token invalide"];
    }

    $userId = $userConnectionToken[1][0]["userId"];

    $user = \cardback\database\select("users",
        "id, password",
        "WHERE id = '$userId'");

    if ($user[0] == 0) {
        return [0, "Utilisateur invalide"];
    }

    return connectAccount($user[1][0]["id"]);
}

function connectAccount($id) {
    $_SESSION["signedIn"] = TRUE;
    $_SESSION["accountId"] = $id;

    session_regenerate_id();

    return [1, "Connecté avec succès"];
}

// Déconnecte le compte actuellement connecté, si il y en a un
function disconnectAccount() {
    unset($_SESSION["signedIn"]);
    unset($_SESSION["accountId"]);

    removeAuthenticationToken();
    session_regenerate_id();
}

// Supprime un compte
function removeAccount($userId) {
    $result = getAllPacksOfUser($userId);

    if ($result[0] == 1) {
        foreach ($result[1] as $pack) {
            removePack($pack["id"]);
        }
    }

    \cardback\database\delete("users", "WHERE id = '$userId'");

    disconnectAccount();
}

// Retourne le contenu d'un compte
function getAccount($userId) {
    $result = \cardback\database\select(
        "users",
        "",
        "WHERE id = '$userId'");

    if ($result[0] == 0) {
        return $result;
    }

    $result[1][0]["name"] = $result[1][0]["firstName"]." ".$result[1][0]["lastName"];

    return $result;
}

// Retourne le contenu de tous les comptes
function getAllAccounts() {
    $result = \cardback\database\select(
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

function updateAccountName($userId, $firstName, $lastName) {
    global $db;

    $firstName = mysqli_real_escape_string($db, $firstName);
    $lastName = mysqli_real_escape_string($db, $lastName);

    \cardback\database\update("users",
        "firstName = '$firstName', lastName = '$lastName'",
        "WHERE id = '$userId'");
}

function updateAccountMail($userId, $email) {
    global $db;

    $email = mysqli_real_escape_string($db, $email);

    \cardback\database\update("users",
        "email = '$email'",
        "WHERE id = '$userId'");
}

function updateAccountDescription($userId, $description) {
    global $db;

    $description = mysqli_real_escape_string($db, $description);

    \cardback\database\update("users",
        "description = '$description'",
        "WHERE id = '$userId'");
}

function updateAccountPassword($userId, $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);

    \cardback\database\update("users",
        "password = '$password'",
        "WHERE id = '$userId'");
}

function updateAccount($userId, $email, $firstName, $lastName, $description) {
    updateAccountMail($userId, $email);
    updateAccountName($userId, $firstName, $lastName);
    updateAccountDescription($userId, $description);
}

function hideFirstName($userId, $hide) {
    \cardback\database\update("users",
        "hideFirstName = ".($hide ? "1" : "0"),
        "WHERE id = '$userId'");
}

function hideLastName($userId, $hide) {
    \cardback\database\update("users",
        "hideLastName = ".($hide ? "1" : "0"),
        "WHERE id = '$userId'");
}

function hideInSearch($userId, $hide) {
    \cardback\database\update("users",
        "hideInSearch = ".($hide ? "1" : "0"),
        "WHERE id = '$userId'");
}

function keepConnected($userId, $value) {
    \cardback\database\update("users",
        "keepConnected = ".($value ? "1" : "0"),
        "WHERE id = '$userId'");
}

function searchAccount($name) {
    return \cardback\database\select("users",
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

// Vérifie si un compte est connecté, ou non. Et redirige au bon endroit du site selon les cas
function checkAccountConnection($connected) {
    if ($connected) {
        if (!isset($_SESSION["signedIn"]) || (isset($_SESSION["signedIn"]) && $_SESSION["signedIn"] == FALSE)) {
            \cardback\utility\redirect();
        }
    } else {
        if (isset($_SESSION["signedIn"]) && $_SESSION["signedIn"] == TRUE) {
            \cardback\utility\redirect("home");
        }
    }
}

function checkAccountAdministration() {
    global $account;

    if ($account["admin"] != 1) {
        \cardback\utility\redirect("403");
    }
}