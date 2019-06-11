<select id="categoria" onchange="redir_cat()" class="form-control">
	<option value="">Seleccione una categoria para filtrar</option>
	<?php
	$cats = $mysqli->query("SELECT * FROM categorias ORDER BY categoria ASC");
	while($rcat = mysqli_fetch_array($cats)){
		?>
		<option value="<?=$rcat['id']?>"><?=$rcat['categoria']?></option>
		<?php
	}
	?>
</select>


<?php

if(isset($cat)){
	$sc = $mysqli->query("SELECT * FROM categorias WHERE id = '$cat'");
	$rc = mysqli_fetch_array($sc);
	?>
	<?php
}
if(isset($agregar) && isset($cant)){

	if(!isset($_SESSION['id_cliente'])){
		//alert("Debe de ingresar a su cuenta o crear una cuenta",0,'registro');
		redir("?p=login");
	}

	$id_cliente = clear($_SESSION['id_cliente']);

	$idp = clear($agregar);
	$cant = clear($cant);
	$v = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'");
	if(mysqli_num_rows($v)>0){
		$q = $mysqli->query("UPDATE carro SET cant = cant + $cant WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'");
	
	}else{
		$q = $mysqli->query("INSERT INTO carro (id_cliente,id_producto,cant) VALUES ($id_cliente,$idp,$cant)");
	}
	alert("Se ha agregado al carro de compras",1,'productos');
}

if(isset($cat)){
	$q = $mysqli->query("SELECT * FROM productos WHERE id_categoria = '$cat' AND oferta>0 ORDER BY id DESC");
}else{
	$q = $mysqli->query("SELECT * FROM productos WHERE oferta>0 ORDER BY id DESC");
}
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
			<del><?=$r['price']?> <?=$divisa?></del> <span class="precio"> <?=$preciototal?> <?=$divisa?> </span>
			
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
			
			<button class="btn btn-warning pull-right" onclick="agregar_carro('<?=$r['id']?>');"><i class="fa fa-shopping-cart"></i></button>
		</div>
	<?php
}
?>

<script type="text/javascript">
	
	function agregar_carro(idp){
		var cant = $("#cant"+idp).val();
		if(cant.length>0){
			window.location="?p=ofertas&agregar="+idp+"&cant="+cant;
		}
	}
	function redir_cat(){
		window.location="?p=ofertas&cat="+$("#categoria").val();
	}
</script>