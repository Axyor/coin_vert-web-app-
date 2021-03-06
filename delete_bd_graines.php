<?php

$id_del=$_POST["id"];

$dsn = "mysql:host=localhost;dbname=coin_vert";
$db = new PDO($dsn, "root", "");
$query =  $db->query("delete  from seeds where id= $id_del");


if ($query->execute()) {

    header("Location: page_user_graines.php");
}

?>