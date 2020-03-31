<?php

function makeTextbox($id, $type, $name, $placeholder, $value = "", $error = FALSE) {
    return '
        <label for="'.$id.'"></label>
        <input class="textbox-main'.($error ? ' textbox-error' : '').'" type="'.$type.'" id="'.$id.'" name="'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'">
        ';
}

function makeTextboxWithAccessory($id, $type, $name, $placeholder, $accessory, $value = "", $error = FALSE, $class = "") {
    return '
    <div class="textbox-container '.$class.'">
        '.makeTextbox($id, $type, $name, $placeholder, $value, $error).'
        <h4 class="image-accessory" style="font-weight: 400">'.$accessory.'</h4>
    </div>';
}