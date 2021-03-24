<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: ./accueil.php");
    }
$id_del=$_POST["id"];
$user_id=$_SESSION["id"];
$dsn = "mysql:host=localhost;dbname=coin_vert";
$db = new PDO($dsn, "root", "");
$query =  $db->prepare("delete  from users_plants where plant_id= :plant_id and  user_id=:user_id");
$query->bindParam(":plant_id",$id_del);
$query->bindParam(":user_id",$user_id);

if ($query->execute()) {

    $plant_id = $_POST["id"];

    $query = $db->prepare("delete from plants where id=:id");
    $query->bindParam(":id",$plant_id);
    $query->execute();
    header("Location: page_user_plants.php");
}
