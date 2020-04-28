<?php
checkIsConnectedToAccount();

$error = "";

if (isset($_POST["submit"])) {
    if ($_POST["message"] === "") {
        $error .= "<br>- Veuillez entrer un avis.";
    }

    if ($error === "") {
        createFeedback($_SESSION["accountId"], $_POST["message"], isset($_POST["recommended"]));

        redirectToHome();
    } else {
        redirect("feedback?error=".urlencode($error)."&recommended=".(isset($_POST["recommended"]) ? "1" : "0"));
    }
}

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once 'core/component/page/search.php';
require_once 'core/component/default/textbox.php';

changeTitle("Feedback");
?>

<main>
    <?php
    echo makeSidebar(4);
    ?>

    <div id="page-main">
        <?php
        echo makeToolbar();
        ?>

        <div id="page-title-container">
            <h2>Nous avons besoin de votre avis!</h2>
        </div>

        <article id="content-main">
            <section>
                <form method="post" id="feedback-form">
                    <h4 style="margin-bottom: 10px;">Donnez votre avis pour améliorer nos services:</h4>
                    <?php
                    if (isset($_GET["error"])) {
                    ?>
                        <div style="width: 100%; margin-bottom: 10px;">
                            <p class="form-label-error" style="text-align: left;">􀁡 Envoi impossible!<?php echo $_GET["error"] ?></p>
                        </div>
                    <?php
                    }
                    ?>
                    <div style="width: 100%; margin-bottom: 10px;">
                        <?php
                        echo makeTextboxMultiline("message", "text", "Écrivez votre avis (5000 caractères maximum)", "", isset($_GET["error"]));
                        ?>
                    </div>
                    <div style="width: 100%; margin-bottom: 20px;">
                        <label class="checkbox-label">Recommanderiez-vous ce site à un proche?
                            <input type="checkbox" name="recommended"<?php echo isset($_GET["recommended"]) && $_GET["recommended"] == 1 ? " checked" : "" ?>>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <input class="button-main" type="submit" form="feedback-form" name="submit" value="Envoyer" style="margin: 0;" />
                </form>
            </section>
        </article>
    </div>
</main>
