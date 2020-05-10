<?php
\cardback\system\checkAccountConnection(TRUE);

$firstId = \cardback\database\selectMinId("packs");
$lastId = \cardback\database\selectMaxId("packs");
$pack = \cardback\system\getPack($_GET["id"])[1][0];

if (!isset($_GET["id"]) || $firstId[0] == 0 || $lastId[0] == 0 || $_GET["id"] < $firstId[1] ||
    $lastId[1] < $_GET["id"] || $pack["published"] == 0 ||
    (isset($_SESSION["game-".$_GET["id"]]) && $_SESSION["game-".$_GET["id"]] != 0)) {
    \cardback\utility\redirect("error/404");
}

$error = "";
$errorOnCards = [];
$cards = \cardback\system\getAllCardsOfPack($_GET["id"])[1];

function saveData() {
    foreach ($_POST as $key => $value) {
        if (substr($key, 0, 5) === "acard") {
            $_SESSION[$key] = $value;
        }
    }
}

if (!empty($_POST)) {
    if (isset($_POST["getResult"])) {
        foreach ($cards as $card) {
            if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0) {
                array_push($errorOnCards, $card["id"]);
            }
        }

        if (count($errorOnCards) > 0) {
            saveData();
            \cardback\utility\redirect("play?id=".$_GET["id"]."&errorType=1");
        } else {
            $_SESSION["game-".$_GET["id"]] = 1;

            foreach ($cards as $card) {
                $cardId = $card["id"];

                unset($_SESSION["acard-$cardId"]);
            }

            \cardback\utility\redirect("result?id=".$_GET["id"]);
        }
    } else if (isset($_POST["abandonPack"])) {
        foreach ($cards as $card) {
            $cardId = $card["id"];
            if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0) {
                $_SESSION["game-".$_GET["id"]."-".$card["id"]] = 3;
            }

            unset($_SESSION["acard-$cardId"]);
        }

        $_SESSION["game-".$_GET["id"]] = 1;

        \cardback\utility\redirect("result?id=".$_GET["id"]);
    } else if (isset($_POST["restart"])) {
        unset($_SESSION["game-".$_GET["id"]]);

        foreach($cards as $card) {
            unset($_SESSION["game-".$_GET["id"]."-".$card["id"]]);
            unset($_SESSION["game-".$_GET["id"]."-answer"]);
            unset($_SESSION["acard-".$_GET["id"]]);
        }

        \cardback\utility\redirect("play?id=".$_GET["id"]);
    } else {
        foreach ($cards as $card) {
            $cardId = $card["id"];

            if (isset($_POST["abandon-$cardId-card"])) {
                $_SESSION["game-".$_GET["id"]."-$cardId"] = 3;
                unset($_SESSION["acard-$cardId"]);
            } else if (isset($_POST["validate-$cardId-card"])) {
                if (trim($_POST["acard-$cardId"]) == "") {
                    $error .= "<br>- Veuillez entrer une réponse.";
                }

                if ($error == "") {
                    $answerUser = strtolower(str_replace(" ", "", $_POST["acard-$cardId"]));
                    $answerDb = strtolower(str_replace(" ", "", $card["answer"]));

                    if (preg_match('/'.$answerDb.'/', $answerUser)) {
                        $_SESSION["game-".$_GET["id"]."-$cardId"] = 1;
                        $_SESSION["game-".$_GET["id"]."-$cardId-answer"] = $_POST["acard-$cardId"];
                    } else {
                        $_SESSION["game-".$_GET["id"]."-$cardId"] = 2;
                        $_SESSION["game-".$_GET["id"]."-$cardId-answer"] = $_POST["acard-$cardId"];
                    }

                    unset($_SESSION["acard-$cardId"]);
                } else {
                    saveData();
                    \cardback\utility\redirect("play?id=".$_GET["id"]."&errorType=0&cardId=".$card["id"]."&error=".urlencode($error));
                }
            }
        }
    }

    saveData();
    \cardback\utility\redirect("play?id=".$_GET["id"]);
}

if (!isset($_SESSION["game-".$_GET["id"]])) {
    $_SESSION["game-".$_GET["id"]] = 0;

    foreach($cards as $card) {
        $_SESSION["game-".$_GET["id"]."-".$card["id"]] = 0;
    }
}

$canRestart = FALSE;
$i = 0;

foreach ($cards as $card) {
    if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] != 0) {
        $canRestart = TRUE;
    }

    if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 1) {
        $i++;
    }
}

if ($i == count($cards)) {
    $_SESSION["game-".$_GET["id"]] = 1;
    \cardback\utility\redirect("result?id=".$_GET["id"]);
}

$getToolbarButtons = function() {
    global $canRestart;

    if ($canRestart) {
        ?>
        <form
                method="post"
                id="get-result-form">
            <input
                    type="submit"
                    id="right-toolbar-main-button"
                    class="button-main"
                    name="restart"
                    value="Recommencer"/>
        </form>
        <?php
    }
    ?>
    <form
            method="post"
            id="abandon-pack-form">
        <input
                type="submit"
                id="right-toolbar-secondary-button"
                class="button-main"
                name="abandonPack"
                value="Abandonner" />
    </form>
    <?php
};

