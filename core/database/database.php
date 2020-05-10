<?php namespace cardback\database;
/**
 * Ce fichier contient les fonctions utilitaires relatives à la base de donnée.
 */

/** @var \mysqli $db Connexion à la base de donnée. */
$db = NULL;

/**
 * Connecte la base de donnée.
 */
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

/**
 * Déconnecte la base de donnée.
 */
function disconnect() {
    global $db;

    $result = mysqli_close($db);

    if (!$result) {
        echo mysqli_error($db);
        exit;
    }

    $db = NULL;
}

/**
 * Fonction interne, pour vérifier le résultat d'une requête.
 *
 * @param \mysqli_result $result Résultat d'une requête.
 */
function _checkResult($result) {
    global $db;

    if (!$result) {
        echo mysqli_error($db);
        mysqli_close($db);
        exit;
    }
}

/**
 * Sélectionne les valeurs voulus dans une table de la base de donnée.
 *
 * @param string $table Table à sélectionner.
 * @param string $rows Valeurs à sélectionner.
 * @param string $conditions Condition à vérifier.
 * @return array Résultat de la sélection.
 */
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

/**
 * Sélectionne l'ID minimale dans une table.
 *
 * @param string $table Table à sélectionner.
 * @return array Résultat de la sélection.
 */
function selectMinId($table) {
    $result = select($table, "MIN(id)");

    return [$result[0], $result[0] == 0 ? $result[1] : $result[1][0]["MIN(id)"]];
}

/**
 * Sélectionne l'ID maximale dans une table.
 *
 * @param string $table Table à sélectionner.
 * @return array Résultat de la sélection.
 */
function selectMaxId($table) {
    $result = select($table, "MAX(id)");

    return [$result[0], $result[0] == 0 ? $result[1] : $result[1][0]["MAX(id)"]];
}

/**
 * Insère les valeurs voulus dans une table.
 *
 * @param string $table Table à sélectionner.
 * @param string $rows Nom des valeurs à insérer.
 * @param string $values Valeurs à insérer.
 */
function insert($table, $rows = "", $values = "") {
    global $db;

    $result = mysqli_query($db, "INSERT INTO $table ($rows) VALUES ($values)");

    _checkResult($result);
}

/**
 * Met à jour les valeurs voulus dans une table.
 *
 * @param string $table Table à sélectionner.
 * @param string $values Valeurs à mettre à jour.
 * @param string $conditions Condition à respecter.
 */
function update($table, $values, $conditions = "") {
    global $db;

    $result = mysqli_query($db, "UPDATE $table SET $values $conditions");

    _checkResult($result);
}

/**
 * Supprime les valeurs voulus dans une table.
 *
 * @param string $table Table à sélectionner.
 * @param string $conditions Condition à respecter.
 */
function delete($table, $conditions = "") {
    global $db;

    $result = mysqli_query($db, "DELETE FROM $table $conditions");

    _checkResult($result);
}