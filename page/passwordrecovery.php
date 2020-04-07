<?php
checkIsNotConnectedToAccount();

$error = "";
$emailIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!checkEmail($_POST["email"])) {
        $error .= "<br>- Veuillez entrer une adresse mail valide.";
        $emailIssue = TRUE;
    }

    if ($error === "") {
        // TODO: récupération d'email
    }
}

require_once 'core/component/default/textbox.php';
require_once 'core/component/default/form.php';
require_once 'core/component/page/footer.php';

changeTitle("Se connecter");
?>

<!-- Contenu principal de la page -->
<main id="main-with-footer">
    <?php
    echo makeForm('Récupération de mot de passe', 'Récupérer',
        ($error !== "" ? '<p class="form-label-error">􀁡 Récupération impossible!'.$error.'</p>' : "").
        '<form method="post" id="page-form">
            '.makeTextboxWithAccessory("email", "email", "E-mail", "􀍕", isset($_POST["email"]) ? $_POST["email"] : "", $emailIssue, "form-textbox").'
        </form>', $baseUrl."/signin");
    ?>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>