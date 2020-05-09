<?php
\cardback\system\checkAccountConnection(TRUE);
\cardback\system\checkAccountAdministration();

$firstId = \cardback\database\selectMinId("users");
$lastId = \cardback\database\selectMaxId("users");

if (!isset($_GET["id"]) || $firstId[0] == 0 || $lastId[0] == 0 || $_GET["id"] < $firstId[1] || $lastId[1] < $_GET["id"]) {
    \cardback\utility\redirect("error/404");
}

$accountUser = \cardback\system\getAccount($_GET["id"])[1][0];

$error = "";
$emailIssue = FALSE;
$firstNameIssue = FALSE;
$lastNameIssue = FALSE;
$descriptionIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!\cardback\utility\checkEmail($_POST["email"])) {
        $error .= "<br>- Veuillez entrer une adresse e-mail valide.";
        $emailIssue = TRUE;
    }

    if (!\cardback\utility\checkName($_POST["firstname"])) {
        $error .= "<br>- Veuillez entrer un nom de famille valide.";
        $firstNameIssue = TRUE;
    }

    if (!\cardback\utility\checkName($_POST["lastname"])) {
        $error .= "<br>- Veuillez entrer un prénom valide.";
        $lastNameIssue = TRUE;
    }

    if ($error === "") {
        \cardback\system\updateAccount($_GET["id"], $_POST["email"], $_POST["firstname"], $_POST["lastname"], $_POST["description"]);
        \cardback\utility\redirect("profile?id=".$_GET["id"]);
    }
}

$getPageForm = function() {
    global $getTextbox;
    global $accountUser;
    global $emailIssue;
    global $firstNameIssue;
    global $lastNameIssue;
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

        $getTextbox("email", "email", "E-mail", "􀍕",
                isset($_POST["email"]) ? $_POST["email"] : $accountUser["email"], $emailIssue,
                "form-textbox",
                254);
        $getTextbox("firstname", "text", "Prénom", "􀉩",
                isset($_POST["firstname"]) ? $_POST["firstname"] : $accountUser["firstName"], $firstNameIssue,
                "form-textbox",
                50);
          ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Il doit contenir entre 2 et 50 caractères.</h6>
        <?php
        $getTextbox("lastname", "text", "Nom de famille", "􀉩",
                isset($_POST["lastname"]) ? $_POST["lastname"] : $accountUser["lastName"], $lastNameIssue,
                "form-textbox",
                50);
          ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Il doit contenir entre 2 et 50 caractères.</h6>
        <?php
        $getTextbox("description", "text", "Description", "􀈏",
                isset($_POST["description"]) ? $_POST["description"] : $accountUser["description"], $descriptionIssue,
                "form-textbox",
                255);
          ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Il doit contenir entre 1 et 255 caractères.
            <br>Décrivez vous en quelques mots!</h6>
    </form>
    <?php
};

\cardback\utility\changeTitle("Modifier un profil");
?>

    <!-- Contenu principal de la page -->
    <main
            id="main-with-footer">
        <?php $getForm('Modifier un profil', 'Modifier', $getPageForm, $serverUrl."profile?id=".$_GET["id"]); ?>
    </main>

    <!-- Pied de page -->
<?php $getFooter(); ?>