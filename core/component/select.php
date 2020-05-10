<?php
/**
 * Ce fichier contient les fonctions relatives aux bloc d'entrée de sélection.
 */

/**
 * Crée un bloc d'entrée de sélection.
 *
 * @param string $name Nom de l'input.
 * @param string $placeholder Placeholder a afficher s'il n'y a pas de textes.
 * @param string $accessory Symbole à afficher dans l'input.
 * @param array $options Liste des options de la sélection.
 * @param string $value Valeur déjà entrée.
 * @param bool $error Définit si on doit afficher un style d'erreur.
 * @param string $class Ajoute une classe si nécessaire.
 */
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