<?php namespace cardback\component\page;

function makeFAQ() {
    return '<div class="cards-container">'
        .\cardback\component\makeCard(
            "Qu'est-ce que <span class=\"span-title\">cardback</span>?",
            "<span class=\"span-title\">cardback</span> 
            est un outil d'apprentissage faisant appel à votre mémoire.")
        .\cardback\component\makeCard(
            "À qui <span class=\"span-title\">cardback</span> est destiné?",
            "<span class=\"span-title\">cardback</span> 
            est destiné à n'importe qui!")
        .\cardback\component\makeCard(
            "Combien coûte <span class=\"span-title\">cardback</span>?",
            "<span class=\"span-title\">cardback</span> 
            est complètement gratuit!",
            TRUE, "margin-right: 0;")
        .\cardback\component\makeCard(
            "Où puis-je utiliser <span class=\"span-title\">cardback</span>?",
            "<span class=\"span-title\">cardback</span> 
            n'est pour l'instant compatible que sur vos ordinateurs.")
        .\cardback\component\makeCard(
            "Que puis-je apprendre sur <span class=\"span-title\">cardback</span>?",
            "Avec l'aide de la communauté, <span class=\"span-title\">cardback</span> 
            compte bien vous permettre d'apprendre sur pleins de sujets variés.")
        .\cardback\component\makeCard(
            "Qui développe <span class=\"span-title\">cardback</span>?",
            "Pour le moment <span class=\"span-title\">cardback</span> 
            est développé par deux étudiants.",
            TRUE, "margin-right: 0;").'
    </div>';
}