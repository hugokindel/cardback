<?php

use function cardback\system\checkAccountConnection;
use function cardback\utility\changeTitle;

checkAccountConnection(TRUE);
changeTitle("Paramètres");
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
