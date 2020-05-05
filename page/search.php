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
                    "Chercher un paquet",
                    $_GET["search"]);
            ?>
        </div>

        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <article id="content-main">
            <?php
            $packs = \cardback\system\searchPacks($_GET["search"]."%");

            if ($packs[0] == 1 && count($packs[1]) > 0) {
                ?>
                <section class="section-cards">
                    <h3 class="theme-default-text">Résultats</h3> <!-- TODO: pluriel -->
                    <div class="cards-container">
                        <?php
                        foreach ($packs[1] as $pack) {
                            echo \cardback\component\makeCardDetailed(
                                $pack["name"],
                                \cardback\utility\getAnonymousNameFromAccount($pack),
                                \cardback\utility\getFormatedDate($pack["creationDate"]),
                                $serverUrl . "/pack?id=" . $pack["id"]);
                        }
                        ?>
                    </div>
                </section>
                <br>
                <?php
            } else {
                ?>
                <section class="section-cards">
                    <h3 class="theme-default-text">Résultats</h3>
                    <div class="cards-container">
                        <h4 class="theme-default-text" style="font-weight: 500;">Il n'y a aucun résultats à votre recherche!</h4>
                    </div>
                </section>
                <br>
                <?php
            }
            ?>
        </article>
    </div>
</main>
