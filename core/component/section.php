<?php
/**
 * Ce fichier contient les fonctions relatives aux bloc de section.
 */

use function cardback\system\isArrayEmpty;
use function cardback\utility\getAnonymousNameFromAccount;
use function cardback\utility\getFormatedDate;

/**
 * Crée un bloc de section de cartes.
 *
 * @param string $text Nom de la section
 * @param array $cards Liste des cartes à afficher.
 * Il y a 3 types de cartes possibles:
 *   - Paquets de cartes ("type" = 0).
 *   - Thème ("type" = 1).
 *   - Compte ("type" = 2).
 * @param bool $showDetails Définit si on doit insérer le texte de détail lorsque c'est nécessaire:
 * Ce texte permet de différencier les compte et les paquets de cartes dans le système de recherche.
 * @param bool $showNoResults Définit si on doit afficher un bloc de section lorsqu'il n'y a pas de résultats.
 * @param string $noResultText Texte à afficher si il n'y a pas de résultat dans le bloc correspondant.
 */
$getSectionCards = function($text, $cards, $showDetails = TRUE, $showNoResults = FALSE, $noResultText = "") {
    global $serverUrl;
    global $getCard;
    global $getCardPack;

    if (!isArrayEmpty($cards)) {
        ?>
        <section
                class="section-cards">
            <h3
                    class="theme-default-text">
                <?php echo $text; ?></h3>
            <div
                    class="cards-container">
                <?php
                foreach ($cards[1] as $card) {
                    if (!isset($card["type"]) || $card["type"] == 0) {
                        $link = $card["published"] == 1 ? "pack" : "editor";
                        $getCardPack($card["name"],
                                getAnonymousNameFromAccount($card),
                                getFormatedDate($card["creationDate"]),
                                $serverUrl . "$link?id=" . $card["id"]);
                    } else if ($card["type"] == 1) {
                        $detail = $showDetails ? "Thème" : "";
                        $getCard($card["name"]."<br>$detail",
                                "Voulez vous accéder<br>à ce thème?",
                                TRUE, "",
                                $serverUrl."theme?id=".$card["id"]);
                    } else {
                        $detail = $showDetails ? ($card["admin"] == 1 ? "Administrateur" : "Utilisateur") : "";
                        $getCard(getAnonymousNameFromAccount($card)."<br>$detail",
                                "Voulez vous accéder<br>à ce profil?",
                                TRUE, "",
                                $serverUrl."profile?id=".$card["id"]);
                    }
                }
                ?>
            </div>
        </section>
        <br>
        <?php
    } else if ($showNoResults) {
        ?>
        <section
                class="section-cards">
            <h3
                    class="theme-default-text">
                <?php echo $text; ?></h3>
            <div
                    class="cards-container">
                <h4
                        class="theme-default-text" style="font-weight: 500;">
                    <?php echo $noResultText; ?></h4>
            </div>
        </section>
        <br>
        <?php
    }
};