<?php
require_once 'component/textbox.php';
require_once 'component/footer.php';

changeTitle("Se connecter");
?>

<!-- Contenu principal de la page -->
<main>
    <h2 class="label-titlemodal">cardback</h2>
    <h3 class="label-descriptionmodal">S'identifier sur <span style="font-weight: 900;">cardback</span></h3>
    <form>
        <?php
        echo makeTextboxWithAccessory("email-textbox", "email", "email", "E-mail", "􀍕", "textbox-modal");
        echo makeTextboxWithAccessory("password-textbox", "password", "password", "Mot de passe", "􀎠", "textbox-modal");
        ?>
    </form>

    <a style="font-weight: 500; margin: 0 0 0 40px;">Mot de passe <span style="font-weight: 700;">oublié</span>?</a>

    <div class="modal-buttons">
        <button class="button-secondary button-closemodal" style="min-height: 32px;">Retour</button>
        <button class="button-main" style="position: absolute; right: 0;">Se connecter</button>
    </div>
</main>
