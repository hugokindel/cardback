<?php
checkIsConnectedToAccount();

$firstId = getFirstPackId();
$lastId = getLastPackId();
$pack = getPack($_GET["id"])[1];

if (!isset($_GET["id"]) || $firstId[0] == FALSE || $lastId[0] == FALSE || $_GET["id"] < $firstId[1] || $lastId[1] < $_GET["id"] || $pack["published"] == 0 || (isset($_SESSION["game-".$_GET["id"]]) && $_SESSION["game-".$_GET["id"]] != 1)) {
    redirectTo404();
} else if (!isset($_SESSION["game-".$_GET["id"]])) {
    redirectToHome();
}

// TODO: Persistance
// TODO: Sauvegarder dans serveur

$error = "";
$errorOnCards = [];
$cards = getAllCardsOfPack($_GET["id"]);
$data = getAccount($_SESSION["accountId"])[1];

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once "core/component/default/card.php";

changeTitle("Résultat pour « ".$pack["name"]." »");
?>

<main>
    <?php
    echo makeSidebar(-1);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <h2>Voici vos résultats, <span style="font-weight: 800;"><?php echo $data["firstName"]." ".$data["lastName"] ?>!</span></h2>
        </div>

        <?php
        echo makeToolbar(FALSE, '<a id="right-toolbar-main-button" class="link-main" href="'.$baseUrl.'/home">OK</a>');
        ?>

        <article id="content-main">
            <section>
                <div class="grid-container">
                    <div>
                        <h1 style="font-weight: 800;"><?php echo $pack["name"] ?></h1>
                        <h4 style="font-weight: 600; "><?php echo $pack["theme"] ?> · <?php echo $pack["difficulty"] ?> · <?php echo count($cards) ?> cartes</h4>
                    </div>
                </div>
            </section>
            <br>

            <section class="section-cards">
                <h4>Cartes</h4>
                <?php
                foreach ($cards as $card) {
                    ?>
                    <form method="post" id="card-<?php echo $card["id"] ?>-form">
                        <input type="hidden" name="id" value="<?php echo $card["id"] ?>" />
                        <div class="cards-container">
                            <?php
                            echo makeCardEditable("qcard-".$card["id"], "", $card["question"], TRUE);
                            echo makeCardEditable("acard-".$card["id"],
                                $_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0 ? "Écrivez votre réponse..." :
                                    ($_SESSION["game-".$_GET["id"]."-".$card["id"]] < 3 ? $_SESSION["game-".$_GET["id"]."-".$card["id"]."-answer"] : "?"),
                                "",
                                $_SESSION["game-".$_GET["id"]."-".$card["id"]] != 0,
                                FALSE,
                                $_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0 ? 0 : ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 1 ? 1 : 2));
                            ?>

                            <?php
                            if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] != 1) {
                                ?>
                                <div style="display: flex; align-items: center; justify-content: left; margin-right: 25px; margin-top: 25px;">
                                    <h1>􀄫</h1>
                                </div>
                                <div style="display: flex; align-items: center; justify-content: left;">
                                    <?php echo makeCardEditable("qcard-".$card["id"], "", $card["answer"], TRUE, TRUE, 1); ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <?php
                                if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0) {
                                    ?>
                                    <input id="abandon-card-<?php echo $card["id"] ?>-button" class="button-main" type="submit" name="abandonCard" value="Abandonner" style="width: 150px; height: 32px; background-color: #FF3B30;"/>
                                    <input id="validate-card-<?php echo $card["id"] ?>-button" class="button-main" type="submit" name="validateCard" value="Valider" style="width: 150px; height: 32px; "/>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if (isset($_GET["error"]) && $_GET["errorType"] == 0 && $card["id"] == $_GET["cardId"]) {
                            ?>
                            <div style="width: 100%; margin: 20px 10px;">
                                <p class="form-label-error" style="text-align: left;">􀁡 Validation impossible!<?php echo $_GET["error"] ?></p>
                            </div>
                            <?php
                        }
                        ?>
                    </form>
                    <?php
                }
                ?>
            </section>
            <br>
        </article>
    </div>
</main>

<?php

unset($_SESSION["game-".$_GET["id"]]);

foreach($cards as $card) {
    unset($_SESSION["game-".$_GET["id"]."-".$card["id"]]);
    unset($_SESSION["game-".$_GET["id"]."-answer"]);
}

?>
