<?php
function createPack($name, $theme, $difficulty) {
    global $db;

    $result = mysqli_query($db, "SELECT id FROM packs WHERE name = '".mysqli_real_escape_string($db, $name)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) != 0) {
        return [FALSE, "Un paquet avec ce nom existe déjà."];
    }

    $result = mysqli_query($db, "INSERT INTO packs (name, theme, firstName, lastName, creationDate, lastConnectionDate) VALUES ('"
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