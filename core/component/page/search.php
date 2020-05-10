<?php
/**
 * Ce fichier contient les fonctions à la barre de recherche?
 */

/**
 * Crée une barre de recherche.
 *
 * @param string $value Valeur à afficher.
 */
$getSearchBar = function($value = "") {
    global $getTextbox;

    ?>
    <div
            id="search-main">
        <?php
        $getTextbox(
                "search",
                "text",
                "Chercher un paquet, un thème ou un utilisateur...",
                "􀊫",
                $value);
        ?>
    </div>
    <?php
};