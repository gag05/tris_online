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

        $sql_set_game = "INSERT INTO game (player1_id,player2_id) VALUES ($player1_id,$ID_ricevente)";
        $result_set_game = mysqli_query($conn,$sql_set_game);
        if(!$result_set_game)
            echo "Error: " . $sql_set_game . "<br>" . mysqli_error($conn);

        //print_r($player1_id." ".$ID_ricevente." aggiornata richiesta 1");
    }

    $sql1 = "UPDATE request SET stato_accettato=$stato_richiesta WHERE id_richiesta=$minimo";
    $result1 = mysqli_query($conn,$sql1); 
    if(!$result1)
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);

    
?>