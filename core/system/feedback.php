<?php namespace cardback\system;

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

function getFeedback($feedbackId) {
    return \cardback\database\select("feedbacks", "", "WHERE id = '$feedbackId'");
}