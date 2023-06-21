<?php 
    session_start();

    include "connection.php";
    $ID_ricevente = $_POST["info"];
    //$ID_ricevente = 339380;
    $stato_richiesta = $_POST["accettato"];
    //$stato_richiesta = -1;
    //print_r("ciao");
    $sql = "SELECT MIN(id_richiesta) as min FROM request";
    $result = mysqli_query($conn,$sql); 
    if(!$result)
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);

    $row = $result->fetch_assoc();
    $minimo = $row["min"];

    if($stato_richiesta == 1){
        $sql_game = "SELECT * FROM request WHERE id_richiesta = $minimo";
        $result_game = mysqli_query($conn,$sql_game);
        if(!$result_game)
            echo "Error: " . $sql_game . "<br>" . mysqli_error($conn);
        $row = $result_game->fetch_assoc();
        $player1_id = $row["player1_id"];

        $sql_check_game_esistenti = "SELECT * FROM game WHERE player1_id = $player1_id AND player2_id = $ID_ricevente";
        $result_check_game_esistenti = mysqli_query($conn,$sql_check_game_esistenti);
        if(!$result_check_game_esistenti)
            echo "err";
        
    }

        //print_r($player1_id." ".$ID_ricevente." aggiornata richiesta 1");
    

    $sql1 = "UPDATE request SET stato_accettato=$stato_richiesta WHERE id_richiesta=$minimo";
    $result1 = mysqli_query($conn,$sql1); 
    if(!$result1)
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);

    $sql_aggiorna_stato = "UPDATE player SET avaible = 0 WHERE player_id = $ID_ricevente";
    $result_aggiorna_stato = mysqli_query($conn,$sql_aggiorna_stato);
    if(!$result_aggiorna_stato)
        echo "err";

    
?>