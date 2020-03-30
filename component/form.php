<?php

function makeForm($descriptionText, $buttonText, $content) {
    return '
        <div class="form-main">
            <a class="label-title1 form-label-title" href="https://cardback.tech">cardback</a>
            <h3 class="form-label-description">'.$descriptionText.'</h3>
            
            '.$content.'
    
            <div class="form-buttons">
                <button class="button-secondary" style="min-height: 32px;" onclick="window.history.back();">Retour</button>
                <button class="button-main" style="position: absolute; right: 0;">'.$buttonText.'</button>
            </div>
        </div>';
}