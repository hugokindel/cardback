<?php

use function cardback\system\checkAccountConnection;
use function cardback\system\updateAccountName;
use function cardback\utility\changeTitle;
use function cardback\utility\checkName;
use function cardback\utility\redirect;

checkAccountConnection(TRUE);

$error = "";
$firstNameIssue = FALSE;
$lastNameIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!checkName($_POST["firstname"])) {
        $error .= "<br>- Veuillez entrer un nom de famille valide.";
        $firstNameIssue = TRUE;
    }

    if (!checkName($_POST["lastname"])) {
        $error .= "<br>- Veuillez entrer un prénom valide.";
        $lastNameIssue = TRUE;
    }

    if ($error === "") {
        updateAccountName($_SESSION["accountId"], $_POST["firstname"], $_POST["lastname"]);
        redirect("/setting/account/preferences");
    }
}

$getPageForm = function() {
    global $getTextbox;
    global $account;
    global $firstNameIssue;
    global $lastNameIssue;
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

        $getTextbox("firstname", "text", "Prénom", "􀉩",
                isset($_POST["firstname"]) ? $_POST["firstname"] : $account["firstName"], $firstNameIssue,
                "form-textbox",
                50);
        ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Il doit contenir entre 2 et 50 caractères.</h6>
        <?php
        $getTextbox("lastname", "text", "Nom de famille", "􀉩",
                isset($_POST["lastname"]) ? $_POST["lastname"] : $account["lastName"], $lastNameIssue,
                "form-textbox",
                50);
        ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Il doit contenir entre 2 et 50 caractères.</h6>
    </form>
    <?php
};

changeTitle("Modifier mon nom/prénom");
?>
®
    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php
        $getForm(
            'Modifier mon nom/prénom',
            'Modifier', $getPageForm, $serverUrl."setting/account/preferences");
        ?>
    </main>

    <!-- Pied de page -->
<?php $getFooter(); ?>