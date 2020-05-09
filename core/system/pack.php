<?php namespace cardback\system;

function _checkPackExists($name) {
    $result = \cardback\database\select("packs",
        "id",
        "WHERE name = '$name'");

    return $result[0] == 1 ? $result[1][0]["id"] : 0;
}

function _associateAuthorToPack($packs) {
    $array = [];

    foreach ($packs as $pack) {
        $packId = $pack["id"];

        $result = \cardback\database\select("userPacks",
            "userId",
        "WHERE packId = '$packId'")[1];

        $result = \cardback\system\getAccount($result[0]["userId"])[1][0];

        $pack["firstName"] = $result["firstName"];
        $pack["lastName"] = $result["lastName"];
        $pack["hideFirstName"] = $result["hideFirstName"];
        $pack["hideLastName"] = $result["hideLastName"];
        $pack["author"] = $result["firstName"]." ".$result["lastName"];
        $pack["authorId"] = $result["id"];

        array_push($array, $pack);
    }

    return $array;
}

function createPack($userId, $name, $description, $difficulty, $theme) {
    global $db;

    $name = mysqli_real_escape_string($db, $name);

    if (_checkPackExists($name) > 0) {
        return [0, "Un paquet avec ce nom existe déjà."];
    }

    $description = mysqli_real_escape_string($db, $description);
    $difficulty = mysqli_real_escape_string($db, $difficulty);
    $theme = mysqli_real_escape_string($db, $theme);
    $creationDate = date("Y-m-d");

    \cardback\database\insert("packs",
        "name, difficulty, theme, creationDate, description",
        "'$name', '$difficulty', '$theme', '$creationDate', '$description'");

    $packId = \cardback\database\selectMaxId("packs")[1];

    \cardback\database\insert("userPacks",
        "userId, packId",
        "$userId, $packId");

    return [1];
}

function publishPack($packId) {
    \cardback\database\update("packs",
        "published = 1",
        "WHERE id = $packId");
}

function unpublishPack($packId) {
    \cardback\database\update("packs",
        "published = 0",
        "WHERE id = $packId");
}

function changePack($packId, $name, $description, $difficulty, $theme) {
    global $db;

    $name = mysqli_real_escape_string($db, $name);
    $packExists = _checkPackExists($name);

    if ($packExists > 0 && $packExists != $packId) {
        return [0, "Un paquet avec ce nom existe déjà."];
    }

    $description = mysqli_real_escape_string($db, $description);
    $difficulty = mysqli_real_escape_string($db, $difficulty);
    $theme = mysqli_real_escape_string($db, $theme);

    \cardback\database\update("packs",
        "name = '$name', description = '$description', difficulty = '$difficulty', theme = '$theme'",
        "WHERE id = $packId");

    return [1];
}

function removePack($packId) {
    $result = getAllCardsOfPack($packId);

    print_r($result);

    if ($result[0] == 1) {
        foreach ($result[1] as $card) {
            removeCard($card["id"]);
        }
    }

    \cardback\database\delete("packs", "WHERE id = '$packId'");
}

function getPack($packId) {
    $result = \cardback\database\select("packs", "", "WHERE id = '$packId'");

    if ($result[0] == 0) {
        return $result;
    } else {
        return [1, _associateAuthorToPack($result[1])];
    }
}

function getAllPacks($published = -1) {
    $result = \cardback\database\select("packs",
        "",
        ($published != -1 ? "WHERE published = $published" : ""));

    if ($result[0] == 0) {
        return $result;
    } else {
        return [1, array_reverse(_associateAuthorToPack($result[1]))];
    }
}

function searchPacks($name) {
    $result = \cardback\database\select("packs",
        "",
        "WHERE published = 1 AND name LIKE '$name%'");

    if ($result[0] == 0) {
        return $result;
    } else {
        return [1, _associateAuthorToPack($result[1])];
    }
}

