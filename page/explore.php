<?php

use function cardback\system\checkAccountConnection;
use function cardback\system\getAllAccounts;
use function cardback\system\getAllPacks;
use function cardback\system\getAllThemes;
use function cardback\utility\changeTitle;

checkAccountConnection(TRUE);
changeTitle("Explorer");
?>

<main>
    <?php $getSidebar(1); ?>
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
            $allThemes = getAllThemes();
            $getSectionCards("Tous les thèmes", $allThemes, FALSE);

            $allPacks = getAllPacks(1);
            $getSectionCards("Tous les paquets de cartes", $allPacks);

            if ($account["admin"] == 1) {
                $allUsers = getAllAccounts();
                $getSectionCards("Tous les utilisateurs", $allUsers);
            }
            ?>
        </article>
    </div>
</main>
