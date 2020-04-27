<?php
checkIsConnectedToAccount();

$firstId = getFirstPackId();
$lastId = getLastPackId();

if (!isset($_GET["id"]) || $firstId[0] == FALSE || $lastId == FALSE || $_GET["id"] < $firstId[1] || $lastId[1] < $_GET["id"] || !userOwnPack($_SESSION["accountId"], $_GET["id"])) {
    redirectTo404();
}

$error = "";

if (!empty($_POST)) {
    if (isset($_POST["add"])) {
        createCard($_GET["id"]);
    }

    if (isset($_POST["validate"])) {
        validateCard($_POST["id"], $_POST["qcard-".$_POST["id"]], $_POST["acard-".$_POST["id"]]);
    }

    redirect("editor?id=".$_GET["id"]);
}

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once "core/component/default/card.php";

changeTitle("Éditeur de paquet");

$data = getPack($_GET["id"])[1];
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
                        <h1 style="font-weight: 800;"><?php echo $data["name"] ?></h1>
                        <h4 style="font-weight: 600; "><?php echo $data["theme"] ?> · <?php echo $data["difficulty"] ?> · <?php echo count($cards) ?> cartes</h4>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: center; margin-left: 50px;">
                        <div style="font-size: 30px; color: black; position: absolute;">􀛷</div>
                        <div style="font-size: 34px; color: #1FCAAC; position: absolute;">􀈌</div>
                    </div>
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
                                echo makeCardEditable("qcard-".$value["id"], "Écrivez votre question...", $value["question"]);
                                echo makeCardEditable("acard-".$value["id"], "Écrivez votre réponse...", $value["answer"]);
                                ?>
                                <div style="display: flex; align-items: center; justify-content: center;">
                                    <input id="suppress-card-<?php echo $value["id"] ?>-button" class="button-main" type="submit" name="suppress" value="Supprimer" style="width: 150px; height: 32px;  background-color: #FF3B30;" />
                                    <input id="validate-card-<?php echo $value["id"] ?>-button" class="button-main" type="submit" name="validate" value="Valider" style="width: 150px; height: 32px; " />
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
                            <input type="hidden" name="add" value="Ajouter" />
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
