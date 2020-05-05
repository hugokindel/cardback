<?php
\cardback\system\checkAccountConnection(TRUE);

$error = "";
$passwordAccountIssue = FALSE;
$passwordIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!password_verify($_POST["passwordAccount"], $account["password"])) {
        $error .= "<br>- Veuillez entrer votre mot de passe actuel.";
        $passwordAccountIssue = TRUE;
    }

    if (!\cardback\utility\checkPassword($_POST["password"])) {
        $error .= "<br>- Veuillez entrer un mot de passe valide.";
        $passwordIssue = TRUE;
    }

    if ($error === "") {
        \cardback\system\updateAccountPassword($_SESSION["accountId"], $_POST["password"]);
        \cardback\utility\redirect("/settings/account/preferences");
    }
}

\cardback\utility\changeTitle("Modifier mon mot de passe");
?>

    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php
        echo \cardback\component\makeForm(
            'Modifier mon mot de passe',
            'Modifier',
            ($error !== "" ? '<p class="form-label-error">􀁡 Modification impossible!'.$error.'</p>' : "").
            '<form method="post" id="page-form">
                '.cardback\component\makeTextboxWithAccessory(
                "passwordAccount", "password", "Mot de passe actuel", "􀎠",
                isset($_POST["passwordAccount"]) ? $_POST["passwordAccount"] : "", $passwordAccountIssue,
                "form-textbox",
                255)
            .'<h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Entrez d\'abord votre mot de passe actuel.</h6>'
            .cardback\component\makeTextboxWithAccessory(
                "password", "password", "Nouveau mot de passe", "􀎠",
                isset($_POST["password"]) ? $_POST["password"] : "", $passwordIssue,
                "form-textbox",
                255).'
                <h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Il doit contenir entre 8 et 64 caractères, au moins une minuscule, une majuscule, 
                    un chiffre et un symbole parmi la liste suivante « !"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~ ».</h6>
            </form>', $serverUrl."/settings/account/preferences");
        ?>
    </main>

    <!-- Pied de page -->
<?php
echo \cardback\component\page\makeFooter();
?>