<?php
checkIsConnectedToAccount();

require_once "core/component/page/title.php";
require_once "core/component/page/sidebar.php";
require_once "core/component/page/toolbar.php";
require_once "core/component/page/search.php";
require_once "core/component/default/textbox.php";
require_once "core/component/default/card.php";

changeTitle("Profil");

$data = getAccountData($_SESSION["accountId"], $_SESSION["accountPassword"])[1];
?>
<main>
    <?php
    echo makeSidebar(2);
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
                <div style="display: flex; align-items: center; justify-content: center;">
                    <img id="avatar-image" src="/res/avatar.png" alt="Avatar">
                    <div style="margin-left: 32px;">
                        <h1><?php echo $data["firstName"]." ".$data["lastName"]; ?></h1>
                        <h4 style="margin-left: 1px;"><?php echo $data["admin"] == 0 ? "Utilisateur" : "Administrateur"; ?></h4>
                    </div>
                </div>
            </section>
            <br>

            <section>
                <h3>Informations</h3>
                <h4 style="font-weight: 500;">Arrivé le <span style="font-weight: 600;"><?php echo strftime("%e %B %G", strtotime($data["creationDate"])); ?></span>.</h4>
                <h4 style="font-weight: 500;">Vu pour la dernière fois le <span style="font-weight: 600;"><?php echo strftime("%e %B %G", strtotime($data["lastConnectionDate"])); ?></span>.</h4>
            </section>
            <br>

            <?php
            if ($data["description"] != ""):
            ?>
            <section>
                <h3>Description</h3>
                <h4 style="font-weight: 500;"><?php echo $data["description"] ?></h4>
            </section>
            <br>
            <?php
            endif;
            ?>

            <!-- TODO: Statistiques -->

            <?php
            $unpublishedPacks = getAllPublishedPacksOfUser($_SESSION["accountId"]);

            if (count($unpublishedPacks) > 0):
                ?>
                <section class="section-cards">
                    <h3>Paquets de cartes</h3>
                    <div class="cards-container">
                        <div class="cards">
                            <?php
                            foreach ($unpublishedPacks as $value) {
                                echo makeCardDetailed($value["name"], $data["firstName"]." ".$data["lastName"], strftime("%e %B %G", strtotime($value["creationDate"]))/* TODO: link */);
                            }
                            ?>
                        </div>
                    </div>
                </section>
                <br>
            <?php
            endif;
            ?>

            <?php
            $unpublishedPacks = getAllUnpublishedPacksOfUser($_SESSION["accountId"]);

            if (count($unpublishedPacks) > 0):
            ?>
            <section class="section-cards">
                <h3>Paquets de cartes en cours de création</h3>
                <div class="cards-container">
                    <div class="cards">
                        <?php
                            foreach ($unpublishedPacks as $value) {
                                echo makeCardDetailed($value["name"], $data["firstName"]." ".$data["lastName"], strftime("%e %B %G", strtotime($value["creationDate"])), "editor?id=".$value["id"], "Voulez-vous continuer de créer ce paquet?");
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
