<?php
\cardback\system\checkAccountConnection(FALSE);

$error = "";
$emailIssue = FALSE;
$firstNameIssue = FALSE;
$lastNameIssue = FALSE;
$passwordIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!\cardback\utility\checkEmail($_POST["email"])) {
        $error .= "<br>- Veuillez entrer une adresse e-mail valide.";
        $emailIssue = TRUE;
    }

    if (!\cardback\utility\checkName($_POST["firstname"])) {
        $error .= "<br>- Veuillez entrer un prénom valide.";
        $firstNameIssue = TRUE;
    }

    if (!\cardback\utility\checkName($_POST["lastname"])) {
        $error .= "<br>- Veuillez entrer un nom valide.";
        $lastNameIssue = TRUE;
    }

    if (!\cardback\utility\checkPassword($_POST["password"])) {
        $error .= "<br>- Veuillez entrer un mot de passe valide.";
        $passwordIssue = TRUE;
    }

    if ($error === "") {
        $result = \cardback\system\createAccount(
            $_POST["email"], $_POST["password"], $_POST["firstname"], $_POST["lastname"]);

        if ($result[0] == TRUE) {
            \cardback\system\connectWithCredentials($_POST["email"], $_POST["password"]);
            \cardback\utility\redirect("home");
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

\cardback\utility\changeTitle("S'inscrire");
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