<?php
    check_admin();

    // 0 recien comprada    POR EL CAMPO ESTADO DE LA TABLA compras
    // 1 preparando compra
    // 2 en camino
    // 3 despachado

    $s = $mysqli->query("SELECT * FROM compra WHERE estado != 3"); //que no se haya despachado

    if(isset($eliminar)){
	    $eliminar = clear($eliminar);
	    $mysqli->query("DELETE FROM productos_compra WHERE id_compra = '$eliminar'");
	    $mysqli->query("DELETE FROM compra WHERE id = '$eliminar'");
	    redir("?p=manejar_tracking");
    }
?>

<h1>Seguimiento de los productos</h1><br>

<table class="table table-stripe">
	<tr>
		<th>Cliente</th>
		<th>Fecha / Hora</th>
		<th>Monto</th>
		<th>Status</th>
		<th>Acciones</th>
	</tr>
<?php

while($r=mysqli_fetch_array($s)){
    $sc = $mysqli->query("SELECT * FROM clientes WHERE id = '".$r['id_cliente']."'");
    $rc = mysqli_fetch_array($sc);
    $cliente = $rc['name'];

    if($r['estado'] == 0){
        $status = "Iniciando";
    }else if($r['estado']==1){
        $status = "Preparando";
    }else if($r['estado'] == 2){
        $status = "Despachando";
    }else if($r['estado'] == 3){
        $status = "Finalizado";
    }else{
        $status = "Indefinido";
    }

    $fecha = fecha($r['fecha']); //va para la funcion

    ?>

    <tr>
        <td><?=$cliente?></td>
        <td><?=$fecha?></td>
        <td><?=$r['monto']?> <?=$divisa?></td>
        <td><?=$status?></td>
        <td>
            <a style="color:#08f;" href="?p=manejar_tracking&eliminar=<?=$r['id']?>">
                <i class="fa fa-times"></i>Eliminar Compra
            </a>
            &nbsp; &nbsp;
            <a style="color:#08f;" href="?p=manejar_status&id=<?=$r['id']?>">
                <i class="fa fa-edit"></i>Editar Compra
            </a>
            &nbsp; &nbsp;
            <a style="color:#08f;" href="?p=ver_compra&id=<?=$r['id']?>">
                <i class="fa fa-eye"></i>Mas informacion
            </a>
        </td>
    </tr>
    <?php
}
?>
</table>