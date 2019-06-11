<?php

check_user('pagar_compra');

if(isset($subir)){
	$nombre = clear($nombre);
	$comprobante = "";

	if(is_uploaded_file($_FILES['comprobante']['tmp_name'])){
		$comprobante = date("His").rand(0,9000).".png";
		move_uploaded_file($_FILES['comprobante']['tmp_name'], "comprobantes/".$comprobante);
	}

	$mysqli->query("INSERT INTO pagos (id_cliente,id_compra,comprobante,nombre,fecha) VALUES ('".$_SESSION['id_cliente']."','$id','$comprobante','$nombre',NOW())");
	alert("Comprobante enviado",1,'miscompras');
	//redir("?p=miscompras");
}
?>

<h1>Metodos de pago</h1>

<table class="table table-striped">
<tr>
	<th>Tipo de pago</th>
	<th>Cuenta</th>
	<th>Beneficiario</th>
	<th>Acciones</th>
</tr>

<tr>
	<td>Transferencia Bancaria</td>
	<td>0000-000-000</td>
	<td>Rocio Murcia</td>
	<th><a target="_blank" href="https://google.com"> Ir al pago </a></th> 
	<!-- iria en la linea de arriba una imagen del banco para su transferencia y el link de redireccion hacia la pagina
	o plataforma que se realizara el pago -->
</tr>
</table>

<br><h1>Envia el comprobante de pago de la compra</h1><br>

<form method="post" action="" enctype="multipart/form-data">
	<div class="form-group">
		<label>Adjuntar comprobante</label>
		<input type="file" class="form-control" name="comprobante" value="" required/>
	</div>

	<div class="form-group">
		<label>Nombre de la persona que transfiere</label>
		<input type="text" class="form-control" name="nombre" value=""/>
	</div>

	<div class="form-group">
		<input type="submit" name="subir" class="btn btn-primary" value="Enviar"/>
	</div>

</form>