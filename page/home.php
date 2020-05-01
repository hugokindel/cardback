<?php
\cardback\system\checkAccountConnection(TRUE);
\cardback\utility\changeTitle("Accueil");
?>

<main>
    <?php
    echo \cardback\component\page\makeSidebar(0);
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
            <section style="width: 100%;">
                <h2><?php echo (date("H") >= 19 ?
                            "Bonsoir" :
                            "Bonjour").", ".$accountData["firstName"]." ".$accountData["lastName"] ?></h2>
            </section>

            <?php
            $packs = \cardback\system\getAllPacksFromAWeek();

            if ($packs[0] == 1 && count($packs[1]) > 0):
                ?>
                <section class="section-cards">
                    <h3>Paquets créés depuis une semaine</h3>
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

            <!-- TODO: Paquet créé depuis un mois -->
            <!-- TODO: Paquet récent dans le thème ... -->
            <!-- TODO: Paquet en tendance -->
        </article>
    </div>
</main>
