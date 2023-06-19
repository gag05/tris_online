<?php 
   session_start();
   echo session_id();
   include "connection.php";
   $ID_GIOCATORE = $_SESSION["log"];

   print_r("<br> sessione:".$_SESSION["situation"]."<br>");

   //print_r($_SESSION["situation"]);
   if(!isset($_SESSION["situation"]))
      $_SESSION["situation"] = array(0,0,0,0,0,0,0,0,0);

   //echo "ciao";

   $sql_id = "SELECT * FROM game WHERE player1_id=$ID_GIOCATORE OR player2_id = $ID_GIOCATORE";
   $result_id = mysqli_query($conn,$sql_id);
   if(!$result_id)
      echo "ERRORE:connessione";
   $row = $result_id->fetch_assoc();
   //print_r("ROW: ". $row);

   $ID_PARTITA = $row["game_id"];
   $GIOCATORE = ($row["player1_id"] == $ID_GIOCATORE) ? 0 : 1;

   $sql_pl_name = "SELECT player.player_name, player.player_id, game.player1_id, game.player2_id FROM player JOIN game WHERE (player.player_id=game.player1_id OR player.player_id=game.player2_id) AND game.game_id=$ID_PARTITA";
   $result_pl_name = mysqli_query($conn,$sql_pl_name);
   if(!$result_pl_name)
      echo "ERRORE:connessione";
   $row_pl_name = $result_pl_name->fetch_assoc();

   if($row_pl_name["player_id"] == $row_pl_name["player1_id"])
      $NAME_PLAYER = $row_pl_name["player_name"];
   else
      $NAME_PLAYER2 = $row_pl_name["player_name"];

   //echo "player_name: ".$NAME_PLAYER."<br>";

   $row_pl_name = $result_pl_name->fetch_assoc();
   if($row_pl_name["player_id"] == $row_pl_name["player1_id"])
      $NAME_PLAYER = $row_pl_name["player_name"];
   else
      $NAME_PLAYER2 = $row_pl_name["player_name"];
   
   /*echo "<br>player1_name: ".$NAME_PLAYER."<br>";
   echo "player2_name: ".$NAME_PLAYER2;*/
?>

