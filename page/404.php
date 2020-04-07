<?php
require_once 'core/component/page/title.php';
require_once 'core/component/page/footer.php';

changeTitle("Erreur 404");
?>

<!-- En-tête de page -->
<header>
    <?php
    echo makeTitle();
    ?>
</header>

<!-- Contenu principal de la page -->
<main id="main-with-footer">
    <h1 id="error-label">Erreur <span id="error-number-label">404</span><br>Cette page n'existe pas.</h1>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>