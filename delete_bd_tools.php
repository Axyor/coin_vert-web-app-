<?php
if(!isset($_SESSION["user"])){
    header("Location: ./accueil.php");
    }
$id_del=$_POST["id"];


$db = new PDO("mysql:host=localhost;dbname=coin_vert", "root", "");
$query =  $db->prepare("delete  from tools where id= :id");
$query->bindParam(":id",$id_del);



if ($query->execute()) {

    header("Location: page_user_outils.php");
}

?>