<?php
\cardback\system\checkAccountConnection(TRUE);

$firstId = \cardback\database\selectMinId("packs");
$lastId = \cardback\database\selectMaxId("packs");
$pack = \cardback\system\getPack($_GET["id"])[1][0];

if (!isset($_GET["id"]) || $firstId[0] == 0 || $lastId[0] == 0 || $_GET["id"] < $firstId[1] ||
    $lastId[1] < $_GET["id"] || $pack["published"] == 0) {
    \cardback\utility\redirect("404");
}

$cards = \cardback\system\getAllCardsOfPack($_GET["id"]);

if (isset($_POST) && isset($_POST["replay"])) {
    unset($_SESSION["game-".$_GET["id"]]);

    foreach($cards as $card) {
        unset($_SESSION["game-".$_GET["id"]."-".$card["id"]]);
        unset($_SESSION["game-".$_GET["id"]."-answer"]);
    }

    \cardback\utility\redirect("play?id=".$_GET["id"]);
}

\cardback\utility\changeTitle($pack["name"]);
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
        echo \cardback\component\page\makeToolbar(TRUE,
            !\cardback\system\checkUserOwnsPack($_SESSION["accountId"], $pack["id"]) ? '' : '
            <form method="post" id="remove-pack-form">
                <input type="submit" id="right-toolbar-secondary-button" class="button-main" name="suppressPack"
                value="Supprimer le paquet" />
            </form>');
        ?>

        <article id="content-main">
            <section>
                <div class="grid-container">
                    <div>
                        <h1 style="font-weight: 800;"><?php echo $pack["name"] ?></h1>
                        <h4 style="font-weight: 600; "><?php echo $pack["theme"] ?> · <?php echo $pack["difficulty"] ?> ·
                            <?php echo count($cards) ?> cartes</h4>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: center; margin-left: 100px; cursor: pointer;">
                        <?php
                        if (!isset($_SESSION["game-".$_GET["id"]]) || $_SESSION["game-".$_GET["id"]] == 0) {
                            ?>
                            <form method="post" id="play-form">
                                <input type="hidden" name="editPack" value="Éditer" />
                                <a id="right-toolbar-main-button" class="link-main"
                                   href="<?php echo $serverUrl ?>/play?id=<?php echo $_GET["id"] ?>">Jouer</a>
                            </form>
                            <?php
                        } else {
                            ?>
                            <form method="post" id="replay-form">
                                <input type="hidden" name="editPack" value="Éditer" />
                                <input type="submit" id="right-toolbar-main-button" class="button-main" name="replay"
                                    value="Rejouer"/>
                            </form>
                            <form method="post" id="results-form">
                                <input type="hidden" name="editPack" value="Éditer" />
                                <a id="right-toolbar-main-button" class="link-main"
                                    href="<?php echo $serverUrl ?>/result?id=<?php echo $_GET["id"] ?>">
                                    Voir mes résultats</a>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
            <br>

            <section>
                <h3>Informations supplémentaires</h3>
                <h4 style="font-weight: 500;">Créé le <span style="font-weight: 600;">
                        <?php echo strftime("%e %B %G", strtotime($pack["creationDate"])) ?></span></h4>
                <h4 style="font-weight: 500;">Par <a style="font-weight: 600; color: black; text-decoration: none;" href="<?php echo $serverUrl."/profile?id=".$pack["authorId"] ?>"><?php echo $pack["author"] ?></a></h4>
            </section>
            <br>

            <?php
            if ($pack["description"] != "") {
                ?>
                <section>
                    <h3>Description</h3>
                    <h4 style="font-weight: 500;"><?php echo $pack["description"] ?></h4>
                </section>
                <br>
                <?php
            }
            ?>

            <!-- TODO: Statistiques -->
            <!-- TODO: Derniers joueurs ayant joué à ce paquet -->
            <!-- TODO: Autres paquets du même auteur -->
            <!-- TODO: Autres paquets dans ce thème -->
        </article>
    </div>
</main>
