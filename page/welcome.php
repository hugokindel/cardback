<?php
require_once 'component/card.php';
require_once 'component/textbox.php';
require_once 'component/title.php';
require_once 'component/footer.php';

changeTitle("Bienvenue");
?>

<!-- En-tête de page -->
<header>
    <?php
    echo makeTitle();
    ?>
    <div id="sign-container">
        <button class="button-secondary" id="signin-button">Se connecter</button>
        <button class="button-main" id="signup-button">S'inscrire</button>
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

    <div class="modal-main" id="signin-modal">
        <div class="modal-content">
            <h2 class="label-titlemodal">cardback</h2>
            <h3 class="label-descriptionmodal">S'identifier sur <span style="font-weight: 900;">cardback</span></h3>
            <form>
                <?php
                echo makeTextboxWithAccessory("email-textbox", "email", "email", "E-mail", "􀍕", "textbox-modal");
                echo makeTextboxWithAccessory("password-textbox", "password", "password", "Mot de passe", "􀎠", "textbox-modal");
                ?>
            </form>

            <a style="font-weight: 500; margin: 0 0 0 40px;">Mot de passe <span style="font-weight: 700;">oublié</span>?</a>

            <div class="modal-buttons">
                <button class="button-secondary button-closemodal" style="min-height: 32px;">Retour</button>
                <button class="button-main" style="position: absolute; right: 0;">Se connecter</button>
            </div>
        </div>
    </div>

    <div class="modal-main" id="signup-modal">
        <div class="modal-content">
            <div id="title-container" style="margin: auto;">
                <h2 class="label-title1" id="title-label">cardback</h2>
            </div>
        </div>
    </div>
</main>

<!-- Pied de page -->
<?php
echo makeFooter();
?>

<script>
    var signInModal = document.getElementById("signin-modal");
    var signUpModal = document.getElementById("signup-modal");
    var signInButton = document.getElementById("signin-button");
    var signUpButton = document.getElementById("signup-button");
    var closeSignInButton = document.getElementsByClassName("button-closemodal")[0];
    var closeSignUpButton = document.getElementsByClassName("button-closemodal")[1];

    signInButton.onclick = function() {
        signInModal.style.display = "block";
    }

    signUpButton.onclick = function () {
        signUpModal.style.display = "block";
    }

    closeSignInButton.onclick = function() {
        signInModal.style.display = "none";
    }

    closeSignUpButton.onclick = function() {
        signUpModal.style.display = "none";
    }
</script>
