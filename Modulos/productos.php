<form method="post" action="">
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<input type="text" class="form-control" name="busq" placeholder="Coloca el nombre del producto"/>
				</div>
			</div>

			<div class="col-md-5">
				<select id="categoria" name="cat" class="form-control">
                
                <option value="">Seleccione alguna categoria</option>
					<?php
					$cats = $mysqli->query("SELECT * FROM categorias ORDER BY categoria ASC");
					while($rcat = mysqli_fetch_array($cats)){
						?>
						<option value="<?=$rcat['id']?>"><?=$rcat['categoria']?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="col-md-2">
				<button type="submit" class="btn btn-primary" name="buscar"><i class="fa fa-search"></i> Buscar</button>
			</div>
		</div>
	</form>

<?php
         
    if(isset($cat)){
	    $sc = $mysqli->query("SELECT * FROM categorias WHERE id = '$cat'");
	    $rc = mysqli_fetch_array($sc);
	    ?>
	    <?php
    }

    if(isset($agregar) && isset($cant)){

        if(!isset($_SESSION['id_cliente'])){
            alert("Debe de ingresar a su cuenta o crear una cuenta",0,'Error');
            redir("?p=login");
        }
        
        $idp = clear($agregar);
        $cant = clear($cant);
        $id_cliente = clear($_SESSION['id_cliente']);

        $v = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'");

        if(mysqli_num_rows($v) > 0){
            $q = $mysqli->query("UPDATE carro SET cant = cant + $cant WHERE id_cliente = '$id_cliente' AND id_producto = '$idp'");
        }else{
            $q = $mysqli->query("INSERT INTO carro (id_cliente,id_producto,cant) VALUES ($id_cliente,$idp,$cant)");
        }

        alert("Se ha agregado al carrito de compras",1,'productos');
        //redir("?p=productos");
    }

    if(isset($busq) && isset($cat)){
        if($cat != null){
            $q = $mysqli->query("SELECT * FROM productos WHERE name LIKE '%$busq%' AND id_categoria = '$cat'");
        }else{
            $q = $mysqli->query("SELECT * FROM productos WHERE name LIKE  '%$busq%'");
        }      
    }else if(isset($cat) && !isset($busq) ){ //existe una categoria pero no una busqueda
        $q = $mysqli->query("SELECT * FROM productos WHERE id_categoria '$cat' ORDER BY id DESC");
    }else if(isset($busq) && !isset($cat)){ //existe una busqueda pero no una categoria
        if($cat != null){
            $q = $mysqli->query("SELECT * FROM productos WHERE name LIKE '%$busq%' AND id_categoria = '$cat'");
        }else{
            $q = $mysqli->query("SELECT * FROM productos WHERE name LIKE  '%$busq%'");
        }      
        $q = $mysqli->query("SELECT * FROM productos WHERE name LIKE '%$busq%'");
    }else if(!isset($busq) && !isset($cat)){
        $q = $mysqli->query("SELECT * FROM productos ORDER BY id DESC");
    }else{
        $q = $mysqli->query("SELECT * FROM productos ORDER BY id DESC");
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
        <div class="name_producto"><?= $r['name']?></div>
        <div><img class="img_producto" src="productos/<?= $r['imagen'] ?>"/></div>

        <?php 
            if($r['oferta'] > 0){
                ?>
                <del><?=$r['price']?><br></del> <span class="precio"> <?=$preciototal?> <?=$divisa?> </span>
                <?php 
            }else{
                ?>
                <span class="precio"><br><?= $r['price']?> <?= $divisa?></span>
                <?php 
            }
        ?>

            <div class="row justify-content-center">
				<div class="col-xs-1">
					<select id="lista1" name="lista1" class="form-control">
						<?php
							$cats2 = $mysqli->query("SELECT * FROM EnStock WHERE id_producto = '$r[id]'");
							
							while($rcats = mysqli_fetch_array($cats2)){
						?>
								<option value="<?=$rcats['idstock']?>"><?=$rcats['TallaS']?> </option>
							<?php
								}	
						?>
					</select>
				
				</div>
            </div><br>
            
            <input type="number" id="cant<?=$r['id']?>" name="cant" class="cant pull-right" value="1"/>
            <button class="btn btn-warning" onclick="agregar_carro('<?= $r['id']?>');"><i class="fa fa-shopping-cart"></i></button>
    </div>

    <?php
    }
?> 

<script type="text/javascript">
	function agregar_carro(idp){
		var cant = $("#cant"+idp).val();
		if(cant.length>0){
			window.location="?p=productos&agregar="+idp+"&cant="+cant;
		}
	}
</script>
