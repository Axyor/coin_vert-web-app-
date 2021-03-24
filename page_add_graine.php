<?php
// Démarrage du système de session
session_start();
if($_SESSION["user"]){

}else{
    header("Location: ./accueil.php");
}

if (!empty($_POST)) {
    $variete_seed = trim(strip_tags($_POST["variete_seed"]));
    $quantity_seed = trim(strip_tags($_POST["quantity_seed"]));
    $type_seed = trim(strip_tags($_POST["type_seed"]));
    $date_seed = trim(strip_tags($_POST["date_seed"]));
    $image_seed = trim(strip_tags($_POST["image_seed"]));

    $errors = [];

    if (empty($variete_seed)) {
        $errors["variete_seed"] = "La variété de la graine est obligatoire";
    }

    if (!filter_var($image_seed, FILTER_VALIDATE_URL)) {
        $errors["image_seed"] = "L'url de l'image est invalide";
    }

    if (empty($errors)) {

        $dsn = "mysql:host=localhost;dbname=coin_vert";
        $db = new PDO($dsn, "root", "");


        $query = $db->prepare("INSERT INTO seeds (variete_seed, quantity_seed, type_seed, date_seed, image_seed) VALUES (:variete_seed, :quantity_seed, :type_seed, :date_seed, :image_seed)");

        $query->bindParam(":variete_seed", $variete_seed);
        $query->bindParam(":quantity_seed", $quantity_seed, PDO::PARAM_INT);
        $query->bindParam(":type_seed", $type_seed);
        $query->bindParam(":date_seed", $date_seed);
        $query->bindParam(":image_seed", $image_seed);



        if ($query->execute()) {

            $user_id=$_SESSION["id"];
            $seed_id = $db->lastInsertId();

            $query = $db->prepare("INSERT INTO users_seeds (user_id, seed_id) Values(:user_id, :seed_id)");

            $query->bindParam(":user_id", $user_id);
            $query->bindParam(":seed_id", $seed_id);
            

            $query->execute();

            header("Location: page_user_graines.php");
        }
    }
}


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
    <title><?= $_SESSION["user"] ?> Nouvelle graine ?</title>

</head>

<body>
    <header>
        <img src="./img/site_img/gardener.png" alt="Logo-jardinnier">
        <h1>Ajoutez du grain à moudre !</h1>
    </header>
    <main>
        <div class="container">
            <form action="" method="post">
                <div class="form-group">
                    <label for="inputVariete_seed">Variété :</label> </br>
                    <input type="text" name="variete_seed" id="inputVariete_seed" placeholder="">
                    <?php
                    if (isset($errors["variete_seed"])) {
                        echo "<span class=\"info-error\">{$errors["variete_seed"]}</span>";
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label for="inputQuantity_seed">Quantité :</label></br>
                    <input type="number" name="quantity_seed" id="inputQuantity_seed">
                </div>

                <div class="form-group">
                    <label for="inputDate_seed">Date d'ajout :</label></br>
                    <input type="date" name="date_seed" id="inputDate_seed" placeholder="">
                </div>

                <div class="form-group">
                    <label for="inputType_seed">Type :</label> </br>
                    <input type="text" name="type_seed" id="inputType_seed" placeholder="">
                </div>

                <div class="form-group">
                    <label for="inputImage_seed">Url de votre image :</label></br>
                    <input type="text" name="image_seed" id="inputImage_seed" placeholder="">
                    <?php
                    if (isset($errors["image_seed"])) {
                        echo "<span class=\"info-error\">{$errors["image_seed"]}</span>";
                    }
                    ?>
                </div>
                <input type="submit" value="Ajouter">
            </form>
        </div>

    </main>
    <div class="btns">
        <a class="btn-back" href="./page_user_graines.php">Retour</a>

    </div>
    <footer>
        <img src="./img/site_img/seed.png" alt="graine">
        <div class="idCreator">
            <p>Projet par</p>
            <a href="https://alexandre-roy.web.app/">Alexandre Roy</a>
        </div>
    </footer>
</body>

</html>