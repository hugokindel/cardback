<?php
checkIsConnectedToAccount();

$firstId = getFirstPackId();
$lastId = getLastPackId();
$pack = getPack($_GET["id"])[1];

if (!isset($_GET["id"]) || $firstId[0] == FALSE || $lastId[0] == FALSE || $_GET["id"] < $firstId[1] || $lastId[1] < $_GET["id"] || $pack["published"] == 0 || (isset($_SESSION["game-".$_GET["id"]]) && $_SESSION["game-".$_GET["id"]] != 0)) {
    redirectTo404();
}

// TODO: Persistance
// TODO: Sauvegarder dans serveur
// TODO: Abandonner

$error = "";
$errorOnCards = [];
$cards = getAllCardsOfPack($_GET["id"]);
$data = getAccount($_SESSION["accountId"])[1];

if (!empty($_POST)) {
    if (isset($_POST["abandonCard"])) {
        $_SESSION["game-".$_GET["id"]."-".$_POST["id"]] = 3;
    } else if (isset($_POST["validateCard"])) {
        if ($_POST["acard-".$_POST["id"]] === "") {
            $error .= "<br>- Veuillez entrer une réponse.";
        }

        if ($error === "") {
            $answerUser = strtolower(trim($_POST["acard-".$_POST["id"]], " "));
            $answerDb = "";

            foreach($cards as $card) {
                if ($card["id"] == $_POST["id"]) {
                    $answerDb = strtolower(trim($card["answer"], " "));
                }
            }

            if ($answerUser == $answerDb) {
                $_SESSION["game-".$_GET["id"]."-".$_POST["id"]] = 1;
                $_SESSION["game-".$_GET["id"]."-".$_POST["id"]."-answer"] = $_POST["acard-".$_POST["id"]];
            } else {
                $_SESSION["game-".$_GET["id"]."-".$_POST["id"]] = 2;
                $_SESSION["game-".$_GET["id"]."-".$_POST["id"]."-answer"] = $_POST["acard-".$_POST["id"]];
            }
        } else {
            redirect("play?id=".$_GET["id"]."&errorType=0&cardId=".$_POST["id"]."&error=".urlencode($error));
        }
    } else if (isset($_POST["getResult"])) {
        foreach ($cards as $card) {
            if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0) {
                array_push($errorOnCards, $card["id"]);
            }
        }

        if (count($errorOnCards) > 0) {
            redirect("play?id=".$_GET["id"]."&errorType=1");
        } else {
            $_SESSION["game-".$_GET["id"]] = 1;

            redirect("result?id=".$_GET["id"]);
        }
    } else if (isset($_POST["abandonPack"])) {
        foreach ($cards as $card) {
            if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0) {
                $_SESSION["game-".$_GET["id"]."-".$card["id"]] = 3;
            }
        }

        $_SESSION["game-".$_GET["id"]] = 1;

        redirect("result?id=".$_GET["id"]);
    }

    redirect("play?id=".$_GET["id"]);
}

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once "core/component/default/card.php";

changeTitle("Joue à « ".$pack["name"]." »");

if (!isset($_SESSION["game-".$_GET["id"]])) {
    $_SESSION["game-".$_GET["id"]] = 0;

    foreach($cards as $card) {
        $_SESSION["game-".$_GET["id"]."-".$card["id"]] = 0;
    }
}
?>

<main>
    <?php
    echo makeSidebar(-1);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <h2>Bonne chance, <span style="font-weight: 800;"><?php echo $data["firstName"]." ".$data["lastName"] ?>!</span></h2>
        </div>

        <?php
        echo makeToolbar(2, TRUE, FALSE);
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
                            if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] != 0) {
                                ?>
                                <div style="display: flex; align-items: center; justify-content: left;">
                                    <?php
                                    if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 1) {
                                        ?>
                                        <h4 style="color: #1FCAAC;">Bonne réponse!</h4>
                                        <?php
                                    } else if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 2) {
                                        ?>
                                        <h4 style="color: #FF3B30;">Mauvaise réponse!</h4>
                                        <?php
                                    } else if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 3) {
                                        ?>
                                        <h4 style="color: #FF3B30;">Question abandonnée!</h4>
                                        <?php
                                    }
                                    ?>
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
                        } else if (isset($_GET["errorType"]) && $_GET["errorType"] == 1 && $_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0) {
                            ?>
                            <div style="width: 100%; margin: 20px 10px;">
                                <p class="form-label-error" style="text-align: left;">􀁡 Obtention des résultats impossible!<br>- Veuillez valider ou abandonner cette carte!</p>
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
