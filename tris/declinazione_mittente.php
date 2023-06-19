<?php 
    session_start();
    include "connection.php";

    $ID_MITTENTE = $_POST["info"];

    $sql = "DELETE FROM request where player1_id = $ID_MITTENTE";
    $result = mysqli_query($conn,$sql);
    if(!$result)
        echo "ERRORE: server";
    
?>  