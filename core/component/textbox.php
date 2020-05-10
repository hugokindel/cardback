<?php
/**
 * Ce fichier contient les fonctions relatives aux bloc d'entrée de texte.
 */

/**
 * Crée un bloc d'entrée de texte.
 *
 * @param string $name Nom de l'input.
 * @param string $type Type de texte de l'input.
 * @param string $placeholder Placeholder a afficher s'il n'y a pas de valeur.
 * @param string $accessory Symbole à afficher dans l'input.
 * @param string $value Valeur déjà entrée.
 * @param bool $error Définit si on doit afficher un style d'erreur.
 * @param string $class Ajoute une classe si nécessaire.
 * @param int $maxLength Longueur maximale de l'input.
 */
$getTextbox = function ($name, $type, $placeholder, $accessory, $value = "", $error = FALSE, $class = "", $maxLength = 0) {
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

/**
 * Crée un bloc d'entrée de texte.
 * @param string $name Nom de l'input.
 * @param string $type Type de texte de l'input.
 * @param string $placeholder Placeholder a afficher s'il n'y a pas de valeur.
 * @param string $value Valeur déjà entrée.
 * @param bool $error Définit si on doit afficher un style d'erreur.
 * @param int $maxLength Longueur maximale de l'input.
 */
$getTextboxMultiline = function ($name, $type, $placeholder, $value = "", $error = FALSE, $maxLength = 0) {
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