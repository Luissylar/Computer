<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login y Register</title>
    <!-- Agregar la letra de googler fonts  fonts.google.com-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,
    wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900
    &display=swap" rel="stylesheet">


    <link rel="stylesheet" href="./CSS/estilos.css">
</head>
<body>

        <main>

            <div class="contenedor_todo">
                <div class="caja_trasera">
                    <div class="caja_trasera-login">
                        <h3>¿Ya tienes una cuenta?</h3>
                        <p>Inicia sesión para entrar en la página</p>
                        <button id="btn_iniciar-sesion">Iniciar Sesión</button>
                    </div>
                    <div class="caja_trasera-register">
                        <h3>¿Aún no tienes una cuenta?</h3>
                        <p>Regístrate para que puedas iniciar sesión</p>
                        <button id="btn_registrarse">Regístrarse</button>
                    </div>
                </div>

                <!--Formulario de Login y registro-->
                <div class="contenedor_login-register">
                    <!--Login-->
                    <form action="../funciones/login.php" class="formulario_login" method="POST">
                        <h2>Iniciar Sesión</h2>
                        <input type="text" placeholder="Correo Electronico" id="correo" name="correo">
                        <input type="password" placeholder="Contraseña" id="contrasena" name="contrasena"> 
                        <button>Entrar</button>
                    </form>

                    <!--Register-->
                    <form action="../funciones/registro_usuario_be.php" method="POST" class="formulario_register">
                        <h2>Regístrarse</h2>
                        <input type="text" placeholder="Nombres" name="nombres">
                        <input type="text" placeholder="Apellidos" name="apellidos">
                        <input type="text" placeholder="Dni" name= "dni">
                        <input type="text" placeholder="Telefono" name= "telefono">
                        <input type="email" placeholder="Correo" name="correo">
                        <input type="password" placeholder="Contraseña" name="contrasena">
                        <input type="text" placeholder="Direccion" name="direccion">
                        <button>Regístrarse</button>
                    </form>
                </div>
            </div>

        </main>

        <script src="./JS/script.js"></script>
</body>
</html>