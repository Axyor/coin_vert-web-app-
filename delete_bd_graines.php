<?php
if (!isset($_SESSION["user"])) {
    header("Location: ./accueil.php");
}
$id_del = $_POST["id"];
$user_id = $_SESSION["id"];
$dsn = "mysql:host=localhost;dbname=coin_vert";
$db = new PDO($dsn, "root", "");
$query =  $db->prepare("delete  from users_seeds where seed_id= :seed_id and  user_id=:user_id");
$query->bindParam(":seed_id", $id_del);
$query->bindParam(":user_id", $user_id);

if ($query->execute()) {

    $seed_id = $_POST["id"];

    $query = $db->prepare("delete from seeds where id=:id");
    $query->bindParam(":id", $seed_id);
    $query->execute();
    header("Location: page_user_graines.php");
}
