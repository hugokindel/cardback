<?php
checkIsNotConnectedToAccount();

require_once 'core/component/card.php';
require_once 'core/component/textbox.php';
require_once 'core/component/title.php';
require_once 'core/component/footer.php';

changeTitle("Bienvenue");
?>

<!-- En-tête de page -->
<header>
    <?php
    echo makeTitle();
    ?>
    <div id="sign-container">
        <a class="link-secondary" id="signin-link" href="signin">Se connecter</a>
        <a class="link-main" id="signup-link" href="signup">S'inscrire</a>
    </div>
</header>

<!-- Contenu principal de la page -->
<main>
    <h1 id="welcome">Bienvenue sur <span style="font-weight: 900;">cardback</span>!</h1>
    <div id="cards-container">
        <div id="cards">
            <?php
            echo makeCard('Qu\'est-ce que <span style="font-weight: 900;">cardback</span>?',
                '<span style="font-weight: 900;">cardback</span> est un outil d\'apprentissage faisant appel à votre mémoire.');
            echo makeCard('À qui <span style="font-weight: 900;">cardback</span> est destiné?',
                '<span style="font-weight: 900;">cardback</span> est destiné à n\'importe qui!');
            echo makeCard('Combien coûte <span style="font-weight: 900;">cardback</span>?',
                '<span style="font-weight: 900;">cardback</span> est complètement gratuit!');
            echo makeCard('Où puis-je utiliser <span style="font-weight: 900;">cardback</span>?',
                '<span style="font-weight: 900;">cardback</span> n\'est pour l\'instant compatible que sur vos ordinateurs.');
            echo makeCard('Que puis-je apprendre sur <span style="font-weight: 900;">cardback</span>?',
                'Avec l\'aide de la communauté, <span style="font-weight: 900;">cardback</span> compte bien vous permettre d\'apprendre sur pleins de sujets variés.');
            echo makeCard('Qui développe <span style="font-weight: 900;">cardback</span>?',
                'Pour le moment <span style="font-weight: 900;">cardback</span> est développé par deux étudiants.');
            ?>
        </div>
    </div>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>