function searchTheme($themeSearch) {
    global $themes;

    $array = [];

    foreach ($themes as $id => $theme) {
        if (preg_match('/^'.strtolower($themeSearch).'/', strtolower($theme))) {
            array_push($array, ["id" => $id, "name" => $theme]);
        }
    }

    if (count($array) == 0) {
        $array = [0, "Il n'y a aucune entrée correspondantes aux conditions '$themeSearch%' pour obtenir les thèmes."];
    } else {
        $array = [1, $array];
    }

    return $array;
}

function getAllThemes() {
    global $themes;

    $array = [];

    foreach ($themes as $id => $theme) {
        array_push($array, ["id" => $id, "name" => $theme, "type" => 1]);
    }

    return [1, $array];
}

function getAllPacksFromWeeks($weeks = 1, $published = -1) {
    $result = \cardback\database\select("packs",
        "",
        "WHERE creationDate BETWEEN DATE_ADD(now(), INTERVAL -".$weeks." WEEK) AND now()"
            .($published != -1 ? " AND published = $published" : ""));

    if ($result[0] == 0) {
        return $result;
    } else {
        return [1, array_reverse(_associateAuthorToPack($result[1]))];
    }
}

function getAllPacksOfTheme($theme, $published = -1) {
    $result = \cardback\database\select("packs",
        "",
        "WHERE theme = '$theme'"
        .($published != -1 ? " AND published = $published" : ""));

    if ($result[0] == 0) {
        return $result;
    } else {
        return [1, array_reverse(_associateAuthorToPack($result[1]))];
    }
}

function getAllPacksOfUser($userId, $published = -1) {
    $result = \cardback\database\select("userPacks",
        "packId",
        "WHERE userId = '$userId'");

    if ($result[0] == 0) {
        return [0, "Aucun paquets de carte n'a été publié par cet utilisateur."];
    }

    $array = [];

    foreach ($result[1] as $userPack) {
        $userPack = $userPack["packId"];


        $pack = \cardback\database\select("packs",
            "",
            "WHERE id = '$userPack'".($published != -1 ? " AND published = $published" : ""));

        if ($pack[0] == 1) {
            array_push($array, $pack[1][0]);
        }
    }

    return [1, array_reverse(_associateAuthorToPack($array))];
}

function checkUserOwnsPack($userId, $packId) {
    $result = \cardback\database\select("userPacks",
        "",
        "WHERE userId = '$userId' AND packId = '$packId'");

    return $result[0] == 1;
}

function createCard($packId) {
    \cardback\database\insert("cards");

    $cardId = \cardback\database\selectMaxId("cards")[1];

    \cardback\database\insert("packCards",
        "packId, cardId",
        "$packId, $cardId");
}

function removeCard($cardId) {
    \cardback\database\delete("cards",
        "WHERE id = '$cardId'");
}

function confirmCard($cardId, $question, $answer) {
    global $db;

    $question = mysqli_real_escape_string($db, $question);
    $answer = mysqli_real_escape_string($db, $answer);

    \cardback\database\update("cards",
        "question = '$question', answer = '$answer', confirmed = 1",
        "WHERE id = '$cardId'");
}

function unconfirmCard($cardId) {
    \cardback\database\update("cards",
        "confirmed = 0",
        "WHERE id = '$cardId'");
}

function getAllCardsOfPack($packId, $confirmed = -1) {
    $result = \cardback\database\select("packCards",
        "cardId",
        "WHERE packId = '$packId'");

    if ($result[0] == 0) {
        return [0, "Aucune carte n'a été créé dans ce paquet de cartes."];
    }

    $array = [];

    foreach ($result[1] as $packCards) {
        $packCards = $packCards["cardId"];


        $pack = \cardback\database\select("cards",
            "",
            "WHERE id = '$packCards'".($confirmed != -1 ? " AND confirmed = $confirmed" : ""));

        array_push($array, $pack[1][0]);
    }

    return [1, $array];
}

function isArrayEmpty($packs) {
    return $packs[0] == 0 || count($packs[1]) == 0;
}