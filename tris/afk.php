<?php 
    include "connection.php";

    $ID_SESSIONE = $_POST["ID"];

    //echo "time".time();
    $time = time();

    //echo "sql ".$ID_SESSIONE;
    $sql = "UPDATE player SET tempo = $time WHERE session_id = '$ID_SESSIONE'";
    $result = mysqli_query($conn,$sql);
    if(!$result)
        echo "err";
    
?>