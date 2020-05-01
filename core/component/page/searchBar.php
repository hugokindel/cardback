<?php namespace cardback\component\page;

function makeSearchBar($placeholder = "Chercher un paquet, un thème ou un auteur", $value = "", $showFilter = TRUE) {
    return '
        <div id="search-main" '.($showFilter ? 'style="margin-top: 27px;"' : '').'>'
            .\cardback\component\makeTextboxWithAccessory("search", "text", $placeholder, "􀊫", $value)
            .($showFilter ? '<button class="button-secondary" style="color: black; margin-left: 0; padding-left: 0; margin-top: 8px;">􀌆 Filtrer</button>' : '').'
        </div>';
}