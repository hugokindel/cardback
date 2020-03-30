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

function removeAccount($db, $email) {
    $result = mysqli_query($db, "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($db, $email)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Le compte n'existe pas"];
    }

    $result = mysqli_query($db, "DELETE FROM users WHERE email = '"
        .mysqli_real_escape_string($db, $email)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return [TRUE, "Le compte a été supprimé"];
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

    session_regenerate_id();

    $_SESSION["signedIn"] = TRUE;
    $_SESSION["accountId"] = $rows[0];
    $_SESSION["accountPassword"] = $rows[1];

    return [TRUE, "Le compte est connecté"];
}