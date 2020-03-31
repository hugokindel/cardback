<?php
function createAccount($email, $password, $firstName, $lastName) {
    global $db;

    $result = mysqli_query($db, "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($db, $email)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) != 0) {
        return [FALSE, "Un compte lié à cette adresse e-mail existe déjà."];
    }

    $result = mysqli_query($db, "INSERT INTO users (email, password, firstName, lastName, creationDate, lastConnectionDate) VALUES ('"
        .mysqli_real_escape_string($db, $email)."','"
        .password_hash($password, PASSWORD_DEFAULT)."','"
        .mysqli_real_escape_string($db, $firstName)."','"
        .mysqli_real_escape_string($db, $lastName)."','"
        .date("Y-m-d")."','"
        .date("Y-m-d")."')");


    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return [TRUE, "Compte créé avec succès."];
}

function connectAccount($email, $password) {
    global $db;

    $result = mysqli_query($db, "SELECT id, password FROM users WHERE email = '".mysqli_real_escape_string($db, $email)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Aucun compte n'est lié à cette adresse e-mail.", "email"];
    }

    $rows = mysqli_fetch_row($result);

    if (!password_verify($password, $rows[1])) {
        return [FALSE, "Mot de passe incorrect.", "password"];
    }

    $result = mysqli_query($db, "UPDATE users SET lastConnectionDate = '"
        .date("Y-m-d")."' WHERE id = '".$rows[0]."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    session_regenerate_id();

    $_SESSION["signedIn"] = TRUE;
    $_SESSION["accountId"] = $rows[0];
    $_SESSION["accountPassword"] = $rows[1];

    return [TRUE, "Compte connecté avec succès."];
}

function removeAccount($id, $password) {
    global $db;

    $result = mysqli_query($db, "SELECT * FROM users WHERE id = '".$id."' AND password = '".$password."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Aucun compte n'est lié à cette ID et mot de passe."];
    }

    $result = mysqli_query($db, "DELETE FROM users WHERE id = '".$id."' AND password = '".$password."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    disconnectAccount();

    return [TRUE, "Compte supprimé avec succès."];
}

function getAccountData($id, $password) {
    global $db;

    $result = mysqli_query($db, "SELECT * FROM users WHERE id = '".$id."' AND password = '".$password."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Aucun compte n'est lié à cette ID et mot de passe."];
    }

    return [TRUE, mysqli_fetch_row($result)];
}

function disconnectAccount() {
    session_regenerate_id();

    unset($_SESSION["signedIn"]);
    unset($_SESSION["accountId"]);
    unset($_SESSION["accountPassword"]);

    return [TRUE, "Compte deconnecté avec succès."];
}

function checkIsConnectedToAccount() {
    if (!isset($_SESSION["signedIn"]) || (isset($_SESSION["signedIn"]) && $_SESSION["signedIn"] == FALSE)) {
        redirectToBase();
    }
}

function checkIsNotConnectedToAccount() {
    if (isset($_SESSION["signedIn"]) && $_SESSION["signedIn"] == TRUE) {
        redirectToHome();
    }
}

