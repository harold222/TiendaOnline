<?php

    check_user('carrito');

    if(isset($eliminar)){
        $eliminar = clear($eliminar);
        $mysqli->query("DELETE FROM carro WHERE id = '$eliminar'");
        redir("?p=carrito");
    }

    if(isset($id) && isset($modificar)){
        $id = clear($id);
        $modificar = clear($modificar);
        $mysqli->query("UPDATE carro SET cant = '$modificar' WHERE id = '$id'");
        alert("Cantidad modificada",1,'carrito');
        //redir("?p=carrito");
    }    

    if(isset($finalizar)){

        $monto = clear($monto_total);
        $id_cliente = clear($_SESSION['id_cliente']);

        $q = $mysqli->query("INSERT INTO compra (id_cliente,fecha,monto,estado) VALUES ('$id_cliente',NOW(),'$monto',0)");
        $sc = $mysqli->query("SELECT * FROM compra WHERE id_cliente = '$id_cliente' ORDER BY id DESC LIMIT 1");
        $rc = mysqli_fetch_array($sc);

        $ultima_compra = $rc['id'];

        $q2 = $mysqli->query("SELECT * FROM carro WHERE id_cliente = '$id_cliente'");

        while($r2=mysqli_fetch_array($q2)){
            $sp = $mysqli->query("SELECT * FROM productos WHERE id = '".$r2['id_producto']."'");
            $rp = mysqli_fetch_array($sp);
            $monto = $rp['price'];
            $mysqli->query("INSERT INTO productos_compra (id_compra,id_producto,cantidad,monto) VALUES ('$ultima_compra','".$r2['id_producto']."','".$r2['cant']."','$monto')");
        }

        $mysqli->query("DELETE FROM carro WHERE id_cliente = '$id_cliente'");
	    
        alert("Se ha finalizado la compra",1,'miscompras');
        //redir("?p=miscompras");
    }
?>

<h1><i class="fa fa-shopping-cart" ></i>Carro de compras</h1>
<br><br>

<table class="table table-striped">
    <tr>
        <th><i class="fa fa-image"></i></th> 
        <th>Nombre del producto</th> 
        <th>Cantidad</th>
        <th>Talla</th> 
        <th>Precio por unidad</th> 
        <th>Oferta</th> 
        <th>Precio Total</th>
        <th>Modificar la cantidad</th>
        <th>Eliminar del carrito</th>
    </tr>
    
<?php
    $id_cliente = clear($_SESSION['id_cliente']);
    $q = $mysqli->query("SELECT * FROM carro WHERE id_cliente= '$id_cliente'");
    $monto_total = 0;

    while($r = mysqli_fetch_array($q)){
        $q2 = $mysqli->query("SELECT * FROM productos WHERE id= '".$r['id_producto']."'");
        $r2 = mysqli_fetch_array($q2);

        $preciototal = 0;
		if($r2['oferta']>0){
			if(strlen($r2['oferta'])==1){
				$desc = "0.0".$r2['oferta'];
			}else{
				$desc = "0.".$r2['oferta'];
            }
            
            $preciototal = $r2['price'] -($r2['price'] * $desc);
            
		}else{
			$preciototal = $r2['price'];
		}

        $nombre_producto = $r2['name'];
        $cantidad = $r['cant'];
        $precio_unidad = $r2['price'];
        $precio_total = $preciototal * $cantidad;
        $imagen_producto = $r2['imagen'];

        $monto_total = $monto_total + $precio_total; 

        ?>
            <tr>
                <td><img src="productos/<?= $imagen_producto ?>" class="imagen_carro" /></td> 
                <td><?=$nombre_producto ?></td> 
                <td><?= $cantidad ?></td> 
                <td><?= $precio_unidad ?> <?= $divisa ?> </td> 
                <td><?php 
                        if($r2['oferta'] > 0){
                            echo $r2['oferta']."% de Descuento";
                        }else{
                            echo "Sin descuento.";
                        }
                    ?>
                </td>
			    <td><?=$precio_total?> <?=$divisa?></td>
                <td>
                    <a onclick="modificar('<?=$r['id']?>')" href="#"><i class="fa fa-edit" tittle="Editar"></i></a><th>
                    <a href="?p=carrito&eliminar=<?= $r['id'] ?>"><i class="fa fa-times" tittle="Eliminar"></i></a>
                </td>
            </tr>
        <?php
    }
?>

</table>
<br>

<h2>El monto total es de: <b class="text-green"> <?= $monto_total?> <?=$divisa?> </b></h2>

<br><br>

<form method="post" action="">
    <div align="center">
        <input type="hidden" name="monto_total" value="<?= $monto_total ?> "/>
        <button class="btn btn-primary" type="submit" name="finalizar"><i class="fa fa-check"></i>Finalizar Compra</button>
    </div>
</form>

<script type="text/javascript">
		
	function modificar(idc){
		var new_cant = prompt("¿Cual es la nueva cantidad?");
		if(new_cant>0){
			window.location="?p=carrito&id="+idc+"&modificar="+new_cant;
		}
	}
</script>