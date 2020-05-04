<?php
\cardback\system\checkAccountConnection(TRUE);
\cardback\utility\changeTitle("À propos de");
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
            echo \cardback\component\page\makeSettingsCategories();
            ?>

            <section style="width: 540px; position: fixed; top: 0;">
                <div class="settings-top-category-container">
                    <h3 class="settings-title">À propos de <span style="font-weight: 900;">cardback</span></h3>
                </div>

                <div class="settings-option-container">
                    <a href="<?php echo $serverUrl; ?>/faq"><h3 class="settings-title">Foire aux questions</h3></a>
                </div>
            </section>
        </article>
    </div>
</main>
