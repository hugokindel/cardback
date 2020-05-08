<?php namespace cardback\component\page;

use function cardback\utility\getAnonymousNameFromAccount;

function makeToolbar($showCreatePack = TRUE, $customButtons = "") {
    global $serverUrl;
    global $account;

    return '
        <div id="right-toolbar">'
            .$customButtons
            .($showCreatePack ? '<a id="right-toolbar-main-button" class="link-main" href="'.$serverUrl.'/editor/create">Créer un paquet</a>' : '').'
            <div id="right-toolbar-menu" onclick="toggleToolbarMenu(event, this)">
                <div id="right-toolbar-menu-button">
                    <img id="right-toolbar-menu-button-avatar" src="'.$serverUrl.'/res/image/default-avatar.png" alt="Avatar">
                    <p class="theme-default-text" id="right-toolbar-menu-button-arrow">􀆈</p>
                </div>
            </div>
            <div id="right-toolbar-menu-content" style="position: absolute; top: 80px;">
                <div style="border-bottom: 1px solid #E6ECF0;">
                    <a style="display: flex; justify-content: center; align-items: center; cursor: pointer; padding: 10px 20px; text-decoration: none; color: black;" href="'.$serverUrl.'/profile?id='.$_SESSION["accountId"].'">
                        <img id="right-toolbar-menu-button-avatar" src="'.$serverUrl.'/res/image/default-avatar.png" alt="Avatar">
                        <div style="padding-left: 16px;">
                            <h4 style="font-weight: 600;">'.getAnonymousNameFromAccount($account).'</h4>
                            <h5 style="font-weight: 400;">'.$account["email"].'</h5>
                        </div>
                    </a>
                </div>
                <div>
                    <a class="right-toolbar-menu-link" href="'.$serverUrl.'/settings" style="padding: 5px 20px;"><span class="right-toolbar-menu-item-icon">􀍟</span>Paramètres</a>
                </div>
                <div style="border-bottom: 1px solid #E6ECF0;">
                    <a class="right-toolbar-menu-link" href="'.$serverUrl.'/feedback" style="padding: 5px 20px;"><span class="right-toolbar-menu-item-icon">􀈎</span>Feedback</a>
                </div>
                <div>
                    <a class="right-toolbar-menu-link" href="'.$serverUrl.'/disconnect" style="padding: 5px 20px;"><span class="right-toolbar-menu-item-icon">􀅁</span>Se déconnecter</a>
                </div>
            </div>
        </div>';
}