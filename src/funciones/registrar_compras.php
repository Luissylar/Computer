<?php
session_start(); // Asegúrate de iniciar la sesión al principio del script

include '../datos/conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los campos requeridos están configurados
    if (isset($_POST['precio'], $_POST['cantidad'], $_POST['fecha_compra'], $_POST['proveedores'], $_POST['total'], $_POST['producto'])) {
        date_default_timezone_set('America/Lima');
        $precio_unitario = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $fecha_registro = date("Y-m-d H:i:s");
        $nombre_proveedor = $_POST['proveedores'];
        $nombre_producto = $_POST['producto'];

        // Consulta SQL para buscar el ID del proveedor por nombre
        $sql_proveedor = "SELECT id_proveedor FROM proveedores WHERE nombre = ?";
        $stmt_proveedor = $conexion->prepare($sql_proveedor);
        $stmt_proveedor->bind_param("s", $nombre_proveedor);
        $stmt_proveedor->execute();
        $result_proveedor = $stmt_proveedor->get_result();

        if ($result_proveedor->num_rows > 0) {
            $row_proveedor = $result_proveedor->fetch_assoc();
            $id_proveedor = $row_proveedor['id_proveedor'];
        } else {
            echo "Proveedor no encontrado en la base de datos.";
            exit(); // Termina la ejecución
        }

        // Consulta SQL para buscar el ID del producto por nombre
        $sql_producto = "SELECT id_producto FROM productos WHERE producto = ?";
        $stmt_producto = $conexion->prepare($sql_producto);
        $stmt_producto->bind_param("s", $nombre_producto);
        $stmt_producto->execute();
        $result_producto = $stmt_producto->get_result();

        if ($result_producto->num_rows > 0) {
            $row_producto = $result_producto->fetch_assoc();
            $id_producto = $row_producto['id_producto'];
        } else {
            // Producto no encontrado en la base de datos. Crear un nuevo registro.
            $sql_insert_producto = "INSERT INTO productos (producto) VALUES (?)";
            $stmt_insert_producto = $conexion->prepare($sql_insert_producto);
            $stmt_insert_producto->bind_param("s", $nombre_producto);
            $stmt_insert_producto->execute();

            // Obtener el ID del nuevo producto
            $id_producto = $stmt_insert_producto->insert_id;

            $stmt_insert_producto->close();
        }

        // Accede al ID del usuario almacenado en la sesión
        if (isset($_SESSION['id_usuario'])) {
            $id_usuario = $_SESSION['id_usuario'];
        } else {
            echo "El usuario no ha iniciado sesión.";
            exit(); // Termina la ejecución
        }

        $fecha_compra = $_POST['fecha_compra'];
        $total = $_POST['total'];

        // Consulta SQL para insertar una compra
        $sql_compra = "INSERT INTO compras (precio_unitario, cantidad, id_proveedor, fecha_compra, fecha_registro, id_usuario, total, id_producto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_compra = $conexion->prepare($sql_compra);
        $stmt_compra->bind_param("ssssssss", $precio_unitario, $cantidad, $id_proveedor, $fecha_compra, $fecha_registro, $id_usuario, $total, $id_producto);

        // Ejecutar la consulta de compra
        if ($stmt_compra->execute()) {
            // Verificar si el producto existe en el inventario
            $sql_inventario = "SELECT id_inventario FROM inventario WHERE id_producto = ?";
            $stmt_inventario = $conexion->prepare($sql_inventario);
            $stmt_inventario->bind_param("i", $id_producto);
            $stmt_inventario->execute();
            $result_inventario = $stmt_inventario->get_result();

            if ($result_inventario->num_rows > 0) {
                // El producto ya existe en el inventario, actualiza la cantidad
                $sql_update_inventario = "UPDATE inventario SET cantidad_disponible = cantidad_disponible + ? WHERE id_producto = ?";
                $stmt_update_inventario = $conexion->prepare($sql_update_inventario);
                $stmt_update_inventario->bind_param("ii", $cantidad, $id_producto);
                $stmt_update_inventario->execute();
                $stmt_update_inventario->close();
            } else {
                // El producto no existe en el inventario, crea un nuevo registro
                $sql_insert_inventario = "INSERT INTO inventario (id_producto, id_usuario, cantidad_disponible, fecha_actualizacion) VALUES (?, ?, ?, ?)";
                $stmt_insert_inventario = $conexion->prepare($sql_insert_inventario);
                $stmt_insert_inventario->bind_param("iiss", $id_producto, $id_usuario, $cantidad, $fecha_registro);
                $stmt_insert_inventario->execute();
                $stmt_insert_inventario->close();
            }

            header('Location: ../Tienda/panel/');
        } else {
            echo "Error: " . $stmt_compra->error;
        }

        // Cerrar las conexiones y sentencias
        $stmt_proveedor->close();
        $stmt_producto->close();
        $stmt_compra->close();
        $stmt_inventario->close();
        $conexion->close();
    } else {
        echo "Por favor, complete todos los campos requeridos.";
    }
}
?>
