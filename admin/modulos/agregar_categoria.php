<?php
check_admin();
if(isset($enviar)){
	$categoria = clear($categoria);
	$s = $mysqli->query("SELECT * FROM categorias WHERE categoria = '$categoria'");
	if(mysqli_num_rows($s)>0){
		alert("Ya esta categoria esta agregada a la base de datos",0,'agregar_categoria');
	}else{
		$mysqli->query("INSERT INTO categorias (categoria) VALUES ('$categoria')");
		alert("Categoria Agregada",1,'agregar_categoria');
	}
}
if(isset($eliminar)){
	$eliminar = clear($eliminar);
	$mysqli->query("DELETE FROM categorias WHERE id = '$eliminar'");
	redir("?p=agregar_categoria");
}
?>

<h1>Agregar Categoria</h1>

<form method="post" action="">
	<div class="form-group">
		<input type="text" class="form-control" name="categoria" placeholder="Categoria"/>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="enviar" value="Agregar categoria"/>
	</div>
</form><br>

<br>

<table class="table table-striped">
	<tr>
		<th>Categoria</th>
		<th>Acciones</th>
	</tr>

	<?php
	$q = $mysqli->query("SELECT * FROM categorias ORDER BY id");
	while($r=mysqli_fetch_array($q)){
		?>
			<tr>
				<td><?=$r['categoria']?>
				<td>
					<a style="color:#08f;" href="?p=agregar_categoria&eliminar=<?=$r['id']?>"><i class="fa fa-times"></i>Eliminar Categoria</a>
				</td>
			</tr>
		<?php
	}
	?>
</table>



