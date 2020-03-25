<?php

function makeCard($text, $id = '') {
    return '
    <div class="card" id="'.$id.'">
        <img src="/res/image/card-background.svg" style="width: 236px; height: 180px;" alt="card"/>
        <div class="card-text">'.$text.'</div>
     </div>';
}