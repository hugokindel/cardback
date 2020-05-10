<?php
/**
 * Ce fichier contient les fonctions relatives à la F.A.Q.
 */

/**
 * Crée une F.A.Q.
 */
$getFaq = function() {
    global $getCard;

    ?>
    <div
            class="cards-container">
        <?php
        $getCard(
                "Qu'est-ce que <span class=\"span-title\">cardback</span>?",
                "<span class=\"span-title\">cardback</span> est un outil d'apprentissage faisant appel à votre mémoire.");
        $getCard(
                "À qui <span class=\"span-title\">cardback</span> est destiné?",
                "<span class=\"span-title\">cardback</span> est destiné à n'importe qui!");
        $getCard(
                "Combien coûte <span class=\"span-title\">cardback</span>?",
                "<span class=\"span-title\">cardback</span> est complètement gratuit!",
                TRUE,
                "margin-right: 0;");
        $getCard(
                "Où puis-je utiliser <span class=\"span-title\">cardback</span>?",
                "<span class=\"span-title\">cardback</span> n'est pour l'instant compatible que sur vos ordinateurs.");
        $getCard(
                "Que puis-je apprendre sur <span class=\"span-title\">cardback</span>?",
                "Avec l'aide de la communauté, <span class=\"span-title\">cardback</span> compte bien vous permettre d'apprendre sur pleins de sujets variés.");
        $getCard(
                "Qui développe <span class=\"span-title\">cardback</span>?",
                "Pour le moment <span class=\"span-title\">cardback</span> est développé par deux étudiants.",
                TRUE,
                "margin-right: 0;");
        ?>
    </div>
    <?php
};