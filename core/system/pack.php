<?php namespace cardback\system;
/**
 * Ce fichier contient les fonctions utilitaires relatives au système de paquets de cartes.
 */

use function cardback\database\delete;
use function cardback\database\insert;
use function cardback\database\select;
use function cardback\database\selectMaxId;
use function cardback\database\update;

/**
 * Vérifie si un paquet existe.
 *
 * @param string $name Nom du paquet.
 * @return int Résultat.
 */
function _checkPackExists($name) {
    $result = select("packs",
        "id",
        "WHERE name = '$name'");

    return $result[0] == 1 ? $result[1][0]["id"] : 0;
}

/**
 * Associe des données des créateurs des paquets à des paquets.
 *
 * @param array $packs Paquets.
 * @return array Résultat.
 */
function _associateAuthorToPack($packs) {
    $array = [];

    foreach ($packs as $pack) {
        $packId = $pack["id"];

        $result = select("userPacks",
            "userId",
        "WHERE packId = '$packId'")[1];

        $result = getAccount($result[0]["userId"])[1][0];

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

/**
 * Crée un paquet de cartes.
 *
 * @param string $userId ID du compte.
 * @param string $name Nom.
 * @param string $description Description.
 * @param string $difficulty Difficulté.
 * @param string $theme Thème.
 * @return array Résultat.
 */
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

    insert("packs",
        "name, difficulty, theme, creationDate, description",
        "'$name', '$difficulty', '$theme', '$creationDate', '$description'");

    $packId = selectMaxId("packs")[1];

    insert("userPacks",
        "userId, packId",
        "$userId, $packId");

    return [1];
}

/**
 * Publie un paquet.
 *
 * @param int $packId ID du paquet.
 */
function publishPack($packId) {
    update("packs",
        "published = 1",
        "WHERE id = $packId");
}

/**
 * Dépublie un paquet.
 *
 * @param int $packId ID du paquet.
 */
function unpublishPack($packId) {
    update("packs",
        "published = 0",
        "WHERE id = $packId");
}

/**
 * Change les données d'un paquet.
 *
 * @param int $packId ID du paquet.
 * @param string $name Nom.
 * @param string $description Description.
 * @param string $difficulty Difficulté.
 * @param string $theme Thème.
 * @return array Résultat.
 */
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

    update("packs",
        "name = '$name', description = '$description', difficulty = '$difficulty', theme = '$theme'",
        "WHERE id = $packId");

    return [1];
}

/**
 * Supprime un paquet.
 *
 * @param int $packId ID du paquet.
 */
function removePack($packId) {
    $result = getAllCardsOfPack($packId);

    print_r($result);

    if ($result[0] == 1) {
        foreach ($result[1] as $card) {
            removeCard($card["id"]);
        }
    }

    delete("packs", "WHERE id = '$packId'");
}

/**
 * Retourne les données d'un paquet.
 *
 * @param int $packId ID du paquet.
 * @return array Résultat.
 */
function getPack($packId) {
    $result = select("packs", "", "WHERE id = '$packId'");

    if ($result[0] == 0) {
        return $result;
    } else {
        return [1, _associateAuthorToPack($result[1])];
    }
}

/**
 * Retourne tous les paquets.
 *
 * @param int $published Définit si on veux les paquets publiés ou non, ou tous.
 * @return array Résultat.
 */
function getAllPacks($published = -1) {
    $result = select("packs",
        "",
        ($published != -1 ? "WHERE published = $published" : ""));

    if ($result[0] == 0) {
        return $result;
    } else {
        return [1, array_reverse(_associateAuthorToPack($result[1]))];
    }
}

/**
 * Cherche un paquet.
 *
 * @param string $name Nom.
 * @return array Résultat.
 */
function searchPacks($name) {
    $result = select("packs",
        "",
        "WHERE published = 1 AND name LIKE '$name%'");

    if ($result[0] == 0) {
        return $result;
    } else {
        return [1, _associateAuthorToPack($result[1])];
    }
}

/**
 * Cherche un thème.
 *
 * @param string $themeSearch Nom.
 * @return array Résultat.
 */
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

/**
 * Retourne tous les thèmes.
 *
 * @return array Résultat.
 */
function getAllThemes() {
    global $themes;

    $array = [];

    foreach ($themes as $id => $theme) {
        array_push($array, ["id" => $id, "name" => $theme, "type" => 1]);
    }

    return [1, $array];
}

/**
 * Retourne tous les paquets créés depuis un certains nombre de semaines.
 *
 * @param int $weeks Nombre de semaines.
 * @param int $published Définit si on veux les paquets publiés ou non, ou tous.
 * @return array Résultat.
 */
