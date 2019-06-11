<?php
if(isset($_SESSION['id_cliente'])){
	redir("./");
}
	
if(isset($enviar)){
	$username = clear($username);
	$password = clear($password);
	$cpassword = clear($cpassword);
    $nombre = clear($nombre);
    
	$q = $mysqli->query("SELECT * FROM clientes WHERE username = '$username'");
	if(mysqli_num_rows($q)>0){ //si el username ya esta registrado
		alert("El usuario ya está en uso",0,'principal');
		die();
    }
    
	if($password != $cpassword){ //si el confirmar contraseña no es igual
		alert("Las contraseñas no coinciden",0,'principal');
		die();
    }
    
	$mysqli->query("INSERT INTO clientes (username,password,name) VALUES ('$username','$password','$nombre')");
    
    $q2 = $mysqli->query("SELECT * FROM clientes WHERE username = '$username'");
	$r = mysqli_fetch_array($q2);
	$_SESSION['id_cliente'] = $r['id'];
	alert("Te has registrado satisfactoriamente",1,'principal');
	die();
	//redir("./");
}
	?>


	<center>
		<form method="post" action="">
			<div class="centrar_login">
				<label><h2><i class="fa fa-key"></i> Registrate</h2></label>
				<div class="form-group">
					<input type="text" autocomplete="off" class="form-control" placeholder="Usuario" name="username" required/>
				</div>

				<div class="form-group">
					<input type="password" class="form-control" placeholder="Contraseña" name="password" required/>
				</div>

				<div class="form-group">
					<input type="password" class="form-control" placeholder="Confirmar Contraseña" name="cpassword" required/>
				</div>


				<div class="form-group">
					<input type="text" autocomplete="off" class="form-control" placeholder="Nombre" name="nombre" required/>
				</div>

				<div class="form-group">
					<button class="btn btn-submit" name="enviar" type="submit"><i class="fas fa-sign-in-alt"></i> Registrate</button>
				</div>
			</div>
		</form>
	</center>