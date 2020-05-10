<?php

use function cardback\utility\changeTitle;

changeTitle("Foire aux questions");
?>

<!-- En-tête de page -->
<header>
    <?php $getCardbackTitle(); ?>
</header>

<!-- Contenu principal de la page -->
<main
        id="main-with-footer">
    <?php $getFaq(); ?>
    <button
            id="error-button"
            class="button-secondary"
            onclick="window.history.back()">
        Retourner à la page précédente</button>
</main>

<!-- Pied de page -->
<?php $getFooter(); ?>