<html>
   <head>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

      <link rel="stylesheet" href="./tris_online_style.css">
   </head>
 
   <body class="dark">
      <div class="overlay display-none">
         <div class="pop-up">
            <h2 class="display-none" id="p1">Ha vinto <?php echo $NAME_PLAYER;?></h2>
            <h2 class="display-none" id="p2">Ha vinto <?php echo $NAME_PLAYER2;?></h2>
            <h2 class="display-none" id="par">Pareggio</h2>
            <div class="row">
               <div class="col" style="padding-bottom: 10px; text-align:center; margin-top:30px;">
                  <button class="btn reset">Rivincita</button>
                  <button class="btn menu">Torna al menù</button>
               </div>
               <div class="invio-rivincita display-none">
                  <p>Hai inviato la rivincita a <?php 
                     echo $GIOCATORE == 0? $NAME_PLAYER2:$NAME_PLAYER;
                  ?></p>
                  <div class="bottoni btn-timer">
                        <button class="btn">Declina</button>
                  </div>
               </div>
               <div class="richiesta-ricevuta display-none">
                  <div class="testo-timer">
                        <p>HAI RICEVUTO UNA RICHIESTA DA <span id="nome-pl-request-ric"></span></p>
                        <p id="mess">Scadrà tra <span id="time">3:00<span> m</p>
                  </div>
                  <div class="btn-timer">
                        <button class="btn" type="submit" id="btn-accetta-richiesta">Accetta</button>
                        <button class="btn" type="submit" id="btn-declina-richiesta">Declina</button>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="cont-turno">
         <h2 class="turno">Turno: <span class="p-turn"><?php echo $NAME_PLAYER;?></span></h2>
         <div class = 'toggle-switch'>
            <label>
                <input type = 'checkbox' id="checkbox1">
                <span class = 'slider'></span>
            </label>
        </div>
      </div>
      
      <div class=contenitore-griglia>
         <div class="grid-container">
            <div class="grid-item lt" data-row="1" data-col="1"></div>
            <div class="grid-item top" data-row="1" data-col="2" ></div>
            <div class="grid-item rt" data-row="1" data-col="3"></div>
            <div class="grid-item ml" data-row="2" data-col="1"></div>
            <div class="grid-item middle" data-row="2" data-col="2"></div>
            <div class="grid-item mr" data-row="2" data-col="3"></div>
            <div class="grid-item bl" data-row="3" data-col="1"></div>
            <div class="grid-item bottom" data-row="3" data-col="2"></div>
            <div class="grid-item br" data-row="3" data-col="3"></div>
         </div>
      </div>

   </body>

   <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
   <script>
      $( document ).ready(function() {
         const info_pl = {
            info: <?php echo $_SESSION["log"];?>,
            accettato: 0
         };

         var a_r = [0,0,0];
         var a_c = [0,0,0];
         var a_d = [0,0]; 

         ricevi_mossa = 0;
         val_p = true; //p1 = true (x), p2 = false (o) 
         turno = 0;
         ris = 0;
         giocatore_bool =  <?php echo $GIOCATORE; ?>;
         if(giocatore_bool == 1)
            ricevi_mossa = setInterval(receive_move,800);     

         arr = <?= json_encode($_SESSION["situation"])?>;
         console.log(arr);
         for(i=0;i<9;i++){
            console.log(<?= $i ?>);
            pos = i;
            row = parseInt(pos/3)+1;
            col = pos%3+1;
            val = arr[i];
            console.log("pos: "+pos+" row: "+row+" col: "+col+" val: "+val);
            if(val == 1){
               console.log("croce inserita");
               click_cella(row,col,2);
            }else if(val != 0){
               console.log("cerchio inserito");
               click_cella(row,col,2);
            }
         }


         function richiesta(){   
            $.ajax({
               type: "POST",
               url: "looking_for_request.php",
               data: info_pl,
               success: function(data){
                  ris = jQuery.parseJSON(data);
                  ris = jQuery.parseJSON(data);

                  if(ris.nome != null)
                     nome_pl_mit = ris.nome;
                  else
                     nome_pl_mit = "";
                  //console.log(ris+"\n");
                  //console.log(data+"\n");
                  if(ris.stato == 1){
                        //console.log(data+"\n");
                        $("#nome-pl-request-ric").text(nome_pl_mit.toUpperCase());
                        $(".col").addClass("display-none");
                        $(".overlay h2").addClass("display-none");
                        $(".richiesta-ricevuta").removeClass("display-none");

                        /*var timer = 3*60, display_timer= document.querySelector("#time"), display_mess = document.querySelector("#mess");
                        startTimer(timer,display_timer,display_mess);*/
                        
                  }else if(ris.stato == -1){

                        //console.log(nome_pl_mit);
                        $(".richiesta-ricevuta").addClass("display-none");
                        $("#nome-pl").text(nome_pl_mit);
                        $(".declino-richiesta").removeClass("display-none");
                  }
               
               }
            });
         }


         function aggiorna_ris(){
            console.log("aggiorno");
            ris = 1;
         }

         function receive_move(){

            json = jQuery.parseJSON('{"game_id": '+<?php echo $ID_PARTITA; ?>+',"turno": '+giocatore_bool+'}');
            $.ajax({
               type: "post",
               url: "ricevi_mossa.php",
               data: json,
               success:function(data){
                  //console.log("sto ricevendo");
                  data = jQuery.parseJSON(data);
                  //console.log(data);
                  //console.log(turno%2);
                  //console.log(parseInt(data.mit) == giocatore_bool);

                  if(data.row != 0 && parseInt(data.mit,10) != giocatore_bool){
                     //console.log("sono stato io");
                     click_cella(data.row,data.col,1);
                     clearInterval(ricevi_mossa);
                     
                  }
               }
            });
         }

         function aggirona_array(row,col,val_agg){
            a_r[row-1] += val_agg;
            a_c[col-1] += val_agg;
            
            if(row != 2 && col != 2){
               if(row == col){
                  a_d[0] += val_agg;
               }else{
                  a_d[1] += val_agg;
               }
            }else if(row == col){
               a_d[0] += val_agg;
               a_d[1] += val_agg;
            }
         }
         
         function update(giocatore,row,col,b){
            //p1 = true (x), p2 = false (o) 
            val_agg = giocatore? 1:-1;

            json = jQuery.parseJSON('{"row": '+row+', "col": '+col+', "val": '+val_agg+'}');

            if(b != 2)
               $.ajax({
                  type: "post",
                  url: "aggiorna_situazione.php",
                  data: json,
                  success:function(data){
                     console.log(data+"\n");
                  }
               });

            //$_SESSION["situation"][((row-1)*3)+col] = val_agg;

            aggirona_array(row,col,val_agg);

            if(b != 1 && b != 2){
               json = jQuery.parseJSON('{"row": '+row+',"col": '+col+',"player": '+<?php echo $GIOCATORE;?>+',"game_id": '+<?php echo $ID_PARTITA;?>+'}');
               console.log("mando mosse");
               return $.ajax({
                  type: "post",
                  url: "invio_mosse.php",
                  data: json,
                  success:function(data){
                     console.log("ho inviato una mossa: "+data);
                  }

               });
            }

         }

         function attesa_risposta(){
               $.ajax({
                  type:"POST",
                  url: "attesa_risposta.php",
                  data: info_pl,
                  success:function(data){
                     $ris = jQuery.parseJSON(data);
                     console.log($ris);
                     if($ris.stato == 1){
                        $("#nome-pl2").text($ris.nome);
                        $(".timer").addClass("d-none");
                        $(".rifiuto-richiesta").removeClass("d-none");
                     }else if($ris.stato == 0){
                        <?php 
                           $sql = "UPDATE game SET n_giocatori = 2 WHERE game_id = $ID_PARTITA";
                           $result = mysqli_query($conn,$sql);
                           if(!$result)
                              echo "err";
                        ?>
                        $(".overlay").addClass("display-none");
                        reset();
                     }

                  }
               });
         }

         function controllo(turno,p){
            pos = 0;
            vinc = false;
            console.log("turno: "+turno);
            if(turno>=5){

               g = p? 1:-1;
               if((pos=$.inArray(g*3,a_r)+1) != 0){
                  vinc = !vinc;
               }else if((pos=$.inArray(g*3,a_c)+1) != 0){
                  vinc = !vinc;
                  $(".grid-item[data-col="+pos+"]").addClass("green");
               }else if((pos=$.inArray(g*3,a_d)+1) != 0){
                  vinc = !vinc;
                  if(pos == 1){
                     for(i=1;i<4;i++){
                        $(".grid-item[data-row='"+i+"'][data-col='"+i+"']").addClass("green");
                     }
                  }else{
                     j = 3;
                     for(i=1;i<4;i++){
                        $(".grid-item[data-row='"+j+"'][data-col='"+i+"']").addClass("green");
                        j--;
                     }        
                  }
               }

               if(pos != 0){
                  //$(".grid-item").off("click");
                  $(".overlay").removeClass("display-none");
                  if(g > 0){
                     $("#p1").removeClass("display-none");
                  }else{
                     $("#p2").removeClass("display-none");
                  }

               }else if(turno>= 9){
                  //$(".grid-item").off("click");
                  $(".overlay").removeClass("display-none");
                  $("#par").removeClass("display-none");
               }
            }
            if(!vinc){
               $(".p-turn").text(""+((turno%2)==0? "<?php echo $NAME_PLAYER?>" : "<?php echo $NAME_PLAYER2?>"));
            }else{
               json = jQuery.parseJSON('{"game_id": '+<?php echo $ID_PARTITA; ?>+'}');

               console.log("reset game");
               if(giocatore_bool == 1){
                  $.ajax({
                     type: "post",
                     url: "reset_game.php",
                     data: json,
                     success:function(){
                        console.log("reset");
                     }
                  });
               }
               setInterval(richiesta,800);
               <?php $_SESSION["situation"] = array(0,0,0,0,0,0,0,0,0); ?>
            }
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


         function click_cella(row,col,b){
            cella = $(".grid-item[data-row='"+row+"'][data-col='"+col+"']");
            turno++;


            $.when(update(val_p,row,col,b)).done(function(){});

            if(val_p){
               cella.addClass("x checked");               
            }else{
               cella.addClass("o checked");
            }
            controllo(turno,val_p);
            val_p = !val_p;
         }

         function reset(){
            $(".grid-item").each(function(index){
               $(this).removeClass("green x o checked")
            });

            $(".p-turn").text(""+'<?php echo $NAME_PLAYER; ?>');
            turno = 0;

            $(".overlay").addClass("display-none");
            $(".pop-up h2").addClass("display-none");
            val_p = true;
            a_r = [0,0,0];
            a_c = [0,0,0];
            a_d = [0,0]; 
         }

         function cancella_stanza(){
            json = jQuery.parseJSON('{"game_id": '+<?= $ID_PARTITA?>+'}');

            return $.ajax({
               type: "post",
               url: "cancella_game.php",
               data: json,
               success:function(data){
                  //console.log(data);
               }
            });

         }

         $(".grid-item").on("click",function(){

            if(!$(this).hasClass("checked") && giocatore_bool == turno%2){
               row = $(this).data("row");
               col = $(this).data("col");
               click_cella(row,col,0);
               ricevi_mossa = setInterval(receive_move,800);
            }
         });

         $('#checkbox1').change(function() { 
            $("body").toggleClass("dark");
         });

         $(".btn.reset").on("click",function(){

            $(".overlay h2").addClass("display-none");
            $(".col").addClass("display-none");
            $(".invio-rivincita").removeClass("display-none");

            json = jQuery.parseJSON('{"pl2":2,"game_id":'+<?php echo $ID_PARTITA;?>+'}');

            $.ajax({
               type: "post",
               url: "ricerca_giocatore.php",
               data: json,
               success:function(){
                  console.log("rimandata la richiesta");
               }
            });
            setInterval(attesa_risposta, 800);
         });

         $(".btn.menu").on("click",function(){
            $.when(cancella_stanza()).done(function(){});
            window.location.href = "scelta_modalita_di_gioco.php";
         });

         $("#btn-accetta-richiesta").on("click",function(){
            $.when(aggiorna_richiesta(1)).done();
            reset();
         });

         $("#btn-rifiuta-richiesta").on("click",function(){
            $.when(aggiorna_richiesta(-1)).done();
            window.location.href = "scelta_modalita_di_gioco.php";
         });

        $(window).bind('beforeunload',function(){
            cancella_stanza();
            return 'saiaodoiasido';
         });

         $(window).on("unload",function(){
            
            return 'saiaodoiasido';
         });
         /*window.onbeforeunload= function(e){
            var s = "s";
            e.returnValue= s;
            return "ciaoooo";
         }*/
      });

   </script>
</html>