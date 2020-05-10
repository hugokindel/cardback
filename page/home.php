<?php
\cardback\system\checkAccountConnection(TRUE);
\cardback\utility\changeTitle("Accueil");
?>

<main>
    <?php $getSidebar(0); ?>
    <div
            id="page-main">
        <div
                id="content-title-container">
            <?php $getSearchBar(); ?>
        </div>
        <?php $getToolbar(); ?>
        <article
                id="content-main">
            <section
                    style="width: 100%;">
                <h2
                        class="theme-default-text">
                    <?php echo (date("H") >= 19 ? "Bonsoir" : "Bonjour").", ".\cardback\utility\getAnonymousNameFromAccount($account) ?>!</h2>
            </section>
            <?php
            $packs = \cardback\system\getAllPacksOfUser($account["id"], 1);
            if (\cardback\system\isArrayEmpty($packs)) {
                ?>
                <section
                        class="section-cards">
                    <h3
                            class="theme-default-text">
                        Bienvenue sur <span style="font-weight: 900;">cardback</span>!</h3>
                    <h4
                            class="theme-default-text"
                            style="font-weight: 500;">
                        - Vous pouvez accéder aux différentes parties du site à l'aide du menu
                        latéral à votre gauche.</h4>
                    <h4
                            class="theme-default-text"
                            style="font-weight: 500;">
                        - Si vous souhaitez créer un paquet de cartes, l'éditeur est
                        accessible à l'aide du bouton qui se situe<br>
                        en haut à droite du site, vous ne pouvez pas le rater!</h4>
                    <h4
                            class="theme-default-text"
                            style="font-weight: 500;">
                        - Si vous avez ne serais-ce qu'une recommandation à nous faire, nous
                        vous prions de bien vouloir nous<br>
                        contacter par notre espace de feedback.</h4>
                    <br>
                    <h4
                            class="theme-default-text"
                            style="font-weight: 500;">
                        Nous vous souhaitons un bon moment sur notre site.</h4>
                </section>
                <br>
                <?php
            }

            $packsInCreation = \cardback\system\getAllPacksOfUser($_SESSION["accountId"], 0);
            $getSectionCards("Paquets de cartes en cours de création", $packsInCreation);

            $packsFromAWeek = \cardback\system\getAllPacksFromWeeks(1, 1);
            if (!\cardback\system\isArrayEmpty($packsFromAWeek)) {
                $getSectionCards("Paquets créés depuis une semaine", $packsFromAWeek);
            } else {
                $packsFromAMonth = \cardback\system\getAllPacksFromWeeks(4, 1);
                $getSectionCards("Paquets créés depuis un mois", $packsFromAMonth);
            }

            $themesArray = \cardback\utility\getNRandomNumbers(3, 0, 6);
            foreach ($themesArray as $themeId) {
                $packsOfTheme = \cardback\system\getAllPacksOfTheme($themes[$themeId], 1);
                $themeName = $themes[$themeId];
                $getSectionCards("Paquets de cartes dans le thème « $themeName »", $packsOfTheme);
            }
            ?>
        </article>
    </div>
</main>