\cardback\utility\changeTitle("Joue à « ".$pack["name"]." »");
?>

<main>
    <?php $getSidebar(-1); ?>
    <div
            id="page-main">
        <div
                id="content-title-container">
            <h2
                    class="theme-default-text">
                Bonne chance, <span style="font-weight: 800;">
                    <?php echo \cardback\utility\getAnonymousNameFromAccount($account) ?>!</span></h2>
        </div>
        <?php $getToolbar(FALSE, $getToolbarButtons);  ?>
        <form
                method="post"
                id="card-<?php echo $card["id"] ?>-form">
            <article
                    id="content-main">
                <section>
                    <div
                            class="grid-container">
                        <div>
                            <h1
                                    class="theme-default-text"
                                    style="font-weight: 800;">
                                <?php echo $pack["name"] ?></h1>
                            <h4
                                    class="theme-default-text"
                                    style="font-weight: 600; ">
                                <?php echo $pack["theme"] ?> · <?php echo $pack["difficulty"] ?> · <?php echo count($cards) ?> cartes</h4>
                        </div>
                        <div
                                style="display: flex; align-items: center; justify-content: center; margin-left: 75px; cursor: pointer;">
                            <input
                                    type="submit"
                                    id="right-toolbar-main-button"
                                    class="button-main"
                                    name="getResult"
                                    value="Voir la correction"/>
                        </div>
                    </div>
                </section>
                <br>

                <section
                        class="section-cards">
                    <h4
                            class="theme-default-text">
                        Cartes</h4>
                    <?php
                    foreach ($cards as $card) {
                        $cardId = $card["id"];
                        $sessionCardId = $_SESSION["game-".$_GET["id"]."-".$card["id"]];
                        ?>
                            <input type="hidden" name="id" value="<?php echo $card["id"] ?>" />
                            <div class="cards-container">
                                <?php
                                $question = $card["question"];
                                $answer = "";

                                if ($sessionCardId == 0) {
                                    $answer = isset($_SESSION["acard-$cardId"]) ? $_SESSION["acard-$cardId"] : "";
                                }

                                $getCardEdit("qcard-".$card["id"],
                                    "", $question, TRUE);
                                $getCardEdit("acard-".$card["id"],
                                    $sessionCardId == 0 ?
                                        "Écrivez votre réponse..." : ($sessionCardId < 3 ?
                                            $_SESSION["game-".$_GET["id"]."-".$card["id"]."-answer"] :  "?"),
                                    $answer, $sessionCardId != 0, FALSE,
                                    $sessionCardId == 0 ?
                                        0 : ($sessionCardId == 1 ? 1 : 2));

                                if ($sessionCardId != 0) {
                                    ?>
                                    <div
                                            style="display: flex; align-items: center; justify-content: left;">
                                        <?php
                                        if ($sessionCardId == 1) {
                                            ?>
                                            <h4
                                                    class="color-text">
                                                Bonne réponse!</h4>
                                            <?php
                                        } else if ($sessionCardId == 2) {
                                            ?>
                                            <h4
                                                    style="color: #FF3B30;">
                                                Mauvaise réponse!</h4>
                                            <?php
                                        } else if ($sessionCardId == 3) {
                                            ?>
                                            <h4
                                                    style="color: #FF3B30;">
                                                Question abandonnée!</h4>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div
                                        style="display: flex; align-items: center; justify-content: center;">
                                    <?php
                                    if ($sessionCardId == 0) {
                                        ?>
                                        <input
                                                id="abandon-card-<?php echo $card["id"] ?>-button"
                                                class="button-main"
                                                type="submit"
                                                name="abandon-<?php echo $card["id"] ?>-card"
                                                value="Abandonner"
                                                style="width: 150px; height: 32px; background-color: #FF3B30;"/>
                                        <input
                                                id="validate-card-<?php echo $card["id"] ?>-button"
                                                class="button-main"
                                                type="submit"
                                                name="validate-<?php echo $card["id"] ?>-card"
                                                value="Valider"
                                                style="width: 150px; height: 32px; "/>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            if (isset($_GET["error"]) && $_GET["errorType"] == 0 && $card["id"] == $_GET["cardId"]) {
                                ?>
                                <div
                                        style="width: 100%; margin: 20px 10px;">
                                    <p
                                            class="form-label-error"
                                            style="text-align: left;">
                                        􀁡 Validation impossible!
                                        <?php echo $_GET["error"] ?></p>
                                </div>
                                <?php
                            } else if (isset($_GET["errorType"]) && $_GET["errorType"] == 1 &&
                                $_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0) {
                                ?>
                                <div
                                        style="width: 100%; margin: 20px 10px;">
                                    <p
                                            class="form-label-error"
                                            style="text-align: left;">
                                        􀁡 Obtention des résultats impossible!<br>
                                        - Veuillez valider ou abandonner cette carte!</p>
                                </div>
                                <?php
                            }
                            ?>
                        <?php
                    }
                    ?>
                </section>
                <br>

                <section>
                    <h5
                            style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
                        Pensez à valider vos réponses avant de quitter votre navigateur pour enregistrer leur contenu!</h5>
                </section>
                <br>
            </article>
        </form>
    </div>
</main>
