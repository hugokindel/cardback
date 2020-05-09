<?php
\cardback\system\checkAccountConnection(TRUE);

$firstId = \cardback\database\selectMinId("users");
$lastId = \cardback\database\selectMaxId("users");

if (!isset($_GET["id"]) || $firstId[0] == 0 || $lastId[0] == 0 || $_GET["id"] < $firstId[1] ||
    $lastId[1] < $_GET["id"]) {
    \cardback\utility\redirect("error/404");
}

if (isset($_POST) && isset($_POST["removeAccount"])) {
    \cardback\system\removeAccount($_GET["id"]);
    \cardback\utility\redirect("home");
}

$accountUser = \cardback\system\getAccount($_GET["id"])[1][0];

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

\cardback\utility\changeTitle("Profil");
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
                            <?php echo \cardback\utility\getAnonymousNameFromAccount($accountUser); ?></h1>
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
                    Arrivé le <span style="font-weight: 600;"><?php echo \cardback\utility\getFormatedDate($accountUser["creationDate"]); ?></span>.
                </h4>
                <h4
                        class="theme-default-text"
                        style="font-weight: 500;">
                    Vu pour la dernière fois le <span style="font-weight: 600;"><?php echo \cardback\utility\getFormatedDate($accountUser["lastConnectionDate"]); ?></span>.
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
            $packsOfUser = \cardback\system\getAllPacksOfUser($_GET["id"], 1);

            $getSectionCards("Paquets de cartes",
                    $packsOfUser);

            if ($_GET["id"] == $_SESSION["accountId"] || $account["admin"] == 1) {
                $packsOfUserInCreation = \cardback\system\getAllPacksOfUser($_GET["id"], 0);

                $getSectionCards("Paquets de cartes en cours de création",
                        $packsOfUserInCreation);
            }
            ?>
        </article>
    </div>
</main>
