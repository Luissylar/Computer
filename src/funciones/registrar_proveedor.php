<?php

include '../datos/conexion_be.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los campos requeridos están configurados
    if (isset( $_POST['nombre'],$_POST['ruc'], $_POST['direccion'], $_POST['telefono'], $_POST['encargado'])) {
        $ruc = $_POST['ruc'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $encargado = $_POST['encargado'];
        $id_estado = 1;


        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }

        // Preparar la consulta SQL para insertar un proveedor
        $sql = "INSERT INTO proveedores (nombre,ruc, direccion, telefono, encargado, id_estado) VALUES (?, ?, ?, ?, ?, ?)";

        // Preparar una sentencia
        $stmt = $conexion->prepare($sql);

        // Vincular los parámetros
        $stmt->bind_param("sssssi",$nombre ,$ruc, $direccion, $telefono, $encargado, $id_estado);

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