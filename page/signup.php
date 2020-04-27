<?php
checkIsNotConnectedToAccount();

$error = "";
$emailIssue = FALSE;
$firstNameIssue = FALSE;
$lastNameIssue = FALSE;
$passwordIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!checkEmail($_POST["email"])) {
        $error .= "<br>- Veuillez entrer une adresse mail valide.";
        $emailIssue = TRUE;
    }

    if (!checkName($_POST["firstname"])) {
        $error .= "<br>- Veuillez entrer un prénom valide.";
        $firstNameIssue = TRUE;
    }

    if (!checkName($_POST["lastname"])) {
        $error .= "<br>- Veuillez entrer un nom valide.";
        $lastNameIssue = TRUE;
    }

    if (!checkPassword($_POST["password"])) {
        $error .= "<br>- Veuillez entrer un mot de passe valide (entre 8 et 64 caractères, au moins une minuscule, une majuscule, un chiffre et un symbole parmi @$!%*#?&.).";
        $passwordIssue = TRUE;
    }

    if ($error === "") {
        $result = createAccount($_POST["email"], $_POST["password"], $_POST["firstname"], $_POST["lastname"]);

        if ($result[0] == TRUE) {
            connectAccount($_POST["email"], $_POST["password"]);
            redirectToHome();
        } else {
            $error .= "<br>- ".$result[1];

            $emailIssue = TRUE;
        }
    }
}

require_once 'core/component/default/textbox.php';
require_once 'core/component/default/form.php';
require_once 'core/component/page/footer.php';

changeTitle("S'inscrire");
?>

<!-- Contenu principal de la page -->
<main id="main-with-footer">
    <?php
    echo makeForm('S\'inscrire sur <span style="font-weight: 900;">cardback', 'S\'inscrire',
        ($error !== "" ? '<p class="form-label-error">􀁡 Inscription impossible!'.$error.'</p>' : "").
        '<form method="post" id="page-form">
            '.makeTextboxWithAccessory("email", "email", "E-mail", "􀍕", isset($_POST["email"]) ? $_POST["email"] : "", $emailIssue, "form-textbox")
             .makeTextboxWithAccessory("firstname", "text", "Prénom", "􀉩", isset($_POST["firstname"]) ? $_POST["firstname"] : "", $firstNameIssue, "form-textbox")
             .makeTextboxWithAccessory("lastname", "text", "Nom de famille", "􀉩", isset($_POST["lastname"]) ? $_POST["lastname"] : "", $lastNameIssue, "form-textbox")
             .makeTextboxWithAccessory("password", "password", "Mot de passe", "􀎠", isset($_POST["password"]) ? $_POST["password"] : "", $passwordIssue, "form-textbox").'
        </form>');
    ?>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>