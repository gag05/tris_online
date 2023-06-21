<?php 
    session_start();

    function ritorno($stato,$nome){
        $Obj = new stdClass();
        $Obj -> stato = $stato;
        $Obj -> nome = $nome;
        
        print_r(json_encode($Obj));
    }

    include "connection.php";
    $ID_GIOCATORE = $_POST["info"];

    //print_r($ID_GIOCATORE."\n");

    $sql = "SELECT request.stato_accettato,player.player_name FROM request JOIN player ON request.player2_id = player.player_id WHERE request.player1_id = $ID_GIOCATORE";
    //$sql = "SELECT stato_accettato FROM request WHERE player1_id = $ID_GIOCATORE";
    //print_r("dopo sql");
    $result = mysqli_query($conn,$sql);
    if(!$result)
        print_r("Errore:connessione al server");
    
    //print_r("dopo op");

    $row = $result->fetch_assoc();
    $stato = $row["stato_accettato"];
    $nome_player2 = $row["player_name"];
    //print_r("row: ".$row["stato_accettato"]);

    if($stato == -1){
        $sql_elimina_richiesta = "DELETE FROM request WHERE player1_id = $ID_GIOCATORE";
        $result_eliminazione = mysqli_query($conn,$sql_elimina_richiesta);
        if(!$result_eliminazione)
            print_r("Errore:connessione al server");

        ritorno(1,$nome_player2);
    }else if($stato == 1){ 
        $sql_elimina_richiesta = "DELETE FROM request WHERE player1_id = $ID_GIOCATORE";
        $result_eliminazione = mysqli_query($conn,$sql_elimina_richiesta);
        if(!$result_eliminazione)
            print_r("Errore:connessione al server");

        ritorno(0,$nome_player2);
        $sql_aggiorna_stato = "UPDATE player SET avaible = 0 WHERE player_id = $ID_GIOCATORE";
        $result_aggiorna_stato = mysqli_query($conn,$sql_aggiorna_stato);
        if(!$result_aggiorna_stato)
            echo "err";
    }else
        ritorno(-100,"");

?>