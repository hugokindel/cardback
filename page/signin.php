<?php
checkIsNotConnectedToAccount();

require_once 'core/component/textbox.php';
require_once 'core/component/form.php';
require_once 'core/component/footer.php';

changeTitle("Se connecter");

$error = "";
$emailIssue = FALSE;
$passwordIssue = FALSE;

if (isset($_POST["email"]) && isset($_POST["password"])) {
    if (!checkEmail($_POST["email"])) {
        $error .= "<br>- Veuillez entrer une adresse mail valide.";
        $emailIssue = TRUE;
    }

    if (!checkPassword($_POST["password"])) {
        $error .= "<br>- Veuillez entrer un mot de passe valide.";
        $passwordIssue = TRUE;
    }

    if ($error === "") {
        $result = connectAccount($db, $_POST["email"], $_POST["password"]);

        if ($result[0] == TRUE) {
            redirectToHome();
        } else {
            $error .= "<br>- ".$result[1];

            if ($result[2] === "email") {
                $emailIssue = TRUE;
            } else {
                $passwordIssue = TRUE;
            }
        }
    }
}
?>

<!-- Contenu principal de la page -->
<main>
    <?php
    echo makeForm('S\'identifier sur <span style="font-weight: 900;">cardback', 'Se connecter',
        ($error !== "" ? '<p class="form-label-error">􀁡 Connexion impossible!'.$error.'</p>' : "").
        '<form method="post" id="page-form">
            '.makeTextboxWithAccessory("email-textbox", "email", "email", "E-mail", "􀍕", isset($_POST["email"]) ? $_POST["email"] : "", $emailIssue, "form-textbox form-textbox-error")
             .makeTextboxWithAccessory("password-textbox", "password", "password", "Mot de passe", "􀎠", isset($_POST["password"]) ? $_POST["password"] : "", $passwordIssue, "form-textbox").'
        </form>

        <a id="passwordforgotten-label" href="passwordrecovery">Mot de passe <span style="font-weight: 700;">oublié</span>?</a>');
    ?>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>