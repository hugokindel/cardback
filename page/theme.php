<?php

use function cardback\system\checkAccountConnection;
use function cardback\system\getAllPacksOfTheme;
use function cardback\utility\changeTitle;
use function cardback\utility\getAnonymousNameFromAccount;
use function cardback\utility\getFormatedDate;
use function cardback\utility\redirect;

checkAccountConnection(TRUE);

if (!isset($_GET["id"]) || $_GET["id"] < 0 || $_GET["id"] >= count($themes)) {
    redirect("error/404");
}

changeTitle($themes[$_GET["id"]]);
?>

<main>
    <?php $getSidebar(-1); ?>
    <div
            id="page-main">
        <div
                id="content-title-container">
            <?php $getSearchBar(); ?>
        </div>
        <?php $getToolbar(); ?>
        <article
                id="content-main">
            <?php
            $packs = getAllPacksOfTheme($themes[$_GET["id"]], 1);

            if ($packs[0] == 1 && count($packs[1]) > 0) {
                ?>
                <section
                        class="section-cards">
                    <h3
                            class="theme-default-text">
                        Paquets de cartes du thème « <?php echo $themes[$_GET["id"]]; ?>»</h3>
                    <div
                            class="cards-container">
                        <?php
                        foreach ($packs[1] as $pack) {
                            $getCardPack(
                                $pack["name"],
                                getAnonymousNameFromAccount($pack),
                                getFormatedDate($pack["creationDate"]),
                                $serverUrl."pack?id=".$pack["id"]);
                        }
                        ?>
                    </div>
                </section>
                <br>
                <?php
            } else {
                ?>
                <section
                        class="section-cards">
                    <h3
                            class="theme-default-text">
                        Paquets de cartes du thème « <?php echo $themes[$_GET["id"]]; ?>»</h3>
                    <div
                            class="cards-container">
                        <h4
                                class="theme-default-text"
                                style="font-weight: 500;">
                            Il n'y a aucun paquets de cartes dans ce thème!</h4>
                    </div>
                </section>
                <br>
                <?php
            }
            ?>
        </article>
    </div>
</main>
