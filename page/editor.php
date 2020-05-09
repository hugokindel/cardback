<?php
\cardback\system\checkAccountConnection(TRUE);

$firstId = \cardback\database\selectMinId("packs");
$lastId = \cardback\database\selectMaxId("packs");
$pack = \cardback\system\getPack($_GET["id"])[1][0];

if (!isset($_GET["id"]) || $firstId[0] == 0 || $lastId[0] == 0 || $_GET["id"] < $firstId[1] ||
    $lastId[1] < $_GET["id"] || (!\cardback\system\checkUserOwnsPack($_SESSION["accountId"], $_GET["id"]) && $account["admin"] == 0) ||
    ($pack["published"] == 1 && $account["admin"] == 0)) {
    \cardback\utility\redirect("404");
}

$error = "";
$errorOnCards = [];
$cards = \cardback\system\getAllCardsOfPack($_GET["id"]);

if ($cards[0] == 0) {
    $cards = [];
} else {
    $cards = $cards[1];
}

function redirectEditor($url) {
    foreach ($_POST as $key => $value) {
        if (substr($key, 0, 5) === "acard" || substr($key, 0, 5) === "qcard") {
            $url .= "&$key=".urlencode($value);
        }
    }

    \cardback\utility\redirect($url);
}

if (!empty($_POST)) {
    if (isset($_POST["add-card"])) {
        \cardback\system\createCard($_GET["id"]);
    } else if (isset($_POST["publishPack"])) {
        if (count($cards) == 0) {
            redirectEditor("editor?id=".$_GET["id"]."&errorType=2");
        }

        foreach ($cards as $card) {
            if ($card["confirmed"] == 0) {
                array_push($errorOnCards, $card["id"]);
            }
        }

        if (count($errorOnCards) > 0) {
            redirectEditor("editor?id=".$_GET["id"]."&errorType=1");
        } else {
            \cardback\system\publishPack($_GET["id"]);
            \cardback\utility\redirect("home");
        }
    } else if (isset($_POST["suppressPack"])) {
        \cardback\system\removePack($_GET["id"]);

        \cardback\utility\redirect("home");
    } else if (isset($_POST["editPack"])) {
        redirectEditor("editor/modify?id=".$_GET["id"]);
    } else if (isset($_POST["unpublishPack"])) {
        \cardback\system\unpublishPack($_GET["id"]);
    } else {
        foreach ($cards as $card) {
            $cardId = $card["id"];

            if (isset($_POST["validate-$cardId-card"])) {
                if ($_POST["qcard-$cardId"] === "") {
                    $error .= "<br>- Veuillez entrer une question.";
                }

                if ($_POST["acard-$cardId"] === "") {
                    $error .= "<br>- Veuillez entrer une réponse.";
                }

                if ($error === "") {
                    \cardback\system\confirmCard($cardId, $_POST["qcard-$cardId"], $_POST["acard-$cardId"]);
                } else {
                    redirectEditor("editor?id=".$_GET["id"]."&errorType=0&cardId=$cardId&error=".urlencode($error));
                }
            } else if (isset($_POST["suppress-$cardId-card"])) {
                \cardback\system\removeCard($cardId);
            } else if (isset($_POST["modify-$cardId-card"])) {
                \cardback\system\unconfirmCard($cardId);
            }
        }
    }

    redirectEditor("editor?id=".$_GET["id"]);
}

\cardback\utility\changeTitle("Éditeur de paquet");
?>

