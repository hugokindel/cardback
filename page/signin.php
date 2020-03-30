<?php
require_once 'component/textbox.php';
require_once 'component/form.php';
require_once 'component/footer.php';

changeTitle("Se connecter");
?>

<!-- Contenu principal de la page -->
<main>
    <?php
    echo makeForm('S\'identifier sur <span style="font-weight: 900;">cardback', 'Se connecter', '
        <form>
            '.makeTextboxWithAccessory("email-textbox", "email", "email", "E-mail", "􀍕", "form-textbox")
             .makeTextboxWithAccessory("password-textbox", "password", "password", "Mot de passe", "􀎠", "form-textbox").'
        </form>

        <a id="passwordforgotten-label" href="passwordrecovery">Mot de passe <span style="font-weight: 700;">oublié</span>?</a>');
    ?>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>