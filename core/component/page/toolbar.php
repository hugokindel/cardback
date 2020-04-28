<?php
function makeToolbar($mainButtonType = 0, $hideSuppressButton = TRUE) {
    $data = getAccount($_SESSION["accountId"])[1];

    return '
        <div id="right-toolbar">
                '.($hideSuppressButton ? '' : '<form method="post" id="remove-pack-form"><input type="submit" id="right-toolbar-secondary-button" class="button-main" name="suppressPack" value="Supprimer le paquet" /></form>').'
                '.($mainButtonType == 0 ? '<a id="right-toolbar-main-button" class="link-main" href="editor/create">Créer un paquet</a>' : '<form method="post" id="remove-pack-form"><input type="submit" id="right-toolbar-main-button" class="button-main" name="publishPack" value="Publier le paquet"/></form>'). '
                <div id="right-toolbar-menu" onclick="toggleToolbarMenu(event, this)">
                    <div id="right-toolbar-menu-button">
                        <img id="right-toolbar-menu-button-avatar" src="/res/image/default-avatar.png" alt="Avatar">
                        <p id="right-toolbar-menu-button-arrow">􀆈</p>
                    </div>
                    <div id="right-toolbar-menu-content">
                        <div style="border-bottom: 1px solid #E6ECF0;">
                            <a style="display: flex; justify-content: center; align-items: center; cursor: pointer; padding: 10px 20px; text-decoration: none; color: black;" href="profile?id='.$_SESSION["accountId"].'">
                                <img id="right-toolbar-menu-button-avatar" src="/res/image/default-avatar.png" alt="Avatar">
                                <div style="padding-left: 16px;">
                                    <h4 style="font-weight: 600;">'.$data["firstName"]." ".$data["lastName"].'</h4>
                                    <h5 style="font-weight: 400;">'.$data["email"].'</h5>
                                </div>
                            </a>
                        </div>
                        <div style="border-bottom: 1px solid #E6ECF0;">
                            <a class="right-toolbar-menu-link" href="settings" style="padding: 5px 20px;"><span class="right-toolbar-menu-item-icon">􀍟</span>Paramètres</a>
                            <a class="right-toolbar-menu-link" href="feedback" style="padding: 5px 20px;"><span class="right-toolbar-menu-item-icon">􀈎</span>Feedback</a>
                        </div>
                        <div>
                            <a class="right-toolbar-menu-link" href="disconnect" style="padding: 5px 20px;"><span class="right-toolbar-menu-item-icon">􀅁</span>Se déconnecter</a>
                        </div>
                    </div>
                </div>
        </div>';
}