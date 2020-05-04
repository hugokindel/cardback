<?php
\cardback\system\checkAccountConnection(FALSE);
\cardback\utility\changeTitle("Bienvenue");
?>

<!-- En-tête de page -->
<header>
    <?php echo \cardback\component\page\makeTitle(); ?>
    <div id="sign-container">
        <a class="link-secondary" id="signin-link" href="<?php echo $serverUrl ?>/signin">Se connecter</a>
        <a class="link-main" id="signup-link" href="<?php echo $serverUrl ?>/signup">S'inscrire</a>
    </div>
</header>

<!-- Contenu principal de la page -->
<main id="main-with-footer">
    <h1 id="welcome">Bienvenue sur <span class="span-title">cardback</span>!</h1>
    <?php echo \cardback\component\page\makeFAQ(); ?>
</main>

<!-- Pied de page -->
<?php echo \cardback\component\page\makeFooter(); ?>