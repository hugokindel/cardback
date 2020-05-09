<?php namespace cardback\database;

$db = NULL;

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

function disconnect() {
    global $db;

    $result = mysqli_close($db);

    if (!$result) {
        echo mysqli_error($db);
        exit;
    }

    $db = NULL;
}

function _checkResult($result) {
    global $db;

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }
}

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

function selectMinId($table) {
    $result = select($table, "MIN(id)");

    return [$result[0], $result[0] == 0 ? $result[1] : $result[1][0]["MIN(id)"]];
}

function selectMaxId($table) {
    $result = select($table, "MAX(id)");

    return [$result[0], $result[0] == 0 ? $result[1] : $result[1][0]["MAX(id)"]];
}

function insert($table, $rows = "", $values = "") {
    global $db;

    $result = mysqli_query($db, "INSERT INTO $table ($rows) VALUES ($values)");

    _checkResult($result);
}

function update($table, $values, $conditions = "") {
    global $db;

    $result = mysqli_query($db, "UPDATE $table SET $values $conditions");

    _checkResult($result);
}

function delete($table, $conditions = "") {
    global $db;

    $result = mysqli_query($db, "DELETE FROM $table $conditions");

    _checkResult($result);
}