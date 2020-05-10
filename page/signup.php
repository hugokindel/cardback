<?php

use function cardback\system\checkAccountConnection;
use function cardback\system\connectWithCredentials;
use function cardback\system\createAccount;
use function cardback\utility\changeTitle;
use function cardback\utility\checkEmail;
use function cardback\utility\checkName;
use function cardback\utility\checkPassword;
use function cardback\utility\redirect;

checkAccountConnection(FALSE);

$error = "";
$emailIssue = FALSE;
$firstNameIssue = FALSE;
$lastNameIssue = FALSE;
$passwordIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!checkEmail($_POST["email"])) {
        $error .= "<br>- Veuillez entrer une adresse e-mail valide.";
        $emailIssue = TRUE;
    }

    if (!checkName($_POST["firstname"])) {
        $error .= "<br>- Veuillez entrer un prénom valide.";
        $firstNameIssue = TRUE;
    }

    if (!checkName($_POST["lastname"])) {
        $error .= "<br>- Veuillez entrer un nom valide.";
        $lastNameIssue = TRUE;
    }

    if (!checkPassword($_POST["password"])) {
        $error .= "<br>- Veuillez entrer un mot de passe valide.";
        $passwordIssue = TRUE;
    }

    if ($error === "") {
        $result = createAccount(
            $_POST["email"], $_POST["password"], $_POST["firstname"], $_POST["lastname"]);

        if ($result[0] == TRUE) {
            connectWithCredentials($_POST["email"], $_POST["password"]);
            redirect("home");
        } else {
            $error .= "<br>- ".$result[1];
            $emailIssue = TRUE;
        }
    }
}

$getPageForm = function() {
    global $getTextbox;
    global $emailIssue;
    global $firstNameIssue;
    global $lastNameIssue;
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
                  􀁡 Inscription impossible!<?php echo $error; ?></p>
              <?php
          }

          $getTextbox("email", "email", "E-mail", "􀍕",
                  isset($_POST["email"]) ? $_POST["email"] : "", $emailIssue,
                  "form-textbox",
                  254);
          $getTextbox("firstname", "text", "Prénom", "􀉩",
                  isset($_POST["firstname"]) ? $_POST["firstname"] : "", $firstNameIssue,
                  "form-textbox",
                  50);
          ?>
          <h6
                  style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
              Il doit contenir entre 2 et 50 caractères.</h6>
          <?php
          $getTextbox("lastname", "text", "Nom de famille", "􀉩",
                  isset($_POST["lastname"]) ? $_POST["lastname"] : "", $lastNameIssue,
                  "form-textbox",
                  50);
          ?>
          <h6
                  style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
              Il doit contenir entre 2 et 50 caractères.</h6>
          <?php
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

changeTitle("S'inscrire");
?>

<!-- Contenu principal de la page -->
<main
        id="main-with-footer">
    <?php
    $getForm('S\'inscrire sur <span style="font-weight: 900;">cardback',
            'S\'inscrire',
            $getPageForm);
    ?>
</main>

<!-- Pied de page -->
<?php $getFooter(); ?>