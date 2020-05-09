<?php namespace cardback\system;

function search($text, $pack = TRUE, $theme = TRUE, $account = TRUE) {
    $packsSearch = $pack ? \cardback\system\searchPacks($text) : [0 => 0];
    $themesSearch = $theme ? \cardback\system\searchTheme($text) : [0 => 0];
    $accountSearch = $account ? \cardback\system\searchAccount($text) : [0 => 0];

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
                $accountSearch[1][$i]["name"] = \cardback\utility\getAnonymousNameFromAccount($accountSearch[1][$i]);
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