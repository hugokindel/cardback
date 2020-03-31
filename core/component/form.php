<?php
function makeForm($descriptionText, $buttonText, $content, $cancelUrl = "") {
    global $baseUrl;

    if ($cancelUrl === "") {
        $cancelUrl = $baseUrl;
    }

    return '
        <div class="form-main">
            <a class="label-title1 form-label-title" href="'.$baseUrl.'">cardback</a>
            <h3 class="form-label-description">'.$descriptionText.'</h3>
            
            '.$content.'
    
            <div class="form-buttons">
                <a class="link-secondary form-button-cancel" href="'.$cancelUrl.'">Retour</a>
                <button class="button-main form-button-submit" type="submit" form="page-form" name="submit">'.$buttonText.'</button>
            </div>
        </div>';
}