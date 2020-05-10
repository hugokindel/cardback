<?php
/**
 * Ce fichier contient les fonctions relatives aux bloc de cartes.
 */

/**
 * Crée une carte.
 *
 * @param string $textOnFront Texte à l'avant de la carte.
 * @param string $textOnBack Texte à l'arrière de la carte.
 * @param bool $rotate Définit si l'on donne un effet de rotation à la carte.
 * @param string $style Ajoute du style CSS.
 * @param string $link Ajoute un lien lors du clique sur la carte.
 */
$getCard = function($textOnFront, $textOnBack, $rotate = TRUE, $style = "", $link = "") {
    global $serverUrl;

    ?>
    <a
            class="card"
            style="<?php echo $style; ?>"
            href="<?php echo $link; ?>">
        <div
                class="card-container card-container-rotate"
                style="transform: rotate(<?php echo $rotate ? rand(-5, 5) : 0; ?>deg)">
            <div
                    class="card-main">
                <div
                        class="card-front">
                    <img
                            class="card-image"
                            src="<?php echo $serverUrl; ?>res/image/card-background.svg"
                            alt="Carte fond avant"/>
                    <div
                            class="card-text-middle"><?php echo $textOnFront; ?></div>
                </div>
                <div
                        class="card-back">
                    <img
                            class="card-image"
                            src="<?php echo $serverUrl; ?>res/image/card-background.svg"
                            alt="Carte fond arrière"/>
                    <div
                            class="card-text-middle"><?php echo $textOnBack; ?></div>
                </div>
             </div>
         </div>
     </a>
    <?php
};

/**
 * Crée une carte pour paquet de cartes.
 *
 * @param string $title Titre du paquet de cartes.
 * @param string $creatorName Nom du créateur du paquet de cartes.
 * @param string $creationDate Date de création du paquet de cartes.
 * @param string $link Ajoute un lien lors du clique sur la carte.
 * @param string $textOnBack Texte à l'arrière de la carte.
 * @param bool $rotate Définit si l'on donne un effet de rotation à la carte.
 */
$getCardPack = function($title, $creatorName, $creationDate, $link = "", $textOnBack = "Serez-vous capable de trouver toutes les réponses?", $rotate = TRUE) {
    global $serverUrl;

    ?>
    <a
            class="card card-pack"
            href="<?php echo $link; ?>">
        <div
                class="card-container card-pack-container card-container-rotate"
                style="transform: rotate(<?php echo $rotate ? rand(-5, 5) : 0; ?>deg);">
            <div
                    class="card-main">
                <div
                        class="card-front">
                    <img
                            class="card-image"
                            src="<?php echo $serverUrl; ?>res/image/card-background.svg"
                            alt="Carte fond avant"/>
                    <div
                            class="card-text-top">
                        <?php echo $title; ?></div>
                    <div
                            class="card-text-bottom">
                        Créé par <?php echo $creatorName; ?><br>
                        <?php echo $creationDate; ?></div>
                </div>
                <div
                        class="card-back">
                    <img
                            class="card-image"
                            src="<?php echo $serverUrl; ?>res/image/card-background.svg"
                            alt="Carte fond arrière"/>
                    <div
                            class="card-text-middle">
                        <?php echo $textOnBack; ?></div>
                </div>
             </div>
         </div>
     </a>
    <?php
};

/**
 * Crée une carte d'édition (avec un bloc d'entrée de texte).
 *
 * @param string $name Nom de l'input.
 * @param string $placeholder Placeholder à afficher s'il n'y a pas de valeur.
 * @param string $value Valeur à afficher.
 * @param bool $readonly Définit si le texte est éditable ou non.
 * @param bool $autocomplete Définit si l'auto-complétion est autorisée ou non.
 * @param int $showStamp Définit si on doit afficher un bloc de tampon:
 *   - 0: Pas de tampon.
 *   - 1: Tampon de réussite.
 *   - 2: Tampon d'échec.
 */
$getCardEdit = function($name, $placeholder, $value = "", $readonly = FALSE, $autocomplete = TRUE, $showStamp = 0) {
    global $serverUrl;

    ?>
    <div
            class="card">
        <div
                class="card-container">
            <div
                    class="card-main">
                <div
                        class="card-front">
                    <img
                            class="card-image"
                            src="<?php echo $serverUrl; ?>res/image/card-background.svg"
                            alt="Carte fond avant"/>
                    <label for="<?php echo $name; ?>-textbox"></label>
                        <textarea
                                style="text-align: center; resize: none; font-size: 17px; font-weight: bold;"
                                class="textbox-main textbox-card"
                                autocomplete="<?php echo $autocomplete ? "on" : "off"; ?>"
                                id="<?php echo $name; ?>-textbox"
                                type="textarea"
                                name="<?php echo $name; ?>"
                                placeholder="<?php echo $placeholder; ?>"
                                maxlength="159"
                                <?php echo $readonly ? "readonly" : ""; ?>><?php echo $value; ?></textarea>
                </div>
                <?php
                if ($showStamp > 0) {
                    ?>
                    <div
                            class="stamp-container">
                        <div
                                class="stamp-background">
                            􀛷</div>
                        <div
                                class="stamp-text <?php echo $showStamp == 1 ? "color-text" : ""; ?>"
                                style="<?php echo $showStamp == 2 ? "color: #FF3B30" : ""; ?>">
                            <?php echo $showStamp == 1 ? "􀁣" : "􀁡"; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
             </div>
         </div>
     </div>
    <?php
};

/**
 * Crée une carte de bouton "+".
 */
$getCardButtonPlus = function() {
    global $serverUrl;

    ?>
    <div
            class="cards-container">
        <label
                class="card"
                style="position: relative; display: block;">
            <input
                    type="submit"
                    style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; visibility: hidden;"
                    name="add-card">
            <div
                    class="card-container"
                    style="cursor: pointer;">
                <div
                        class="card-main">
                    <div
                            class="card-front">
                        <img
                                class="card-image"
                                src="<?php echo $serverUrl; ?>res/image/card-background.svg"
                                alt="Carte fond avant"/>
                        <div
                                class="card-text-middle theme-default-text"
                                style="font-size: 28px; color: black;">
                            􀛷</div>
                        <div
                                class="card-text-middle color-text"
                                style="font-size: 34px;">
                            􀁍</div>
                    </div>
                </div>
            </div>
            </input>
        </label>
    </div>
    <?php
};