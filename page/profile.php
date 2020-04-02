<?php
checkIsConnectedToAccount();

require_once 'core/component/title.php';
require_once 'core/component/sidebar.php';
require_once 'core/component/toolbar.php';

changeTitle("Profil");
?>

<main>
    <div class="sidebar-main">
        <?php
        echo makeTitle();
        echo makeSidebar(2);
        ?>
    </div>

    <div class="content-main">
        <?php
        echo makeToolbar();
        ?>
    </div>
</main>
