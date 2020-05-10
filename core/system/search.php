<?php namespace cardback\system;
/**
 * Ce fichier contient les fonctions utilitaires relatives au système de recherches.
 */

use function cardback\utility\getAnonymousNameFromAccount;

/**
 * Fait une recherche global (paquets, thèmes, comptes)
 * Les recherches sont ordonnés alphabétiquement.
 *
 * @param string $text Texte à chercher.
 * @param bool $pack Définit si on recherche les paquets.
 * @param bool $theme  Définit si on recherche les thèmes.
 * @param bool $account  Définit si on recherche les comptes.
 * @return array Résultats.
 */
function search($text, $pack = TRUE, $theme = TRUE, $account = TRUE) {
    $packsSearch = $pack ? searchPacks($text) : [0 => 0];
    $themesSearch = $theme ? searchTheme($text) : [0 => 0];
    $accountSearch = $account ? searchAccount($text) : [0 => 0];

    if ($packsSearch[0] == 1) {
        for ($i = 0; $i < count($packsSearch[1]); $i++) {
            $packsSearch[1][$i]["type"] = 0;
        }
    }
    if ($themesSearch[0] == 1) {
        for ($i = 0; $i < count($themesSearch[1]); $i++) {
            $themesSearch[1][$i]["type"] = 1;
        }
    }
    if ($accountSearch[0] == 1) {
        for ($i = 0; $i < count($accountSearch[1]); $i++) {
            if ($accountSearch[1][$i]["hideInSearch"] == 1 && $_SESSION["admin"] == 0) {
                unset($accountSearch[1][$i]);
            } else {
                $accountSearch[1][$i]["type"] = 2;
                $accountSearch[1][$i]["name"] = getAnonymousNameFromAccount($accountSearch[1][$i]);
            }
        }
    }

    $allSearch = array_merge(
        $packsSearch[0] == 1 ? $packsSearch[1] : [],
        $themesSearch[0] == 1 ? $themesSearch[1] : [],
        $accountSearch[0] == 1 ? $accountSearch[1] : []);

    $nameColumn = array_column($allSearch, "name");

    array_multisort($nameColumn, SORT_ASC, $allSearch);

    return $allSearch;
}