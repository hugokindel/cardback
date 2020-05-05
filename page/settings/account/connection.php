<?php
\cardback\system\checkAccountConnection(TRUE);
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

                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>/disconnect"><h3 class="settings-title theme-default-text">Se déconnecter</h3></a>
                </div>

                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>/suppress"><h3 class="settings-title" style="color: #FF3B30;">Supprimer mon compte</h3></a>
                </div>
            </section>
        </article>
    </div>
</main>
