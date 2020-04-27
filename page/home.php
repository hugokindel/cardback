<?php
checkIsConnectedToAccount();

if (isset($_POST["disconnect"])) {
    disconnectAccount();
    redirect();
}

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once 'core/component/page/search.php';
require_once 'core/component/default/textbox.php';

changeTitle("Accueil");

$data = getAccountData($_SESSION["accountId"], $_SESSION["accountPassword"]);
?>

<main>
    <?php
    echo makeSidebar(0);
    ?>

    <div id="page-main">
        <div id="content-title-container">
            <?php
            echo makeSearchBar("Chercher un de vos paquet ou un thème");
            ?>
        </div>

        <?php
        echo makeToolbar();
        ?>

        <article id="content-main">
            <section>
                <form method="post" id="remove-pack-form"><input type="submit" id="right-toolbar-secondary-button" class="button-main" name="disconnect" value="Se déconnecter" /></form>
            </section>
        </article>
    </div>
</main>
