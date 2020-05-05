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
            echo \cardback\component\page\makeSearchBar();
            ?>
        </div>

        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <article id="content-main">
            <section style="width: 100%;">
                <h2 class="theme-default-text"><?php echo (date("H") >= 19 ?
                            "Bonsoir" :
                            "Bonjour").", ".\cardback\utility\getAnonymousNameFromAccount($account) ?>!</h2>
            </section>

            <?php
            $packs = \cardback\system\getAllPacksOfUser($account["id"], 1);

            if ($packs[0] == 0 || count($packs[1]) == 0) {
                ?>
                <section class="section-cards">
                    <h3 class="theme-default-text">Bienvenue sur <span style="font-weight: 900;">cardback</span>!</h3>
                    <h4 class="theme-default-text" style="font-weight: 500;">- Vous pouvez accéder aux différentes parties du site à l'aide du menu
                        latéral à votre gauche.</h4>
                    <h4 class="theme-default-text" style="font-weight: 500;">- Si vous souhaitez créer un paquet de carte, l'éditeur est
                        accessible à l'aide du bouton qui se situe<br> en haut à droite du site, vous ne pouvez pas le rater!</h4>
                    <h4 class="theme-default-text" style="font-weight: 500;">- Si vous avez ne serais-ce qu'une recommandation à nous faire, nous
                        vous prions de bien vouloir nous<br> contacter par notre espace de feedback.</h4>
                    <br>
                    <h4 class="theme-default-text" style="font-weight: 500;">Nous vous souhaitons un bon moment sur notre site.</h4>
                </section>
                <br>
                <?php
            }
            ?>

            <?php
            $packs = \cardback\system\getAllPacksFromAWeek(1);

            if ($packs[0] == 1 && count($packs[1]) > 0) {
                ?>
                <section class="section-cards">
                    <h3 class="theme-default-text">Paquets créés depuis une semaine</h3>
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
            }
            ?>

            <!-- TODO: Paquet créé depuis un mois -->
            <!-- TODO: Paquet récent dans le thème ... -->
            <!-- TODO: Paquet en tendance -->
        </article>
    </div>
</main>
