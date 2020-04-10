<?php
require_once 'core/component/default/textbox.php';

function makeSearchBar($placeholder = "Chercher un paquet, un thème ou un auteur") {
    return '
        <div id="search-main" style="margin-top: 32px;">'
            .makeTextboxWithAccessory("search", "text", $placeholder, "􀊫").'
            <button class="button-secondary" style="color: black; margin-left: 0; padding-left: 0; margin-top: 8px;">􀌆 Filtrer</button>
        </div>';
}