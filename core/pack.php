<?php
function createPack($name, $difficulty, $theme) {
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

    $result = mysqli_query($db, "INSERT INTO packs (name, difficulty, theme, creationDate) VALUES ('"
        .mysqli_real_escape_string($db, $name)."','"
        .mysqli_real_escape_string($db, $theme)."','"
        .mysqli_real_escape_string($db, $difficulty)."','"
        .date("Y-m-d")."')");


    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return [TRUE, "Pack créé avec succès."];
}

function getLastPack() {
    global $db;

    $result = mysqli_query($db, "SELECT MAX(id) FROM packs");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Il n'y a aucun paquet dans la base de donnée."];
    }

    $rows = mysqli_fetch_row($result);

    return [TRUE, $rows[0]];
}