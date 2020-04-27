<?php
checkIsConnectedToAccount();

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once 'core/component/page/search.php';
require_once 'core/component/default/textbox.php';
require_once "core/component/default/card.php";

changeTitle("Explorer");

$data = getAccount($_SESSION["accountId"])[1];
?>

<main>
    <?php
    echo makeSidebar(1);
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
            <?php
            $packs = getAllPacks();

            if (count($packs) > 0):
                ?>
                <section class="section-cards">
                    <h3>Tout</h3>
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
