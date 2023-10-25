<!DOCTYPE html>
<html>
<head>
    <title>Producto</title>
    <link rel="stylesheet" type="text/css" href="../CSS/producto.css">
    <script src="../JS/cliente.js"></script>
</head>
<body>
    <?php
    include 'menu.php';
    ?>
    
    <h2>Agregar Productos</h2>
    <button id="mostrar">Ver Productos</button>
    <form method="post" action="../../funciones/registrar_producto.php" id="clienteForm">
        <label for="nombre">Nombre:</label>
        <input type="text" id="producto" name="producto" required><br>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"></textarea><br>
        <input type="submit" value="Agregar Producto">
    </form>
        <?php
            include '../../datos/conexion_be.php';

            // Realiza una consulta para seleccionar los clientes desde la base de datos
            $query = "SELECT * FROM productos";
            $result = $conexion->query($query);

            echo "<table border='1' id='clienteTable'>";

            if ($result) {
                // Comprobar si se obtuvieron resultados
                if ($result->num_rows > 0) {
                    echo "<tr>"; // Iniciar una fila para los encabezados
                    echo "<th>ID Producto</th>";
                    echo "<th>Nombre</th>";
                    echo "<th>Fecha de Registro</th>";
                    echo "<th>Descripcion</th>";
                    echo "<th>Nombre de usuario</th>";
                    echo "</tr>";

                    while ($row = $result->fetch_assoc()) {
                        // Itera sobre cada fila de resultados y muestra los datos en la tabla
                        echo "<tr>";
                        echo "<td>" . $row['id_producto'] . "</td>";
                        echo "<td>" . $row['producto'] . "</td>";
                        echo "<td>" . $row['fecha_registro'] . "</td>";
                        echo "<td>" . $row['descripcion'] . "</td>";
                        echo "<td>" . $row['id_usuario'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No se encontraron clientes.</td></tr>";
                }

                // Liberar los resultados
                $result->free();
            } else {
                echo "<tr><td colspan='9'>Error en la consulta: " . $conexion->error . "</td></tr>";
            }

            echo "</table>"; // Cerrar la tabla

            // Cerrar la conexión
            $conexion->close();
        ?>
    </body>
</html>



