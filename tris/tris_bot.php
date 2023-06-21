<?php
	/*session_start();
	include "connection.php";

	$sql_aggiorna_avaible = "UPDATE player SET avaible = 0 WHERE player_id = ".$_SESSION["log"];
	//echo $sql_aggiorna_avaible;
	$result_aggiorna_avaible = mysqli_query($conn,$sql_aggiorna_avaible);
	if(!$result_aggiorna_avaible)
		echo "err";*/
?>

<html>
	<head>

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

		<style>
			/* f4dddd */
			body{
				font-family: 'Poppins', sans-serif;
				background-color: #fffbff;
				color:#201a1a;
			}

			body.dark{
				background-color:#201a1a;
				color: #ece0df;
			}

			.grid-container {
				display: grid;
				grid-template-columns: auto auto auto;
				
				width:100%;
				max-height: 800px;
				padding: 10px;
				max-width:800px;
				margin: auto;
			}
			.grid-item {
				border: 3px solid rgba(0, 0, 0, 0.8);
				font-size:0px;
				display:flex;
				align-items:center;
				justify-content:center;
				padding-top: 100%;
				border-color: #201a1a;
			}

			.dark .grid-item{
				border-color: #ece0df;
			}

			.contenitore-griglia{
				display: flex;
				width:100%;
				height:auto;
				align-content:center;
				flex-direction: column;
				justify-content: center;
				position:relative;
				top:80px;
			}

			.lt{
				border-top-style: none;
				border-left-style: none;
			}

			.top{
				border-top-style: none;
			}

			.rt{
				border-top-style: none;
				border-right-style: none;
			}

			.ml{
				border-left-style: none;
			}

			.mr{
				border-right-style: none;
			}

			.bl{
				border-bottom-style: none;
				border-left-style: none;
			}

			.bottom{
				border-bottom-style: none;
			}

			.br{
				border-bottom-style: none;
				border-right-style: none;
			}

			.x{
				background-image: URL("svg/icon_p1.svg");
				background-size: contain;
			}

			.dark .x{
				background-image: URL("svg/icon_p1_dark.svg");
			}

			.o{
				background-image: URL("svg/icon_p2.svg");
				background-size: contain;
			}

			.dark .o{
				background-image: URL("svg/icon_p2_dark.svg");
			}

			.overlay,.overlay-loader{
				width: 100%;
				height: 100%;
				position: absolute;
				left: 50%;
				top: 50%;
				transform: translate(-50%,-50%);
				display: flex;
				justify-content: center;
				align-items: center;
				background: rgba(255,255,255,.2);
				z-index:1;
			}

			.overlay-loader{
				background: rgba(255,255,255,.8);
				opacity: 0;
				transition: .3s linear opacity;
				pointer-events: none;
			}
			.overlay-loader.active{
				opacity: 1;
				pointer-events: auto;
			}	
			.dark .overlay{
				background: rgba(0,0,0,.2);
			}

			.dark .overlay-loader{
				background: rgba(0,0,0,.8);
			}

			.dark .turno{
				color: rgba(255,255,255,0.8);
			}

			.pop-up{
				background-color: #ffdada;
				padding: 30px 40px;
				border-radius: 14px;
				display: inline-block;
				color: #40000c;
			}

			.dark .pop-up{
				background-color: #7d2933;
				color:#ffdada;
			}

			.display-none{
				display: none;
			}

			.btn {
				position:relative;
				width: auto;
				color:#ffffff;
				border: 0px solid transparent;
				border-radius:5px;
				background:#9c4049;
				text-align:center;
				padding:16px 18px 14px;
				margin: 0px 5px;
			}

			.btn:hover{
				background: #40000b;
			}
			.dark .btn:hover{
				background-color: #e5a1ab;
			}

			.dark .btn{
				background-color: #ffb3b6;
				color: #5f121e;
			}

			:root {
				--light: #d8dbe0;
				--dark: #28292c;
				--link: rgb(27, 129, 112);

			}

			* {
				padding: 0;
				margin: 0;
				box-sizing: border-box;
			}

			.toggle-switch {
				position: relative;
				width: 65px;
				z-index: 2;
			}

			.green{
				background-color: green;
			}

			.dark .green{
				background-color: rgb(25,104,0);
			}

			label {
				position: absolute;
				width: 100%;
				height: 30px;
				background-color: var(--light);
				border-radius: 50px;
				cursor: pointer;
			}

			input {
				position: absolute;
				display: none;
			}

			.slider {
				position: absolute;
				width: 100%;
				height: 100%;
				border-radius: 50px;
				transition: 0.3s;
			}

			input:checked ~ .slider {
				background-color: var(--dark);
			}

			.slider::before {
				content: "";
				position: absolute;
				top: 5px;
				left: 5px;
				width: 20px;
				height: 20px;
				border-radius: 50%;
				box-shadow: inset 8px -2px 0px -1px var(--dark);
				background-color: var(--light);
				transition: 0.3s;
				
			}

			input:checked ~ .slider::before {
				transform: translateX(35px);
				background-color: var(--light);
				box-shadow: none;
			}

			a:hover {
				color: var(--link-hover);
			}

			.cont-turno{
				display: flex;
				justify-content: space-between;
				padding: 30px 30px 0px;
			}

			.loader{
				position: fixed;
				top:0;
				right:0;
				bottom:0;
				left:0;
				display: flex;
				justify-content:center;
				align-items: center;
			}

			.loader svg{
				width: 400px;
				height:400px;
			}

			.anim-line{

			}
		</style>
	</head>
	
	<body class="dark">
		<div class="overlay-loader">
		<div class="loader">
				<?php include("./svg/loader.svg"); ?>
			</div>
		</div>
		<div class="overlay display-none">
			<div class="pop-up">
				<h2 class="display-none" id="p1">Ha vinto il giocatore 1</h2>
				<h2 class="display-none" id="p2">Ha vinto il giocatore 2</h2>
				<h2 class="display-none" id="par">Pareggio</h2>
				<div class="row">
				<div class="col" style="padding-bottom: 10px; text-align:center; margin-top:30px;">
					<button class="btn reset">Rigioca</button>
					<button class="btn menu">Torna al menù</button>
				</div>
				</div>
			</div>
		</div>

		<div class="cont-turno">
			<h2 class="turno">Turno: player<span class="p-turn">1</span></h2>
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
			
			function mossa_bot(){
				console.log("bot mossa");
				$(".overlay-loader").addClass("active");
				$(".loader svg").addClass("animato");
				loader = setInterval(function(){$(".loader svg").toggleClass("animato");},4200);
				//$(".loader svg").addClass("animato");
				a_r_json =  JSON.stringify(a_r);
				a_c_json = JSON.stringify(a_c);
				a_d_json = JSON.stringify(a_d);
				sit_json = JSON.stringify(sit);
				//console.log("json a_r: "+sit);
				json = jQuery.parseJSON('{"row":'+a_r_json+',"col": '+a_c_json+',"diag": '+a_d_json+',"sit": '+sit_json+',"turn": '+turno+'}');
				$.ajax({
					type: "post",
					url: "comunicazione_bot.php",
					data: json,
					success:function(data){
						ris = JSON.parse(data);
						//console.log(ris.row,ris.col);
						clicca_cella(parseInt(ris.row)+1,parseInt(ris.col)+1);
						clearInterval(loader);
						$(".loader svg").removeClass("animato");
						//console.log("remove amimato")
						$(".overlay-loader").removeClass("active");
					}
				});
			}

			function update(row,col){
				//p1 = true (x), p2 = false (o) 
				val_agg = val_p? 1:-1;
				
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
				sit[row-1][col-1] = val_agg;
				/*console.log(a_r+"\n");
				console.log(a_c+"\n");
				console.log(a_d+"\n");*/
			}

			function controllo(turno,p){
				pos = 0;
				vinc = false;
				//pos+"\n");
				if(turno>=5){
				//console.log("almeno 5");
				g = p? 1:-1;
				if((pos=$.inArray(g*3,a_r)+1) != 0){
					//console.log("a_r vincente");
					//console.log(pos+"\n");
					vinc = !vinc;
					$(".grid-item[data-row="+pos+"]").addClass("green");
				}else if((pos=$.inArray(g*3,a_c)+1) != 0){
					//console.log("a_c vincente");
					//console.log(pos+"\n");
					vinc = !vinc;
					$(".grid-item[data-col="+pos+"]").addClass("green");
				}else if((pos=$.inArray(g*3,a_d)+1) != 0){
					//console.log("a_d vincente");
					vinc = !vinc;
					if(pos == 1){
						for(i=1;i<4;i++){
							//console.log(i+"\n");
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
				if(!vinc)
					$(".p-turn").text(""+((turno%2)+1));
				
				return vinc;	
			}

			function clicca_cella(row,col){
				//console.log("val_p: "+val_p);
				cella = $(".grid-item[data-row='"+row+"'][data-col='"+col+"']");
				turno++;
				//onsole.log(row,col);
				update(row,col);
				if(val_p){
					cella.addClass("x checked");               
				}else{
					cella.addClass("o checked");
				}
				rit = controllo(turno,val_p);
				val_p = !val_p;
				return rit;
			}

			var a_r = [0,0,0];
			var a_c = [0,0,0];
			var a_d = [0,0]; 
			var sit = [
						[0,0,0],
						[0,0,0],
						[0,0,0]
					];

			val_p = true; //p1 = true (x), p2 = false (o) 
			turno = 0;
			//console.log("ce stox2");
			$(".grid-item").on("click",function(){
				console.log("ce sto: ",val_p);
				if(!$(this).hasClass("checked") && val_p){
					//console.log(""+((turno%2)+1));
					row = $(this).data("row");
					col = $(this).data("col");
					if(!clicca_cella(row,col))
						mossa_bot();
				}

			});

			$('#checkbox1').change(function() { 
				$("body").toggleClass("dark");
			});

			$(".btn.reset").on("click",function(){
				//console.log("premuto_bot");
				$(".grid-item").each(function(index){
				$(this).removeClass("green x o checked")
				});

				$(".p-turn").text(""+1);
				turno = 0;

				$(".overlay").addClass("display-none");
				$(".pop-up h2").addClass("display-none");
				val_p = true;
				a_r = [0,0,0];
				a_c = [0,0,0];
				a_d = [0,0]; 
				sit = [[0,0,0],[0,0,0],[0,0,0]];
			});

			$(".btn.menu").on("click",function(){
				window.location.href = "scelta_modalita_di_gioco.php";
			});
		});

	</script>
</html>