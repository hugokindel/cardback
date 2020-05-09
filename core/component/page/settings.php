<?php
$getSettingsCategory = function($text, $top = FALSE) {
    ?>
    <div
            class="settings<?php echo $top ? "-top" : ""; ?>-category-container">
        <h3
                class="settings-title theme-default-text">
            <?php echo $text; ?></h3>
    </div>
    <?php
};

$getSettingsOptionLink = function($text, $link, $selected = FALSE) {
    global $serverUrl;

    ?>
    <div
            class="settings-option-container">
        <a
                href="<?php echo $serverUrl.$link; ?>">
            <h3
                    class="settings-title settings-title-button theme-default-text <?php echo $selected ? "settings-category-selected" : ""; ?>">
                <?php echo $text; ?><span class="settings-option-accessory">􀆊</span></h3>
        </a>
    </div>
    <?php
};

$getSettings = function($selected = -1) {
    global $getSettingsCategory;
    global $getSettingsOptionLink;

    ?>
    <section
            class="section-settings-sidebar">
        <?php
        $getSettingsCategory("Paramètres", TRUE);

        $getSettingsCategory("Général");
        $getSettingsOptionLink("Affichage", "setting/general/display", $selected == 0);
        $getSettingsOptionLink("À propos de cardback", "setting/general/about", $selected == 1);

        $getSettingsCategory("Compte");
        $getSettingsOptionLink("Préférences", "setting/account/preferences", $selected == 2);
        $getSettingsOptionLink("Connexion", "setting/account/connection", $selected == 3);
        $getSettingsOptionLink("Confidentialité et sécurité", "setting/account/security", $selected == 4);
        ?>
    </section>
    <?php
};
