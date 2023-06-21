<?php
    session_start();
    include "connection.php";

    function ret($mit,$row,$col){     
        $Obj= new stdClass();
        $Obj -> row= $row;
        $Obj -> col= $col; 
        $Obj -> mit= $mit;

        echo json_encode($Obj);
    }

    $giocatore = $_POST["turno"];
    $game_id = $_POST["game_id"];

    $sql = "SELECT mittente FROM game WHERE game_id = $game_id";
    $result = mysqli_query($conn,$sql);
    if(!$result)
        echo "BRUH";
    $row = $result->fetch_assoc();    
    
    //echo "giocatore: ".$giocatore." mittente: ".$row["mittente"]."\n";

    if($giocatore != $row["mittente"]){
        $sql_cord = "SELECT modify_row,modify_col FROM game WHERE game_id = $game_id";
        $result_cord = mysqli_query($conn,$sql_cord);
        if(!$result_cord)
            echo "BRHUUH";
        $row_cord = $result_cord->fetch_assoc(); 

        ret($row["mittente"],$row_cord["modify_row"],$row_cord["modify_col"]);

        $sql_reset_to_default = "UPDATE game SET modify_col = 0, modify_row = 0 WHERE game_id = $game_id";
        $result_reset_to_default = mysqli_query($conn,$sql_reset_to_default);
        if(!$result_reset_to_default)
            echo "err";
    }else
        ret($giocatore,1,1);

?>