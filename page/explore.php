<?php
\cardback\system\checkAccountConnection(TRUE);
\cardback\utility\changeTitle("Explorer");
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
            $allThemes = \cardback\system\getAllThemes();
            $getSectionCards("Tous les thèmes", $allThemes, FALSE);

            $allPacks = \cardback\system\getAllPacks(1);
            $getSectionCards("Tous les paquets de cartes", $allPacks);

            if ($account["admin"] == 1) {
                $allUsers = \cardback\system\getAllAccounts();
                $getSectionCards("Tous les utilisateurs", $allUsers);
            }
            ?>
        </article>
    </div>
</main>
