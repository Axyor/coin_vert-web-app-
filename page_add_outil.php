<?php
// Démarrage du système de session
session_start();
if(!isset($_SESSION["user"])){
    header("Location: ./accueil.php");
    }

if (!empty($_POST)) {
    $name_tool = trim(strip_tags($_POST["name_tool"]));
    $date_tool = trim(strip_tags($_POST["date_tool"]));
    $image_tool = trim(strip_tags($_POST["image_tool"]));
    
    $errors = [];

    if (empty($name_tool)) {
        $errors["name_tool"] = "Le nom de l'outil est obligatoire";
    }

    if (!filter_var($image_tool, FILTER_VALIDATE_URL)) {
        $errors["image_tool"] = "L'url de l'image est invalide";
    }

    if (empty($errors)) {

        $dsn = "mysql:host=localhost;dbname=coin_vert";
        $db = new PDO($dsn, "root", "");


        $query = $db->prepare("INSERT INTO tools (name_tool, date_tool, image_tool) VALUES (:name_tool, :date_tool, :image_tool)");

        $query->bindParam(":name_tool", $name_tool);
        $query->bindParam(":date_tool", $date_tool);
        $query->bindParam(":image_tool", $image_tool);
        
 
        
        if ($query->execute()) {
            $user_id=$_SESSION["id"];
            $tool_id = $db->lastInsertId();

            $query = $db->prepare("INSERT INTO users_tools (user_id, tool_id) Values(:user_id, :tool_id)");

            $query->bindParam(":user_id", $user_id);
            $query->bindParam(":tool_id", $tool_id);
            

            $query->execute();

            

            header("Location: page_user_outils.php");
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
    <title><?= $_SESSION["user"] ?> Nouvel outil ?</title>

</head>
<?php
if (isset($_SESSION["user"])) {
?>
<body>
    <header>
        <img src="./img/site_img/gardener.png" alt="Logo-jardinnier">
        <h1>Quoi de neuf ?
        </h1>
    </header>
    <main>
        <div class="container"></br>
            <form action="" method="post">
                <div class="form-group">
                    <label for="inputName_tool">Nom de l'outil :</label></br>
                    <input type="text" name="name_tool" id="inputName_tool" placeholder="">
                    <?php
                    if (isset($errors["name_tool"])) {
                        echo "<span class=\"info-error\">{$errors["name_tool"]}</span>";
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="inputDate_tool">Date d'ajout :</label></br>
                    <input type="date" name="date_tool" id="inputDate_tool" placeholder="">
                </div>

                <div class="form-group">
                    <label for="inputImage_tool">Url de votre image :</label></br>
                    <input type="text" name="image_tool" id="inputImage_tool" placeholder="">
                    <?php
                    if (isset($errors["image_tool"])) {
                        echo "<span class=\"info-error\">{$errors["image_tool"]}</span>";
                    }
                    ?>
                </div>
                <input type="submit" value="Ajouter">
            </form>
            </br>
        </div>

    </main>
    <div class="btns">
        <a class="btn-back" href="./page_user_outils.php">Retour</a>

    </div>
    </br>
    <footer>
        <img src="./img/site_img/outils.png" alt="outil">
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