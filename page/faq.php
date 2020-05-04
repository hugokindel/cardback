<?php
\cardback\utility\changeTitle("Foire aux questions");
?>

    <!-- En-tête de page -->
    <header>
        <?php echo \cardback\component\page\makeTitle(); ?>
    </header>

    <!-- Contenu principal de la page -->
    <main id="main-with-footer">
        <?php echo \cardback\component\page\makeFAQ(); ?>
        <button id="error-button" class="button-secondary" onclick="window.history.back()">
            Retourner à la page précédente</button>
    </main>

    <!-- Pied de page -->
<?php echo \cardback\component\page\makeFooter(); ?>