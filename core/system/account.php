<?php namespace cardback\system;

// Vérifie si un compte existe déjà
function _checkAccountExists($email) {
    $result = \cardback\database\select("users",
        "id",
        "WHERE name = '$email'");

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
    \cardback\database\delete("users", "WHERE id = '$userId'");
    disconnectAccount();
}

// Retourne le contenu d'un compte
function getAccount($userId) {
    return \cardback\database\select("users", "", "WHERE id = '$userId'");
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