<style>
@media print *{
	*{
		font-family: arial;
	}
	body{
		padding:0;
		margin:0;
	}
	a{
		text-decoration: none;
		color:#fff;
	}
	.header{
		background:#111;
		color:#fff;
		padding:30px;
		text-align: center;
		font-size:30px;
		font-weight: bold;
		text-transform: uppercase;
	}
	.menu{
		padding:10px;
		background: #111;
	}
	.menu a{
		text-decoration: none;
		color:#fff;
		background:#111;
		padding:10px;
	}
	.menu a:hover{
		background: #000;
	}
	.cuerpo{
		background: #eaeaea;
		padding:30px;
		min-height:440px;
	}
	.footer{
		background:#000;
		color:#aaa;
		text-align:center;
		font-size:10px;
		padding:50px;
	}
	.centrar_login{
		width:40%;
		text-align: center;
		padding-top:100px;
	}
	.producto{
		display:inline-block;
		width:25%;
		padding:10px;
		background: rgba(0,0,0,0.05);
		color:#333;
		margin:5px;
	}
	.img_producto{
		text-align: center;
		width:320px;
		height:322px;
	}
	.name_producto{
		padding:10px;
		color:#fff;
		background:#ff8800;
		text-align: center;
		font-size:18px;
		font-weight: bold;
	}
	.precio{
		color:#00aa00;
		padding:20px;
	}
	.subir{
		position: relative;
		bottom: 10px;
	}
	.imagen_carro{
		width:50px;
		height:50px;
		border-radius: 1000px;
	}
	.text-green{
		color:#0a0;
	}
}
</style>

<?php

if(isset($agregar) && isset($cant)){

	if(!isset($_SESSION['id_cliente'])){
		//alert("Debe de ingresar a su cuenta o crear una cuenta",0,'login');
		redir("?p=login");
	}

	$idp = clear($agregar);
	$cant = clear($cant);
	$id_cliente = clear($_SESSION['id_cliente']);
	$v = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'");
	
	if(mysqli_num_rows($v)>0){
		$q = $mysqli->query("UPDATE carro SET cant = cant + $cant WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'");	
	}else{
		$q = $mysqli->query("INSERT INTO carro (id_cliente,id_producto,cant) VALUES ($id_cliente,$idp,$cant)");
	}
	alert("Se ha agregado al carro de compras",1,'principal');
	//redir("?p=principal");
}
?>

<h1>Ultimos 3 Productos En Stock</h1><br><br>

<?php
$q = $mysqli->query("SELECT * FROM productos WHERE oferta = 0 ORDER BY id DESC LIMIT 3");
while($r=mysqli_fetch_array($q)){
	$preciototal = 0;

	$a = $r['id'];
	
		if($r['oferta']>0){
			if(strlen($r['oferta'])==1){
				$desc = "0.0".$r['oferta'];
			}else{
				$desc = "0.".$r['oferta'];
			}
				$preciototal = $r['price'] -($r['price'] * $desc);
			}else{
				$preciototal = $r['price'];
			}
?>

		<div class="producto">
			<div class="name_producto"><?=$r['name']?></div>
			<div><img class="img_producto" src="productos/<?=$r['imagen']?>"/></div>
			<?php
			if($r['oferta']>0){
				?>
				<del><?=$r['price']?> <?=$divisa?></del> <span class="precio"> <?=$preciototal?> <?=$divisa?> </span>
				<?php
			}else{
				?>
				<span class="precio"><br><?=$r['price']?> <?=$divisa?></span>
				<?php
			}
			?>

			<br><span class="name_talla">Seleccione su talla</span><br>

			<div class="row justify-content-center">
				<div class="col-xs-1">
					<select id="lista1s" name="lista1s" class="form-control">
						<?php
							$cats2 = $mysqli->query("SELECT * FROM EnStock WHERE id_producto = '$r[id]'");
							
							while($rcats = mysqli_fetch_array($cats2)){
						?>
								<option value="<?=$rcats['idstock']?>"><?=$rcats['TallaS']?> </option>
							<?php
								}	
						?>
					</select>
				
					<!-- <div id="select2lista" name="select2lista"></div> -->
				</div>
			</div><br>

			<input type="number" id="cant<?=$r['id']?>" name="cant" class="cant pull-right" value="1"/>


			<button class="btn btn-warning pull-right" onclick="agregar_carro('<?=$r['id']?>');" style="border-radius:0px 4px 4px 0px"><i class="fa fa-shopping-cart"></i></button>
			
		</div>
	<?php
}
?>
<br><h1>Ultimas 3 Ofertas En Stock</h1><br><br>

<?php
	$q = $mysqli->query("SELECT * FROM productos WHERE oferta>0 ORDER BY id DESC LIMIT 3");
	while($r=mysqli_fetch_array($q)){
	$preciototal = 0;
			if($r['oferta']>0){
				if(strlen($r['oferta'])==1){
					$desc = "0.0".$r['oferta'];
				}else{
					$desc = "0.".$r['oferta'];
				}
				$preciototal = $r['price'] -($r['price'] * $desc);
			}else{
				$preciototal = $r['price'];
			}
	?>
		<div class="producto">
			<div class="name_producto"><?=$r['name']?></div>
			<div><img class="img_producto" src="productos/<?=$r['imagen']?>"/></div><br>
			<del><?=$r['price']?></del> <span class="precio"> <?=$preciototal?> <?=$divisa?> </span>
		
			<br><span class="name_talla">Seleccione su talla</span><br>

			<div class="row justify-content-center">
				<div class="col-xs-1">
					<select id="lista1s" name="lista1s" class="form-control">
						<?php
							$cats2 = $mysqli->query("SELECT * FROM EnStock WHERE id_producto = '$r[id]'");
							
							while($rcats = mysqli_fetch_array($cats2)){
						?>
								<option value="<?=$rcats['idstock']?>"><?=$rcats['TallaS']?> </option>
							<?php
								}	
						?>
					</select>
				
					<!-- <div id="select2lista" name="select2lista"></div> -->
				</div>
			</div><br>

			<input type="number" id="cant<?=$r['id']?>" name="cant" class="cant pull-right" value="1"/>
			<button class="btn btn-warning pull-right" onclick="agregar_carro('<?=$r['id']?>');" style="border-radius:0px 4px 4px 0px"><i class="fa fa-shopping-cart"></i></button>
			&nbsp; &nbsp;
			
		</div>
	<?php
}
?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#lista1').val(1);
		recargarLista();

		$('#lista1').change(function(){
			recargarLista();
		});
	})
</script>

<script type="text/javascript">
	function recargarLista(){
		$.ajax({
			type:"POST",
			url:"Modulos/datos.php",
			data:"continente=" + $('#lista1').val(),
			success:function(r){
				$('#select2lista').html(r);
			}
		});
	}

</script>

<script type="text/javascript">
	
	function agregar_carro(idp){

		cant = $("#cant"+idp).val();
		talla = $("#lista1s");

		if(cant.length>0){
			window.location="?p=principal&agregar="+idp+"&cant="+cant+"&talla="+talla;
		}
	}
</script>