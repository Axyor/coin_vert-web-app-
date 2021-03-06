<?php
$message = "";

if (!empty($_POST)) {

    $errors = [];
    $firstname = trim(strip_tags($_POST["firstname"]));
    $email = trim(strip_tags($_POST["email"]));
    $password = trim(strip_tags($_POST["password"]));
    $retypePassword = trim(strip_tags($_POST["retypePassword"]));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "L'email n'est pas valide";
    }

    if ($password != $retypePassword) {
        $errors["retypePassword"] = "Les deux mots de passe ne correspondent pas";
    }
    $uppercase = preg_match("/[A-Z]/", $password);
    $lowercase = preg_match("/[a-z]/", $password);
    $number = preg_match("/[0-9]/", $password);
    $specialChar = preg_match("/[^a-zA-Z0-9]/", $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChar || strlen($password) < 6) {
        $errors["password"] = "Le mot de passe doit contenir 6 caractères minimum, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial";
    }

    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $db = new PDO("mysql:host=localhost;dbname=coin_vert", "root", "");

        $query = $db->prepare("INSERT INTO users (firstname, email, password) VALUES (:firstname, :email, :password)");
        $query->bindParam(":firstname", $firstname);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $password);

        if ($query->execute()) {
            header("Location: accueil.php");
        } else {
            $message = "<p class=\"error\">Un problème est survenu lors de la création du compte, veuillez réessayer !</p>";
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
    <title>Crée ton compte</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Lobster+Two&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <header>
        <a href="./accueil.php"><img src="./img/site_img/gardener.png" alt=""></a>
        <h1>Bienvenue !</h1>

    </header>
    <main>
        <div class="container">
            <p>“Mon petit coin vert” ? </p>
            <p>Comme une grelinette, c’est un outil super utile pour tous les potagistes ! C’est un peu le pense-bête des jardiniers.</p>
            <p>
                Trop difficile de se rappeler de son stock d’outils, de graines et de plants ? C’est l’application qui s’en charge !</p>
            <p>
                Si tu veux essayer, inscris-toi ci-dessous. Sinon clique sur ma moustache.</p>

                <?= $message ?>
            <form action="" method="post">
                <div class="form-group">
                    <input type="text" name="firstname" id="inputFirstname" placeholder="Nom">
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="inputEmail" placeholder="Adresse email" value="<?= isset($email) ? $email : "" ?>">
                    <?php echo isset($errors["email"]) ? "<p class=\"error\">{$errors["email"]}</p>" : "" ?>
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="inputPassword" placeholder="Mot de passe" value="<?= isset($password) ? $password : "" ?>">
                    <?php echo isset($errors["password"]) ? "<p class=\"error\">{$errors["password"]}</p>" : "" ?>
                </div>
                <div class="form-group">
                    <input type="password" name="retypePassword" id="inputRetypePassword" placeholder="Confirmation de votre mdp" value="<?= isset($retypePassword) ? $retypePassword : "" ?>">
                    <?php echo isset($errors["retypePassword"]) ? "<p class=\"error\">{$errors["retypePassword"]}</p>" : "" ?>
                </div>

                <input type="submit" value="S'inscrire">
            </form>

        </div>
    </main>
    <footer>
        <img src="./img/site_img/panier.png" alt="panier">
        <div class="idCreator">
            <p>Projet par</p>
            <a href="https://alexandre-roy.web.app/">Alexandre Roy</a>
        </div>

    </footer>
</body>

</html>