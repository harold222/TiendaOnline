<?php 
$conexion = mysqli_connect('localhost','root','','tienda');
$continente= $_POST['continente'];

	$sql="SELECT idstock,cantidadStock FROM EnStock WHERE idstock ='$continente'";

	$result=mysqli_query($conexion,$sql);

	$cadena="
            <select id='lista2' name='lista2' class='form-control'>
            <option>Seleccione la cantidad.</option>";

	while ($ver=mysqli_fetch_row($result)) {
        $es = $ver[1]; //valor total
		while($es > 0){ //hasta que llegue a 0 la cantidad
            $cadena=$cadena.'<option value='.$ver[0].'>'.utf8_encode($es).'</option>';
            $es = $es -1;
		}
	}
	echo  $cadena."</select>";
?>