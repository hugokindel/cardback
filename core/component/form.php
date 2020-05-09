<?php
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