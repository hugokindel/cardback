<?php namespace cardback\component\page;

function makeSettingsCategories($selected = 0) {
    global $serverUrl;

    return '
        <section style="width: 432px;">
            <div class="settings-top-category-container">
                <h3 class="settings-title theme-default-text">Paramètres</h3>
            </div>

            <div class="settings-category-container">
                <h3 class="settings-title theme-default-text">Général</h3>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/general/display"><h3 class="settings-title settings-title-button theme-default-text'.($selected === 0 ? ' settings-category-selected' : '').'">Affichage 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
                        <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/general/about"><h3 class="settings-title settings-title-button theme-default-text'.($selected === 1 ? ' settings-category-selected' : '').'">À propos de cardback
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>

            <div class="settings-category-container">
                <h3 class="settings-title theme-default-text">Compte</h3>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/account/preferences"><h3 class="settings-title settings-title-button theme-default-text'.($selected === 2 ? ' settings-category-selected' : '').'">Préférences 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/account/connection"><h3 class="settings-title settings-title-button theme-default-text'.($selected === 3 ? ' settings-category-selected' : '').'">Connexion 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/account/security"><h3 class="settings-title settings-title-button theme-default-text'.($selected === 4 ? ' settings-category-selected' : '').'">Confidentialité et sécurité 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
        </section>';
}
