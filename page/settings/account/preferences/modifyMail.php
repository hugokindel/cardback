<?php
\cardback\system\checkAccountConnection(TRUE);

$error = "";
$emailAccountIssue = FALSE;
$emailIssue = FALSE;

if (isset($_POST["submit"])) {
    if ($_POST["emailAccount"] != $account["email"]) {
        $error .= "<br>- Veuillez entrer votre adresse e-mail actuelle.";
        $emailAccountIssue = TRUE;
    }

    if (!\cardback\utility\checkEmail($_POST["email"])) {
        $error .= "<br>- Veuillez entrer une adresse e-mail valide.";
        $emailIssue = TRUE;
    }

    if ($error === "") {
        \cardback\system\updateAccountMail($_SESSION["accountId"], $_POST["email"]);
        \cardback\utility\redirect("/settings/account/preferences");
    }
}

\cardback\utility\changeTitle("Modifier mon e-mail");
?>

    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php
        echo \cardback\component\makeForm(
            'Modifier mon e-mail',
            'Modifier',
            ($error !== "" ? '<p class="form-label-error">􀁡 Modification impossible!'.$error.'</p>' : "").
            '<form method="post" id="page-form">
                '.cardback\component\makeTextboxWithAccessory(
                "emailAccount", "email", "E-mail actuelle", "􀍕",
                isset($_POST["emailAccount"]) ? $_POST["emailAccount"] : "", $emailAccountIssue,
                "form-textbox",
                254)
            .'<h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Entrez d\'abord votre adresse e-mail actuelle.</h6>'
            .cardback\component\makeTextboxWithAccessory(
                "email", "email", "Nouvelle e-mail", "􀍕",
                isset($_POST["email"]) ? $_POST["email"] : "", $emailIssue,
                "form-textbox",
                254).'
            </form>', $serverUrl."/settings/account/preferences");
        ?>
    </main>

    <!-- Pied de page -->
<?php
echo \cardback\component\page\makeFooter();
?>