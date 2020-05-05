<?php
\cardback\system\checkAccountConnection(TRUE);

$firstId = \cardback\database\selectMinId("packs");
$lastId = \cardback\database\selectMaxId("packs");
$pack = \cardback\system\getPack($_GET["id"])[1][0];

if (!isset($_GET["id"]) || $firstId[0] == 0 || $lastId[0] == 0 || $_GET["id"] < $firstId[1] ||
    $lastId[1] < $_GET["id"] || $pack["published"] == 0 ||
    (isset($_SESSION["game-".$_GET["id"]]) && $_SESSION["game-".$_GET["id"]] != 0)) {
    \cardback\utility\redirect("404");
}

$error = "";
$errorOnCards = [];
$cards = \cardback\system\getAllCardsOfPack($_GET["id"])[1];

if (!empty($_POST)) {
    if (isset($_POST["abandonCard"])) {
        $_SESSION["game-".$_GET["id"]."-".$_POST["id"]] = 3;
    } else if (isset($_POST["validateCard"])) {
        if ($_POST["acard-".$_POST["id"]] === "") {
            $error .= "<br>- Veuillez entrer une réponse.";
        }

        if ($error === "") {
            $answerUser = strtolower(str_replace(" ", "", $_POST["acard-".$_POST["id"]]));
            $answerDb = "";

            foreach($cards as $card) {
                if ($card["id"] == $_POST["id"]) {
                    $answerDb = strtolower(str_replace(" ", "", $card["answer"]));
                    break;
                }
            }

            if (preg_match('/'.$answerDb.'/', $answerUser) == TRUE) {
                $_SESSION["game-".$_GET["id"]."-".$_POST["id"]] = 1;
                $_SESSION["game-".$_GET["id"]."-".$_POST["id"]."-answer"] = $_POST["acard-".$_POST["id"]];
            } else {
                $_SESSION["game-".$_GET["id"]."-".$_POST["id"]] = 2;
                $_SESSION["game-".$_GET["id"]."-".$_POST["id"]."-answer"] = $_POST["acard-".$_POST["id"]];
            }
        } else {
            \cardback\utility\redirect(
                    "play?id=".$_GET["id"]."&errorType=0&cardId=".$_POST["id"]."&error=".urlencode($error));
        }
    } else if (isset($_POST["getResult"])) {
        foreach ($cards as $card) {
            if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0) {
                array_push($errorOnCards, $card["id"]);
            }
        }

        if (count($errorOnCards) > 0) {
            \cardback\utility\redirect("play?id=".$_GET["id"]."&errorType=1");
        } else {
            $_SESSION["game-".$_GET["id"]] = 1;

            \cardback\utility\redirect("result?id=".$_GET["id"]);
        }
    } else if (isset($_POST["abandonPack"])) {
        foreach ($cards as $card) {
            if ($_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0) {
                $_SESSION["game-".$_GET["id"]."-".$card["id"]] = 3;
            }
        }

        $_SESSION["game-".$_GET["id"]] = 1;

        \cardback\utility\redirect("result?id=".$_GET["id"]);
    }

    \cardback\utility\redirect("play?id=".$_GET["id"]);
}

if (!isset($_SESSION["game-".$_GET["id"]])) {
    $_SESSION["game-".$_GET["id"]] = 0;

    foreach($cards as $card) {
        $_SESSION["game-".$_GET["id"]."-".$card["id"]] = 0;
    }
}

\cardback\utility\changeTitle("Joue à « ".$pack["name"]." »");
?>

<main>
    <?php
    echo \cardback\component\page\makeSidebar(-1);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <h2 class="theme-default-text">Bonne chance, <span style="font-weight: 800;">
                    <?php echo \cardback\utility\getAnonymousNameFromAccount($account) ?>!</span></h2>
        </div>

        <?php
        echo \cardback\component\page\makeToolbar(FALSE, '
        <form method="post" id="abandon-pack-form">
            <input type="submit" id="right-toolbar-secondary-button" class="button-main" name="abandonPack"
            value="Abandonner" />
        </form>
        <form method="post" id="get-result-form">
            <input type="submit" id="right-toolbar-main-button" class="button-main" name="getResult"
            value="Obtenir mes résultats"/>
        </form>');
        ?>

        <article id="content-main">
            <section>
                <div class="grid-container">
                    <div>
                        <h1 class="theme-default-text" style="font-weight: 800;"><?php echo $pack["name"] ?></h1>
                        <h4 class="theme-default-text" style="font-weight: 600; "><?php echo $pack["theme"] ?> · <?php echo $pack["difficulty"] ?> ·
                            <?php echo count($cards) ?> cartes</h4>
                    </div>
                </div>
            </section>
            <br>

            <section class="section-cards">
                <h4 class="theme-default-text">Cartes</h4>
                <?php
                foreach ($cards as $card) {
                    $sessionCardId = $_SESSION["game-".$_GET["id"]."-".$card["id"]];
                    ?>
                    <form method="post" id="card-<?php echo $card["id"] ?>-form">
                        <input type="hidden" name="id" value="<?php echo $card["id"] ?>" />
                        <div class="cards-container">
                            <?php
                            echo \cardback\component\makeCardEditable("qcard-".$card["id"],
                                "", $card["question"], TRUE);
                            echo \cardback\component\makeCardEditable("acard-".$card["id"],
                                $sessionCardId == 0 ?
                                    "Écrivez votre réponse..." : ($sessionCardId < 3 ?
                                        $_SESSION["game-".$_GET["id"]."-".$card["id"]."-answer"] :  "?"),
                                "", $sessionCardId != 0, FALSE,
                                $sessionCardId == 0 ?
                                    0 : ($sessionCardId == 1 ? 1 : 2));

                            if ($sessionCardId != 0) {
                                ?>
                                <div style="display: flex; align-items: center; justify-content: left;">
                                    <?php
                                    if ($sessionCardId == 1) {
                                        ?>
                                        <h4 style="color: #1FCAAC;">Bonne réponse!</h4>
                                        <?php
                                    } else if ($sessionCardId == 2) {
                                        ?>
                                        <h4 style="color: #FF3B30;">Mauvaise réponse!</h4>
                                        <?php
                                    } else if ($sessionCardId == 3) {
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
                                if ($sessionCardId == 0) {
                                    ?>
                                    <input id="abandon-card-<?php echo $card["id"] ?>-button" class="button-main"
                                           type="submit" name="abandonCard" value="Abandonner" style="width: 150px; height: 32px; background-color: #FF3B30;"/>
                                    <input id="validate-card-<?php echo $card["id"] ?>-button" class="button-main"
                                           type="submit" name="validateCard" value="Valider" style="width: 150px; height: 32px; "/>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if (isset($_GET["error"]) && $_GET["errorType"] == 0 && $card["id"] == $_GET["cardId"]) {
                            ?>
                            <div style="width: 100%; margin: 20px 10px;">
                                <p class="form-label-error" style="text-align: left;">􀁡 Validation impossible!
                                    <?php echo $_GET["error"] ?></p>
                            </div>
                            <?php
                        } else if (isset($_GET["errorType"]) && $_GET["errorType"] == 1 &&
                            $_SESSION["game-".$_GET["id"]."-".$card["id"]] == 0) {
                            ?>
                            <div style="width: 100%; margin: 20px 10px;">
                                <p class="form-label-error" style="text-align: left;">􀁡 Obtention des résultats impossible!
                                    <br>- Veuillez valider ou abandonner cette carte!</p>
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
