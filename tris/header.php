<?php 
    session_start();

    include "conncection.php";

    $ID_SESSIONE = session_id();
    $nome;

    if(isset($_POST['nome-player'])){
        $sql = "UPDATE player SET player_name='".$_POST['nome-player']."' WHERE session_id = '$ID_SESSIONE'"; 
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        $sql = "UPDATE player SET avaible='1' WHERE session_id = '$ID_SESSIONE'"; 
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $nome  = $_POST['nome-player'];
    }else if(isset($_SESSION['log'])) {
        $sql = "SELECT player_name FROM player WHERE session_id = '$ID_SESSIONE'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $row = $result -> fetch_assoc();
        $nome = $row["player_name"];
    }
    else
        $nome = "Pinco pallo";


?>

<html>
    <head>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="./style.css">
    </head>

    <body class="dark">
        <div class="container-info-player">
        <div class="row-info">
            <div class="col-info">
                <div class="svg">
                </div>
                <div class="info-pl"> 
                    <p><strong><?php echo $nome;?></strong><br></p>
                    <p><strong>#<?php echo $_SESSION["log"];?></strong>  <br></p>
                </div>
            </div>
            
                <div class = 'toggle-switch'>
                    <label>
                        <input type = 'checkbox' id="checkbox1">
                        <span class = 'slider'></span>
                    </label>
                </div>
            
        </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('#checkbox1').change(function() { 
                $("body").toggleClass("dark");
            });
        });

        function aggiorna_tempo(){
            $.ajax({
                type: "post",
                url: "afk.php",
                data: jQuery.parseJSON('{"ID":  "<?= $ID_SESSIONE?>"}'), 
                suscces:function(){
                    
                }
            });
        }

        $(document).ready(function(){
            aggiorna_tempo();
        });

        $(document).on("click",function(){
            aggiorna_tempo();
        });
    </script>   
</html>