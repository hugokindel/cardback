<?php
checkIsConnectedToAccount();

$firstId = getFirstPackId();
$lastId = getLastPackId();

if (!isset($_GET["id"]) || $firstId[0] == FALSE || $lastId == FALSE || $_GET["id"] < $firstId[1] || $lastId[1] < $_GET["id"] || !userOwnPack($_SESSION["accountId"], $_GET["id"])) {
    redirectTo404();
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "add") {
        createCard($_GET["id"]);
    }

    redirect("editor?id=".$_GET["id"]);
}

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once "core/component/default/card.php";

changeTitle("Éditeur de paquet");

$data = getPackData($_GET["id"])[1];
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
                <h1 style="font-weight: 800;"><?php echo $data["name"] ?></h1>
                <h4 style="font-weight: 600; "><?php echo $data["theme"] ?> · <?php echo $data["difficulty"] ?> · 0 cartes</h4>
            </section>
            <br>

            <section class="section-cards">
                <h4 style="margin-bottom: 20px;">Cartes</h4>

                <?php
                $cards = getAllCardsOfPack($_GET["id"]);

                foreach ($cards as $value) {
                ?>
                    <div id="cards-container">
                        <div id="cards">
                            <?php
                            echo makeCardEditable("Écrivez votre question...");
                            echo makeCardEditable("Écrivez votre réponse...");
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>

                <div id="cards-container">
                    <div id="cards">
                        <form id="add-card-form">
                            <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>" />
                            <input type="hidden" name="action" value="add" />
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
