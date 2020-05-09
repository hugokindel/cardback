<?php
\cardback\system\checkAccountConnection(TRUE);

if (!isset($_GET["search"])) {
    \cardback\utility\redirect("explore");
}

\cardback\utility\changeTitle("Recherche de « ".$_GET["search"]." »");
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
                    [1, \cardback\system\search($_GET["search"])],
                    TRUE,
                    TRUE,
                    "Il n'y a aucun résultat pour votre recherche");
          ?>
        </article>
    </div>
</main>
