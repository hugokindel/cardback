<?php
function createAccount($db, $email, $password, $firstName, $lastName) {
    $result = mysqli_query($db, "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($db, $email)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) != 0) {
        return [FALSE, "Le compte existe déjà"];
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

    return [TRUE, "Le compte a été créé"];
}

function connectAccount($db, $email, $password) {
    $result = mysqli_query($db, "SELECT id, password FROM users WHERE email = '".mysqli_real_escape_string($db, $email)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Le compte n'existe pas"];
    }

    $rows = mysqli_fetch_row($result);

    if (!password_verify($password, $rows[1])) {
        return [FALSE, "Le mot de passe est incorrect"];
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

    return [TRUE, "Le compte est connecté"];
}

function removeAccount($db, $id, $password) {
    $result = mysqli_query($db, "SELECT * FROM users WHERE id = '".$id."' AND password = '".$password."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Le compte n'existe pas"];
    }

    $result = mysqli_query($db, "DELETE FROM users WHERE id = '".$id."' AND password = '".$password."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    disconnectAccount();

    return [TRUE, "Le compte a été supprimé"];
}

function disconnectAccount() {
    session_regenerate_id();

    unset($_SESSION["signedIn"]);
    unset($_SESSION["accountId"]);
    unset($_SESSION["accountPassword"]);
}

function checkConnectionAccount() {
    if (!isset($_SESSION["signedIn"]) || $_SESSION["signedIn"] == FALSE) {
        redirectToBase();
    }
}