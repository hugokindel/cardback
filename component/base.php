<?php

function makeBase($title, $head, $body)
{
    return '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <!-- Titre de la page -->
            <title>'.$title. ' · cardback</title>
        
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
            '.$head.'
        </head>
        <body>
            ' .$body.'
        </body>
        </html>';
}