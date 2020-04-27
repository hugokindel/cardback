<?php

function makeToolbar($mainButtonType = 0, $hideSuppresButton = TRUE) {
    return '
        <div id="right-toolbar">
                '.($hideSuppresButton ? '' : '<button id="right-toolbar-secondary-button" class="button-main">Supprimer le paquet</button>').'
                '.($mainButtonType == 0 ? '<a id="right-toolbar-main-button" class="link-main" href="editor/create">Créer un paquet</a>' : '<button id="right-toolbar-main-button" class="button-main">Publier le paquet</button>').'
                <img id="right-toolbar-avatar" src="/res/avatar.png" alt="Avatar">
                <p style="margin-left: 8px; font-size: 16px;">􀆈</p>
        </div>';
}