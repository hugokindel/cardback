<?php namespace cardback\database;

// Variable contenant la connexion à la base de donnée
$db = NULL;

// Fonction de connexion à la base de donnée
function connect() {
    global $db;
    global $dbHost;
    global $dbUser;
    global $dbPassword;
    global $dbBase;
    global $dbPort;

    $db = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbBase, $dbPort);

    if (!$db) {
        echo mysqli_connect_error();
        exit;
    }
}

// Fonction de déconnexion à la base de donnée
function disconnect() {
    global $db;

    $result = mysqli_close($db);

    if (!$result) {
        echo mysqli_error($db);
        exit;
    }

    $db = NULL;
}

// Fonction interne pour vérifier le résultat d'une requête MySQL
function _checkResult($result) {
    global $db;

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }
}

// Fonction SELECT
function select($table, $rows = "", $conditions = "") {
    global $db;

    $rows = $rows != "" ? $rows : "*";
    $result = mysqli_query($db, "SELECT $rows FROM $table $conditions");

    _checkResult($result);

    if (mysqli_num_rows($result) == 0) {
        return [0, "Il n'y a aucune entrée correspondante "
            .($conditions != "" ? "aux conditions '$conditions'" : "")
            ."dans la table '$table' pour obtenir les valeurs '$rows'"];
    }

    $array = [];

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($array, $row);
    }

    return [1, $array];
}

// Fonction SELECT pour obtenir le plus petit ID
function selectMinId($table) {
    $result = select($table, "MIN(id)");

    return [$result[0], $result[0] == 0 ? $result[1] : $result[1][0]["MIN(id)"]];
}

// Fonction SELECT pour obtenir le plus grand ID
function selectMaxId($table) {
    $result = select($table, "MAX(id)");

    return [$result[0], $result[0] == 0 ? $result[1] : $result[1][0]["MAX(id)"]];
}

// Fonction INSERT
function insert($table, $rows = "", $values = "") {
    global $db;

    $result = mysqli_query($db, "INSERT INTO $table ($rows) VALUES ($values)");

    _checkResult($result);
}

// Fonction UPDATE
function update($table, $values, $conditions = "") {
    global $db;

    $result = mysqli_query($db, "UPDATE $table SET $values $conditions");

    _checkResult($result);
}

// Fonction DELETE
function delete($table, $conditions = "") {
    global $db;

    $result = mysqli_query($db, "DELETE FROM $table $conditions");

    _checkResult($result);
}