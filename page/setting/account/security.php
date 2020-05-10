<?php

use function cardback\system\checkAccountConnection;
use function cardback\system\hideFirstName;
use function cardback\system\hideInSearch;
use function cardback\system\hideLastName;
use function cardback\utility\changeTitle;
use function cardback\utility\redirect;

checkAccountConnection(TRUE);

if (isset($_POST)) {
    if (isset($_POST["hideFirstName"])) {
        hideFirstName($account["id"], isset($_POST["hideFirstNameCheckbox"]));
        redirect("setting/account/security");
    } else if (isset($_POST["hideLastName"])) {
        hideLastName($account["id"], isset($_POST["hideLastNameCheckbox"]));
        redirect("setting/account/security");
    } else if (isset($_POST["hideSearch"])) {
        hideInSearch($account["id"], isset($_POST["hideSearchCheckbox"]));
        redirect("setting/account/security");
    }
}

changeTitle("Paramètres de confidentialité et securité");
?>

<main>
    <?php
    $getSidebar(3);
    ?>

    <div id="page-main">
        <?php
        $getToolbar();
        ?>

        <article id="content-settings-main">
            <?php
            $getSettings(4);
            ?>

            <section style="width: 540px; position: fixed; top: 0;">
                <div class="settings-top-category-container">
                    <h3 class="settings-title theme-default-text">Confidentialité et sécurité</h3>
                </div>

                <div class="settings-category-container">
                    <h3 class="settings-title theme-default-text">Gestion de l'anonymat</h3>
                </div>
                <div class="settings-option-container">
                    <form method="post" id="hide-first-name-form">
                        <input type="hidden" name="hideFirstName" value="" />
                        <label class="checkbox-label theme-default-text" style="padding-left: 20px; line-height: 48px; font-size: 20px; font-weight: normal; border: 0;">Anonymiser mon prénom
                            <input type="checkbox" name="hideFirstNameCheckbox" onclick="document.getElementById('hide-first-name-form').submit();"<?php
                            echo $account["hideFirstName"] == 1 ? " checked" : "" ?>>
                            <span class="checkmark theme-default-background" style="left: unset; right: 20px; top: 11px;"></span>
                        </label>
                    </form>
                </div>
                <div class="settings-option-container">
                    <form method="post" id="hide-last-name-form">
                        <input type="hidden" name="hideLastName" value="" />
                        <label class="checkbox-label theme-default-text" style="padding-left: 20px; line-height: 48px; font-size: 20px; font-weight: normal; border: 0;">Anonymiser mon nom
                            <input type="checkbox" name="hideLastNameCheckbox" onclick="document.getElementById('hide-last-name-form').submit();"<?php
                            echo $account["hideLastName"] == 1 ? " checked" : "" ?>>
                            <span class="checkmark theme-default-background" style="left: unset; right: 20px; top: 11px;"></span>
                        </label>
                    </form>
                </div>
                <div class="settings-option-container">
                    <form method="post" id="hide-search-form">
                        <input type="hidden" name="hideSearch" value="" />
                        <label class="checkbox-label theme-default-text" style="padding-left: 20px; line-height: 48px; font-size: 20px; font-weight: normal; border: 0;">Ne pas apparaître dans les recherches
                            <input type="checkbox" name="hideSearchCheckbox" onclick="document.getElementById('hide-search-form').submit();"<?php
                            echo $account["hideInSearch"] == 1 ? " checked" : "" ?>>
                            <span class="checkmark theme-default-background" style="left: unset; right: 20px; top: 11px;"></span>
                        </label>
                    </form>
                </div>
            </section>
        </article>
    </div>
</main>
