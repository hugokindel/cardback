<?php namespace cardback\component\page;

function makeSettingsCategories() {
    global $serverUrl;

    return '
        <section style="width: 432px;">
            <div class="settings-top-category-container">
                <h3 class="settings-title">Paramètres</h3>
            </div>

            <div class="settings-category-container">
                <h3 class="settings-title">Général</h3>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/general/display"><h3 class="settings-title">Affichage 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
                        <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/general/about"><h3 class="settings-title">À propos de cardback
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>

            <div class="settings-category-container">
                <h3 class="settings-title">Compte</h3>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/account/preferences"><h3 class="settings-title">Préférences 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/account/connection"><h3 class="settings-title">Connexion 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
            <div class="settings-option-container">
                <a href="'.$serverUrl.'/settings/account/security"><h3 class="settings-title">Confidentialité et sécurité 
                    <span class="settings-option-accessory">􀆊</span></h3></a>
            </div>
        </section>';
}
