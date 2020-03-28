<?php
require_once 'component/card.php';
?>

<!-- En-tête de page -->
<header>
    <div id="title-container">
        <a id="title-label" href="http://localhost">cardback</a>
    </div>
    <div id="sign-container">
        <a class="link-secondary">Se connecter</a>
        <a class="link-main">S'inscrire</a>
    </div>
</header>

<!-- Contenu principal de la page -->
<main>
    <div id="welcome">Bienvenue sur <span style="font-weight: 900;">cardback</span>!</div>
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
<footer>
    <p id="copyright-label">© 2020 Groupe 1. Tous droits réservés.</p>
    <p id="made-label">Fait avec <span id="made-heart-label">􀊵</span></p>
</footer>