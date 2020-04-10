<?php
checkIsConnectedToAccount();

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';

changeTitle("Paramètres");
?>

<main>
    <?php
    echo makeSidebar(3);
    ?>

    <div id="page-main">
        <?php
        echo makeToolbar();
        ?>
    </div>
</main>
