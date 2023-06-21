<?php 
    session_start();
    include "connection.php";
    $ID_SESSIONE = session_id();

    $sql_controllo_sessione = "SELECT * FROM player WHERE session_id = '$ID_SESSIONE'";
    $result_controllo_sessione = mysqli_query($conn,$sql_controllo_sessione);
    if(!$result_controllo_sessione)
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);

    if($result_controllo_sessione->num_rows>0) {
        header('Location: http://localhost/tris/scelta_modalita_di_gioco.php');
        die();
    }

   
    $sql = "SELECT * FROM player WHERE session_id='$ID_SESSIONE'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    if($result->num_rows>0){
        $sql_playerID = "SELECT player_id FROM player WHERE session_id='$ID_SESSIONE'";
        $result_playerID = mysqli_query($conn, $sql_playerID);
        if (!$result_playerID) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $row = $result_playerID->fetch_assoc();
        
        $_SESSION["log"] = $row["player_id"];
    }else{

        do{
            $ID = random_int(100000,999999);
            $sql = "SELECT * FROM `player` WHERE player_id=$ID";
            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }while($conn->num_rows>0);

        $_SESSION["log"] = $ID;
        $sql = "INSERT INTO player (player_id,session_id) VALUES('$ID','$ID_SESSIONE')";
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    $time = time();
    $time_valid = $time -(30*60);
    //$sql_controllo_afk = "SELECT tempo FROM player WHERE tempo < $time_valid";
    $sql_controllo_afk = "DELETE FROM player WHERE tempo < $time_valid";
    $result_controllo_afk = mysqli_query($conn,$sql_controllo_afk);
    if(!$result_controllo_afk)
        echo "err";
    
   //while($row_controllo_afk = $result_controllo_afk->fetch_assoc())

?>

    <?php include "header.php" ?>

        <div class="box-scelta-nome">
            <div id="text-scelta-nome">
                <p>Inserisci il tuo nome</p>
            </div>
            <div class="scelta-nome">
                <form action="scelta_modalita_di_gioco.php" method="post">
                    <input type="text" id="nome-player" name="nome-player" minlength="4" maxlength="24" placeholder="Nome giocatore">    
                    <input type="submit" class="btn" id="btn-scelta-nome" value="Scegli">
                </form>
            </div>
        </div>

    </body>

</html>
