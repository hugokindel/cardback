<?php
\cardback\system\checkAccountConnection(TRUE);

$error = "";
$emailIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!\cardback\utility\checkEmail($_POST["email"])) {
        $error .= "<br>- Veuillez entrer une adresse mail valide.";
        $emailIssue = TRUE;
    }

    if ($error === "") {
        // TODO: récupération d'email
    }
}

\cardback\utility\changeTitle("Se connecter");
?>

<!-- Contenu principal de la page -->
<main id="main-with-footer">
    <?php
    echo \cardback\component\makeForm('Récupération de mot de passe', 'Récupérer',
        ($error !== "" ? '<p class="form-label-error">􀁡 Récupération impossible!'.$error.'</p>' : "").
        '<form method="post" id="page-form">
            '.\cardback\component\makeTextboxWithAccessory(
                    "email", "email", "E-mail", "􀍕",
                    isset($_POST["email"]) ? $_POST["email"] : "", $emailIssue,
                    "form-textbox").'
        </form>', $serverUrl."/signin");
    ?>
</main>

<!-- Pied de page -->
<?php
echo \cardback\component\page\makeFooter();
?>