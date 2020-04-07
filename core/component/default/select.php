<?php

// TODO: Add "tabbable"

function makeSelectWithAccessory($name, $accessory, $placeholder, $options, $value = "", $error = FALSE, $class = "") {
    $optionsInnerHtml = "";

    foreach ($options as $option) {
        $optionsInnerHtml .= '<option value="'.$option[0].'"'.($value == $option[0] ? ' selected' : '').'>'.$option[1].'</option>';
    }

    return '
    <div class="select-main '.$class.($error ? ' select-error' : '').'" data-icon="'.$accessory.'">
        <label for="'.$name.'-select"></label>
        <select id="'.$name.'-select" name="'.$name.'">
            <option value="" disabled'.($value == "" ? ' selected' : '').'>'.$placeholder.'</option>'
            .$optionsInnerHtml.'
        </select>
    </div>';
}