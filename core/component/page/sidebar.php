<?php
require_once 'core/component/page/title.php';

function makeSidebar($selected = 0) {
    return '
        <div id="sidebar-main">'
            .makeTitle().'
            <div id="sidebar-links">
                <a class="sidebar-link'.($selected === 0 ? ' sidebar-link-selected' : '').'" href="home"><span class="sidebar-link-icon">􀎞</span>Accueil</a><br>
                <a class="sidebar-link'.($selected === 1 ? ' sidebar-link-selected' : '').'" href="explore"><span class="sidebar-link-icon">􀊫</span>Explorer</a><br>
                <a class="sidebar-link'.($selected === 2 ? ' sidebar-link-selected' : '').'" href="profile?id='.$_SESSION["accountId"].'"><span class="sidebar-link-icon">􀉭</span>Profil</a><br>
                <a class="sidebar-link'.($selected === 3 ? ' sidebar-link-selected' : '').'" href="settings"><span class="sidebar-link-icon">􀍟</span>Paramètres</a><br>
                <a class="sidebar-link'.($selected === 4 ? ' sidebar-link-selected' : '').'" href="feedback"><span class="sidebar-link-icon">􀈎</span>Feedback</a><br>
            </div>
        </div>';
}