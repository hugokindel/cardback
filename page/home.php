<?php
checkIsConnectedToAccount();

if (isset($_POST["submit"])) {
    disconnectAccount();
    redirectToBase();
}

changeTitle("Accueil");

$data = getAccountData($_SESSION["accountId"], $_SESSION["accountPassword"]);
?>

<h1>Bonjour, <?php echo $data[1][3]." ".$data[1][4] ?></h1>
<form method="post" id="page-form"></form>
<button class="button-main" type="submit" form="page-form" name="submit" style="margin-top: 50px; width: 220px;">Se déconnecter</button>
