<?php
\cardback\system\checkAccountConnection(TRUE);

$error = "";

if (isset($_POST["submit"])) {
    if ($_POST["message"] === "") {
        $error .= "<br>- Veuillez entrer un avis.";
    }

    if ($error === "") {
        \cardback\system\createFeedback($_SESSION["accountId"], $_POST["message"], isset($_POST["recommended"]));

        \cardback\utility\redirect("home");
    } else {
        \cardback\utility\redirect(
                "feedback?error=".urlencode($error)."&recommended=".(isset($_POST["recommended"]) ? "1" : "0"));
    }
}

\cardback\utility\changeTitle("Feedback");
?>

<main>
    <?php
    echo \cardback\component\page\makeSidebar(4);
    ?>

    <div id="page-main">
        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <div id="content-title-container">
            <h2 class="theme-default-text">Nous avons besoin de votre avis!</h2>
        </div>

        <article id="content-main">
            <section>
                <form method="post" id="feedback-form">
                    <h4 class="theme-default-text" style="margin-bottom: 10px;">Donnez votre avis pour améliorer nos services:</h4>
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
                        echo \cardback\component\makeTextboxMultiline(
                            "message",
                            "text",
                            "Écrivez votre avis (5000 caractères maximum)",
                            "", isset($_GET["error"]), 5000);
                        ?>
                    </div>
                    <div style="width: 100%; margin-bottom: 20px;">
                        <label class="checkbox-label theme-default-text" style="border: 0;">Recommanderiez-vous ce site à un proche?
                            <input type="checkbox" name="recommended"<?php
                            echo isset($_GET["recommended"]) && $_GET["recommended"] == 1 ? " checked" : "" ?>>
                            <span class="checkmark theme-default-background"></span>
                        </label>
                    </div>
                    <input class="button-main" type="submit" form="feedback-form" name="submit" value="Envoyer"
                        style="margin: 0;" />
                </form>
            </section>
        </article>
    </div>
</main>
