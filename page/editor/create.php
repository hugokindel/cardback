<?php
\cardback\system\checkAccountConnection(TRUE);

$error = "";
$nameIssue = FALSE;
$difficultyIssue = FALSE;
$themeIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!\cardback\utility\checkName($_POST["name"])) {
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
        $result = \cardback\system\createPack($_SESSION["accountId"],
            $_POST["name"],
            $_POST["description"],
            $_POST["difficulty"],
            $_POST["theme"]);

        if ($result[0] == TRUE) {
            \cardback\utility\redirect("editor?id=".\cardback\database\selectMaxId("packs")[1]);
        } else {
            $error .= "<br>- ".$result[1];

            $nameIssue = TRUE;
        }
    }
}

\cardback\utility\changeTitle("Création d'un paquet");
?>

<!-- Contenu principal de la page -->
<main id="main-with-footer">
    <?php
    global $themes;
    global $difficulties;

    $themesString = array();
    $difficultiesString = array();

    foreach ($themes as $i => $value) {
        array_push($themesString, $value);
    }
    foreach ($difficulties as $i => $value) {
        array_push($difficultiesString, $value);
    }

    echo \cardback\component\makeForm('Création d\'un paquet', 'Créer',
        ($error !== "" ? '<p class="form-label-error">􀁡 Création impossible!'.$error.'</p>' : "").
            '<form method="post" id="page-form">
                '.\cardback\component\makeTextboxWithAccessory(
                    "name",
                    "text",
                    "Nom",
                    "􀅯",
                    isset($_POST["name"]) ? $_POST["name"] : "", $nameIssue, "form-textbox",
                    50).'
                <h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Il doit contenir entre 2 et 50 caractères.</h6>'
                .\cardback\component\makeTextboxWithAccessory(
                    "description",
                    "text",
                    "Description",
                    "􀌄",
                    isset($_POST["description"]) ? $_POST["description"] : "", FALSE, "form-textbox",
                    255).'
                <h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Optionnel, il peut contenir au maximum 255 caractères.</h6>'
                .\cardback\component\makeSelectWithAccessory(
                    "difficulty",
                    "􀛸",
                    "Difficulté",
                    $difficultiesString,
                    isset($_POST["difficulty"]) ? $_POST["difficulty"] : "", $difficultyIssue,
                    "form-select")
                .\cardback\component\makeSelectWithAccessory(
                    "theme",
                    "􀈕",
                    "Thème",
                    $themesString,
                    isset($_POST["theme"]) ? $_POST["theme"] : "",$themeIssue, "form-select").'
            </form>');
    ?>
</main>

<!-- Pied de page -->
<?php
echo \cardback\component\page\makeFooter();
?>