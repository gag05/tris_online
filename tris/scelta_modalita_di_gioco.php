<?php 
    //session_start();

    include "connection.php";
    //$ID_SESSIONE = session_id();
?>

    <?php include "header.php"; ?>
        <div class="overlay d-none">
            <div class="messaggio-utente">
                <div class="timer d-none">
                    <div class="testo-timer">
                        <p>RICHIESTA INVIATA</p>
                        <p id="mess">Scadrà tra <span id="time">3:00<span> m</p>
                    </div>
                    <div class="btn-timer">
                        <button class="btn">Declina</button>
                    </div>
                </div>
                <div class="richiesta-ricevuta d-none">
                    <div class="testo-timer">
                        <p>HAI RICEVUTO UNA RICHIESTA DA <span id="nome-pl-request-ric"></span></p>
                        <p id="mess">Scadrà tra <span id="time">3:00<span> m</p>
                    </div>
                    <div class="btn-timer">
                        <button class="btn" type="submit" id="btn-accetta-richiesta">Accetta</button>
                        <button class="btn" type="submit" id="btn-declina-richiesta">Declina</button>
                    </div>
                </div>
                <div class="rifiuto-richiesta d-none">
                    <p><span id="nome-pl2"></span> ha rifiutato la tua richiesta</p>
                    <button class="btn btn-rifiuto" id="rif">va bene</button>
                </div>
                <div class="declino-richiesta d-none">
                    <p><span id="nome-pl"></span> ha declinato la richiesta</p>
                    <button class="btn btn-rifiuto" id="dec">va bene</button>
                </div>
                <div class="messaggio-errore d-none">
                    <p><span id="mess-err"></span></p>
                    <button class="btn btn-rifiuto" id="err">va bene</button>
                </div>
            </div> 
        </div>

        <div class="container-cards-game-mode">
            <div class="card card-play-with-a-friend">
                <div class="title-card">
                    <h1>Gioca online</h1>
                </div>
                <div class="descrizione">
                    <p>Gioca a tris online con un altro giocatore</p>
                    <div class="bottoni player-casuale">
                        <button class="btn random-player">Trova</button>
                    </div>

                    <div class="separatore">
                        <hr>
                        <span>oppure</span>
                    </div>
                    <p>sfida un amico</p>
                </div>
                <form action="ricerca_giocatore.php" method="post" id="form">
                    <div class="form">
                        <label>Inserisci ID del giocatore<br></label>
                        <div class="input-wrapper">
                            <div class="prefisso">#</div>
                            <input type="text" id="idpl2" name="pl2" maxlength="6" placeholder="ID giocatore">
                        </div>
                        <div class="bottoni">
                            <input type="submit" value="Trova" id="btn-trova-amico" class="btn bottoni">
                        </div>
                    </div>
                </form>
            </div>
            <div class="card card-play-with-a-friend-local">
                <div class="title-card">
                    <h1>Gioca in locale</h1>
                </div>
                <div class="descrizione">
                    <p>Gioca contro un amico dallo stesso computer</p>
                </div>
                <div class="bottoni">
                    <button class="btn" id="mod-local">Gioca</button>
                </div>
            </div>
            <div class="card card-play-with-pc">
                <div class="title-card">
                    <h1>Gioca contro il computer</h1>
                </div>
            </div> 
        </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){

            const info_pl = {
                info: <?php echo $_SESSION["log"];?>,
                accettato: 0
            };

            function startTimer(duration, display_timer, display_mess) {
                var timer = duration, minutes, seconds;
                setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display_timer.textContent = minutes + ":" + seconds + (minutes == 0 ? " s":" m");

                    if (--timer < 0) {
                        display_mess.textContent = "Richiesta scaduta";
                        display_timer.textContent = "";
                        return;
                    }
                }, 1000);
            }

            function aggiorna_richiesta(status){
                $(".overlay").addClass("d-none");
                $(".richiesta-ricevuta").addClass("d-none");
                
                info_pl.accettato = status;


                var rit_ajax = $.ajax({
                    
                    type: "POST",
                    url: "aggiorna_richiesta.php",
                    data: info_pl,
                    success:function(data){
                        //console.log(data);
                    }
                });

                return rit_ajax;
                
            }

            function attesa_risposta(){
                $.ajax({
                    type:"POST",
                    url: "attesa_risposta.php",
                    data: info_pl,
                    success:function(data){
                        $ris = jQuery.parseJSON(data);
                        //console.log($ris);
                        if($ris.stato == 1){
                            $("#nome-pl2").text($ris.nome);
                            $(".timer").addClass("d-none");
                            $(".rifiuto-richiesta").removeClass("d-none");
                        }else if($ris.stato == 0){
                            window.location.href = "tris_online.php";
                        }

                    }
                });
            }


            //console.log("ready21\n");
            
            $("#richiesta-decli").submit(function(e){
                e.preventDefault();
                $(this).parents(".overlay").addClass("d-none");
                clearInterval(yourInterval);
            });

            $("#form").submit(function(e){
                e.preventDefault();
                //console.log(this);
                $(".overlay").removeClass("d-none");

                var form=$(this);
                var actionUrl = form.attr("action");


                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: form.serialize(),
                    success: function(data){
                        var json = jQuery.parseJSON(data);
                        /*console.log(json);
                        console.log(json.message);
                        console.log(json.status);*/
                        if(json.status == 1){
                            setInterval(attesa_risposta,500);
                            $("#idpl2").val("");
                            $(".timer").removeClass("d-none");
                            var timer = 3*60, display_timer= document.querySelector("#time"), display_mess = document.querySelector("#mess");
                            startTimer(timer,display_timer,display_mess);
                            //console.log("dopo timer");
                        }else if(json.status == 0){
                            $("#mess-err").text(json.message);
                            $(".messaggio-errore").removeClass("d-none");
                        }
                    }
                });
            });

            function richiesta(){
                $.ajax({
                    type: "POST",
                    url: "looking_for_request.php",
                    data: info_pl,
                    success: function(data){
                        ris = jQuery.parseJSON(data);
                        if(ris.nome != null)
                            nome_pl_mit = ris.nome;
                        //console.log(ris+"\n");
                        //console.log(data+"\n");
                        if(ris.stato == 1){
                            //console.log(data+"\n");
                            $("#nome-pl-request-ric").text(nome_pl_mit.toUpperCase());
                            $(".overlay").removeClass("d-none");
                            $(".richiesta-ricevuta").removeClass("d-none");
                            var timer = 3*60, display_timer= document.querySelector("#time"), display_mess = document.querySelector("#mess");
                            startTimer(timer,display_timer,display_mess);
                            
                        }else if(ris.stato == -1){

                            //console.log(nome_pl_mit);
                            $(".richiesta-ricevuta").addClass("d-none");
                            $("#nome-pl").text(nome_pl_mit);
                            $(".declino-richiesta").removeClass("d-none");
                        }
                    
                    }
                });
            }
            setInterval(richiesta,800);

            $("#btn-accetta-richiesta").on("click",function(e){
                $.when(aggiorna_richiesta(1)).done(function(event){
                    //console.log(event);
                    window.location.href = "tris_online.php";
                });
            });

            $("#btn-declina-richiesta").on("click",function(e){
                aggiorna_richiesta(-1);
            });

            $(".btn-rifiuto").on("click",function(){
                $(this).parent().addClass("d-none");
                $(this).parents(".overlay").addClass("d-none");
            });

            $(".timer .btn-timer").on("click",function(){
                $.ajax({
                    type: "post",
                    url: "declinazione_mittente.php",
                    data: info_pl,
                    success:function(){
                        $(".timer").addClass("d-none");
                        $(".overlay").addClass("d-none");
                    }
                });
            });

            $("#mod-local").on("click",function(){
                window.location.href = "tris.php";
            });
        });
    </script>        

</html>