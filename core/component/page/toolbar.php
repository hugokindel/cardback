<?php

function makeToolbar($mainButtonType = 0, $hideSuppresButton = TRUE) {
    return '
        <div id="right-toolbar">
                '.($hideSuppresButton ? '' : '<form method="post" id="remove-pack-form"><input type="submit" id="right-toolbar-secondary-button" class="button-main" name="suppressPack" value="Supprimer le paquet" /></form>').'
                '.($mainButtonType == 0 ? '<a id="right-toolbar-main-button" class="link-main" href="editor/create">Créer un paquet</a>' : '<form method="post" id="remove-pack-form"><input type="submit" id="right-toolbar-main-button" class="button-main" name="publishPack" value="Publier le paquet"/></form>'). '
                <img id="right-toolbar-avatar" src="/res/image/default-avatar.png" alt="Avatar">
                <p style="margin-left: 8px; font-size: 16px;">􀆈</p>
        </div>';
}