<?php namespace cardback\component\page;

function makeSearchBar($value = "", $showFilter = FALSE) {
    return '
        <div id="search-main" '.($showFilter ? 'style="margin-top: 27px;"' : '').'>'
            .\cardback\component\makeTextboxWithAccessory("search", "text", "Chercher un paquet, un thème ou un utilisateur...", "􀊫", $value)
            .($showFilter ? '<button class="button-secondary" style="color: black; margin-left: 0; padding-left: 0; margin-top: 8px;">􀌆 Filtrer</button>' : '').'
        </div>';
}