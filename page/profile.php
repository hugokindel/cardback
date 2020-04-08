<?php
checkIsConnectedToAccount();

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';

changeTitle("Profil");
?>

<main>
    <?php
    echo makeSidebar(2);
    ?>

    <div id="content-main">
        <?php
        echo makeToolbar();
        ?>
    </div>
</main>
