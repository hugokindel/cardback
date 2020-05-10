<?php

use function cardback\system\checkAccountConnection;
use function cardback\utility\changeTitle;

checkAccountConnection(TRUE);
changeTitle("Paramètres de préférences");
?>

<main>
    <?php
    $getSidebar(3);
    ?>

    <div id="page-main">
        <?php
        $getToolbar();
        ?>

        <article id="content-settings-main">
            <?php
            $getSettings(2);
            ?>

            <section style="width: 540px; position: fixed; top: 0;">
                <div class="settings-top-category-container">
                    <h3 class="settings-title theme-default-text">Préférences</h3>
                </div>

                <div class="settings-category-container">
                    <h3 class="settings-title theme-default-text">Informations principales</h3>
                </div>
                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>setting/account/preferences/modifyName"><h3 class="settings-title settings-title-button theme-default-text">Modifier mon nom/prénom</h3></a>
                </div>
                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>setting/account/preferences/modifyMail"><h3 class="settings-title settings-title-button theme-default-text">Modifier mon e-mail</h3></a>
                </div>
                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>setting/account/preferences/modifyPassword"><h3 class="settings-title settings-title-button theme-default-text">Modifier mon mot de passe</h3></a>
                </div>
                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>setting/account/preferences/modifyDescription"><h3 class="settings-title settings-title-button theme-default-text">Modifier ma description</h3></a>
                </div>
            </section>
        </article>
    </div>
</main>
