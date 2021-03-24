<?php
if(!isset($_SESSION["user"])){
    header("Location: ./accueil.php");
    }
$id_del=$_POST["id"];
$user_id=$_SESSION["id"];

$db = new PDO("mysql:host=localhost;dbname=coin_vert", "root", "");
$query =  $db->prepare("delete  from users_tools where tool_id= :tool_id and  user_id=:user_id");
$query->bindParam(":tool_id",$id_del);
$query->bindParam(":user_id",$user_id);



if ($query->execute()) {
    $tool_id = $_POST["id"];

    $query = $db->prepare("delete from tools where id=:id");
    $query->bindParam(":id",$tool_id);
    $query->execute();
    header("Location: page_user_outils.php");
}

?>