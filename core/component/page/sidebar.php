<?php namespace cardback\component\page;

function makeSidebar($selected = 0) {
    global $serverUrl;

    return '
        <div id="sidebar-main">'
            .makeTitle().'
            <div id="sidebar-links">
                <a class="sidebar-link theme-default-text'.($selected === 0 ? ' sidebar-link-selected' : '').'" href="'.$serverUrl.'/home"><span class="sidebar-link-icon">􀎞</span>Accueil</a><br>
                <a class="sidebar-link theme-default-text'.($selected === 1 ? ' sidebar-link-selected' : '').'" href="'.$serverUrl.'/explore"><span class="sidebar-link-icon">􀊫</span>Explorer</a><br>
                <a class="sidebar-link theme-default-text'.($selected === 2 ? ' sidebar-link-selected' : '').'" href="'.$serverUrl.'/profile?id='.$_SESSION["accountId"].'"><span class="sidebar-link-icon">􀉭</span>Profil</a><br>
                <a class="sidebar-link theme-default-text'.($selected === 3 ? ' sidebar-link-selected' : '').'" href="'.$serverUrl.'/settings"><span class="sidebar-link-icon">􀍟</span>Paramètres</a><br>
                <a class="sidebar-link theme-default-text'.($selected === 4 ? ' sidebar-link-selected' : '').'" href="'.$serverUrl.'/feedback"><span class="sidebar-link-icon">􀈎</span>Feedback</a><br>
            </div>
        </div>';
}