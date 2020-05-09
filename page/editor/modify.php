<?php
\cardback\system\checkAccountConnection(TRUE);

$firstId = \cardback\database\selectMinId("packs");
$lastId = \cardback\database\selectMaxId("packs");

$pack = \cardback\system\getPack($_GET["id"])[1][0];

if (!isset($_GET["id"]) || $firstId[0] == 0 || $lastId[0] == 0 || $_GET["id"] < $firstId[1] ||
    $lastId[1] < $_GET["id"] || (!\cardback\system\checkUserOwnsPack($_SESSION["accountId"], $_GET["id"]) && $account["admin"] == 0) ||
    ($pack["published"] == 1 && $account["admin"] == 0)) {
    \cardback\utility\redirect("error/404");
}

$error = "";
$nameIssue = FALSE;
$difficultyIssue = FALSE;
$themeIssue = FALSE;

function dataSaver($url) {
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 5) === "acard" || substr($key, 0, 5) === "qcard") {
            $url .= "&$key=".urlencode($value);
        }
    }

    return $url;
}

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

        if ($result[0] == 1) {
            \cardback\utility\redirect(dataSaver("editor?id=".$_GET["id"]));
        } else {
            $error .= "<br>- ".$result[1];

            $nameIssue = TRUE;
        }
    }
}

$cards = \cardback\system\getAllCardsOfPack($_GET["id"])[1];

$getPageForm = function() {
    global $getTextbox;
    global $getSelect;
    global $nameIssue;
    global $difficultyIssue;
    global $themeIssue;
    global $error;
    global $themes;
    global $difficulties;
    global $pack;

    $themesString = array();
    $difficultiesString = array();

    foreach ($themes as $i => $value) {
        array_push($themesString, $value);
    }
    foreach ($difficulties as $i => $value) {
        array_push($difficultiesString, $value);
    }

    ?>
    <form
            method="post"
            id="page-form">
        <?php
        if ($error != "") {
            ?>
            <p
                    class="form-label-error">
                􀁡 Création impossible!<?php echo $error; ?></p>
            <?php
        }

        $getTextbox("name",
                "text",
                "Nom",
                "􀅯",
                isset($_POST["name"]) ? $_POST["name"] : $pack["name"], $nameIssue, "form-textbox",
                50);
        ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Il doit contenir entre 2 et 50 caractères.</h6>
        <?php
        $getTextbox("description",
                "text",
                "Description",
                "􀌄",
                isset($_POST["description"]) ? $_POST["description"] : $pack["description"], FALSE, "form-textbox",
                255);
          ?>
        <h6
                style="color: #8A8A8E; margin: -16px 5px 20px 5px;">
            Il doit contenir entre 2 et 50 caractères.</h6>
        <?php
        $getSelect("difficulty",
                "􀛸",
                "Difficulté",
                $difficultiesString,
                isset($_POST["difficulty"]) ? $_POST["difficulty"] : $pack["difficulty"], $difficultyIssue,
                "form-select");
          ?>
        <?php
        $getSelect("theme",
                "􀈕",
                "Thème",
                $themesString,
                isset($_POST["theme"]) ? $_POST["theme"] : $pack["theme"],$themeIssue, "form-select");
          ?>
    </form>
    <?php
};

\cardback\utility\changeTitle("Modification d'un paquet");
?>

    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php $getForm('Modification d\'un paquet', 'Modifier', $getPageForm, $serverUrl.dataSaver("/editor?id=".$_GET['id'])); ?>
    </main>

    <!-- Pied de page -->
<?php $getFooter(); ?>