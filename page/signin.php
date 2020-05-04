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
        $result = \cardback\system\connectAccount($_POST["email"], $_POST["password"]);

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

\cardback\utility\changeTitle("Se connecter");
?>

<!-- Contenu principal de la page -->
<main id="main-with-footer">
    <?php
    echo \cardback\component\makeForm('S\'identifier sur <span style="font-weight: 900;">cardback',
        'Se connecter',
        ($error !== "" ? '<p class="form-label-error">􀁡 Connexion impossible!'.$error.'</p>' : "").
            '<form method="post" id="page-form">
                '.cardback\component\makeTextboxWithAccessory(
                    "email", "email", "E-mail", "􀍕",
                    isset($_POST["email"]) ? $_POST["email"] : "", $emailIssue,
                    "form-textbox",
                    254)
                .cardback\component\makeTextboxWithAccessory(
                    "password", "password", "Mot de passe", "􀎠",
                    isset($_POST["password"]) ? $_POST["password"] : "", $passwordIssue,
                    "form-textbox",
                    64).'
            </form>');
    ?>
</main>

<!-- Pied de page -->
<?php
echo \cardback\component\page\makeFooter();
?>