<?php
$getToolbarButton = function($text, $accessory, $link, $separator = FALSE) {
    global $serverUrl;

  ?>
    <div
            class="<?php echo $separator ? "right-toolbar-menu-item-separator" : ""; ?>">
        <a
                class="right-toolbar-menu-link"
                href="<?php echo $serverUrl.$link; ?>">
            <span class="right-toolbar-menu-item-icon"><?php echo $accessory; ?></span><?php echo $text; ?></a>
    </div>
    <?php
};

$getToolbar = function($showCreatePack = TRUE, $customButtons = NULL) {
    global $serverUrl;
    global $account;
    global $getToolbarButton;

    ?>
        <div
                id="right-toolbar">
            <?php
            if (is_callable($customButtons)) {
                $customButtons();
            }

            if ($showCreatePack) {
                ?>
                <a
                        id="right-toolbar-main-button"
                        class="link-main"
                        href="<?php echo $serverUrl; ?>editor/create">Créer un paquet</a>
                <?php
            }
            ?>
            <div
                    id="right-toolbar-menu"
                    onclick="toggleToolbarMenu(event, this)">
                <div
                        id="right-toolbar-menu-button">
                    <img
                            id="right-toolbar-menu-button-avatar"
                            src="<?php echo $serverUrl; ?>res/image/default-avatar.png" alt="Avatar">
                    <p
                            class="theme-default-text"
                            id="right-toolbar-menu-button-arrow">
                        􀆈</p>
                </div>
            </div>
            <div
                    id="right-toolbar-menu-content">
                <div
                        class="right-toolbar-menu-item-separator">
                    <a
                            id="right-toolbar-menu-button-avatar-link"
                            href="<?php echo $serverUrl; ?>profile?id=<?php echo $_SESSION["accountId"]; ?>">
                        <img
                                id="right-toolbar-menu-button-avatar"
                                src="<?php echo $serverUrl; ?>res/image/default-avatar.png" alt="Avatar">
                        <div
                                style="padding-left: 16px;">
                            <h4
                                    style="font-weight: 600;">
                                <?php echo \cardback\utility\getAnonymousNameFromAccount($account); ?></h4>
                            <h5
                                    style="font-weight: 400;">
                                <?php echo $account["email"]; ?></h5>
                        </div>
                    </a>
                </div>
                <?php
                $getToolbarButton("Paramètres", "􀍟", "settings");
                $getToolbarButton("Feedback", "􀈎", "feedback", TRUE);
                $getToolbarButton("Se déconnecter", "􀅁", "account/disconnect");
                ?>
            </div>
        </div>
    <?php
};