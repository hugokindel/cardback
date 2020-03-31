<?php
function makeTitle() {
    global $baseUrl;

    return '
        <div id="title-container">
            <a class="label-title1" id="title-label" href="'.$baseUrl.'">cardback</a>
        </div>';
}