<?php
\cardback\system\checkAccountConnection(FALSE);
\cardback\utility\changeTitle("Bienvenue");
?>

<!-- En-tête de page -->
<header>
    <?php
    echo \cardback\component\page\makeTitle();
    ?>
    <div id="sign-container">
        <a class="link-secondary" id="signin-link" href="<?php echo $serverUrl ?>/signin">Se connecter</a>
        <a class="link-main" id="signup-link" href="<?php echo $serverUrl ?>/signup">S'inscrire</a>
    </div>
</header>

<!-- Contenu principal de la page -->
<main id="main-with-footer">
    <h1 id="welcome">Bienvenue sur <span class="span-title">cardback</span>!</h1>
    <div class="cards-container">
        <?php
        echo \cardback\component\makeCard(
            'Qu\'est-ce que <span class="span-title">cardback</span>?',
            '<span class="span-title">cardback</span> 
            est un outil d\'apprentissage faisant appel à votre mémoire.');
        echo \cardback\component\makeCard(
            'À qui <span class="span-title">cardback</span> est destiné?',
            '<span class="span-title">cardback</span> 
            est destiné à n\'importe qui!');
        echo \cardback\component\makeCard(
            'Combien coûte <span class="span-title">cardback</span>?',
            '<span class="span-title">cardback</span> 
            est complètement gratuit!',
            TRUE, "margin-right: 0;");
        echo \cardback\component\makeCard(
            'Où puis-je utiliser <span class="span-title">cardback</span>?',
            '<span class="span-title">cardback</span> 
            n\'est pour l\'instant compatible que sur vos ordinateurs.');
        echo \cardback\component\makeCard(
            'Que puis-je apprendre sur <span class="span-title">cardback</span>?',
            'Avec l\'aide de la communauté, <span class="span-title">cardback</span> 
            compte bien vous permettre d\'apprendre sur pleins de sujets variés.');
        echo \cardback\component\makeCard(
            'Qui développe <span class="span-title">cardback</span>?',
            'Pour le moment <span class="span-title">cardback</span> 
            est développé par deux étudiants.',
            TRUE, "margin-right: 0;");
        ?>
    </div>
</main>

<!-- Pied de page -->
<?php
echo \cardback\component\page\makeFooter();
?>