<?php
\cardback\system\checkAccountConnection(TRUE);

$firstId = \cardback\database\selectMinId("packs");
$lastId = \cardback\database\selectMaxId("packs");

$pack = \cardback\system\getPack($_GET["id"])[1];

if (!isset($_GET["id"]) || $firstId[0] == FALSE || $lastId[0] == FALSE || $_GET["id"] < $firstId[1] ||
    $lastId[1] < $_GET["id"] || !\cardback\system\checkUserOwnsPack($_SESSION["accountId"], $_GET["id"]) ||
    $pack["published"] == 1) {
    \cardback\utility\redirect("404");
}

$error = "";
$nameIssue = FALSE;
$difficultyIssue = FALSE;
$themeIssue = FALSE;

if (isset($_POST["submit"])) {
    if (!\cardback\utility\checkName($_POST["name"])) {
        $error .= "<br>- Veuillez entrer un nom valide.";
        $nameIssue = TRUE;
    }

    if ($error === "") {
        $result = \cardback\system\changePack(
            $_GET["id"],
            $_POST["name"],
            $_POST["description"],
            $_POST["difficulty"],
            $_POST["theme"]);

        if ($result[0] == TRUE) {
            \cardback\utility\redirect("editor?id=".$_GET["id"]);
        } else {
            $error .= "<br>- ".$result[1];

            $nameIssue = TRUE;
        }
    }
}

$cards = \cardback\system\getAllCardsOfPack($_GET["id"])[1];

\cardback\utility\changeTitle("Modification d'un paquet");
?>

    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php
        global $serverUrl;

        echo \cardback\component\makeForm('Modification d\'un paquet', 'Modifier',
            ($error !== "" ? '<p class="form-label-error">􀁡 Modification impossible!'.$error.'</p>' : "").
            '<form method="post" id="page-form">
            '.\cardback\component\makeTextboxWithAccessory("name", "text", "Nom", "􀅯",
                isset($_POST["name"]) ? $_POST["name"] : $pack["name"], $nameIssue, "form-textbox", 50).'
            <h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Il doit contenir entre 2 et 50 caractères.</h6>'
            .\cardback\component\makeTextboxWithAccessory("description", "text", "Description", "􀌄",
                isset($_POST["description"]) ? $_POST["description"] : $pack["description"], FALSE, "form-textbox", 255).'
            <h6 style="color: #8A8A8E; margin: -16px 5px 20px 5px;">Optionnel, il peut contenir au maximum 255 caractères.</h6>'
            .\cardback\component\makeTextboxWithAccessory(
                "difficulty",
                "􀛸",
                "Difficulté",
                ["Facile", "Moyen", "Difficile"],
                isset($_POST["difficulty"]) ? $_POST["difficulty"] : $pack["difficulty"],
                $difficultyIssue,
                "form-select")
            .\cardback\component\makeTextboxWithAccessory(
                "theme",
                "􀈕",
                "Thème",
                ["Informatique", "Mathématiques", "Géographie", "Histoire", "Langues", "Divertissement", "Autres"],
                isset($_POST["theme"]) ? $_POST["theme"] : $pack["theme"],
                $themeIssue,
                "form-select").'
        </form>', $serverUrl."/editor?id=".$_GET["id"]);
        ?>
    </main>

    <!-- Pied de page -->
<?php
echo \cardback\component\page\makeFooter();
?>