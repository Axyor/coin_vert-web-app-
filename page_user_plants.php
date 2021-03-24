<?php
// Démarrage du système de session
session_start();
if(!isset($_SESSION["user"])){
    header("Location: ./accueil.php");
    }
$dsn = "mysql:host=localhost;dbname=coin_vert";
$db = new PDO($dsn, "root", "");
$query =  $db->query("select * from plants order by id");

$plants = $query->fetchAll();
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
    <title><?= $_SESSION["user"] ?> vos plants</title>
</head>
<?php
if (isset($_SESSION["user"])) {
?>

    <body>
        <header>
            <img src="./img/site_img/gardener.png" alt="Logo-jardinnier">
            <h1>Avez-vous planté des choux ?</h1>
        </header>
        <main>
            <div class="container">
                <a class="new-btn" href="./page_add_plant.php">Nouveau plant</a>
                <div class="item">
                    <?php

                    foreach ($plants as $plant) {

                        $image = $plant["image_plant"];
                        $variete = $plant["variete_plant"];
                        $position = $plant["position_plant"];
                        $type = $plant["type_plant"];
                        $date = $plant["date_plant"];
                        $id = $plant["id"];
                    ?>
                        <div class="item-img">
                            <img src="<?= $image ?>" alt="">
                        </div>
                        <div class="item-description">
                            <p>Variété : <span><?= $variete ?></span></p>

                            <p>Position : <span><?= $position ?></span></p>

                            <p>Type : <span><?= $type ?></span></p>

                            <p>Date d'ajout : <span><?= $date ?></span></p>

                        </div>
                        <form class="delete" method="post" action="delete_bd_plants.php">
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
            <img src="./img/site_img/tree.png" alt="">
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