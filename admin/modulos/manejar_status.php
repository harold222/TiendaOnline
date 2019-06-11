<?php
    check_admin();
    $id = clear($id);
    $s = $mysqli->query("SELECT * FROM compra WHERE id = '$id'");
    $r = mysqli_fetch_array($s);

    if(isset($modificar)){
	    $estado = clear($estado);
	    $mysqli->query("UPDATE compra SET estado = '$estado' WHERE id = '$id'");
	    redir("?p=manejar_tracking");
    }
?>

<h1>Manejar El Estado De La Compra</h1>

<br>
<form method="post" action="">
	<div class="form-group">
		<select class="form-control" name="estado">
			<option <?php if($r['estado'] == 0) { echo "selected"; } ?> value="0">Iniciando</option>
			<option <?php if($r['estado'] == 1) { echo "selected"; } ?> value="1">Preparando</option>
			<option <?php if($r['estado'] == 2) { echo "selected"; } ?> value="2">Despachando</option>
			<option <?php if($r['estado'] == 3) { echo "selected"; } ?> vlaue="3">Finalizado</option>
		</select>
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Cambiar status de la compra" name="modificar"/>
	</div>
</form>
