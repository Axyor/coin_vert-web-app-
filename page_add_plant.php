<?php
// Démarrage du système de session
session_start();
if(!isset($_SESSION["user"])){
header("Location: ./accueil.php");
}


if (!empty($_POST)) {
    $variete_plant = trim(strip_tags($_POST["variete_plant"]));
    $position_plant = trim(strip_tags($_POST["position_plant"]));
    $type_plant = trim(strip_tags($_POST["type_plant"]));
    $date_plant = trim(strip_tags($_POST["date_plant"]));
    $image_plant = trim(strip_tags($_POST["image_plant"]));

    $errors = [];

    if (empty($variete_plant)) {
        $errors["variete_plant"] = "La variété du plant est obligatoire";
    }

    if (!filter_var($image_plant, FILTER_VALIDATE_URL)) {
        $errors["image_plant"] = "L'url de l'image est invalide";
    }

    if (empty($errors)) {

        $dsn = "mysql:host=localhost;dbname=coin_vert";
        $db = new PDO($dsn, "root", "");


        $query = $db->prepare("INSERT INTO plants (variete_plant, position_plant, type_plant, date_plant, image_plant) VALUES (:variete_plant, :position_plant, :type_plant, :date_plant, :image_plant)");

        $query->bindParam(":variete_plant", $variete_plant);
        $query->bindParam(":position_plant", $position_plant);
        $query->bindParam(":type_plant", $type_plant);
        $query->bindParam(":date_plant", $date_plant);
        $query->bindParam(":image_plant", $image_plant);



        if ($query->execute()) {
            $user_id=$_SESSION["id"];
            $plant_id = $db->lastInsertId();

            $query = $db->prepare("INSERT INTO users_plants (user_id, plant_id) Values(:user_id, :plant_id)");

            $query->bindParam(":user_id", $user_id);
            $query->bindParam(":plant_id", $plant_id);
            

            $query->execute();

            header("Location: page_user_plants.php");
        
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
    <title><?= $_SESSION["user"] ?> Nouveau plant ?</title>

</head>

<body>
    <header>
        <img src="./img/site_img/gardener.png" alt="Logo-jardinnier">
        <h1>À la mode de chez nous.</h1>
    </header>
    <main>
        <div class="container">
            <form action="" method="post">
                <div class="form-group">
                    <label for="inputVariete_plant">Variété :</label> </br>
                    <input type="text" name="variete_plant" id="inputVariete_plant" placeholder="">
                    <?php
                    if (isset($errors["variete_plant"])) {
                        echo "<span class=\"info-error\">{$errors["variete_plant"]}</span>";
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label for="inputType_plant">Type :</label> </br>
                    <input type="text" name="type_plant" id="inputType_plant" placeholder="">
                </div>

                <div class="form-group">
                    <label for="inputPosition_plant">Position :</label> </br>
                    <input type="text" name="position_plant" id="inputPosition_plant" placeholder="">
                </div>

                <div class="form-group">
                    <label for="inputDate_plant">Date d'ajout :</label></br>
                    <input type="date" name="date_plant" id="inputDate_plant" placeholder="">
                </div>



                <div class="form-group">
                    <label for="inputImage_plant">Url de votre image :</label></br>
                    <input type="text" name="image_plant" id="inputImage_plant" placeholder="">
                    <?php
                    if (isset($errors["image_plant"])) {
                        echo "<span class=\"info-error\">{$errors["image_plant"]}</span>";
                    }
                    ?>
                </div>
                <input type="submit" value="Ajouter">
            </form>
        </div>

    </main>
    <div class="btns">
        <a class="btn-back" href="./page_user_plants.php">Retour</a>

    </div>
    <footer>
        <img src="./img/site_img/tree.png" alt="arbre">
        <div class="idCreator">
            <p>Projet par</p>
            <a href="https://alexandre-roy.web.app/">Alexandre Roy</a>
        </div>
    </footer>
</body>

</html>