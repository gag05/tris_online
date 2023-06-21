<?php 
    session_start();
    include "connection.php";
    

    function select($id,$cond,$conn){
        //echo "entato";
        $sql = "SELECT ".$id." as 'res' FROM game WHERE game_id = $cond";
        //echo $sql."\n";
        $result = mysqli_query($conn,$sql);
        if(!$result)
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
       // echo "sono qua";
        $row = $result->fetch_assoc();
        //echo $row["res"];
        return $row["res"];
    }

    //json_decode($_POST);
    $row_index = json_decode($_POST["row"]);
    $col_index = json_decode($_POST["col"]);
    $gioc = json_decode($_POST["player"]);
    $game_id = json_decode($_POST["game_id"]);

    //echo $row_index." ".$col_index." aggiornato1";

    $row_name = "row".$row_index;
    $col_name = "col".$col_index;

    $sql_update = "UPDATE game SET modify_row = $row_index,modify_col = $col_index WHERE game_id = $game_id";
    $result_update = mysqli_query($conn,$sql_update);
    //echo $sql_update;
    if(!$result_update)
        echo "ERROREEE";

    $sql_update_turno = "UPDATE game SET mittente = $gioc WHERE game_id = $game_id";
    //echo "\n\n".$sql_update_turno;
    $result_update_turno = mysqli_query($conn,$sql_update_turno);
    if(!$sql_update_turno)
        echo "OH MIO DIO ERRORE";
        
    echo $gioc."\n";
    
    $cell_number = (($row_index-1)*3+$col_index);
    $cell_name = "cell".$cell_number;
    $val = $gioc == 0? 1:-1;

    echo $cell_name."\n";

    $sql_update_cell = "UPDATE game SET `$cell_name` = $val WHERE game_id = $game_id";
    $result_update_cell = mysqli_query($conn,$sql_update_cell);
    if(!$result_update_cell)
        echo "err";

    
?>