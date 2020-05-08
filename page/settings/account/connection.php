<?php
\cardback\system\checkAccountConnection(TRUE);

if (isset($_POST)) {
    if (isset($_POST["keepConnected"])) {
        \cardback\system\keepConnected($_SESSION["accountId"], isset($_POST["keepConnectedCheckbox"]));

        if (isset($_POST["keepConnectedCheckbox"])) {
            \cardback\system\createAuthenticationToken($_SESSION["accountId"]);
        } else {
            \cardback\system\removeAuthenticationToken();
        }

        \cardback\utility\redirect("settings/account/connection");
    }
}

\cardback\utility\changeTitle("Paramètres de connexion");
?>

<main>
    <?php
    echo \cardback\component\page\makeSidebar(3);
    ?>

    <div id="page-main">
        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <article id="content-settings-main">
            <?php
            echo \cardback\component\page\makeSettingsCategories(3);
            ?>

            <section style="width: 540px; position: fixed; top: 0;">
                <div class="settings-top-category-container">
                    <h3 class="settings-title theme-default-text">Connexion</h3>
                </div>

                <div class="settings-category-container">
                    <h3 class="settings-title theme-default-text">Gestion de la connexion</h3>
                </div>
                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>/disconnect"><h3 class="settings-title settings-title-button theme-default-text">Se déconnecter</h3></a>
                </div>
                <div class="settings-option-container">
                    <form method="post" id="keep-connected-form">
                        <input type="hidden" name="keepConnected" value="" />
                        <label class="checkbox-label theme-default-text" style="padding-left: 20px; line-height: 48px; font-size: 20px; font-weight: normal; border: 0;">Rester connecté
                            <input type="checkbox" name="keepConnectedCheckbox" onclick="document.getElementById('keep-connected-form').submit();"<?php
                            echo $account["keepConnected"] == 1 ? " checked" : "" ?>>
                            <span class="checkmark theme-default-background" style="left: unset; right: 20px; top: 11px;"></span>
                        </label>
                    </form>
                </div>
                <div class="settings-category-container">
                    <h3 class="settings-title theme-default-text">Autres</h3>
                </div>
                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>/suppress"><h3 class="settings-title settings-title-button" style="color: #FF3B30;">Supprimer mon compte</h3></a>
                </div>
            </section>
        </article>
    </div>
</main>
