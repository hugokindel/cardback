<?php

function makeCard($textOnFront, $textOnBack, $rotate = TRUE) {
    return '
    <div class="card-container"  style="transform: rotate('.($rotate ? rand(-5, 5) : 0).'deg)">
        <div class="card-main">
            <div class="card-front">
                <img class="card-image" src="/res/image/card-background.svg" alt="Carte fond avant"/>
                <div class="card-text">'.$textOnFront.'</div>
            </div>
            <div class="card-back">
                <img class="card-image" src="/res/image/card-background.svg" alt="Carte fond arrière"/>
                <div class="card-text">'.$textOnBack.'</div>
            </div>
         </div>
     </div>';
}