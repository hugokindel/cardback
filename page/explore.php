<?php
\cardback\system\checkAccountConnection(TRUE);
\cardback\utility\changeTitle("Explorer");
?>

<main>
    <?php
    echo \cardback\component\page\makeSidebar(1);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <?php
            echo \cardback\component\page\makeSearchBar("Chercher un de vos paquet ou un thème");
            ?>
        </div>

        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <article id="content-main">
            <?php
            $packs = \cardback\system\getAllPacks(1);

            if ($packs[0] == 1 && count($packs[1]) > 0):
                ?>
                <section class="section-cards">
                    <h3>Tout</h3>
                    <div class="cards-container">
                        <?php
                        foreach ($packs[1] as $pack) {
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
