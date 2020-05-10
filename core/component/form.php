<?php
/**
 * Ce fichier contient les fonctions relatives aux formulaires.
 */

/**
 * Crée un formulaire.
 *
 * @param string $descriptionText Texte de description (titre du formulaire).
 * @param string $buttonText Texte du bouton d'envoi du formulaire.
 * @param callable $content Contenu du formulaire.
 * @param string $cancelUrl URL du bouton de retour.
 */
$getForm = function($descriptionText, $buttonText, $content, $cancelUrl = "") {
    global $serverUrl;

    if ($cancelUrl == "") {
        $cancelUrl = $serverUrl;
    }

    ?>
    <div
            class="form-main">
        <a
                class="label-title1 form-label-title theme-default-text"
                href="<?php echo $serverUrl; ?>">
            cardback</a>
        <h3
                class="form-label-description theme-default-text">
            <?php echo $descriptionText; ?></h3>
        <?php $content(); ?>
        <div
                class="form-buttons">
            <a
                    class="link-secondary form-button-cancel"
                    href="<?php echo $cancelUrl; ?>">
                Retour</a>
            <button
                    class="button-main form-button-submit"
                    type="submit"
                    form="page-form"
                    name="submit">
                <?php echo $buttonText; ?></button>
        </div>
    </div>
    <?php
};