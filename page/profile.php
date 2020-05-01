<?php
\cardback\system\checkAccountConnection(TRUE);

$firstId = \cardback\database\selectMinId("users");
$lastId = \cardback\database\selectMaxId("users");

if (!isset($_GET["id"]) || $firstId[0] == 0 || $lastId[0] == 0 || $_GET["id"] < $firstId[1] ||
    $lastId[1] < $_GET["id"]) {
    \cardback\utility\redirect("404");
}

\cardback\utility\changeTitle("Profil");
?>
<main>
    <?php
    echo \cardback\component\page\makeSidebar(2);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <?php
            echo \cardback\component\page\makeSearchBar("Chercher un de vos paquet ou un thème");
            ?>
        </div>

        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <article id="content-main">
            <section>
                <div style="display: flex; align-items: center; justify-content: center;">
                    <img id="avatar-image" src="/res/image/default-avatar.png" alt="Avatar">
                    <div style="margin-left: 32px;">
                        <h1><?php echo $accountData["firstName"]." ".$accountData["lastName"]; ?></h1>
                        <h4 style="margin-left: 1px;"><?php echo $accountData["admin"] == 0 ?
                                "Utilisateur" :
                                "Administrateur"; ?></h4>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: center; margin-left: 100px; cursor: pointer;">
                        <?php
                        if ($_SESSION["accountId"] === $_GET["id"]) {
                            ?>
                            <form method="post" id="edit-pack-form">
                                <input type="hidden" name="editPack" value="Éditer"/>
                                <div style="display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="document.forms['edit-pack-form'].submit();">
                                    <div style="font-size: 30px; color: black; position: absolute;">􀛷</div>
                                    <div style="font-size: 34px; color: #1FCAAC; position: absolute;">􀈌</div>
                                </div>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
            <br>

            <section>
                <h3>Informations</h3>
                <h4 style="font-weight: 500;">Arrivé le <span style="font-weight: 600;">
                    <?php echo \cardback\utility\getFormatedDate($accountData["creationDate"]); ?></span>.
                </h4>
                <h4 style="font-weight: 500;">Vu pour la dernière fois le <span style="font-weight: 600;">
                    <?php echo \cardback\utility\getFormatedDate($accountData["lastConnectionDate"]); ?></span>.
                </h4>
            </section>
            <br>

            <?php
            if ($accountData["description"] != ""):
            ?>
            <section>
                <h3>Description</h3>
                <h4 style="font-weight: 500;"><?php echo $accountData["description"] ?></h4>
            </section>
            <br>
            <?php
            endif;
            ?>

            <!-- TODO: Statistiques -->

            <?php
            $unpublishedPacks = \cardback\system\getAllPacksOfUser($_GET["id"], 1);

            if ($unpublishedPacks[0] == 1 && count($unpublishedPacks[1]) > 0) {
                ?>
                <section class="section-cards">
                    <h3>Paquets de cartes</h3>
                    <div class="cards-container">
                        <?php
                        foreach ($unpublishedPacks[1] as $pack) {
                            echo \cardback\component\makeCardDetailed(
                                $pack["name"],
                                $accountData["firstName"]." ".$accountData["lastName"],
                                \cardback\utility\getFormatedDate($pack["creationDate"]),
                                $serverUrl."/pack?id=".$pack["id"]);
                        }
                        ?>
                    </div>
                </section>
                <br>
                <?php
            }
            ?>

            <?php
            $unpublishedPacks = \cardback\system\getAllPacksOfUser($_SESSION["accountId"], 0);

            if ($unpublishedPacks[0] == 1 && count($unpublishedPacks[1]) > 0) {
                ?>
                <section class="section-cards">
                    <h3>Paquets de cartes en cours de création</h3>
                    <div class="cards-container">
                        <?php
                        foreach ($unpublishedPacks[1] as $pack) {
                            echo \cardback\component\makeCardDetailed($pack["name"],
                                $accountData["firstName"]." ".$accountData["lastName"],
                                \cardback\utility\getFormatedDate($pack["creationDate"]),
                                $serverUrl."/editor?id=".$pack["id"],
                                "Voulez-vous continuer à créer ce paquet?");
                        }
                        ?>
                    </div>
                </section>
                <br>
                <?php
            }
            ?>
        </article>
    </div>
</main>
