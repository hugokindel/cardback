<?php namespace cardback\component;

function makeTextbox($name, $type, $placeholder, $value = "", $error = FALSE, $maxlength = 0) {
    return '
        <label for="'.$name.'-textbox"></label>
        <input class="textbox-main theme-default-background theme-default-text'.($error ? ' textbox-error' : '').'" id="'.$name.'-textbox" type="'.$type.'" name="'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'"'.($maxlength > 0 ? ' maxlength="'.$maxlength.'"' : '').'>
        ';
}

function makeTextboxWithAccessory($name, $type, $placeholder, $accessory, $value = "", $error = FALSE, $class = "", $maxlength = 0) {
    return '
    <div class="textbox-container '.$class.'">
        '.makeTextbox($name, $type, $placeholder, $value, $error, $maxlength).'
        <h4 class="image-accessory" style="font-weight: 400">'.$accessory.'</h4>
    </div>';
}

function makeTextboxMultiline($name, $type, $placeholder, $value = "", $error = FALSE, $maxlength = 0) {
    return '
        <label for="'.$name.'-textbox"></label>
        <textarea class="textbox-main theme-default-background theme-default-text textbox-multiline'.($error ? ' textbox-error' : '').'" id="'.$name.'-textbox" type="'.$type.'" name="'.$name.'" placeholder="'.$placeholder.'"'.($maxlength > 0 ? ' maxlength="'.$maxlength.'"' : '').'>'.$value.'</textarea>
        ';
}