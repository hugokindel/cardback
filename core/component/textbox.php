<?php
$getTextbox = function($name, $type, $placeholder, $accessory, $value = "", $error = FALSE, $class = "", $maxLength = 0) {
    global $getTextbox;

    ?>
    <div
            class="textbox-container <?php echo $class; ?>">
        <label>
            <input
                    class="textbox-main theme-default-background theme-default-text <?php echo $error ? "textbox-error" : ""; ?>"
                    id="<?php echo $name; ?>-textbox"
                    type="<?php echo $type; ?>"
                    name="<?php echo $name; ?>"
                    placeholder="<?php echo $placeholder; ?>"
                    value="<?php echo $value; ?>"
                    <?php echo $maxLength > 0 ? "maxlength=\"$maxLength\"" : ""; ?>>
        </label>
        <h4
                class="image-accessory">
            <?php echo $accessory; ?></h4>
    </div>
    <?php
};

$getTextboxMultiline = function($name, $type, $placeholder, $value = "", $error = FALSE, $maxLength = 0) {
    ?>
    <label>
        <textarea
                class="textbox-main theme-default-background theme-default-text textbox-multiline <?php echo $error ? "textbox-error" : ""; ?>"
                id="<?php echo $name; ?>-textbox"
                type="<?php echo $type; ?>"
                name="<?php echo $name; ?>"
                placeholder="<?php echo $placeholder; ?>"
                <?php echo $maxLength > 0 ? "maxlength=\"$maxLength\"" : ""; ?>><?php echo $value; ?></textarea>
    </label>
    <?php
};