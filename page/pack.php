<?php
\cardback\system\checkAccountConnection(TRUE);

$firstId = \cardback\database\selectMinId("packs");
$lastId = \cardback\database\selectMaxId("packs");
$pack = \cardback\system\getPack($_GET["id"])[1][0];

if (!isset($_GET["id"]) || $firstId[0] == 0 || $lastId[0] == 0 || $_GET["id"] < $firstId[1] ||
    $lastId[1] < $_GET["id"] || $pack["published"] == 0) {
    \cardback\utility\redirect("error/404");
}

$cards = \cardback\system\getAllCardsOfPack($_GET["id"])[1];

if (isset($_POST)) {
    if (isset($_POST["replay"])) {
        unset($_SESSION["game-".$_GET["id"]]);

        foreach($cards as $card) {
            unset($_SESSION["game-".$_GET["id"]."-".$card["id"]]);
            unset($_SESSION["game-".$_GET["id"]."-answer"]);
        }

        \cardback\utility\redirect("play?id=".$_GET["id"]);
    } else if (isset($_POST["suppressPack"])) {
        \cardback\system\removePack($_GET["id"]);
        \cardback\utility\redirect("home");
    }
}

$getToolbarButtons = function() {
    global $pack;
    global $account;
    global $serverUrl;

    if (\cardback\system\checkUserOwnsPack($_SESSION["accountId"], $pack["id"]) || $account["admin"] == 1) {
        ?>
        <form
                method="post"
                id="remove-account-form">
            <input
                    type="submit"
                    id="right-toolbar-secondary-button"
                    class="button-main"
                    name="removeAccount"
                    value="Supprimer le compte"/>
        </form>
        <?php
    }

    if ($account["admin"] == 1) {
        ?>
        <a
                id="right-toolbar-main-button"
                class="link-main"
                style="margin-right: 20px;"
                href="<?php echo $serverUrl; ?>editor?id=<?php echo $_GET["id"]; ?>">Éditer le paquet</a>
        <?php
    }
};

\cardback\utility\changeTitle($pack["name"]);
?>

<main>
    <?php $getSidebar(-1); ?>
    <div
            id="page-main">
        <div
                id="content-title-container">
            <?php $getSearchBar(); ?>
        </div>
        <?php $getToolbar(TRUE, $getToolbarButtons); ?>
        <article
                id="content-main">
            <section>
                <div
                        class="grid-container">
                    <div>
                        <h1
                                class="theme-default-text" style="font-weight: 800;">
                            <?php echo $pack["name"] ?></h1>
                        <h4
                                class="theme-default-text" style="font-weight: 600; ">
                            <?php echo $pack["theme"] ?> · <?php echo $pack["difficulty"] ?> · <?php echo count($cards) ?> cartes</h4>
                    </div>
                    <div
                            style="display: flex; align-items: center; justify-content: center; margin-left: 75px; cursor: pointer;">
                        <?php
                        if (!isset($_SESSION["game-".$_GET["id"]]) || $_SESSION["game-".$_GET["id"]] == 0) {
                            ?>
                            <form
                                    method="post"
                                    id="play-form">
                                <input
                                        type="hidden"
                                        name="editPack"
                                        value="Éditer" />
                                <a
                                        id="right-toolbar-main-button"
                                        class="link-main"
                                        href="<?php echo $serverUrl ?>/play?id=<?php echo $_GET["id"] ?>">
                                    Jouer</a>
                            </form>
                            <?php
                        } else {
                            ?>
                            <form
                                    method="post"
                                    id="replay-form">
                                <input
                                        type="hidden"
                                        name="editPack"
                                        value="Éditer" />
                                <input
                                        type="submit"
                                        id="right-toolbar-main-button"
                                        class="button-main"
                                        name="replay"
                                        value="Rejouer"/>
                            </form>
                            <form
                                    method="post"
                                    id="results-form">
                                <input
                                        type="hidden"
                                        name="editPack"
                                        value="Éditer" />
                                <a
                                        id="right-toolbar-main-button"
                                        class="link-main"
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
                <h3
                        class="theme-default-text">
                    Informations supplémentaires</h3>
                <h4
                        class="theme-default-text"
                        style="font-weight: 500;">
                    Créé le <span style="font-weight: 600;"><?php echo \cardback\utility\getFormatedDate($pack["creationDate"]) ?></span></h4>
                <h4
                        class="theme-default-text"
                        style="font-weight: 500;">
                    Par <a class="author-link theme-default-text"
                           style="font-weight: 600; text-decoration: none;"
                           href="<?php echo $serverUrl."profile?id=".$pack["authorId"] ?>">
                        <?php echo \cardback\utility\getAnonymousNameFromAccount($pack) ?></a>
                </h4>
            </section>
            <br>

            <?php
            if ($pack["description"] != "") {
                ?>
                <section>
                    <h3
                            class="theme-default-text">
                        Description</h3>
                    <h4
                            class="theme-default-text" style="font-weight: 500;">
                        <?php echo $pack["description"] ?></h4>
                </section>
                <br>
                <?php
            }
            ?>

            <?php
            $packsOfTheme = \cardback\system\getAllPacksOfTheme($pack["theme"], 1);

            if ($packsOfTheme[0] == 1) {
                for ($i = 0; $i < count($packsOfTheme); $i++) {
                    if ($packsOfTheme[1][$i]["id"] == $_GET["id"]) {
                        unset($packsOfTheme[1][$i]);
                        break;
                    }
                }
            }

            $getSectionCards("Autres paquets du même thème",
                    $packsOfTheme);

            $packsOfUser = \cardback\system\getAllPacksOfUser($pack["authorId"], 1);

            if ($packsOfUser[0] == 1) {
                for ($i = 0; $i < count($packsOfUser); $i++) {
                    if ($packsOfUser[1][$i]["id"] == $_GET["id"]) {
                        unset($packsOfUser[1][$i]);
                        break;
                    }
                }
            }

            $getSectionCards("Autres paquets du même auteur",
                    $packsOfUser);
            ?>
        </article>
    </div>
</main>
