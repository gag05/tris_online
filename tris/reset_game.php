<?php
    session_start();
    include "connection.php";

    $game_id = $_POST["game_id"];

    $sql_reset = "UPDATE game SET mittente = NULL, modify_row = 0, modify_col = 0 WHERE game_id = $game_id";
    $result_reset = mysqli_query($conn,$sql_reset);
    if(!$result_reset)
        echo "err";
    
?>  