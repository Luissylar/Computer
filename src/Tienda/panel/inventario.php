<?php
    include 'menu.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inventario General</title>
    <link rel="stylesheet" type="text/css" href="../CSS/inventario.css">
</head>
<body>
    
    <!-- Tabla de Compras (a completar con datos de la base de datos) -->
    <h2>Inventario General de Equipos de Computo</h2>
    <?php
        include '../../datos/conexion_be.php';

        // Realiza una consulta para seleccionar las compras desde la base de datos
        $query = "SELECT * FROM inventario";

        $result = $conexion->query($query);

        echo "<table border='1' id='clienteTable'>";

        if ($result) {
            // Comprobar si se obtuvieron resultados
            if ($result->num_rows > 0) {
                echo "<tr>"; // Iniciar una fila para los encabezados
                echo "<th>ID Inventario</th>";
                echo "<th>Producto</th>";
                echo "<th>Usuario</th>";
                echo "<th>Cantidad disponible</th>";
                echo "<th>Fecha de Actualizacion</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    // Obtener los nombres de id_producto e id_usuario
                    $id_producto = $row['id_producto'];
                    $id_usuario = $row['id_usuario'];

                    // Consulta para obtener el nombre del producto
                    $producto_query = "SELECT producto FROM productos WHERE id_producto = $id_producto";
                    $producto_result = $conexion->query($producto_query);
                    $producto_row = $producto_result->fetch_assoc();
                    $nombre_producto = $producto_row['producto'];

                    // Consulta para obtener el nombre del usuario
                    $usuario_query = "SELECT nombres FROM usuarios WHERE id_usuario = $id_usuario";
                    $usuario_result = $conexion->query($usuario_query);
                    $usuario_row = $usuario_result->fetch_assoc();
                    $nombre_usuario = $usuario_row['nombres'];

                    echo "<tr>";
                    echo "<td>" . $row['id_inventario'] . "</td>";
                    echo "<td>" . $nombre_producto . "</td>";
                    echo "<td>" . $nombre_usuario . "</td>";
                    echo "<td>" . $row['cantidad_disponible'] . "</td>";
                    echo "<td>" . $row['fecha_actualizacion'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No se encontraron compras.</td></tr>";
            }

            // Liberar los resultados
            $result->free();
        } else {
            echo "<tr><td colspan='5'>Error en la consulta: " . $conexion->error . "</td></tr>";
        }

        echo "</table>"; // Cerrar la tabla

        // Cerrar la conexión
        $conexion->close();
    ?>

</body>
</html>
