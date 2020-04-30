<?php
checkIsConnectedToAccount();

$firstId = getFirstPackId();
$lastId = getLastPackId();
$pack = getPack($_GET["id"])[1];

if (!isset($_GET["id"]) || $firstId[0] == FALSE || $lastId[0] == FALSE || $_GET["id"] < $firstId[1] || $lastId[1] < $_GET["id"] || $pack["published"] == 0) {
    redirectTo404();
}

if (isset($_POST) && isset($_POST["replay"])) {
    $cards = getAllCardsOfPack($_GET["id"]);

    unset($_SESSION["game-".$_GET["id"]]);

    foreach($cards as $card) {
        unset($_SESSION["game-".$_GET["id"]."-".$card["id"]]);
        unset($_SESSION["game-".$_GET["id"]."-answer"]);
    }

    redirect("play?id=".$_GET["id"]);
}

require_once 'core/component/page/title.php';
require_once 'core/component/page/search.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once "core/component/default/card.php";

changeTitle($pack["name"]);

$cards = getAllCardsOfPack($_GET["id"]);
?>

<main>
    <?php
    echo makeSidebar(-1);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <?php
            echo makeSearchBar("Chercher un de vos paquet ou un thème");
            ?>
        </div>

        <?php
        echo makeToolbar(TRUE, !isAuthorOfPack($_SESSION["accountId"], $pack["id"]) ? '' : '
            <form method="post" id="remove-pack-form">
                <input type="submit" id="right-toolbar-secondary-button" class="button-main" name="suppressPack" value="Supprimer le paquet" />
            </form>');
        ?>

        <article id="content-main">
            <section>
                <div class="grid-container">
                    <div>
                        <h1 style="font-weight: 800;"><?php echo $pack["name"] ?></h1>
                        <h4 style="font-weight: 600; "><?php echo $pack["theme"] ?> · <?php echo $pack["difficulty"] ?> · <?php echo count($cards) ?> cartes</h4>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: center; margin-left: 100px; cursor: pointer;">
                        <?php
                        if (!isset($_SESSION["game-".$_GET["id"]]) || $_SESSION["game-".$_GET["id"]] == 0) {
                            ?>
                            <form method="post" id="play-form">
                                <input type="hidden" name="editPack" value="Éditer" />
                                <a id="right-toolbar-main-button" class="link-main" href="<?php echo $baseUrl ?>/play?id=<?php echo $_GET["id"] ?>">Jouer</a>
                            </form>
                            <?php
                        } else {
                            ?>
                            <form method="post" id="replay-form">
                                <input type="hidden" name="editPack" value="Éditer" />
                                <input type="submit" id="right-toolbar-main-button" class="button-main" name="replay" value="Rejouer"/>
                            </form>
                            <form method="post" id="results-form">
                                <input type="hidden" name="editPack" value="Éditer" />
                                <a id="right-toolbar-main-button" class="link-main" href="<?php echo $baseUrl ?>/result?id=<?php echo $_GET["id"] ?>">Voir mes résultats</a>
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
                <h4 style="font-weight: 500;">Créé le <span style="font-weight: 600;"><?php echo strftime("%e %B %G", strtotime($pack["creationDate"])) ?></span></h4>
                <h4 style="font-weight: 500;">Par <span style="font-weight: 600;"><?php echo $pack["author"] ?></span></h4>
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
