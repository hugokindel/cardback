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
            echo \cardback\component\page\makeSearchBar($_GET["search"]);
            ?>
        </div>

        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <article id="content-main">
            <?php
            $allSearch = \cardback\system\search($_GET["search"]);

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
                                $type = $searchElement["type"] == 1 ? "Thème" : ($searchElement["admin"] == 1 ? "Administrateur" : "Utilisateur");
                                $frontText = $searchElement["name"]."<br>".$type;
                                $backText = "Voulez vous accéder<br>".($searchElement["type"] == 1 ? "à ce thème" : "à ce profil")."?";
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
