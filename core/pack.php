<?php
function getPack($id) {
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

    $result = mysqli_fetch_assoc($result);

    $results2 = mysqli_query($db, "SELECT userId FROM userPacks WHERE packId = ".$result["id"]);

    if (!$results2) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    $results2 = mysqli_query($db, "SELECT firstName, lastName FROM users WHERE id = "
        .mysqli_fetch_assoc($results2)["userId"]);

    if (!$results2) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    $results2 = mysqli_fetch_assoc($results2);

    $result["author"] = $results2["firstName"]." ".$results2["lastName"];

    return [TRUE, $result];
}

function isAuthorOfPack($userId, $packId) {
    global $db;

    $result = mysqli_query($db, "SELECT * FROM userPacks WHERE userId = '".$userId."' AND packId = '".$packId."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return FALSE;
    }

    return TRUE;
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

function createPack($userId, $name, $description, $difficulty, $theme) {
    global $db;

    $result = mysqli_query($db, "SELECT id FROM packs WHERE name = '"
        .mysqli_real_escape_string($db, $name)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) != 0) {
        return [FALSE, "Un paquet avec ce nom existe déjà."];
    }

    $result = mysqli_query($db, "INSERT INTO packs (name, difficulty, theme, creationDate, description) VALUES ('"
        .mysqli_real_escape_string($db, $name)."','"
        .mysqli_real_escape_string($db, $difficulty)."','"
        .mysqli_real_escape_string($db, $theme)."','"
        .date("Y-m-d")."','"
        .mysqli_real_escape_string($db, $description)."')");


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

    $result = mysqli_query($db, "INSERT INTO cards () VALUES ()");

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

function getAllPublishedPacksOfUser($userId) {
    global $db;

    $return = [];
    $results = mysqli_query($db, "SELECT packId FROM userPacks WHERE userId = '"
        .mysqli_real_escape_string($db, $userId)."'");

    if (!$results) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($results) == 0) {
        return [];
    }

    while ($result = mysqli_fetch_assoc($results)) {
        $results2 = mysqli_query($db, "SELECT * FROM packs WHERE id = '"
            .$result["packId"]."' AND published = 1");

        if (!$results) {
            echo mysqli_error($db);
            mysqli_close($db);
            exit;
        }

        if (mysqli_num_rows($results2) > 0) {
            array_push($return, mysqli_fetch_assoc($results2));
        }
    }

    return $return;
}

function getAllUnpublishedPacksOfUser($userId) {
    global $db;

    $return = [];
    $results = mysqli_query($db, "SELECT packId FROM userPacks WHERE userId = '"
        .mysqli_real_escape_string($db, $userId)."'");

    if (!$results) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($results) == 0) {
        return [];
    }

    while ($result = mysqli_fetch_assoc($results)) {
        $results2 = mysqli_query($db, "SELECT * FROM packs WHERE id = '"
            .$result["packId"]."' AND published = 0");

        if (!$results) {
            echo mysqli_error($db);
            mysqli_close($db);
            exit;
        }

        if (mysqli_num_rows($results2) > 0) {
            array_push($return, mysqli_fetch_assoc($results2));
        }
    }

    return $return;
}

function getAllPacks() {
    global $db;

    $return = [];

    $results = mysqli_query($db, "SELECT * FROM packs");

    if (!$results) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($results) == 0) {
        return [];
    }

    while ($result = mysqli_fetch_assoc($results)) {
        $results2 = mysqli_query($db, "SELECT userId FROM userPacks WHERE packId = ".$result["id"]);

        if (!$results2) {
            echo mysqli_error($db);
            mysqli_close($db);
            exit;
        }

        $results2 = mysqli_query($db, "SELECT firstName, lastName FROM users WHERE id = "
            .mysqli_fetch_assoc($results2)["userId"]);

        if (!$results2) {
            echo mysqli_error($db);
            mysqli_close($db);
            exit;
        }

        $results2 = mysqli_fetch_assoc($results2);

        $result["author"] = $results2["firstName"]." ".$results2["lastName"];

        array_push($return, $result);
    }

    return $return;
}

