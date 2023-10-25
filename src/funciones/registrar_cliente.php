<?php
include '../datos/conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los campos requeridos están configurados
    if (isset($_POST['dni'], $_POST['nombres'], $_POST['apellidos'], $_POST['correo'], $_POST['direccion'], $_POST['rango'])) {
        date_default_timezone_set('America/Lima');
        $dni = $_POST['dni'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        $fecha_registro = date("Y-m-d H:i:s");
        $puntos = 0;
        $rango = $_POST['rango'];

        // Verificar si la conexión a la base de datos es exitosa
        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }

        // Preparar la consulta SQL para insertar un cliente
        $sql = "INSERT INTO cliente (dni, nombres, apellidos, correo, direccion, fecha_registro, puntos, rango) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar una sentencia
        $stmt = $conexion->prepare($sql);

        // Vincular los parámetros
        $stmt->bind_param("ssssssss", $dni, $nombres, $apellidos, $correo, $direccion, $fecha_registro, $puntos, $rango);


        // Ejecutar la consulta
        if ($stmt->execute()) {
            header('Location: ../Tienda/panel/');
        } else {
            echo "Error: " . $stmt->error;
        }

        // Cerrar la conexión
        $stmt->close();
        $conexion->close();
    } else {
        echo "Por favor, complete todos los campos requeridos.";
    }
}
?>
