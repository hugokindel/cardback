<?php
$getSidebarLink = function($text, $accessory, $link, $selected = FALSE) {
    global $serverUrl;

    ?>
    <a
            class="sidebar-link theme-default-text <?php echo $selected ? "sidebar-link-selected" : "" ?>"
            href="<?php echo $serverUrl.$link; ?>">
        <span class="sidebar-link-icon"><?php echo $accessory; ?></span><?php echo $text; ?></a><br>
    <?php
};

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