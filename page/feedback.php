<?php
checkIsConnectedToAccount();

require_once 'core/component/page/title.php';
require_once 'core/component/page/sidebar.php';
require_once 'core/component/page/toolbar.php';
require_once 'core/component/page/search.php';
require_once 'core/component/default/textbox.php';

changeTitle("Feedback");
?>

<main>
    <?php
    echo makeSidebar(4);
    ?>

    <div id="page-main">
        <?php
        echo makeToolbar();
        ?>

        <div id="page-title-container">
            <h2>Nous avons besoin de votre avis!</h2>
        </div>

        <article id="content-main">

        </article>
    </div>
</main>
