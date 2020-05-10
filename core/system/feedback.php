<?php namespace cardback\system;
/**
 * Ce fichier contient les fonctions utilitaires relatives au système de feedback.
 */

use function cardback\database\insert;
use function cardback\database\select;
use function cardback\database\selectMaxId;

/**
 * Crée un feedback.
 *
 * @param string $userId ID du compte.
 * @param string $message Message.
 * @param bool $recommended Recommandé ou non.
 */
function createFeedback($userId, $message, $recommended) {
    global $db;

    $message = mysqli_real_escape_string($db, $message);
    $recommended = $recommended ? "1" : "0";
    $creationDate = date("Y-m-d");

    insert("feedbacks",
        "message, recommended, creationDate",
        "'$message', $recommended, '$creationDate'");

    $feedbackId = selectMaxId("feedbacks")[1];

    insert("userFeedbacks",
        "userId, feedbackId",
        "$userId, $feedbackId");
}

/**
 * Sélectionne un feedback.
 *
 * @param string $feedbackId ID du feedback.
 * @return array Résultat.
 */
function getFeedback($feedbackId) {
    return select(
            "feedbacks",
            "",
            "WHERE id = '$feedbackId'");
}