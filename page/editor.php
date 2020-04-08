<?php
checkIsConnectedToAccount();

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';

changeTitle("Éditeur de paquet");
?>

<main>
    <?php
    echo makeSidebar(-1);
    ?>

    <div id="content-main">
        <div id="content-title-container">
            <h2>Créateur de paquet</h2>
        </div>
        <?php
        echo makeToolbar(1, FALSE);
        ?>
    </div>
</main>
