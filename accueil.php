<?php
$message = "";
if(!empty($_POST)) {
    $email = trim(strip_tags($_POST["email"]));
    $password = trim(strip_tags($_POST["password"]));

    $db = new PDO("mysql:host=localhost;dbname=coin_vert", "root", "");

    $query = $db->prepare("SELECT firstname, email, password FROM users WHERE email = :email");
    $query->bindParam(":email", $email);
    $query->execute();
    $result = $query->fetch();

    if(!empty($result) && password_verify($password, $result["password"])) {
        session_start();
        $_SESSION["user"] = $result["firstname"];
        $_SESSION["user_ip"] = $_SERVER["REMOTE_ADDR"];
        header("Location: page_user.php");
    } else {
        $message = "<p class=\"error\">Impossible de se connecter avec les informations saisies, veuillez réessayer</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon petit coin vert</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Lobster+Two&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <header>
        <img src="./img/site_img/gardener.png" alt="">
        <h1>Mon petit coin vert</h1>

    </header>
    <main>
        <div class="container">
            <p>Bien le bonjour ! Je suis Edward le jardinier !</p>
            <p>Bienvenue à “Mon petit coin vert” !</p>
            <p>Si tu es habitué(e) des lieux, viens te connecter ci-dessous.</p>
            <?= $message ?>
            <form action="" method="post">
                <div class="form-group">
                    <input type="email" name="email" id="inputEmail" placeholder="Adresse email">
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="inputPassword" placeholder="Mot de passe">
                </div>

                <input type="submit" value="Se connecter">
            </form>

            <p>Sinon prépares tes outils et viens t’inscrire <a class="signIn" href="./create_account.php">ici</a> .</p>

        </div>
</main>
        <footer>
            <img src="./img/site_img/brouette.png" alt="">
            <div class="idCreator">
                <p>Projet par</p>
                <a href="https://alexandre-roy.web.app/">Alexandre Roy</a>
            </div>
        </footer>
    
    <script src="js/main.js"></script>
</body>

</html>