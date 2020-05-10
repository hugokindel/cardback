<?php

use function cardback\system\checkAccountConnection;
use function cardback\system\search;
use function cardback\utility\changeTitle;
use function cardback\utility\redirect;

checkAccountConnection(TRUE);

if (!isset($_GET["search"])) {
    redirect("explore");
}

changeTitle("Recherche de « ".$_GET["search"]." »");
?>

<main>
    <?php $getSidebar(-1); ?>

    <div
            id="page-main">
        <div
                id="content-title-container">
            <?php $getSearchBar($_GET["search"]); ?>
        </div>
        <?php $getToolbar();  ?>
        <article
                id="content-main">
            <?php
            $getSectionCards("Résultats",
                    [1, search($_GET["search"])],
                    TRUE,
                    TRUE,
                    "Il n'y a aucun résultat pour votre recherche");
          ?>
        </article>
    </div>
</main>
