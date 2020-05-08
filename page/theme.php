<?php
\cardback\system\checkAccountConnection(TRUE);

if (!isset($_GET["id"]) || $_GET["id"] < 0 || $_GET["id"] >= count($themes)) {
    \cardback\utility\redirect("404");
}



\cardback\utility\changeTitle($themes[$_GET["id"]]);
?>

<main>
    <?php
    echo \cardback\component\page\makeSidebar(-1);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <?php
            echo \cardback\component\page\makeSearchBar();
            ?>
        </div>

        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <article id="content-main">
            <?php
            $packs = \cardback\system\getAllPacksOfTheme($themes[$_GET["id"]], 1);

            if ($packs[0] == 1 && count($packs[1]) > 0) {
                ?>
                <section class="section-cards">
                    <h3 class="theme-default-text">Paquets de cartes du thème « <?php echo $themes[$_GET["id"]]; ?>»</h3>
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
                    <h3 class="theme-default-text">Paquets de cartes du thème « <?php echo $themes[$_GET["id"]]; ?>»</h3>
                    <div class="cards-container">
                        <h4 class="theme-default-text" style="font-weight: 500;">Il n'y a aucun résultats dans ce thème!</h4>
                    </div>
                </section>
                <br>
                <?php
            }
            ?>
        </article>
    </div>
</main>
