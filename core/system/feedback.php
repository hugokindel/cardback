<?php namespace cardback\system;

// Crée un feedback
function createFeedback($userId, $message, $recommended) {
    global $db;

    $message = mysqli_real_escape_string($db, $message);
    $recommended = $recommended ? "1" : "0";
    $creationDate = date("Y-m-d");

    \cardback\database\insert("feedbacks",
        "message, recommended, creationDate",
        "'$message', $recommended, '$creationDate'");

    $feedbackId = \cardback\database\selectMaxId("feedbacks")[1];

    \cardback\database\insert("userFeedbacks",
        "userId, feedbackId",
        "$userId, $feedbackId");
}

// Retourne le contenu d'un feedback
function getFeedback($feedbackId) {
    return \cardback\database\select("feedbacks", "", "WHERE id = '$feedbackId'");
}