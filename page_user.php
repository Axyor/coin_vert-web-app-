<?php
// Démarrage du système de session
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Lobster+Two&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <title> <?= $_SESSION["user"] ?></title>
</head>
<?php
if (isset($_SESSION["user"])) {
?>

    <body>
        <header>
            <img src="./img/site_img/gardener.png" alt="Jardinnier">
            <h1>Hello <?= $_SESSION["user"] ?></h1>

        </header>
        <main>
            <div class="container">
                <p>Content de te revoir <?= $_SESSION["user"] ?> !
                    À quoi veux-tu accéder ?</p>

                <a class="btn-category" href="./page_user_outils.php"><img class="img_outil" src="./img/site_img/outil_page.png" alt="Page outils"></a>
                <a class="btn-category" href="./page_user_graines.php"><img class="img_graine" src="./img/site_img/recolte.png" alt="Page graines"></a>
                <a class="btn-category" href="./page_user_plants.php"><img class="img_plant" src="./img/site_img/littlePlant.png" alt="Page plants"></a>

            </div>
        </main>
        <div class="btns">
            <a class="btn-back" href="./logout.php">Retour</a>
            <a class="btn-logout" href="./logout.php">Se déconnecter</a>
        </div>
        <footer>
            <img src="./img/site_img/epouvantail.png" alt="">
            <div class="idCreator">
                <p>Projet par</p>
                <a href="https://alexandre-roy.web.app/">Alexandre Roy</a>
            </div>
        </footer>
        
    </body>
<?php
} else {
    header("Location: ./accueil.php");
}
?>

</html>