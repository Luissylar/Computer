<!DOCTYPE html>
<html>
<head>
    <title>Proveedor</title>
    <link rel="stylesheet" type="text/css" href="../CSS/proveedor.css">
    <script src="../JS/cliente.js"></script>
</head>
<body>
    <?php
    include 'menu.php';
    ?>

    <!-- Formulario para agregar Proveedor -->
    <h2>Proveedor</h2>
    <button id="mostrar">Registrar Proveedores</button>
    <form method="post" action="../../funciones/registrar_proveedor.php" id="clienteForm">
        <h3>Registra los datos del prooveedor</h3>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="ruc">RUC:</label>
        <input type="text" id="ruc" name="ruc" required><br>
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required><br>
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required><br>
        <label for="encargado">Encargado:</label>
        <input type="text" id="encargado" name="encargado" required><br>
        <input type="submit" value="Agregar Proveedor">
    </form>

    <!-- Tabla de Clientes (a completar con datos de la base de datos) -->
    <?php
        include '../../datos/conexion_be.php';

        // Realiza una consulta para seleccionar los clientes desde la base de datos
        $query = "SELECT p.id_proveedor, p.nombre, p.ruc, p.direccion, p.telefono, p.encargado, e.estado AS estado_nombre FROM proveedores p
                LEFT JOIN estado e ON p.id_estado = e.id_estado"; // Asume que el campo en la tabla estados se llama "nombre"
        $result = $conexion->query($query);

        echo "<table border='1' id='clienteTable'>";

        if ($result) {
            // Comprobar si se obtuvieron resultados
            if ($result->num_rows > 0) {
                echo "<tr>"; // Iniciar una fila para los encabezados
                echo "<th>ID Proveedor</th>";
                echo "<th>Nombre</th>";
                echo "<th>Ruc</th>";
                echo "<th>Direccion</th>";
                echo "<th>Telefono</th>";
                echo "<th>Encargado</th>";
                echo "<th>Estado</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    // Itera sobre cada fila de resultados y muestra los datos en la tabla
                    echo "<tr>";
                    echo "<td>" . $row['id_proveedor'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['ruc'] . "</td>";
                    echo "<td>" . $row['direccion'] . "</td>";
                    echo "<td>" . $row['telefono'] . "</td>";
                    echo "<td>" . $row['encargado'] . "</td>";
                    echo "<td>" . $row['estado_nombre'] . "</td>"; // Muestra el nombre del estado
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No se encontraron Proveedores.</td></tr>";
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




