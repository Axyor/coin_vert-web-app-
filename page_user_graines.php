<?php
// Démarrage du système de session
session_start();
if(!isset($_SESSION["user"])){
    header("Location: ./accueil.php");
    }
$dsn = "mysql:host=localhost;dbname=coin_vert";
$db = new PDO($dsn, "root", "");
$query =  $db->query("select * from seeds order by id");

$seeds = $query->fetchAll();

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
    <title><?= $_SESSION["user"] ?> vos graines</title>
</head>
<?php
if (isset($_SESSION["user"])) {
?>

    <body>
        <header>
            <img src="./img/site_img/gardener.png" alt="">
            <h1>Une graine par-ci une graine par là...</h1>
        </header>
        <main>
            <div class="container">
                <a class="new-btn" href="./page_add_graine.php">Nouvelle graine</a>
                <div class="item">
                    <?php

                    foreach ($seeds as $seed) {

                        $image = $seed["image_seed"];
                        $variete = $seed["variete_seed"];
                        $quantity = $seed["quantity_seed"];
                        $type = $seed["type_seed"];
                        $date=$seed["date_seed"];
                        $id = $seed["id"];
                    ?>
                        <div class="item-img">
                            <img src="<?= $image ?>" alt="">
                        </div>
                        <div class="item-description">
                            <p>Variété : <span><?= $variete ?></span></p>
                            
                            <p>Quantité : <span><?= $quantity ?></span></p>
                            
                            <p>Type : <span><?= $type ?></span></p>
                            
                            <p>Date d'ajout : <span><?= $date ?></span></p>
                            
                        </div>
                        <form class="delete" method="post" action="delete_bd_graines.php">
                            <input class="btn-hidden"  name="id" value="<?= $id ?>">
                            <input type="submit" class="btn-delete" name="valider" value="X">

                        </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </main>
        <div class="btns">
            <a class="btn-back" href="./page_user.php">Retour</a>
            <a class="btn-logout" href="./logout.php">Se déconnecter</a>
        </div>
        <footer>
            <img src="./img/site_img/seed.png" alt="">
            <div class="idCreator">
                <p>Projet par</p>
                <a href="https://alexandre-roy.web.app/">Alexandre Roy</a>
            </div>
        </footer>
    </body>
<?php } else {
    header("Location: ./accueil.php");
}
?>

</html>