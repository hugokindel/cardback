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
            echo \cardback\component\page\makeSearchBar();
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
                    <h3 class="theme-default-text">Tout</h3>
                    <div class="cards-container">
                        <?php
                        foreach ($packs[1] as $pack) {
                            echo \cardback\component\makeCardDetailed(
                                $pack["name"],
                                \cardback\utility\getAnonymousNameFromAccount($pack),
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
