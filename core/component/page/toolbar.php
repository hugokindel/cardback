<?php

function makeToolbar($mainButtonType = 0, $hideSuppresButton = TRUE) {
    return '
        <div id="right-toolbar">
                '.($hideSuppresButton ? '' : '<a id="right-toolbar-secondary-button" class="link-main" href="editor/create">Supprimer le paquet</a>').'
                <a id="right-toolbar-main-button" class="link-main" href="editor/create">'.($mainButtonType == 0 ? 'Créer un paquet' : 'Publier le paquet').'</a>
                <img id="right-toolbar-avatar" src="/res/avatar.png" alt="Avatar">
                <p style="margin-left: 8px;">􀆈</p>
        </div>';
}