<?php
\cardback\utility\changeTitle("Erreur 404");
?>

<!-- En-tête de page -->
<header>
    <?php $getCardbackTitle(); ?>
</header>

<!-- Contenu principal de la page -->
<main
        id="main-with-footer">
    <div>
        <h1
                class="theme-default-text"
                id="error-label">
            Erreur <span id="error-number-label">404</span><br>
            Cette page n'existe pas.</h1>
        <button
                id="error-button"
                class="button-secondary"
                onclick="window.history.back()">
            Retourner à la page précédente</button>
    </div>
</main>

<!-- Pied de page -->
<?php $getFooter(); ?>