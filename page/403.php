<?php
require_once 'core/component/page/title.php';
require_once 'core/component/page/footer.php';

changeTitle("Erreur 403");
?>

<!-- En-tête de page -->
<header>
    <?php
    echo makeTitle();
    ?>
</header>

<!-- Contenu principal de la page -->
<main id="main-with-footer">
    <div>
        <h1 id="error-label">Erreur <span id="error-number-label">403</span><br>Vous n'avez pas l'autorisation d'accéder à cette ressource.</h1>
        <button id="error-button" class="button-secondary" onclick="window.history.back()">Retourner à la page précédente</button>
    </div>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>