function getAllPublishedPacks() {
    global $db;

    $return = [];

    $results = mysqli_query($db, "SELECT * FROM packs WHERE published = 1");

    if (!$results) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($results) == 0) {
        return [];
    }

    while ($result = mysqli_fetch_assoc($results)) {
        $results2 = mysqli_query($db, "SELECT userId FROM userPacks WHERE packId = ".$result["id"]);

        if (!$results2) {
            echo mysqli_error($db);
            mysqli_close($db);
            exit;
        }

        $results2 = mysqli_query($db, "SELECT firstName, lastName FROM users WHERE id = "
            .mysqli_fetch_assoc($results2)["userId"]);

        if (!$results2) {
            echo mysqli_error($db);
            mysqli_close($db);
            exit;
        }

        $results2 = mysqli_fetch_assoc($results2);

        $result["author"] = $results2["firstName"]." ".$results2["lastName"];

        array_push($return, $result);
    }

    return $return;
}

function getAllPacksCreatedLastWeek() {
    global $db;

    $return = [];

    $results = mysqli_query($db, "SELECT * FROM packs WHERE creationDate BETWEEN DATE_ADD(now(), INTERVAL -1 WEEK) AND now() AND published = 1");

    if (!$results) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($results) == 0) {
        return [];
    }

    while ($result = mysqli_fetch_assoc($results)) {
        $results2 = mysqli_query($db, "SELECT userId FROM userPacks WHERE packId = ".$result["id"]);

        if (!$results2) {
            echo mysqli_error($db);
            mysqli_close($db);
            exit;
        }

        $results2 = mysqli_query($db, "SELECT firstName, lastName FROM users WHERE id = "
            .mysqli_fetch_assoc($results2)["userId"]);

        if (!$results2) {
            echo mysqli_error($db);
            mysqli_close($db);
            exit;
        }

        $results2 = mysqli_fetch_assoc($results2);

        $result["author"] = $results2["firstName"]." ".$results2["lastName"];

        array_push($return, $result);
    }

    return $return;
}

function getAllCardsOfPack($packId) {
    global $db;

    $return = [];
    $results = mysqli_query($db, "SELECT cardId FROM packCards WHERE packId = '"
        .mysqli_real_escape_string($db, $packId)."'");

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

function validateCard($cardId, $question, $answer) {
    global $db;

    $result = mysqli_query($db, "UPDATE cards SET question = '"
        .mysqli_real_escape_string($db, $question)."', answer = '"
        .mysqli_real_escape_string($db, $answer)."', confirmed = 1 WHERE id = '"
        .mysqli_real_escape_string($db, $cardId)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return TRUE;
}

function modifyCard($cardId) {
    global $db;

    $result = mysqli_query($db, "UPDATE cards SET confirmed = 0 WHERE id = '"
        .mysqli_real_escape_string($db, $cardId)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return TRUE;
}

function removeCard($cardId) {
    global $db;

    $result = mysqli_query($db, "SELECT * FROM cards WHERE id = '".$cardId."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Aucune carte n'est lié à cette identifiant."];
    }

    $result = mysqli_query($db, "DELETE FROM cards WHERE id = '".$cardId."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return [TRUE, "Carte supprimé avec succès."];
}

function removePack($packId) {
    global $db;

    $result = mysqli_query($db, "SELECT * FROM packs WHERE id = '".$packId."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Aucun paquet de cartes n'est lié à cette identifiant."];
    }

    $result = mysqli_query($db, "DELETE FROM packs WHERE id = '".$packId."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return [TRUE, "Paquet de cartes supprimé avec succès."];
}

function validatePack($packId) {
    global $db;

    $result = mysqli_query($db, "UPDATE packs SET published = 1 WHERE id = '"
        .mysqli_real_escape_string($db, $packId)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return TRUE;
}

function modifyPack($packId, $name, $description, $difficulty, $theme) {
    global $db;

    $result = mysqli_query($db, "SELECT id FROM packs WHERE name = '"
        .mysqli_real_escape_string($db, $name)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) != 0 && mysqli_fetch_assoc($result)["id"] != $packId) {
        return [FALSE, "Un paquet avec ce nom existe déjà."];
    }

    $result = mysqli_query($db, "UPDATE packs SET name = '"
        .mysqli_real_escape_string($db, $name)."', difficulty = '"
        .mysqli_real_escape_string($db, $difficulty)."', theme = '"
        .mysqli_real_escape_string($db, $theme)."', description = '"
        .mysqli_real_escape_string($db, $description)."' WHERE id = '"
        .mysqli_real_escape_string($db, $packId)."'");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return [TRUE, "Paquet de cartes modifié avec succès."];
}