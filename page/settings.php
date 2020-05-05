<?php
\cardback\system\checkAccountConnection(TRUE);
\cardback\utility\changeTitle("Paramètres");
?>

<main>
    <?php
    echo \cardback\component\page\makeSidebar(3);
    ?>

    <div id="page-main">
        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <article id="content-settings-main">
            <?php
            echo \cardback\component\page\makeSettingsCategories(-1);
            ?>
        </article>
    </div>
</main>
