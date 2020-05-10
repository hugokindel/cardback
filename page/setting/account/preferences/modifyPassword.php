<?php

use function cardback\system\checkAccountConnection;
use function cardback\system\updateAccountPassword;
use function cardback\utility\changeTitle;
use function cardback\utility\checkPassword;
use function cardback\utility\redirect;

checkAccountConnection(TRUE);

$error = "";
$passwordAccountIssue = FALSE;
$passwordIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!password_verify($_POST["passwordAccount"], $account["password"])) {
        $error .= "<br>- Veuillez entrer votre mot de passe actuel.";
        $passwordAccountIssue = TRUE;
    }

    if (!checkPassword($_POST["password"])) {
        $error .= "<br>- Veuillez entrer un mot de passe valide.";
        $passwordIssue = TRUE;
    }

    if ($error === "") {
        updateAccountPassword($_SESSION["accountId"], $_POST["password"]);
        redirect("/setting/account/preferences");
    }
}

$getPageForm = function() {
    global $getTextbox;
    global $passwordAccountIssue;
    global $passwordIssue;
    global $error;

    ?>
    <form
            method="post"
            id="page-form">
        <?php
        if ($error != "") {
            ?>
            <p
                    class="form-label-error">
                􀁡 Modification impossible!<?php echo $error; ?></p>
            <?php
        }

        $getTextbox("passwordAccount", "password", "Mot de passe actuel", "􀎠",
                isset($_POST["passwordAccount"]) ? $_POST["passwordAccount"] : "", $passwordAccountIssue,
                "form-textbox",
                255);
        ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Entrez d'abord votre mot de passe actuel.</h6>
        <?php
        $getTextbox("password", "password", "Nouveau mot de passe", "􀎠",
                isset($_POST["password"]) ? $_POST["password"] : "", $passwordIssue,
                "form-textbox",
                255);
        ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Il doit contenir entre 8 et 64 caractères, au moins une minuscule, une majuscule,
            un chiffre et un symbole parmi la liste suivante « !"#$%&'()*+,-./:;<=>?@[\]^_`{|}~ ».</h6>
    </form>
    <?php
};

changeTitle("Modifier mon mot de passe");
?>

    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php
        $getForm(
            'Modifier mon mot de passe',
            'Modifier', $getPageForm, $serverUrl."setting/account/preferences");
        ?>
    </main>

    <!-- Pied de page -->
<?php $getFooter(); ?>