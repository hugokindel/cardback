<?php
checkIsConnectedToAccount();

$firstId = getFirstPackId();
$lastId = getLastPackId();
$pack = getPack($_GET["id"])[1];

if (!isset($_GET["id"]) || $firstId[0] == FALSE || $lastId[0] == FALSE || $_GET["id"] < $firstId[1] || $lastId[1] < $_GET["id"] || !userOwnPack($_SESSION["accountId"], $_GET["id"]) || $pack["published"] == 1) {
    redirectTo404();
}

$error = "";

// TODO: Erreurs
// TODO: Persistance des données

if (!empty($_POST)) {
    if (isset($_POST["addCard"])) {
        createCard($_GET["id"]);
    }

    if (isset($_POST["validateCard"])) {
        validateCard($_POST["id"], $_POST["qcard-".$_POST["id"]], $_POST["acard-".$_POST["id"]]);
    }

    if (isset($_POST["suppressCard"])) {
        removeCard($_POST["id"]);
    }

    if (isset($_POST["modifyCard"])) {
        modifyCard($_POST["id"]);
    }

    if (isset($_POST["suppressPack"])) {
        removePack($_GET["id"]);

        redirectToHome();
    }

    if (isset($_POST["publishPack"])) {
        validatePack($_GET["id"]);

        redirectToHome();
    }

    if (isset($_POST["editPack"])) {
        redirect("editor/modify?id=".$_GET["id"]);
    }

    redirect("editor?id=".$_GET["id"]);
}

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once "core/component/default/card.php";

changeTitle("Éditeur de paquet");

$cards = getAllCardsOfPack($_GET["id"]);
?>

<main>
    <?php
    echo makeSidebar(-1);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <h2>Créateur de paquet</h2>
        </div>

        <?php
        echo makeToolbar(1, FALSE);
        ?>

        <article id="content-main">
            <section>
                <div class="grid-container">
                    <div>
                        <h1 style="font-weight: 800;"><?php echo $pack["name"] ?></h1>
                        <h4 style="font-weight: 600; "><?php echo $pack["theme"] ?> · <?php echo $pack["difficulty"] ?> · <?php echo count($cards) ?> cartes</h4>
                    </div>
                    <form method="post" id="edit-pack-form">
                        <input type="hidden" name="editPack" value="Éditer" />
                        <div style="display: flex; align-items: center; justify-content: center; margin-left: 50px; cursor: pointer;" onclick="document.forms['edit-pack-form'].submit();">
                            <div style="font-size: 30px; color: black; position: absolute;">􀛷</div>
                            <div style="font-size: 34px; color: #1FCAAC; position: absolute;">􀈌</div>
                        </div>
                    </form>
                </div>
            </section>
            <br>

            <section class="section-cards">
                <h4 style="margin-bottom: 20px;">Cartes</h4>

                <?php
                foreach ($cards as $value) {
                    ?>
                    <form method="post" id="card-<?php echo $value["id"] ?>-form">
                        <input type="hidden" name="id" value="<?php echo $value["id"] ?>" />
                        <div class="cards-container">
                            <div class="cards">
                                <?php
                                echo makeCardEditable("qcard-".$value["id"], "Écrivez votre question...", $value["question"], $value["confirmed"]);
                                echo makeCardEditable("acard-".$value["id"], "Écrivez votre réponse...", $value["answer"], $value["confirmed"]);
                                ?>

                                <?php
                                if ($value["confirmed"] == 1) {
                                ?>
                                    <div style="display: flex; align-items: center; justify-content: center;">
                                        <h4>Question validé!</h4>
                                    </div>
                                <?php
                                }
                                ?>
                                <div style="display: flex; align-items: center; justify-content: center;">
                                    <input id="suppress-card-<?php echo $value["id"] ?>-button" class="button-main" type="submit" name="suppressCard" value="Supprimer" style="width: 150px; height: 32px;  background-color: #FF3B30;" />

                                    <?php
                                    if ($value["confirmed"] == 0) {
                                    ?>
                                        <input id="validate-card-<?php echo $value["id"] ?>-button" class="button-main" type="submit" name="validateCard" value="Valider" style="width: 150px; height: 32px; "/>
                                    <?php
                                    } else {
                                    ?>
                                        <input id="modify-card-<?php echo $value["id"] ?>-button" class="button-main" type="submit" name="modifyCard" value="Modifier" style="width: 150px; height: 32px; "/>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php
                }
                ?>

                <div class="cards-container">
                    <div class="cards">
                        <form method="post" id="add-card-form">
                            <input type="hidden" name="addCard" value="Ajouter" />
                            <?php
                            echo makeCardPlus();
                            ?>
                        </form>
                    </div>
                </div>
            </section>
        </article>
    </div>
</main>
