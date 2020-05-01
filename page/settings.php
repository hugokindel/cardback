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

        <article id="content-main">

        </article>
    </div>
</main>
