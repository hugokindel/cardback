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
            $allThemes = \cardback\system\getAllThemes();
            ?>
            <section class="section-cards">
                <h3 class="theme-default-text">Thèmes</h3>
                <div class="cards-container">
                    <?php
                    foreach ($allThemes[1] as $theme) {
                        $frontText = $theme["name"];
                        $backText = "Voulez vous accéder<br>à ce thème?";
                        $link = $serverUrl."/theme?id=".$theme["id"];

                        echo \cardback\component\makeCard($frontText, $backText, TRUE, "", $link);
                    }
                    ?>
                </div>
            </section>
            <br>

            <?php
            $packs = \cardback\system\getAllPacks(1);

            if ($packs[0] == 1 && count($packs[1]) > 0) {
                ?>
                <section class="section-cards">
                    <h3 class="theme-default-text">Tous les paquets de carte</h3>
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

            <?php
            if ($account["admin"] == 1) {
                $accounts = \cardback\system\getAllAccounts();

                if ($accounts[0] == 1 && count($accounts[1]) > 0) {
                    ?>
                    <section class="section-cards">
                        <h3 class="theme-default-text">Tous les profils</h3>
                        <div class="cards-container">
                            <?php
                            foreach ($accounts[1] as $userAccount) {
                                echo \cardback\component\makeCard(\cardback\utility\getAnonymousNameFromAccount($userAccount) . "<br>" . ($userAccount["admin"] == 1 ? "Administrateur" : "Utilisateur"),
                                    "Voulez-vous accéder à ce profil?", TRUE, "", "profile?id=".$userAccount["id"]);
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