<main>
    <?php
    echo \cardback\component\page\makeSidebar(-1);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <h2 class="theme-default-text">Créateur de paquet</h2>
        </div>

        <?php
        echo \cardback\component\page\makeToolbar(0, '
            <form method="post" id="remove-pack-form">
                <input type="submit" id="right-toolbar-secondary-button" class="button-main" name="suppressPack"
                value="Supprimer le paquet" />
            </form>
            <form method="post" id="remove-pack-form">
                <input type="submit" id="right-toolbar-main-button" class="button-main" name="'.($pack["published"] == 1 ? 'un' : '').'publishPack"
                value="'.($pack["published"] == 1 ? 'Dép' : 'P').'ublier le paquet"/>
            </form>');
        ?>

        <form method="post" id="page-general-form">
            <article id="content-main">
                <section>
                    <div class="grid-container">
                        <div>
                            <h1 class="theme-default-text" style="font-weight: 800;"><?php echo $pack["name"] ?></h1>
                            <h4 class="theme-default-text" style="font-weight: 600; "><?php echo $pack["theme"] ?> · <?php echo $pack["difficulty"] ?> ·
                                <?php echo count($cards) ?> cartes</h4>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: center; margin-left: 75px; cursor: pointer;">
                            <label class="card" style="position: relative; display: block;">
                                <input type="submit" style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; visibility: hidden;" name="editPack">
                                <div class="button-round" style="display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="document.forms['edit-pack-form'].submit();">
                                    <div style="font-size: 30px; position: absolute;">􀛷</div>
                                    <div class="color-text" style="font-size: 34px; position: absolute;">􀈌</div>
                                </div>
                                </input>
                            </label>
                        </div>
                    </div>
                </section>
                <br>

                <?php
                if ($pack["description"] != "") {
                    ?>
                    <section>
                        <h3 class="theme-default-text">Description</h3>
                        <h4 class="theme-default-text" style="font-weight: 500;"><?php echo $pack["description"] ?></h4>
                    </section>
                    <br>
                    <?php
                }
                ?>

                <section class="section-cards">
                    <h4 class="theme-default-text">Cartes</h4>
                    <?php if (isset($_GET["errorType"]) && $_GET["errorType"] == 2) {
                        ?>
                        <div style="width: 100%; margin: 20px 10px;">
                            <p class="form-label-error" style="text-align: left;">􀁡 Publication impossible!
                                <br>- Veuillez créer au moins une carte!</p>
                        </div>
                        <?php
                    }
                    ?>

                        <?php
                        foreach ($cards as $value) {
                            $cardId = $value["id"];
                            $question = $value["question"] != "" ? $value["question"] : (isset($_GET["qcard-$cardId"]) ? $_GET["qcard-$cardId"] : "");
                            $answer = $value["answer"] != "" ? $value["answer"] : (isset($_GET["acard-$cardId"]) ? $_GET["acard-$cardId"] : "");

                            ?>
                                <div class="cards-container">
                                    <?php
                                    echo \cardback\component\makeCardEditable(
                                            "qcard-".$value["id"],
                                            "Écrivez votre question...", $question, $value["confirmed"]);
                                    echo \cardback\component\makeCardEditable(
                                            "acard-".$value["id"],
                                            "Écrivez votre réponse...", $answer, $value["confirmed"]);
                                    ?>
                                    <div style="display: flex; align-items: center; justify-content: center;">
                                        <input id="suppress-card-<?php echo $value["id"] ?>-button" class="button-main"
                                               type="submit" name="suppress-<?php echo $value["id"] ?>-card" value="Supprimer" style="width: 150px; height: 32px;  background-color: #FF3B30;" />

                                        <?php
                                        if ($value["confirmed"] == 0) {
                                            ?>
                                            <input id="validate-card-<?php echo $value["id"] ?>-button" class="button-main"
                                                   type="submit" name="validate-<?php echo $value["id"] ?>-card" value="Valider" style="width: 150px; height: 32px; "/>
                                            <?php
                                        } else {
                                            ?>
                                            <input id="modify-card-<?php echo $value["id"] ?>-button" class="button-main"
                                                   type="submit" name="modify-<?php echo $value["id"] ?>-card" value="Modifier" style="width: 150px; height: 32px; "/>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if ($value["confirmed"] == 1) {
                                        ?>
                                        <div style="margin-left: 30px; display: flex; align-items: center; justify-content: center;">
                                            <h4 class="theme-default-text">Question validé!</h4>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if (isset($_GET["error"]) && $_GET["errorType"] == 0 && $value["id"] == $_GET["cardId"]) {
                                ?>
                                    <div style="width: 100%; margin: 20px 10px;">
                                        <p class="form-label-error" style="text-align: left;">􀁡 Validation impossible!
                                            <?php echo $_GET["error"] ?></p>
                                    </div>
                                <?php
                                } else if (isset($_GET["errorType"]) && $_GET["errorType"] == 1 && $value["confirmed"] == 0) {
                                ?>
                                    <div style="width: 100%; margin: 20px 10px;">
                                        <p class="form-label-error" style="text-align: left;">􀁡 Publication impossible!
                                            <br>- Veuillez valider ou supprimer cette carte!</p>
                                    </div>
                                <?php
                                }
                                ?>
                        <?php
                        }
                        ?>

                        <div class="cards-container">
                                <?php
                                echo \cardback\component\makeCardPlus();
                                ?>
                        </div>
                </section>
                <br>

                <section>
                    <h5 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
                        Pensez à valider vos cartes avant de quitter pour enregistrer leur contenu!</h5>
                </section>
            </article>
        </form>
    </div>
</main>
