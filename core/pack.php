<?php
function getPackData($id) {
    global $db;

    $result = mysqli_query($db, "SELECT * FROM packs WHERE id = '".$id."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Aucun paquet n'est lié à cette ID."];
    }

    return [TRUE, mysqli_fetch_assoc($result)];
}

function getFirstPackId()
{
    global $db;

    $result = mysqli_query($db, "SELECT MIN(id) FROM packs");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Il n'y a aucun paquet dans la base de donnée."];
    }

    return [TRUE, mysqli_fetch_assoc($result)["MIN(id)"]];
}

function getFirstCardId() {
    global $db;

    $result = mysqli_query($db, "SELECT MIN(id) FROM cards");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Il n'y a aucune carte dans la base de donnée."];
    }

    return [TRUE, mysqli_fetch_assoc($result)["MIN(id)"]];
}

function getLastPackId() {
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

    return [TRUE, mysqli_fetch_assoc($result)["MAX(id)"]];
}

function getLastCardId() {
    global $db;

    $result = mysqli_query($db, "SELECT MAX(id) FROM cards");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Il n'y a aucune carte dans la base de donnée."];
    }

    return [TRUE, mysqli_fetch_assoc($result)["MAX(id)"]];
}

function createPack($userId, $name, $difficulty, $theme) {
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
        .mysqli_real_escape_string($db, $difficulty)."','"
        .mysqli_real_escape_string($db, $theme)."','"
        .date("Y-m-d")."')");


    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    $result = mysqli_query($db, "INSERT INTO userPacks (userId, packId) VALUES ("
        .$userId.","
        .getLastPackId()[1].")");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return [TRUE, "Pack créé avec succès."];
}

function createCard($packId) {
    global $db;

    $result = mysqli_query($db, "INSERT INTO cards (creationDate) VALUES ('".date("Y-m-d")."')");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    $result = mysqli_query($db, "INSERT INTO packCards (packId, cardId) VALUES ("
        .$packId.","
        .getLastCardId()[1].")");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return [TRUE, "Carte créé avec succès."];
}

function getAllUnpublishedPacksOfUser($userId) {
    global $db;

    $return = [];
    $results = mysqli_query($db, "SELECT packId FROM userPacks WHERE userId = '".mysqli_real_escape_string($db, $userId)."'");

    if (!$results) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($results) == 0) {
        return [];
    }

    while ($result = mysqli_fetch_assoc($results)) {
        $results2 = mysqli_query($db, "SELECT * FROM packs WHERE id = '".$result["packId"]."' AND published = 0");

        if (!$results) {
            echo mysqli_error($db);
            mysqli_close($db);
            exit;
        }

        array_push($return, mysqli_fetch_assoc($results2));
    }

    return $return;
}

function getAllCardsOfPack($packId) {
    global $db;

    $return = [];
    $results = mysqli_query($db, "SELECT cardId FROM packCards WHERE packId = '".mysqli_real_escape_string($db, $packId)."'");

    if (!$results) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($results) == 0) {
        return [];
    }

    while ($result = mysqli_fetch_assoc($results)) {
        $results2 = mysqli_query($db, "SELECT * FROM cards WHERE id = '".$result["cardId"]."'");

        if (!$results) {
            echo mysqli_error($db);
            mysqli_close($db);
            exit;
        }

        array_push($return, mysqli_fetch_assoc($results2));
    }

    return $return;
}

function userOwnPack($userId, $packId) {
    global $db;

    $results = mysqli_query($db, "SELECT * FROM userPacks WHERE userId = '"
        .mysqli_real_escape_string($db, $userId)."' AND packId = '"
        .mysqli_real_escape_string($db, $packId)."'");

    if (!$results) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($results) == 0) {
        return FALSE;
    }

    return TRUE;
}