<?php

function getLastFeedbackId() {
    global $db;

    $result = mysqli_query($db, "SELECT MAX(id) FROM feedbacks");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    if (mysqli_num_rows($result) == 0) {
        return [FALSE, "Il n'y a aucun feedback dans la base de donnée."];
    }

    return [TRUE, mysqli_fetch_assoc($result)["MAX(id)"]];
}

function createFeedback($userId, $message, $recommended) {
    global $db;

    $result = mysqli_query($db, "INSERT INTO feedbacks (message, recommended, creationDate) VALUES ('"
        .mysqli_real_escape_string($db, $message)."','"
        .($recommended ? "1" : "0")."','"
        .date("Y-m-d")."')");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    $result = mysqli_query($db, "INSERT INTO userFeedbacks (userId, feedbackId) VALUES ("
        .$userId.","
        .getLastFeedbackId()[1].")");

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }

    return [TRUE, "Feedback créé avec succès."];
}