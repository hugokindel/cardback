<?php
\cardback\system\checkAccountConnection(TRUE);

$error = "";
$descriptionIssue = FALSE;

if (isset($_POST["submit"])) {
    \cardback\system\updateAccountDescription($_SESSION["accountId"], $_POST["description"]);
    \cardback\utility\redirect("/settings/account/preferences");
}

\cardback\utility\changeTitle("Modifier ma description");
?>

    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php
        echo \cardback\component\makeForm(
            'Modifier ma description',
            'Modifier',
            ($error !== "" ? '<p class="form-label-error">􀁡 Modification impossible!'.$error.'</p>' : "").
            '<form method="post" id="page-form">
                '.cardback\component\makeTextboxWithAccessory(
                "description", "text", "Description", "􀈏",
                isset($_POST["description"]) ? $_POST["description"] : $account["description"], $descriptionIssue,
                "form-textbox",
                255).'
                <h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Il doit contenir entre 1 et 255 caractères.
                <br>Décrivez vous en quelques mots!</h6>
            </form>', $serverUrl."/settings/account/preferences");
        ?>
    </main>

    <!-- Pied de page -->
<?php
echo \cardback\component\page\makeFooter();
?>