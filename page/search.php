<?php
\cardback\system\checkAccountConnection(TRUE);

if (!isset($_GET["search"])) {
    \cardback\utility\redirect("explore");
}

\cardback\utility\changeTitle("Recherche de « ".$_GET["search"]." »");
?>

<main>
    <?php
    echo \cardback\component\page\makeSidebar(-1);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <?php
            echo \cardback\component\page\makeSearchBar(
                    "Chercher un de vos paquet ou un thème",
                    $_GET["search"]);
            ?>
        </div>

        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <article id="content-main">
            <?php
            $packs = \cardback\system\getAllPacks(1);

            if (count($packs) > 0):
                ?>
                <section class="section-cards">
                    <h3>Résultats</h3> <!-- TODO: pluriel -->
                    <div class="cards-container">
                        <?php
                        foreach ($packs as $pack) {
                            echo \cardback\component\makeCardDetailed(
                                $pack["name"],
                                $pack["author"],
                                \cardback\utility\getFormatedDate($pack["creationDate"]),
                                $serverUrl."/pack?id=".$pack["id"]);
                        }
                        ?>
                    </div>
                </section>
                <br>
            <?php
            endif;
            ?>
        </article>
    </div>
</main>
