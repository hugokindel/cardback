<?php
\cardback\system\checkAccountConnection(TRUE);

$error = "";
$firstNameIssue = FALSE;
$lastNameIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!\cardback\utility\checkName($_POST["firstname"])) {
        $error .= "<br>- Veuillez entrer un nom de famille valide.";
        $firstNameIssue = TRUE;
    }

    if (!\cardback\utility\checkName($_POST["lastname"])) {
        $error .= "<br>- Veuillez entrer un prénom valide.";
        $lastNameIssue = TRUE;
    }

    if ($error === "") {
        \cardback\system\updateAccountName($_SESSION["accountId"], $_POST["firstname"], $_POST["lastname"]);
        \cardback\utility\redirect("/settings/account/preferences");
    }
}

\cardback\utility\changeTitle("Modifier mon nom/prénom");
?>
®
    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php
        echo \cardback\component\makeForm(
            'Modifier mon nom/prénom',
            'Modifier',
            ($error !== "" ? '<p class="form-label-error">􀁡 Modification impossible!'.$error.'</p>' : "").
            '<form method="post" id="page-form">
                '.cardback\component\makeTextboxWithAccessory(
                    "firstname", "text", "Prénom", "􀉩",
                    isset($_POST["firstname"]) ? $_POST["firstname"] : $account["firstName"], $firstNameIssue,
                    "form-textbox",
                    50).'
                <h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Il doit contenir entre 2 et 50 caractères.</h6>
                '.cardback\component\makeTextboxWithAccessory(
                    "lastname", "text", "Nom de famille", "􀉩",
                    isset($_POST["lastname"]) ? $_POST["lastname"] : $account["lastName"], $lastNameIssue,
                    "form-textbox",
                    50).'
                <h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Il doit contenir entre 2 et 50 caractères.</h6>
            </form>', $serverUrl."/settings/account/preferences");
        ?>
    </main>

    <!-- Pied de page -->
<?php
echo \cardback\component\page\makeFooter();
?>