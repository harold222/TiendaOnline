<?php
check_admin();

if(isset($aceptar)){
	$mysqli->query("UPDATE pagos SET estado = 1 WHERE id = '$aceptar'");
	$id_compra = clear($id_compra);
	$mysqli->query("UPDATE compra SET estado = 1 WHERE id = '$id_compra'");
	redir("?p=ver_compra&id=".$id_compra);
}

//Estados:
//0 Sin verificar
//1 Verificado
//2 Reembolso

?>
<h1>Pagos Pendientes</h1>

<table class="table table-striped">
	<tr>
		<th>Cliente</th>
		<th>Fecha</th>
		<th>Comprobante</th>
		<th>Nombre de comprobante</th>
		<th>Estado</th>
		<th>Acciones</th>
	</tr>

	<?php
	$s = $mysqli->query("SELECT * FROM pagos WHERE estado = 0 ORDER BY fecha DESC");
	while($r=mysqli_fetch_array($s)){
		?>
		<tr>
			<td><?=nombre_cliente($r['id_cliente'])?></td>
			<td><?=fecha($r['fecha'])?></td>
			<td><a style="color:#333" target="_blank" href="../comprobantes/<?=$r['comprobante']?>">Ver Comprobante <i class="fa fa-eye"></i></a></td>
			<td><?=$r['nombre']?></td>
			<td><?=estado_pago($r['estado'])?></td>
			<td>
				<?php
				if($r['estado']==0){
					?>
						<a style="color:#333" href="?p=pagos&aceptar=<?=$r['id']?>&id_compra=<?=$r['id_compra']?>" title="Verificar y aceptar pago"><i class="fa fa-check"></i></a>
						<a style="color:#333" href="?p=pagos&aceptar=<?=$r['id']?>&id_compra=<?=$r['id_compra']?>" title="Reembolsar pago"><i class="fas fa-exclamation-triangle"></i></a>
						<a style="color:#333" href="?p=pagos&aceptar=<?=$r['id']?>&id_compra=<?=$r['id_compra']?>" title="Eliminar pago"><i class="fa fa-window-close"></i></a>
					<?php
				}
				?>
				<a style="color:#333" href="?p=ver_compra&id=<?=$r['id_compra']?>"><i class="fa fa-eye" title="Ver Compra"></i></a>
			</td>
		</tr>
		<?php
	}
	?>
</table>

<h1>Pagos de los clientes</h1>

<table class="table table-striped">
	<tr>
		<th>Cliente</th>
		<th>Fecha</th>
		<th>Comprobante</th>
		<th>Nombre de comprobante</th>
		<th>Estado</th>
		<th>Acciones</th>
	</tr>

	<?php
	$s = $mysqli->query("SELECT * FROM pagos ORDER BY fecha DESC");
	while($r=mysqli_fetch_array($s)){
		?>
		<tr>
			<td><?=nombre_cliente($r['id_cliente'])?></td>
			<td><?=fecha($r['fecha'])?></td>
			<td><a style="color:#333" target="_blank" href="../comprobantes/<?=$r['comprobante']?>">Ver Comprobante <i class="fa fa-eye"></i></a></td>
			<td><?=$r['nombre']?></td>
			<td><?=estado_pago($r['estado'])?></td>
			<td>
				<?php
				if($r['estado']==0){
					?>
						<a style="color:#333" href="?p=pagos&aceptar=<?=$r['id']?>" title="Verificar y aceptar pago"><i class="fa fa-check"></i></a>
						<a style="color:#333" href="?p=pagos&aceptar=<?=$r['id']?>&id_compra=<?=$r['id_compra']?>" title="Reembolsar pago"><i class="fas fa-exclamation-triangle"></i></a>
						<a style="color:#333" href="?p=pagos&aceptar=<?=$r['id']?>&id_compra=<?=$r['id_compra']?>" title="Eliminar pago"><i class="fa fa-window-close"></i></a>
					<?php
				}
				?>
				<a style="color:#333" href="?p=ver_compra&id=<?=$r['id_compra']?>"><i class="fa fa-eye" title="Ver Compra"></i></a>
			</td>
		</tr>
		<?php
	}
	?>
</table>