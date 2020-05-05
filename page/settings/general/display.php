<?php
\cardback\system\checkAccountConnection(TRUE);

if (isset($_POST) && isset($_POST["theme"])) {
    setcookie('theme', $_POST["theme"], time() + 365243600, "/", null, false, true);

    \cardback\utility\redirect("settings/general/display");
}

\cardback\utility\changeTitle("Paramètres d'affichage");
?>

<main>
    <?php
    echo \cardback\component\page\makeSidebar(3);
    ?>

    <div id="page-main">
        <?php
        echo \cardback\component\page\makeToolbar();
        ?>

        <article id="content-settings-main">
            <?php
            echo \cardback\component\page\makeSettingsCategories(0);
            ?>

            <section style="width: 540px; position: fixed; top: 0;">
                <div class="settings-top-category-container">
                    <h3 class="settings-title theme-default-text">Affichage</h3>
                </div>

                <div class="settings-option-container" style="cursor: inherit;">
                    <div>
                        <h4 class="theme-default-text" style="font-weight: normal; margin-left: 20px;">Thème</h4>
                    </div>
                    <div style="position: relative; top: -48px;">
                        <form method="post" id="theme-form">
                            <ul class="radio-buttons-container" style="float: right; margin-right: 20px; height: 48px; display: flex; justify-content: center; align-items: center;">
                                <li class="radio-button">
                                    <input type="radio" id="light" name="theme" value="light"
                                           onclick="document.getElementById('theme-form').submit();"
                                        <?php echo (isset($_COOKIE["theme"]) && $_COOKIE["theme"] == "light")
                                            || !isset($_COOKIE["theme"]) ? "checked" : "" ?>/>
                                    <label class="theme-default-text" for="light">Clair</label>
                                    <div style="width: 1px; height: 100%; border-left: 1px solid #E9EEF2; position: relative; left: 50px; padding-bottom: 1px; margin-left: 1px;"></div>
                                </li>
                                <li class="radio-button">
                                    <input type="radio" id="dark" name="theme" value="dark"
                                           onclick="document.getElementById('theme-form').submit();"
                                        <?php echo isset($_COOKIE["theme"]) &&
                                            $_COOKIE["theme"] == "dark" ? "checked" : "" ?>/>
                                    <label class="theme-default-text" for="dark">Sombre</label>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </section>
        </article>
    </div>
</main>