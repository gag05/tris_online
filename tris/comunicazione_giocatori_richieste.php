    <?php function attesa_risposta(){ ?>
        <script>
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
        </script>
    <?php } ?>

    <?php function ricerca(){ ?>
        <script>
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
        </script>
    <?php } ?>

    <?php function richiesta(){ ?>
    </script>
        <script>
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
        
        </script>
    <?php } ?>

    <?php function declinazione(){ ?>
        <script>
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
        </script>
    <?php } ?>

    <?php function aggiorna_richiesta($status){ ?>
        <script>
            $(".overlay").addClass("d-none");
            $(".richiesta-ricevuta").addClass("d-none");
            
            info_pl.accettato = <?= $status; ?>;


            var rit_ajax = $.ajax({
                
                type: "POST",
                url: "aggiorna_richiesta.php",
                data: info_pl,
                success:function(data){
                    //console.log(data);
                }
            });

            return rit_ajax;
        </script>
    <?php } ?>

