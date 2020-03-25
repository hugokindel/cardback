<?php

function makeHomeDisconnected($title)
{
    return '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <!-- Titre de la page -->
        <title>'.$title.' · cardback</title>
    
        <!-- Informations générales -->
        <meta charset="utf-8">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
        
        <!-- Favicon -->
        <meta name="theme-color" content="#FFFFFF">
        <link rel="icon" type="image/png" sizes="32x32" href="/res/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/res/favicon/favicon-16x16.png">
        
        <link rel="stylesheet" href="/res/style/utility/normalize.css">
        <link rel="stylesheet" href="/res/style/sf-pro-rounded.css">
        <link rel="stylesheet" href="/res/style/components.css">
        <link rel="stylesheet" href="/res/style/page/base.css">
    </head>
    <body>
        <!-- En-tête de page -->
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
            <div id="cards">
                <div id="oneone">Bienvenue sur <span style="font-weight: 900;">cardback</span>!</div>
                '.makeCard('Qu\'est-ce que <span style="font-weight: 900;">cardback</span>?', 'one')
                 .makeCard('À qui <span style="font-weight: 900;">cardback</span> est destiné?', 'two')
                 .makeCard('Combien coûte <span style="font-weight: 900;">cardback</span>?', 'three')
                 .makeCard('Où puis-je utiliser <span style="font-weight: 900;">cardback</span>?', 'four')
                 .makeCard('Que puis-je apprendre sur <span style="font-weight: 900;">cardback</span>?', 'five')
                 .makeCard('Qui développe <span style="font-weight: 900;">cardback</span>?', 'six').'
            </div>
        </main>
        <!-- Pied de page -->
        <footer>
            <p id="copyright-label">© 2020 Groupe 1. Tous droits réservés.</p>
            <p id="made-label">Fait avec <span id="made-heart-label">􀊵</span></p>
        </footer>
    </body>
    </html>';
}