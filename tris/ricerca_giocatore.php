<?php 
    session_start();
    include "connection.php";
    
    function messaggio_di_uscita($status_exit,$message_exit){
        $myObj = new stdClass();
        $myObj ->status = $status_exit;
        $myObj ->message = $message_exit;

        echo json_encode($myObj);
    } 

    $sql = "SELECT * FROM `player` WHERE session_id='".session_id()."'"; 
    $result = mysqli_query($conn,$sql);
    if (!$result) 
        messaggio_di_uscita(0,"Patate: " . $sql . "<br>" . mysqli_error($conn));
    else{
        $row = $result->fetch_assoc();
        $ID_giocatore_mitt = $row["player_id"];
    }

    $ID_ricerca = intval($_POST["pl2"]);
    if(isset($_POST["game_id"]))
        $ID_partita = $_POST["game_id"];
    //$ID_ricerca = 339380;


    if($ID_giocatore_mitt == $ID_ricerca)
        messaggio_di_uscita(0,"Errore: non puoi giocare online con te stesso");
    else if($ID_ricerca == 2){
        $id_richiedente = $_POST["id"];
        $sql_player_id = "SELECT player1_id,player2_id FROM game WHERE game_id = $ID_partita";
        $result_player_id = mysqli_query($conn,$sql_player_id);
        if(!$result_player_id) 
            messaggio_di_uscita(0,"Errore: connesione con il server non riuscita");
        $row = $result_player_id->fetch_assoc();

        if($row["player1_id"] == $id_richiedente){
            $ID_player1 = $row["player1_id"];
            $ID_player2 = $row["player2_id"];
        }else{
            $ID_player2 = $row["player1_id"];
            $ID_player1 = $row["player2_id"];
        }

        $sql_richiesta = "INSERT INTO request (player1_id,player2_id) VALUES ($ID_player1,$ID_player2)";
        $result_richiesta = mysqli_query($conn,$sql_richiesta);
        if(!$result_richiesta)
            messaggio_di_uscita(0,"Errore: connesione con il server non riuscita");
        
    }else{
        $sql = "SELECT * FROM player WHERE player_id=$ID_ricerca";
        $result = mysqli_query($conn,$sql);
        if (!$result) {
            messaggio_di_uscita(0,"Errore: connesione con il server non riuscita");
        }else if($result->num_rows==0){
            messaggio_di_uscita(0,"Errore: giocatore non esistente");
        }else{
            $sql = "SELECT * FROM player WHERE avaible=1";
            $result = mysqli_query($conn,$sql);
            if(!$result){
                messaggio_di_uscita(0,"Errore: connesione con il server non riuscita");
            }else if($result->num_rows==0){
                messaggio_di_uscita(0,"Errore: il giocatore è impegnato in un'altra partita o si sta registrando");
            }else{
                $sql = "INSERT INTO request (player1_id,player2_id) VALUES('$ID_giocatore_mitt','$ID_ricerca')";
                $result = mysqli_query($conn,$sql);
                if(!$result)
                    messaggio_di_uscita(0,"Errore: invio richiesta");
                messaggio_di_uscita(1,"TUTTO ANDATO A BUON FINE");
            }
        }
    }

    //print_r( $result->fetch_assoc() );

    //print_r($result); 
?>