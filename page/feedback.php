<?php

use function cardback\system\checkAccountConnection;
use function cardback\system\createFeedback;
use function cardback\utility\changeTitle;
use function cardback\utility\redirect;

checkAccountConnection(TRUE);

$error = "";

if (isset($_POST["submit"])) {
    if (trim($_POST["message"]) == "") {
        $error .= "<br>- Veuillez entrer un avis.";
    }

    if ($error === "") {
        createFeedback($_SESSION["accountId"], $_POST["message"], isset($_POST["recommended"]));

        redirect("home");
    } else {
        redirect(
                "feedback?error=".urlencode($error)."&recommended=".(isset($_POST["recommended"]) ? "1" : "0"));
    }
}

changeTitle("Feedback");
?>

<main>
    <?php $getSidebar(4); ?>
    <div
            id="page-main">
        <?php $getToolbar(); ?>
        <div
                id="content-title-container">
            <h2
                    class="theme-default-text">
                Nous avons besoin de votre avis!</h2>
        </div>
        <article
                id="content-main">
            <section>
                <form
                        method="post"
                        id="feedback-form">
                    <h4
                            class="theme-default-text"
                            style="margin-bottom: 10px;">
                        Donnez votre avis pour améliorer nos services:</h4>
                    <?php
                    if (isset($_GET["error"])) {
                    ?>
                        <div
                                style="width: 100%; margin-bottom: 10px;">
                            <p
                                    class="form-label-error"
                                    style="text-align: left;">
                                􀁡 Envoi impossible!<?php echo $_GET["error"] ?></p>
                        </div>
                    <?php
                    }
                    ?>
                    <div
                            style="width: 100%; margin-bottom: 10px;">
                        <?php
                        $getTextboxMultiline(
                                "message",
                            "text",
                            "Écrivez votre avis (5000 caractères maximum)",
                            "", isset($_GET["error"]), 5000);
                        ?>
                    </div>
                    <?php
                    $getCheckbox(
                            "Recommanderiez-vous ce site à un proche?",
                            isset($_GET["recommended"]) && $_GET["recommended"] == 1,
                            "width: 100%; margin-bottom: 20px;");
                    ?>
                    <input
                            class="button-main"
                            type="submit"
                            form="feedback-form"
                            name="submit"
                            value="Envoyer"
                            style="margin: 0;" />
                </form>
            </section>
        </article>
    </div>
</main>
