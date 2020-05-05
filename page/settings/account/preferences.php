<?php
\cardback\system\checkAccountConnection(TRUE);
\cardback\utility\changeTitle("Paramètres de préférences");
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
            echo \cardback\component\page\makeSettingsCategories(2);
            ?>

            <section style="width: 540px; position: fixed; top: 0;">
                <div class="settings-top-category-container">
                    <h3 class="settings-title theme-default-text">Préférences</h3>
                </div>

                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>/settings/account/preferences/modifyName"><h3 class="settings-title theme-default-text">Modifier mon nom/prénom</h3></a>
                </div>
                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>/settings/account/preferences/modifyMail"><h3 class="settings-title theme-default-text">Modifier mon e-mail</h3></a>
                </div>
                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>/settings/account/preferences/modifyPassword"><h3 class="settings-title theme-default-text">Modifier mon mot de passe</h3></a>
                </div>
                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>/settings/account/preferences/modifyDescription"><h3 class="settings-title theme-default-text">Modifier ma description</h3></a>
                </div>
            </section>
        </article>
    </div>
</main>
