<?php



?>

<!DOCTYPE html>
<HTML lang="en">
    <HEAD>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-AU-Compatible" content="ie=edge">
        <script src="../js/script.js"></script>
        <title>Contactanos</title>
    </HEAD>

    <BODY>
        <section class="form_wrap">
            <section class="contact_info">
                <section class="info_title">
                    <span class="fa fa-user-circle fa-3x" style="color:#4091EC;"></span>
                    <br><h2>INFORMACION<br>DE CONTACTO</h2>
                </section>
                <section class="info_items">
                    <span class="fa fa-envelope fa-3x" style="color:#4091EC;" ></span>
                    <p>sucorreo@hotmail.com</p>
                    <br><span class="fa fa-mobile fa-3x" style="color:#4091EC;"></span>
                    <p>CEL: +57 3133458748</p>
                </section>
            </section>

            <form action="" class="form_contact">
                <h2>Envia un mensaje</h2>
                <div class="user_info">
                    <label for="names">Nombre Apellido *</label>
                    <input type="text" id="names">
                    
                    <label for="phone">Telefono / Celular</label>
                    <input type="text" id="phone">

                    <label for="email">Correo Electronico *</label>
                    <input type="text" id="email">

                    <label for="mensaje">Mensaje *</label>
                    <textarea id="mensaje"></textarea>

                    <input type="button" value="Enviar mensaje" id="btnSend">
                </div>
            </form>
        </section>
    </BODY>
</HTML>