<?php

use function cardback\database\selectMaxId;
use function cardback\database\selectMinId;
use function cardback\system\checkAccountConnection;
use function cardback\system\getAccount;
use function cardback\system\getAllPacksOfUser;
use function cardback\system\removeAccount;
use function cardback\utility\changeTitle;
use function cardback\utility\getAnonymousNameFromAccount;
use function cardback\utility\getFormatedDate;
use function cardback\utility\redirect;

checkAccountConnection(TRUE);

$firstId = selectMinId("users");
$lastId = selectMaxId("users");

if (!isset($_GET["id"]) || $firstId[0] == 0 || $lastId[0] == 0 || $_GET["id"] < $firstId[1] ||
    $lastId[1] < $_GET["id"]) {
    redirect("error/404");
}

if (isset($_POST) && isset($_POST["removeAccount"])) {
    removeAccount($_GET["id"]);
    redirect("home");
}

$accountUser = getAccount($_GET["id"])[1][0];

$getToolbarButtons = function() {
    global $account;

    if ($account["admin"] == 1) {
        ?>
        <form
                method="post"
                id="remove-account-form">
            <input
                    type="submit"
                    id="right-toolbar-secondary-button"
                    class="button-main"
                    name="removeAccount"
                    value="Supprimer le compte"/>
        </form>
        <?php
    }
};

changeTitle("Profil");
?>
<main>
    <?php $getSidebar(2); ?>
    <div
            id="page-main">
        <div
                id="content-title-container">
            <?php $getSearchBar(); ?>
        </div>
        <?php $getToolbar(TRUE, $getToolbarButtons); ?>
        <article
                id="content-main">
            <section>
                <div
                        style="display: flex; align-items: center; justify-content: center;">
                    <img
                            id="avatar-image"
                            src="/res/image/default-avatar.png"
                            alt="Avatar">
                    <div
                            style="margin-left: 32px;">
                        <h1
                                class="theme-default-text">
                            <?php echo getAnonymousNameFromAccount($accountUser); ?></h1>
                        <h4
                                class="theme-default-text"
                                style="margin-left: 1px;">
                            <?php echo $accountUser["admin"] == 0 ? "Utilisateur" : "Administrateur"; ?></h4>
                    </div>
                    <div
                            style="display: flex; align-items: center; justify-content: center; margin-left: 75px; cursor: pointer;">
                        <?php
                        if ($_SESSION["accountId"] === $_GET["id"] || $account["admin"] == 1) {
                            ?>
                            <form
                                    method="post"
                                    id="edit-pack-form">
                                <input
                                        type="hidden"
                                        name="editPack"
                                        value="Éditer"/>
                                <?php
                                $accountModificationLink = "";

                                if ($_GET["id"] == $account["id"] || $account["admin"] == 0) {
                                    $accountModificationLink = $serverUrl."setting/account/preferences";
                                } else {
                                    $accountModificationLink = $serverUrl."admin/modifyAccount?id=".$_GET["id"];
                                }
                                ?>
                                <a
                                        class="button-round"
                                        style="display: flex; align-items: center; justify-content: center; cursor: pointer;"
                                        href="<?php echo $accountModificationLink; ?>">
                                    <div
                                            style="font-size: 30px; position: absolute;">
                                        􀛷</div>
                                    <div
                                            class="color-text"
                                            style="font-size: 34px; position: absolute;">
                                        􀈌</div>
                                </a>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
            <br>

            <section>
                <h3
                        class="theme-default-text">
                    Informations</h3>
                <h4
                        class="theme-default-text"
                        style="font-weight: 500;">
                    Arrivé le <span style="font-weight: 600;"><?php echo getFormatedDate($accountUser["creationDate"]); ?></span>.
                </h4>
                <h4
                        class="theme-default-text"
                        style="font-weight: 500;">
                    Vu pour la dernière fois le <span style="font-weight: 600;"><?php echo getFormatedDate($accountUser["lastConnectionDate"]); ?></span>.
                </h4>
            </section>
            <br>

            <?php
            if ($accountUser["description"] != "") {
                ?>
                <section>
                    <h3
                            class="theme-default-text">
                        Description</h3>
                    <h4
                            class="theme-default-text"
                            style="font-weight: 500;">
                        <?php echo $accountUser["description"] ?></h4>
                </section>
                <br>
                <?php
            }
            ?>

            <?php
            $packsOfUser = getAllPacksOfUser($_GET["id"], 1);

            $getSectionCards("Paquets de cartes",
                    $packsOfUser);

            if ($_GET["id"] == $_SESSION["accountId"] || $account["admin"] == 1) {
                $packsOfUserInCreation = getAllPacksOfUser($_GET["id"], 0);

                $getSectionCards("Paquets de cartes en cours de création",
                        $packsOfUserInCreation);
            }
            ?>
        </article>
    </div>
</main>
