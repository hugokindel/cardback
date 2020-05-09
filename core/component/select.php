<?php

$getSelect = function($name, $accessory, $placeholder, $options, $value = "", $error = FALSE, $class = "") {
    $optionsInnerHtml = "";

    foreach ($options as $option) {
        $selected = $value == $option[0] ? "selected" : "";
        $optionsInnerHtml .= "<option value=\"$option\" $selected>$option</option>";
    }

    ?>
    <div
            class="select-main <?php echo $class; ?> <?php echo $error ? "select-error" : ""; ?>"
            data-icon="<?php echo $accessory; ?>">
        <label>
            <select
                    id="<?php echo $name; ?>-select"
                    name="<?php echo $name; ?>">
                <option
                        value=""
                        disabled
                        <?php echo $value == "" ? "selected" : ""; ?>>
                    <?php echo $placeholder; ?></option>
                <?php echo $optionsInnerHtml; ?>
            </select>
        </label>
    </div>
    <?php
};