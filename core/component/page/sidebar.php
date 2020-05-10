<?php
/**
 * Ce fichier contient les fonctions relatives aux composants de la barre latérale gauche.
 */

/**
 * Crée un bouton de la barre de type lien.
 *
 * @param string $text Nom du bouton.
 * @param string $accessory Symbole à afficher.
 * @param string $link Lien à charger lors du clique.
 * @param bool $selected Définit si il est sélectionné ou non.
 */
$getSidebarLink = function($text, $accessory, $link, $selected = FALSE) {
    global $serverUrl;

    ?>
    <a
            class="sidebar-link theme-default-text <?php echo $selected ? "sidebar-link-selected" : "" ?>"
            href="<?php echo $serverUrl.$link; ?>">
        <span class="sidebar-link-icon"><?php echo $accessory; ?></span><?php echo $text; ?></a><br>
    <?php
};

/**
 * Crée les boutons principaux de la barre.
 *
 * @param int $selected Définit si un des boutons est sélectionné et si oui lequel.
 */
$getSidebar = function($selected = 0) {
    global $serverUrl;
    global $getCardbackTitle;
    global $getSidebarLink;

    ?>
    <div
            id="sidebar-main">
        <?php echo $getCardbackTitle(); ?>
        <div
                id="sidebar-links">
            <?php
            $getSidebarLink("Accueil", "􀎞", "home", $selected == 0);
            $getSidebarLink("Explorer", "􀊫", "explore", $selected == 1);
            $getSidebarLink("Profil", "􀉭", "profile?id=".$_SESSION["accountId"], $selected == 2);
            $getSidebarLink("Paramètres", "􀍟", "settings", $selected == 3);
            $getSidebarLink("Feedback", "􀈎", "feedback", $selected == 4);
            ?>
        </div>
    </div>
<?php
};