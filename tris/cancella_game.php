<?php 
    session_start();
    include "connection.php";

    $game_id = $_POST["game_id"];

    $sql_controllo_nGiocatori = "SELECT n_giocatori FROM game WHERE game_id = $game_id";
    //echo $sql_controllo_nGiocatori."\n";
    $result_controllo_nGiocatori = mysqli_query($conn,$sql_controllo_nGiocatori);
    if(!$result_controllo_nGiocatori)
        echo "err";
    $row_controllo_nGiocatori = $result_controllo_nGiocatori->fetch_assoc();
   
    //print_r($row_controllo_nGiocatori["n_giocatori"]);

    $sql = "DELETE FROM game WHERE game_id = $game_id";
    $result = mysqli_query($conn,$sql);
    if(!$result)
        echo "err";

?>