<?php

// TODO: Bug carte flou
// TODO: Bug carte détaillé

function makeCard($textOnFront, $textOnBack, $rotate = TRUE) {
    global $baseUrl;

    return '
    <div class="card-container card-container-rotate" style="transform: rotate('.($rotate ? rand(-5, 5) : 0). 'deg)">
        <div class="card-main">
            <div class="card-front">
                <img class="card-image" src="'.$baseUrl.'/res/image/card-background.svg" alt="Carte fond avant"/>
                <div class="card-text-middle">'.$textOnFront.'</div>
            </div>
            <div class="card-back">
                <img class="card-image" src="'.$baseUrl.'/res/image/card-background.svg" alt="Carte fond arrière"/>
                <div class="card-text-middle">'.$textOnBack.'</div>
            </div>
         </div>
     </div>';
}

function makeCardDetailed($title, $creatorName, $creationDate, $link = "", $message = "Serez-vous capable de trouver toutes les réponses?", $rotate = TRUE) {
    global $baseUrl;

    return '
    <a href="'.$link.'" style="outline: none; color: black;">
        <div class="card-container card-container-rotate" style="transform: rotate('.($rotate ? rand(-5, 5) : 0). 'deg); cursor: pointer;">
            <div class="card-main">
                <div class="card-front">
                    <img class="card-image" src="'.$baseUrl.'/res/image/card-background.svg" alt="Carte fond avant"/>
                    <div class="card-text-top">'.$title.'</div>
                    <div class="card-text-bottom">Créé par '.$creatorName.'<br>'.$creationDate.'</div>
                </div>
                <div class="card-back">
                    <img class="card-image" src="'.$baseUrl.'/res/image/card-background.svg" alt="Carte fond arrière"/>
                    <div class="card-text-middle">'.$message.'</div>
                </div>
             </div>
         </div>
     </a>';
}

function makeCardPlus() {
    global $baseUrl;

    return '
    <div class="card-container" style="cursor: pointer;" onClick="document.forms[\'add-card-form\'].submit();">
        <div class="card-main">
            <div class="card-front">
                <img class="card-image" src="'.$baseUrl.'/res/image/card-background.svg" alt="Carte fond avant"/>
                <div class="card-text-middle" style="font-size: 28px; color: black;">􀛷</div>
                <div class="card-text-middle" style="font-size: 34px; color: #1FCAAC;">􀁍</div>
            </div>
         </div>
     </div>';
}

function makeCardEditable($name, $placeholder, $value = "", $readonly = FALSE) {
    global $baseUrl;

    return '
    <div class="card-container">
        <div class="card-main">
            <div class="card-front">
                <img class="card-image" src="'.$baseUrl.'/res/image/card-background.svg" alt="Carte fond avant"/>
                <label for="'.$name.'"></label>
                <input id="'.$name.'-textbox" class="textbox-main textbox-card" type="text" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" maxlength="159"'.($readonly ? ' readonly' : '').'>
            </div>
         </div>
     </div>';
}