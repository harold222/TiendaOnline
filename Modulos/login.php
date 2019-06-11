<?php
    if(isset($_SESSION['id_cliente'])){
        redir("./");
    }

    if(isset($enviar)){
        $username = clear($username);
        $password = clear($password);

        $q = $mysqli->query("SELECT * FROM clientes WHERE username = '$username' AND password = '$password'");
        if(mysqli_num_rows($q)>0){
            $r = mysqli_fetch_array($q);
            $_SESSION['id_cliente'] = $r['id'];

            if(isset($return)){
                redir("?p=".$return);
            }else{
            redir("./");
            }

        }else{
            alert("Los datos ingresados estan incorrectos",0,'login');
            //redir("?p=login");
        }
    }
        ?> 
        <center>
            <form method="post" action="">
                <div class="centrar_login">
                    <label><h2><i class="fa fa-key"></i>Iniciar Sesion</h2></label>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Usuario" name="username"/>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Contraseña" name="password"/>                
                    </div>
                    
                    <div class="form-group">
                        <button class="btn btn-submit" type="submit" name="enviar"><i class="fas fa-sign-in-alt"></i> Ingresar</button>              
                    </div>
                </div>
            </form>
        </center>
   

