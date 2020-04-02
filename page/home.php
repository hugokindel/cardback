<?php
checkIsConnectedToAccount();

if (isset($_POST["submit"])) {
    disconnectAccount();
    redirectToBase();
}

require_once 'core/component/title.php';
require_once 'core/component/sidebar.php';
require_once 'core/component/toolbar.php';

changeTitle("Accueil");

$data = getAccountData($_SESSION["accountId"], $_SESSION["accountPassword"]);
?>

<main>
    <div class="sidebar-main">
        <?php
        echo makeTitle();
        echo makeSidebar(0);
        ?>
    </div>

    <div class="content-main">
        <?php
        echo makeToolbar();
        ?>

        <div class="page-main">
            <h1>Bonjour, <?php echo $data[1][3]." ".$data[1][4] ?></h1>
            <form method="post" id="page-form"></form>
            <button class="button-main" type="submit" form="page-form" name="submit" style="margin-top: 50px; width: 220px;">Se déconnecter</button>
        </div>
    </div>
</main>
