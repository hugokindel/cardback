<?php

function makeHomeDisconnected($title)
{
    return makeBase($title,
        '<link rel="stylesheet" href="/res/style/page/home-disconnected.css">',

        '<!-- En-tête de page -->
        <header>
            <div id="title-container">
                <div id="title-label">cardback</div>
            </div>
            <div id="sign-container">
                <a class="link-secondary">Se connecter</a>
                <a class="link-main">S\'inscrire</a>
            </div>
        </header>
        <!-- Contenu principal de la page -->
        <main>
            <!--<div id="oneone">Bienvenue sur <span style="font-weight: 900;">cardback</span>!</div>-->
            <div id="cards">
                '.makeCard('Qu\'est-ce que <span style="font-weight: 900;">cardback</span>?', 'Le meilleur site de l\'univers')
                 .makeCard('À qui <span style="font-weight: 900;">cardback</span> est destiné?', '')
                 .makeCard('Combien coûte <span style="font-weight: 900;">cardback</span>?', '')
                 .makeCard('Où puis-je utiliser <span style="font-weight: 900;">cardback</span>?', '')
                 .makeCard('Que puis-je apprendre sur <span style="font-weight: 900;">cardback</span>?', '')
                 .makeCard('Qui développe <span style="font-weight: 900;">cardback</span>?', '').'
            </div>
        </main>
        <!-- Pied de page -->
        <footer>
            <p id="copyright-label">© 2020 Groupe 1. Tous droits réservés.</p>
            <p id="made-label">Fait avec <span id="made-heart-label">􀊵</span></p>
        </footer>');
}