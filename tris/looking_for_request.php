<?php 
    session_start();
    include "connection.php";
    if(!isset($_SESSION["ricevuto"])){
        $_SESSION["ricevuto"] = 0;
    }
    //print_r("sessione: ".$_SESSION["ricevuto"]."\n");
    //echo "sessione: ".$_SESSION["ricevuto"]."\n";

    function mess($stato,$nome){
        //echo "stato cambiato: ".$stato."\n";
        $Obj = new stdClass();
        $Obj -> stato = $stato;
        $Obj -> nome = $nome;
        //print_r($Obj);

        echo json_encode($Obj);
    }

    $ID_CONTROLLORE = $_POST["info"];

    $sql_nome_pl_mittente = "SELECT player_name FROM player WHERE player_id = (SELECT player1_id FROM request WHERE player2_id = $ID_CONTROLLORE AND id_richiesta = (SELECT MIN(id_richiesta) FROM request))";
    $result_nome = mysqli_query($conn,$sql_nome_pl_mittente);
    if(!$result_nome)
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    else{
        $row_nome = $result_nome->fetch_assoc();
        $nome = $row_nome["player_name"];
    }

    $sql = "SELECT * FROM player JOIN request ON player.player_id=request.player2_id WHERE player.avaible = 1 AND player.player_id = $ID_CONTROLLORE" ;
    $result = mysqli_query($conn,$sql);
    if(!$result)
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    else{
        if($result->num_rows>0){
            $_SESSION["ricevuto"] = 1;
            mess(1,$nome);
            //echo $nome;
        }else if($_SESSION["ricevuto"] == 1){
            $_SESSION["ricevuto"] = 0;
            mess(-1,$nome);
            //echo 0;
        }else
            mess(0,"");
    }
    
?>