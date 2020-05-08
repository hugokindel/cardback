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
            $unpublishedPacks = \cardback\system\getAllPacksOfUser($_SESSION["accountId"], 0);

            if ($unpublishedPacks[0] == 1 && count($unpublishedPacks[1]) > 0) {
                ?>
                <section class="section-cards">
                    <h3 class="theme-default-text">Paquets de cartes en cours de création</h3>
                    <div class="cards-container">
                        <?php
                        foreach ($unpublishedPacks[1] as $pack) {
                            echo \cardback\component\makeCardDetailed($pack["name"],
                                \cardback\utility\getAnonymousNameFromAccount($account),
                                \cardback\utility\getFormatedDate($pack["creationDate"]),
                                $serverUrl . "/editor?id=" . $pack["id"],
                                "Voulez-vous continuer à créer ce paquet?");
                        }
                        ?>
                    </div>
                </section>
                <br>
                <?php
            }
            ?>

            <?php
            $packs = \cardback\system\getAllPacksFromWeeks(1, 1);

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
            } else {
                $packs = \cardback\system\getAllPacksFromWeeks(4, 1);

                if ($packs[0] == 1 && count($packs[1]) > 0) {
                    ?>
                    <section class="section-cards">
                        <h3 class="theme-default-text">Paquets créés depuis un mois</h3>
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
            }
            ?>

            <?php
            $themesArray = [0 => rand(0, 6), 1 => 0, 2 => 0];
            do {
                $themesArray[1] = rand(0, 6);
            } while ($themesArray[1] == $themesArray[0]);
            do {
                $themesArray[2] = rand(0, 6);
            } while ($themesArray[2] == $themesArray[1] || $themesArray[2] == $themesArray[0]);

            foreach ($themesArray as $themeId) {
                $themePack = \cardback\system\getAllPacksOfTheme($themes[$themeId], 0);

                if ($themePack[0] == 1 && count($themePack[1]) > 0) {
                    ?>
                    <section class="section-cards">
                        <h3 class="theme-default-text">Paquets de cartes dans le thème « <?php echo $themes[$themeId]; ?> »</h3>
                        <div class="cards-container">
                            <?php
                            foreach ($themePack[1] as $pack) {
                                echo \cardback\component\makeCardDetailed($pack["name"],
                                    \cardback\utility\getAnonymousNameFromAccount($account),
                                    \cardback\utility\getFormatedDate($pack["creationDate"]),
                                    $serverUrl . "/editor?id=" . $pack["id"],
                                    "Voulez-vous continuer à créer ce paquet?");
                            }
                            ?>
                        </div>
                    </section>
                    <br>
                    <?php
                }
            }
            ?>
        </article>
    </div>
</main>
