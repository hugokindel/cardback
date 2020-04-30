<?php
checkIsConnectedToAccount();

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once 'core/component/page/search.php';
require_once 'core/component/default/textbox.php';
require_once "core/component/default/card.php";

changeTitle("Accueil");

$data = getAccount($_SESSION["accountId"])[1];
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
            <section style="width: 100%;">
                <h2><?php echo (date("H") >= 19 ? "Bonsoir" : "Bonjour").", ".$data["firstName"]." ".$data["lastName"] ?></h2>
            </section>

            <?php
            $packs = getAllPacksCreatedLastWeek();

            if (count($packs) > 0):
                ?>
                <section class="section-cards">
                    <h3>Paquet<?php echo count($packs) > 1 ? "s" : "" ?> créé<?php echo count($packs) > 1 ? "s" : "" ?> depuis une semaine</h3>
                    <div class="cards-container">
                        <?php
                        foreach ($packs as $pack) {
                            echo makeCardDetailed($pack["name"], $pack["author"], strftime("%e %B %G", strtotime($pack["creationDate"])), $baseUrl."/pack?id=".$pack["id"]);
                        }
                        ?>
                    </div>
                </section>
                <br>
            <?php
            endif;
            ?>

            <!-- TODO: Paquet créé depuis un mois -->
            <!-- TODO: Paquet récent dans le thème ... -->
            <!-- TODO: Paquet en tendance -->
        </article>
    </div>
</main>
