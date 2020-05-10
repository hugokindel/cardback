<?php
/**
 * Ce fichier contient les fonctions relatives au titre global.
 */

/**
 * Crée le titre "cardback".
 */
$getCardbackTitle = function() {
    global $serverUrl;

    ?>
    <div
            id="title-container">
        <a
                class="label-title1 theme-default-text"
                id="title-label"
                href="<?php echo $serverUrl; ?>">
            cardback</a>
    </div>
    <?php
};