<?php
include '../datos/conexion_be.php';

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$consulta_login = "SELECT id_usuario, correo, contrasena FROM usuarios WHERE correo = '$correo'";
$resultado = mysqli_query($conexion, $consulta_login);

if ($resultado === false) { 
    // Si la consulta tiene errores, mostrar el mensaje de error.
    echo "Error en la consulta: " . mysqli_error($conexion);
} else {
    // Si la consulta se ejecutó correctamente, verificar el número de filas.
    if (mysqli_num_rows($resultado) > 0) {
        // El correo existe en la base de datos, ahora verifica la contraseña.
        $fila = mysqli_fetch_assoc($resultado);
        $contrasena_almacenada = $fila['contrasena'];

        if ($contrasena === $contrasena_almacenada) {
            // Iniciar la sesión si aún no está iniciada
            session_start();
            
            // Almacenar el ID del usuario en la sesión
            $_SESSION['id_usuario'] = $fila['id_usuario'];
            
            header('Location: ../Tienda/panel');
            exit();
        } else {
           
            header('Location: ../Tienda/');
        }
    } else {
        // El correo no está registrado en la base de datos.
        echo "El correo no está registrado en la base de datos. Regístrate primero.";
    }
}
?>
