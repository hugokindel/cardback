<?php
checkIsConnectedToAccount();

$error = "";
$nameIssue = FALSE;
$difficultyIssue = FALSE;
$themeIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!checkName($_POST["name"])) {
        $error .= "<br>- Veuillez entrer un nom valide.";
        $nameIssue = TRUE;
    }

    if (!isset($_POST["difficulty"])) {
        $error .= "<br>- Veuillez choisir une difficulté.";
        $difficultyIssue = TRUE;
    }

    if (!isset($_POST["theme"])) {
        $error .= "<br>- Veuillez choisir un thème.";
        $themeIssue = TRUE;
    }

    if ($error === "") {
        $result = createPack($_SESSION["accountId"], $_POST["name"], $_POST["difficulty"], $_POST["theme"]);

        if ($result[0] == TRUE) {
            redirectToEditor(getLastPackId()[1]);
        } else {
            $error .= "<br>- ".$result[1];

            $nameIssue = TRUE;
        }
    }
}

require_once 'core/component/default/textbox.php';
require_once 'core/component/default/select.php';
require_once 'core/component/default/form.php';
require_once 'core/component/page/footer.php';

changeTitle("Création d'un paquet");
?>

<!-- Contenu principal de la page -->
<main id="main-with-footer">
    <?php
    echo makeForm('Création d\'un paquet', 'Créer',
        ($error !== "" ? '<p class="form-label-error">􀁡 Création impossible!'.$error.'</p>' : "").
        '<form method="post" id="page-form">
            '.makeTextboxWithAccessory("name", "text", "Nom", "􀅯",
                isset($_POST["name"]) ? $_POST["name"] : "", $nameIssue, "form-textbox")
             .makeSelectWithAccessory("difficulty", "􀛸", "Difficulté", ["Facile", "Moyen", "Difficile"], isset($_POST["difficulty"]) ? $_POST["difficulty"] : "", $difficultyIssue, "form-select")
             .makeSelectWithAccessory("theme", "􀈕", "Thème", ["Informatique", "Mathématiques", "Géographie", "Histoire", "Langues", "Divertissement", "Autres"], isset($_POST["theme"]) ? $_POST["theme"] : "", $themeIssue, "form-select").'
        </form>');
    ?>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>