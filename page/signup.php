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

    if (!checkName($_POST["firstName"])) {
        $error .= "<br>- Veuillez entrer un prénom valide.";
        $firstNameIssue = TRUE;
    }

    if (!checkName($_POST["lastName"])) {
        $error .= "<br>- Veuillez entrer un nom valide.";
        $lastNameIssue = TRUE;
    }

    if (!checkPassword($_POST["password"])) {
        $error .= "<br>- Veuillez entrer un mot de passe valide (entre 8 et 64 caractères, au moins une minuscule, une majuscule, un chiffre et un symbole).";
        $passwordIssue = TRUE;
    }

    if ($error === "") {
        $result = createAccount($_POST["email"], $_POST["password"], $_POST["firstName"], $_POST["lastName"]);

        if ($result[0] == TRUE) {
            connectAccount($_POST["email"], $_POST["password"]);
            redirectToHome();
        } else {
            $error .= "<br>- ".$result[1];

            $emailIssue = TRUE;
        }
    }
}

require_once 'core/component/textbox.php';
require_once 'core/component/form.php';
require_once 'core/component/footer.php';

changeTitle("S'inscrire");
?>

<!-- Contenu principal de la page -->
<main>
    <?php
    echo makeForm('S\'inscrire sur <span style="font-weight: 900;">cardback', 'S\'inscrire',
        ($error !== "" ? '<p class="form-label-error">􀁡 Inscription impossible!'.$error.'</p>' : "").
        '<form method="post" id="page-form">
            '.makeTextboxWithAccessory("email-textbox", "email", "email", "E-mail", "􀍕", isset($_POST["email"]) ? $_POST["email"] : "", $emailIssue, "form-textbox")
             .makeTextboxWithAccessory("firstname-textbox", "text", "firstName", "Prénom", "􀉩", isset($_POST["firstName"]) ? $_POST["firstName"] : "", $firstNameIssue, "form-textbox")
             .makeTextboxWithAccessory("lastname-textbox", "text", "lastName", "Nom de famille", "􀉩", isset($_POST["lastName"]) ? $_POST["lastName"] : "", $lastNameIssue, "form-textbox")
             .makeTextboxWithAccessory("password-textbox", "password", "password", "Mot de passe", "􀎠", isset($_POST["password"]) ? $_POST["password"] : "", $passwordIssue, "form-textbox").'
        </form>');
    ?>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>