function getAllPacksFromWeeks($weeks = 1, $published = -1) {
    $result = select("packs",
        "",
        "WHERE creationDate BETWEEN DATE_ADD(now(), INTERVAL -".$weeks." WEEK) AND now()"
            .($published != -1 ? " AND published = $published" : ""));

    if ($result[0] == 0) {
        return $result;
    } else {
        return [1, array_reverse(_associateAuthorToPack($result[1]))];
    }
}

/**
 * Retourne tous les paquets d'un thème.
 *
 * @param string $theme Thème.
 * @param int $published Définit si on veux les paquets publiés ou non, ou tous.
 * @return array
 */
function getAllPacksOfTheme($theme, $published = -1) {
    $result = select("packs",
        "",
        "WHERE theme = '$theme'"
        .($published != -1 ? " AND published = $published" : ""));

    if ($result[0] == 0) {
        return $result;
    } else {
        return [1, array_reverse(_associateAuthorToPack($result[1]))];
    }
}

/**
 * Retourne tous les paquets d'un utilisateur.
 *
 * @param string $userId ID du compte.
 * @param int $published Définit si on veux les paquets publiés ou non, ou tous.
 * @return array
 */
function getAllPacksOfUser($userId, $published = -1) {
    $result = select("userPacks",
        "packId",
        "WHERE userId = '$userId'");

    if ($result[0] == 0) {
        return [0, "Aucun paquets de carte n'a été publié par cet utilisateur."];
    }

    $array = [];

    foreach ($result[1] as $userPack) {
        $userPack = $userPack["packId"];


        $pack = select("packs",
            "",
            "WHERE id = '$userPack'".($published != -1 ? " AND published = $published" : ""));

        if ($pack[0] == 1) {
            array_push($array, $pack[1][0]);
        }
    }

    return [1, array_reverse(_associateAuthorToPack($array))];
}

/**
 * Vérifie si un utilisateur est propriétaire d'un paquet.
 *
 * @param string $userId ID du compte.
 * @param int $packId ID du paquet.
 * @return bool Résultat.
 */
function checkUserOwnsPack($userId, $packId) {
    $result = select("userPacks",
        "",
        "WHERE userId = '$userId' AND packId = '$packId'");

    return $result[0] == 1;
}

/**
 * Crée une carte dans un paquet.
 *
 * @param int $packId ID du paquet.
 */
function createCard($packId) {
    insert("cards");

    $cardId = selectMaxId("cards")[1];

    insert("packCards",
        "packId, cardId",
        "$packId, $cardId");
}

/**
 * Supprime une carte d'un paquet.
 *
 * @param int $cardId ID d'une carte.
 */
function removeCard($cardId) {
    delete("cards",
        "WHERE id = '$cardId'");
}

/**
 * Confirme une carte d'un paquet.
 *
 * @param int $cardId ID d'une carte.
 */
function confirmCard($cardId, $question, $answer) {
    global $db;

    $question = mysqli_real_escape_string($db, $question);
    $answer = mysqli_real_escape_string($db, $answer);

    update("cards",
        "question = '$question', answer = '$answer', confirmed = 1",
        "WHERE id = '$cardId'");
}

/**
 * Déconfirme une carte d'un paquet.
 *
 * @param int $cardId ID d'une carte.
 */
function unconfirmCard($cardId) {
    update("cards",
        "confirmed = 0",
        "WHERE id = '$cardId'");
}

/**
 * Retourne toutes les cartes d'un paquet.
 *
 * @param int $packId ID du paquet.
 * @param int $confirmed Définis si on veut les confiremr ou non.
 * @return array Résultat.
 */
function getAllCardsOfPack($packId, $confirmed = -1) {
    $result = select("packCards",
        "cardId",
        "WHERE packId = '$packId'");

    if ($result[0] == 0) {
        return [0, "Aucune carte n'a été créé dans ce paquet de cartes."];
    }

    $array = [];

    foreach ($result[1] as $packCards) {
        $packCards = $packCards["cardId"];


        $pack = select("cards",
            "",
            "WHERE id = '$packCards'".($confirmed != -1 ? " AND confirmed = $confirmed" : ""));

        array_push($array, $pack[1][0]);
    }

    return [1, $array];
}

/**
 * Vérifie si un paquet est vide.
 *
 * @param array $packs Résultat de paquet.
 * @return bool Résultat.
 */
function isArrayEmpty($packs) {
    return $packs[0] == 0 || count($packs[1]) == 0;
}