<?php

$getCheckbox = function($text, $checked = FALSE, $style = "") {
    ?>
    <div
            style="<?php echo $style; ?>">
        <label
                class="checkbox-label theme-default-text">
            <?php echo $text; ?>
            <input
                    type="checkbox"
                    name="recommended"
                    <?php echo $checked ? "checked" : ""; ?>>
            <span
                    class="checkmark theme-default-background"></span>
        </label>
    </div>
    <?php
};