<?php
\cardback\system\checkAccountConnection(TRUE);
\cardback\utility\changeTitle("Paramètres");
?>

<main>
    <?php  $getSidebar(3); ?>

    <div
            id="page-main">
        <?php $getToolbar(); ?>
        <article
                id="content-settings-main">
            <?php $getSettings(); ?>
        </article>
    </div>
</main>
