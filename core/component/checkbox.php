<?php
/**
 * Ce fichier contient les fonctions relatives aux bloc d'entrée de case à cocher.
 */

/**
 * Crée un bloc de case à cocher.
 *
 * @param string $text Texte de description.
 * @param bool $checked Définit si la case est cochée ou non.
 * @param string $style Ajoute du style CSS.
 */
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