<?php namespace cardback\system;

// Vérifie si un paquet existe déjà
function _checkPackExists($name) {
    $result = \cardback\database\select("packs",
        "id",
        "WHERE name = '$name'");

    return $result[0] == 1;
}

// Associe le nom de l'auteur (obtenu dans la table 'users') à un paquet de cartes
function _associateAuthorToPack($packs) {
    $array = [];

    foreach ($packs as $pack) {
        $packId = $pack["id"];

        $result = \cardback\database\select("userPacks",
            "userId",
        "WHERE packId = '$packId'")[1];

        $result = \cardback\system\getAccount($result[0]["userId"])[1][0];

        $pack["author"] = $result["firstName"]." ".$result["lastName"];

        array_push($array, $pack);
    }

    return $array;
}

// Crée un paquet de cartes
function createPack($userId, $name, $description, $difficulty, $theme) {
    global $db;

    $name = mysqli_real_escape_string($db, $name);

    if (_checkPackExists($name)) {
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

// Publie un paquet de cartes
function publishPack($packId) {
    \cardback\database\update("packs",
        "published = 1",
        "WHERE id = $packId");
}

// Modifie un paquet de cartes
function changePack($packId, $name, $description, $difficulty, $theme) {
    global $db;

    $name = mysqli_real_escape_string($db, $name);

    if (_checkPackExists($name)) {
        return [0, "Un paquet avec ce nom existe déjà."];
    }

    $description = mysqli_real_escape_string($db, $description);
    $difficulty = mysqli_real_escape_string($db, $difficulty);
    $theme = mysqli_real_escape_string($db, $theme);

    \cardback\database\update("packs",
        "name = '$name', description = '$description', difficulty = '$difficulty', theme = '$theme'",
        "WHERE id = $packId");
}

// Supprime un paquet de cartes
function removePack($packId) {
    \cardback\database\delete("packs", "WHERE id = '$packId'");
}

// Retourne le contenu d'un paquet de cartes
function getPack($packId) {
    $result = \cardback\database\select("packs", "", "WHERE id = '$packId'");

    if ($result == 0) {
        return $result;
    } else {
        return [1, _associateAuthorToPack($result[1])];
    }
}

// Retourne le contenu de tous les paquets de cartes
function getAllPacks($published = -1) {
    $result = \cardback\database\select("packs",
        "",
        ($published != -1 ? "WHERE published = $published" : ""));

    if ($result == 0) {
        return $result;
    } else {
        return [1, _associateAuthorToPack($result[1])];
    }
}

// Retourne le contenu de tous les paquets créé dans les 7 derniers jours
function getAllPacksFromAWeek($published = -1) {
    $result = \cardback\database\select("packs",
        "",
        "WHERE creationDate BETWEEN DATE_ADD(now(), INTERVAL -1 WEEK) AND now()"
            .($published != -1 ? " AND published = $published" : ""));

    if ($result == 0) {
        return $result;
    } else {
        return [1, _associateAuthorToPack($result[1])];
    }
}

// Retourne tous les paquets de cartes publiés créé par l'utilisateur
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

        array_push($array, $pack[1][0]);
    }

    return [1, _associateAuthorToPack($array)];
}

// Vérifie si un utilisateur est l'auteur d'un paquet de cartes ou non
function checkUserOwnsPack($userId, $packId) {
    $result = \cardback\database\select("userPacks",
        "",
        "WHERE userId = '$userId' AND packId = '$packId'");

    return $result[0] == 1;
}

// Crée une carte
function createCard($packId) {
    \cardback\database\insert("cards");

    $cardId = \cardback\database\selectMaxId("cards")[1];

    \cardback\database\insert("packCards",
        "packId, cardId",
        "$packId, $cardId");
}

// Supprime une carte
function removeCard($cardId) {
    \cardback\database\delete("cards",
        "WHERE id = '$cardId'");
}

// Valide une carte
function confirmCard($cardId, $question, $answer) {
    global $db;

    $question = mysqli_real_escape_string($db, $question);
    $answer = mysqli_real_escape_string($db, $answer);

    \cardback\database\update("cards",
        "question = '$question', answer = '$answer', confirmed = 1",
        "WHERE id = '$cardId'");
}

// Invalide une carte (pour la rendre modifiable par l'utilisateur)
function unconfirmCard($cardId) {
    \cardback\database\update("cards",
        "confirmed = 0",
        "WHERE id = '$cardId'");
}

// Retourne le contenu de toutes les cartes d'un paquet de cartes
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