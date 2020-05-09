<?php
\cardback\system\checkAccountConnection(FALSE);

$error = "";
$emailIssue = FALSE;
$passwordIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!\cardback\utility\checkEmail($_POST["email"])) {
        $error .= "<br>- Veuillez entrer une adresse mail valide.";
        $emailIssue = TRUE;
    }

    if (!\cardback\utility\checkPassword($_POST["password"])) {
        $error .= "<br>- Veuillez entrer un mot de passe valide (entre 8 et 64 caractères, au moins une minuscule, une 
            majuscule, un chiffre et un symbole parmi la liste suivante « !\"#$%&'()*+,-./:;<=>?@[\]^_`{|}~ ».).";
        $passwordIssue = TRUE;
    }

    if ($error === "") {
        $result = \cardback\system\connectWithCredentials($_POST["email"], $_POST["password"]);

        if ($result[0] == TRUE) {
            \cardback\utility\redirect("home");
        } else {
            $error .= "<br>- ".$result[1];

            if ($result[2] === "email") {
                $emailIssue = TRUE;
            } else {
                $passwordIssue = TRUE;
            }
        }
    }
}

$getPageForm = function() {
    global $getTextbox;
    global $emailIssue;
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
                􀁡 Connexion impossible!<?php echo $error; ?></p>
            <?php
        }

        $getTextbox("email", "email", "E-mail", "􀍕",
                isset($_POST["email"]) ? $_POST["email"] : "", $emailIssue,
                "form-textbox",
                254);
        $getTextbox("password", "password", "Mot de passe", "􀎠",
                isset($_POST["password"]) ? $_POST["password"] : "", $passwordIssue,
                "form-textbox",
                64);
        ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Il doit contenir entre 8 et 64 caractères, au moins une minuscule, une majuscule,
            un chiffre et un symbole parmi la liste suivante « !"#$%&'()*+,-./:;<=>?@[\]^_`{|}~ ».</h6>
    </form>
    <?php
};

\cardback\utility\changeTitle("Se connecter");
?>

<!-- Contenu principal de la page -->
<main
        id="main-with-footer">
    <?php
    $getForm('S\'identifier sur <span style="font-weight: 900;">cardback',
            'Se connecter',
            $getPageForm);
    ?>
</main>

<!-- Pied de page -->
<?php $getFooter(); ?>