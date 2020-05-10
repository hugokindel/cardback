<?php
\cardback\system\checkAccountConnection(TRUE);

$error = "";
$descriptionIssue = FALSE;

if (isset($_POST["submit"])) {
    \cardback\system\updateAccountDescription($_SESSION["accountId"], $_POST["description"]);
    \cardback\utility\redirect("/setting/account/preferences");
}

$getPageForm = function() {
    global $getTextbox;
    global $account;
    global $descriptionIssue;
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

        $getTextbox("description", "text", "Description", "􀈏",
                isset($_POST["description"]) ? $_POST["description"] : $account["description"], $descriptionIssue,
                "form-textbox",
                255);
        ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Optionnel, il peut contenir jusqu'à 255 caractères.<br>
            Décrivez vous en quelques mots!</h6>
    </form>
    <?php
};

\cardback\utility\changeTitle("Modifier ma description");
?>

    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php
        $getForm(
            'Modifier ma description',
            'Modifier', $getPageForm, $serverUrl."setting/account/preferences");
        ?>
    </main>

    <!-- Pied de page -->
<?php $getFooter(); ?>