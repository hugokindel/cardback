<?php namespace cardback\system;

// Vérifie si un compte existe déjà
use function cardback\database\update;

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

// Connecte un compte en enregistrant les informations nécessaire dans la SESSION
function connectAccount($email, $password) {
    global $db;

    $email = mysqli_real_escape_string($db, $email);

    $result = \cardback\database\select("users",
        "id, password",
        "WHERE email = '$email'");

    if ($result[0] == 0) {
        return [0, "Aucun compte n'est lié à cette adresse e-mail.", "email"];
    } else if (!password_verify($password, $result[1][0]["password"])) {
        return [0, "Mot de passe incorrect.", "password"];
    }

    $lastConnectionDate = date("Y-m-d");
    $id = $result[1][0]["id"];
    $password = $result[1][0]["password"];

    \cardback\database\update("users",
        "lastConnectionDate = '$lastConnectionDate'",
        "WHERE id = '$id'");

    session_regenerate_id();

    $_SESSION["signedIn"] = TRUE;
    $_SESSION["accountId"] = $id;
    $_SESSION["accountPassword"] = $password;

    return [1];
}

// Déconnecte le compte actuellement connecté, si il y en a un
function disconnectAccount() {
    session_regenerate_id();

    unset($_SESSION["signedIn"]);
    unset($_SESSION["accountId"]);
    unset($_SESSION["accountPassword"]);
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
    $result = \cardback\database\select("users", "", "WHERE id = '$userId'");

    if ($result[0] == 0) {
        return $result;
    }

    $result[1][0]["name"] = $result[1][0]["firstName"]." ".$result[1][0]["lastName"];

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