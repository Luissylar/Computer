<?php
    session_start(); // Asegúrate de iniciar la sesión al principio del script

    include '../datos/conexion_be.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        date_default_timezone_set('America/Lima');
        $producto = $_POST['producto'];
        $descripcion = $_POST['descripcion'];
        
        // Accede al ID del usuario almacenado en la sesión
        if (isset($_SESSION['id_usuario'])) {
            $id_usuario = $_SESSION['id_usuario'];
        } else {
            // Maneja el caso en el que el usuario no ha iniciado sesión
            echo "El usuario no ha iniciado sesión.";
            exit(); // Termina la ejecución del script
        }

        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }

        // Preparar la consulta SQL para insertar un producto
        $sql = "INSERT INTO productos (producto, fecha_registro, descripcion, id_usuario) VALUES (?, NOW(), ?, ?)";

        // Preparar una sentencia
        $stmt = $conexion->prepare($sql);

        // Vincular los parámetros
        $stmt->bind_param("ssi", $producto, $descripcion, $id_usuario);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            header('Location: ../Tienda/panel/');
        } else {
            echo "Error: " . $stmt->error;
        }

        // Cerrar la conexión
        $stmt->close();
        $conexion->close();
    }
?>
