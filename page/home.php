<?php
checkIsConnectedToAccount();

if (isset($_POST["disconnect"])) {
    disconnectAccount();
    redirect();
}

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once 'core/component/page/search.php';
require_once 'core/component/default/textbox.php';
require_once "core/component/default/card.php";

changeTitle("Accueil");

$data = getAccountData($_SESSION["accountId"], $_SESSION["accountPassword"]);
?>

<main>
    <?php
    echo makeSidebar(0);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <?php
            echo makeSearchBar("Chercher un de vos paquet ou un thème");
            ?>
        </div>

        <?php
        echo makeToolbar();
        ?>

        <article id="content-main">
            <section>
                <form method="post" id="remove-pack-form"><input type="submit" id="right-toolbar-secondary-button" class="button-main" name="disconnect" value="Se déconnecter" /></form>
            </section>

            <?php
            $packs = getAllPacksCreatedLastWeek();

            if (count($packs) > 0):
                ?>
                <section class="section-cards">
                    <h3>Paquet<?php echo count($packs) > 1 ? "s" : "" ?> de cartes créé<?php echo count($packs) > 1 ? "s" : "" ?> cette semaine</h3>
                    <div class="cards-container">
                        <div class="cards">
                            <?php
                            foreach ($packs as $pack) {
                                echo makeCardDetailed($pack["name"], $pack["author"], strftime("%e %B %G", strtotime($pack["creationDate"])));
                            }
                            ?>
                        </div>
                    </div>
                </section>
                <br>
            <?php
            endif;
            ?>
        </article>
    </div>
</main>
