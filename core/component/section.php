<?php

// TODO: User
$getSectionCards = function($text, $cards, $showDetails = TRUE, $showNoResults = FALSE, $noResultText = "") {
    global $serverUrl;
    global $getCard;
    global $getCardPack;

    if (!\cardback\system\isArrayEmpty($cards)) {
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
                                \cardback\utility\getAnonymousNameFromAccount($card),
                                \cardback\utility\getFormatedDate($card["creationDate"]),
                                $serverUrl . "$link?id=" . $card["id"]);
                    } else if ($card["type"] == 1) {
                        $detail = $showDetails ? "Thème" : "";
                        $getCard($card["name"]."<br>$detail",
                                "Voulez vous accéder<br>à ce thème?",
                                TRUE, "",
                                $serverUrl."theme?id=".$card["id"]);
                    } else {
                        $detail = $showDetails ? ($card["admin"] == 1 ? "Administrateur" : "Utilisateur") : "";
                        $getCard(\cardback\utility\getAnonymousNameFromAccount($card)."<br>$detail",
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