<?php

function makeTextbox($id, $type, $name, $placeholder) {
    return '
        <label for="'.$id.'"></label>
        <input class="textbox-main" type="'.$type.'" id="'.$id.'" name="'.$name.'" placeholder="'.$placeholder.'">
        ';
}

function makeTextboxWithAccessory($id, $type, $name, $placeholder, $accessory, $class = "") {
    return '
    <div class="textbox-container '.$class.'">
        '.makeTextbox($id, $type, $name, $placeholder).'
        <h4 class="image-accessory" style="font-weight: 400">'.$accessory.'</h4>
    </div>';
}