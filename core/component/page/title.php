<?php namespace cardback\component\page;

function makeTitle() {
    global $serverUrl;

    return '
        <div id="title-container">
            <a class="label-title1" id="title-label" href="'.$serverUrl.'">cardback</a>
        </div>';
}