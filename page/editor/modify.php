<?php
checkIsConnectedToAccount();

$firstId = getFirstPackId();
$lastId = getLastPackId();

$pack = getPack($_GET["id"])[1];

if (!isset($_GET["id"]) || $firstId[0] == FALSE || $lastId == FALSE || $_GET["id"] < $firstId[1] || $lastId[1] < $_GET["id"] || !userOwnPack($_SESSION["accountId"], $_GET["id"]) || $pack["published"] == 1) {
    redirectTo404();
}

$error = "";
$nameIssue = FALSE;
$difficultyIssue = FALSE;
$themeIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!checkName($_POST["name"])) {
        $error .= "<br>- Veuillez entrer un nom valide.";
        $nameIssue = TRUE;
    }

    if ($error === "") {
        $result = modifyPack($_GET["id"], $_POST["name"], $_POST["difficulty"], $_POST["theme"]);

        if ($result[0] == TRUE) {
            redirectToEditor($_GET["id"]);
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

changeTitle("Modification d'un paquet");

$cards = getAllCardsOfPack($_GET["id"]);
?>

    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php
        global $baseUrl;

        echo makeForm('Modification d\'un paquet', 'Modifier',
            ($error !== "" ? '<p class="form-label-error">􀁡 Modification impossible!'.$error.'</p>' : "").
            '<form method="post" id="page-form">
            '.makeTextboxWithAccessory("name", "text", "Nom", "􀅯",
                isset($_POST["name"]) ? $_POST["name"] : $pack["name"], $nameIssue, "form-textbox")
            .makeSelectWithAccessory("difficulty", "􀛸", "Difficulté", ["Facile", "Moyen", "Difficile"], isset($_POST["difficulty"]) ? $_POST["difficulty"] : $pack["difficulty"], $difficultyIssue, "form-select")
            .makeSelectWithAccessory("theme", "􀈕", "Thème", ["Informatique", "Mathématiques", "Géographie", "Histoire", "Langues", "Divertissement", "Autres"], isset($_POST["theme"]) ? $_POST["theme"] : $pack["theme"], $themeIssue, "form-select").'
        </form>', $baseUrl."/editor?id=".$_GET["id"]);
        ?>
    </main>

    <!-- Pied de page -->
<?php
echo makeFooter();
?>