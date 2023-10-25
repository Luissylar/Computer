<?php

include '../datos/conexion_be.php';



date_default_timezone_set('America/Lima');

$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$dni = $_POST['dni'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$fecha_registro = date("Y-m-d H:i:s");
$id_rol = 2;
$direccion = $_POST['direccion'];
$id_estado = 1;

// Verificar si el correo ya está registrado en la base de datos
$correo_existente_query = "SELECT correo FROM usuarios WHERE correo = '$correo'";
$resultado = mysqli_query($conexion, $correo_existente_query);

if ($resultado === false) {
    // Si la consulta tiene errores, mostrar el mensaje de error.
    echo "Error en la consulta: " . mysqli_error($conexion);
} else {
    // Si la consulta se ejecutó correctamente, verificar el número de filas.
    if (mysqli_num_rows($resultado) > 0) {
        // El correo ya está registrado, puedes mostrar un mensaje de error o redirigir a una página de error.
        echo "El correo ya está registrado en la base de datos";
    } else {
        // El correo no está registrado, procede con la inserción.
        $query = "INSERT INTO usuarios (nombres, apellidos, dni, telefono, correo, contrasena, fecha_registro, id_rol, direccion, id_estado)
            VALUES ('$nombres', '$apellidos', '$dni', '$telefono', '$correo', '$contrasena', '$fecha_registro', '$id_rol', '$direccion', '$id_estado')";

        $ejecutar = mysqli_query($conexion, $query);

        if ($ejecutar) {
            header('Location: ../Tienda/panel/');
        } else {
            echo "Error al registrar usuario: " . mysqli_error($conexion);
        }
    }
}

?>