<?php
/**
 * Ce fichier contient les fonctions relatives aux composants de paramètres.
 */

/**
 * Crée une catégorie de paramètres.
 *
 * @param string $text Nom de la catégorie.
 * @param bool $top Définit si c'est la catégorie principale.
 */
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

/**
 * Crée une option de paramètres de type lien.
 *
 * @param string $text Nom de l'option
 * @param string $link Lien à charger lors du clique.
 * @param bool $selected Définit si c'est l'option sélectionné ou non.
 */
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

/**
 * Crée les catégories principales des paramètres.
 *
 * @param int $selected Définit quel catégorie est sélectionnée.
 */
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
