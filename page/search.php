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
            $packsSearch = \cardback\system\searchPacks($_GET["search"]);
            $themesSearch = \cardback\system\searchTheme($_GET["search"]);
            $accountSearch = \cardback\system\searchAccount($_GET["search"]);

            for ($i = 0; $i < count($packsSearch[1]); $i++) {
                $packsSearch[1][$i]["type"] = 0;
            }
            for ($i = 0; $i < count($themesSearch[1]); $i++) {
                $themesSearch[1][$i]["type"] = 1;
            }
            for ($i = 0; $i < count($accountSearch[1]); $i++) {
                $accountSearch[1][$i]["type"] = 2;
                $accountSearch[1][$i]["name"] = \cardback\utility\getAnonymousNameFromAccount($accountSearch[1][$i]);
            }

            $allSearch = array_merge(
                $packsSearch[0] == 1 ? $packsSearch[1] : [],
                $themesSearch[0] == 1 ? $themesSearch[1] : [],
                $accountSearch[0] == 1 ? $accountSearch[1] : []);

            $nameColumn = array_column($allSearch, "name");

            array_multisort($nameColumn, SORT_ASC, $allSearch);

            if (count($allSearch) > 0) {
                ?>
                <section class="section-cards">
                    <h3 class="theme-default-text">Résultats</h3>
                    <div class="cards-container">
                        <?php
                        foreach ($allSearch as $searchElement) {
                            if ($searchElement["type"] == 0) {
                                echo \cardback\component\makeCardDetailed(
                                    $searchElement["name"],
                                    \cardback\utility\getAnonymousNameFromAccount($searchElement),
                                    \cardback\utility\getFormatedDate($searchElement["creationDate"]),
                                    $serverUrl . "/pack?id=" . $searchElement["id"]);
                            } else {
                                $type = $searchElement["type"] == 1 ? "Thème" : "Utilisateur";
                                $frontText = $searchElement["name"]."<br>".$type;
                                $backText = "Voulez vous accéder<br>".($searchElement["type"] == 1 ? "à ce thème" : "à cet utilisateur")."?";
                                $link = $serverUrl."/".($searchElement["type"] == 1 ? "theme?id=".$searchElement["id"] : "profile?id=".$searchElement["id"]);

                                echo \cardback\component\makeCard($frontText, $backText, TRUE, "", $link);
                            }
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
