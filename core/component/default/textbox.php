<?php

function makeTextbox($name, $type, $placeholder, $value = "", $error = FALSE) {
    return '
        <label for="'.$name.'-textbox"></label>
        <input class="textbox-main'.($error ? ' textbox-error' : '').'" id="'.$name.'-textbox" type="'.$type.'" name="'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'">
        ';
}

function makeTextboxWithAccessory($name, $type, $placeholder, $accessory, $value = "", $error = FALSE, $class = "") {
    return '
    <div class="textbox-container '.$class.'">
        '.makeTextbox($name, $type, $placeholder, $value, $error).'
        <h4 class="image-accessory" style="font-weight: 400">'.$accessory.'</h4>
    </div>';
}