<?php
require_once 'component/textbox.php';
require_once 'component/form.php';
require_once 'component/footer.php';

changeTitle("S'inscrire");
?>

<!-- Contenu principal de la page -->
<main>
    <?php
    echo makeForm('S\'inscrire sur <span style="font-weight: 900;">cardback', 'S\'inscrire', '
        <form>
            '.makeTextboxWithAccessory("email-textbox", "email", "email", "E-mail", "􀍕", "form-textbox")
             .makeTextboxWithAccessory("firstname-textbox", "text", "firstname", "Prénom", "􀉩", "form-textbox")
             .makeTextboxWithAccessory("lastname-textbox", "text", "lastname", "Nom de famille", "􀉩", "form-textbox")
             .makeTextboxWithAccessory("password-textbox", "password", "password", "Mot de passe", "􀎠", "form-textbox").'
        </form>')
    ?>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>