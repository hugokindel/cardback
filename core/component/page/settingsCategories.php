<?php namespace cardback\component\page;

function makeSettingsCategories() {
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
                <a href="'.$serverUrl.'/settings/general/display"><h3 class="settings-title theme-default-text">Affichage 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
                        <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/general/about"><h3 class="settings-title theme-default-text">À propos de cardback
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>

            <div class="settings-category-container">
                <h3 class="settings-title theme-default-text">Compte</h3>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/account/preferences"><h3 class="settings-title theme-default-text">Préférences 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/account/connection"><h3 class="settings-title theme-default-text">Connexion 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/account/security"><h3 class="settings-title theme-default-text">Confidentialité et sécurité 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
        </section>';
}
