<?php
    include "Configuracion/config.php";
    include "Configuracion/funciones.php";

    if(!isset($p)){
        $p = "principal";
    }else{
        $p = $p;
    }
?>

<!DOCTYPE html>
<HTML>
    <HEAD>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="Recursos/css/estilo.css"/>
	    <link rel="stylesheet" href="Recursos/bootstrap/css/bootstrap.css"/>
	    <link rel="stylesheet" href="Recursos/fontawesome/css/all.css"/>
	    <script type="text/javascript" src="Recursos/bootstrap/js/bootstrap.js"></script>
	    <script type="text/javascript" src="Recursos/fontawesome/js/all.js"></script>
	    <script type="text/javascript" src="Recursos/js/jquery.js"></script>
	    <script type="text/javascript" src="Recursos/js/app.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.js"></script> -->
        
        <title>Tienda Online</title>
    </HEAD>

    <BODY>

        <nav>

            <div class="logo">
                <img src="Recursos/img/28.png">
            </div>

            <ul>
                <li><a href="?p=principal" class="active">Home</a></li>
                <li><a href="?p=productos">Productos</a></li>
                <li><a href="?p=ofertas">Ofertas</a></li>

                <?php
                    if(isset($_SESSION['id_cliente'])){
                ?>

                <li><a href="?p=carrito">Mi Carrito</a></li>
                <li><a href="?p=miscompras">Mis compras</a></li>
                <li><a href="#"><?=nombre_cliente($_SESSION['id_cliente'])?></a></li>
                <li><a href="?p=salir">Salir</a></li>

                <?php
                }else{
                    ?>
                        <li><a href="?p=contacto">Contactanos</a></li>
                        <li><a href="?p=login">Login</a></li>
                    <?php 
                }
            ?>
            </ul>

        </nav>

        <section class="sec1">

                <h1>Tienda Online de ropa M&M</h1>

        </section>
        <section class="content">

        <?php
                if(file_exists("Modulos/".$p.".php")){
                    include "Modulos/".$p.".php";
                }else{
                    echo "<i>No se ha encontrado el modulo<a href='./'>Regresar</a></i>";
                }
            ?> </section>
        <div class="carritot" onclick="minimizer()">
            Ver carrito de compras
            <input type="hidden" id="minimized" value=0/>
        </div>  

        <div class="carritob">

        <table class="table table-striped">
            <tr>
                <th>Nombre del producto</th> 
                <th>Cantidad</th> 
                <th>Precio total</th> 
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
                <td><?=$nombre_producto ?></td> 
                <td><?= $cantidad ?></td> 
                <td><?= $precio_total ?> <?= $divisa ?> </td> 
            </tr>
        <?php
    }
?>

</table>
<br>

<span>El monto total es de: <b class="text-green"> <?= $monto_total?> <?=$divisa?> </b></span>

<br><br>

<form method="post" action="?p=carrito">
    <div align="center">
        <input type="hidden" name="monto_total" value="<?= $monto_total ?> "/>
            <button onclick ='carrito.php' class="btn btn-sucess" type="submit" name="revisar"><i class="fa fa-check"></i>Revisar Compra</button>
            <button class="btn btn-primary" type="submit" name="finalizar"><i class="fa fa-check"></i>Finalizar Compra</button>
        </div>
</form>

        </div> 

        <div class="footer">
            Copyright Jeans M&M &copy; <?=date("y")?>
        </div>     

    </BODY> 
</HTML>

    <script type="text/javascript">
        $(window).on('scroll', function(){
            if($(window).scrollTop()){
                $('nav').addClass('black');
            }else{
                $('nav').removeClass('black');
            }
        })
    </script>


<script type="text/javascript">

    function minimizer(){
        var minimized = $("#minimized").val();

		if(minimized == 0){
			//mostrar
			$(".carritot").css("bottom","350px");
			$(".carritob").css("bottom","0px");
			$("#minimized").val('1');
		}else{
			//minimizar
			$(".carritot").css("bottom","0px");
			$(".carritob").css("bottom","-350px");
			$("#minimized").val('0');
		}

    }

</script>



