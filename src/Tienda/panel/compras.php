<?php
include 'menu.php';
include '../../datos/conexion_be.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Compras</title>
    <link rel="stylesheet" type="text/css" href="../CSS/compras.css">
    <script src="../JS/cliente.js"></script>
</head>
<body>

    <!-- Formulario para agregar Compra -->
    <h2>Compras</h2>
    <button id="mostrar">Registrar una compra</button>
    <form method="post" action="../../funciones/registrar_compras.php" id="clienteForm">
        <label for="precio">Precio por Unidad:</label>
        <input type="number" id="precio" name="precio" required><br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required><br>
        <label for="fecha_compra">Fecha:</label>
        <input type="text" id="fecha_compra" name="fecha_compra" value="<?php echo date('Y-m-d'); ?>" required><br>
        <label for="proveedores">Proveedores:</label>
        <select id="proveedores" name="proveedores" required>
            <?php
                include 'conexion_be.php';

                // Realiza una consulta para seleccionar los nombres de los proveedores
                $query = "SELECT nombre FROM proveedores";
                $result = $conexion->query($query);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                    }
                }

                $conexion->close();
            ?>
        </select><br>
        <label for="total">Total:</label>
        <input type="text" id="total" name="total" required><br>
        <label for="producto">Producto:</label>
        <select id="producto" name="producto" required>
            <?php
                include '../../datos/conexion_be.php';

                // Realiza una consulta para seleccionar los nombres de los productos
                $query = "SELECT producto FROM productos";
                $result = $conexion->query($query);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['producto'] . "'>" . $row['producto'] . "</option>";
                    }
                }

                $conexion->close();
            ?>

        </select><br>
        <input type="submit" value="Agregar Compra">
    </form>
    <script>
        // Obtén referencias a los campos de precio, cantidad y total
        const precioInput = document.getElementById('precio');
        const cantidadInput = document.getElementById('cantidad');
        const totalInput = document.getElementById('total');

        // Agrega un evento oninput para calcular el total automáticamente
        precioInput.addEventListener('input', calcularTotal);
        cantidadInput.addEventListener('input', calcularTotal);

        // Función para calcular el total
        function calcularTotal() {
            const precio = parseFloat(precioInput.value);
            const cantidad = parseFloat(cantidadInput.value);
            if (!isNaN(precio) && !isNaN(cantidad)) {
                const total = precio * cantidad;
                totalInput.value = total.toFixed(2); // Ajusta el número de decimales según sea necesario
            } else {
                totalInput.value = ''; // Restablece el campo si no se pueden realizar cálculos
            }
        }
    </script>

    <?php
        include '../../datos/conexion_be.php';

        // Realiza una consulta para seleccionar las compras desde la base de datos
        $query = "SELECT compras.id_compra, compras.precio_unitario, compras.cantidad, compras.id_proveedor, proveedores.nombre AS proveedor_nombre, compras.fecha_compra, compras.fecha_registro, compras.id_usuario, usuarios.nombres AS usuario_nombre, total, compras.id_producto, productos.producto AS producto_nombre FROM compras INNER JOIN proveedores ON compras.id_proveedor = proveedores.id_proveedor INNER JOIN usuarios ON compras.id_usuario = usuarios.id_usuario INNER JOIN productos ON compras.id_producto = productos.id_producto";

        $result = $conexion->query($query);

        echo "<table border='1' id='clienteTable'>";


        if ($result) {
            // Comprobar si se obtuvieron resultados
            if ($result->num_rows > 0) {
                echo "<tr>"; // Iniciar una fila para los encabezados
                echo "<th>ID Compra</th>";
                echo "<th>Precio Unitario</th>";
                echo "<th>Cantidad</th>";
                echo "<th>Nombre Proveedor</th>";
                echo "<th>Fecha de Compra</th>";
                echo "<th>Fecha de Registro</th>";
                echo "<th>Nombre Usuario</th>";
                echo "<th>Total Pagado</th>";
                echo "<th>Nombre Producto</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    // Itera sobre cada fila de resultados y muestra los datos en la tabla
                    echo "<tr>";
                    echo "<td>" . $row['id_compra'] . "</td>";
                    echo "<td>" . $row['precio_unitario'] . "</td>";
                    echo "<td>" . $row['cantidad'] . "</td>";
                    echo "<td>" . $row['proveedor_nombre'] . "</td>";
                    echo "<td>" . $row['fecha_compra'] . "</td>";
                    echo "<td>" . $row['fecha_registro'] . "</td>";
                    echo "<td>" . $row['usuario_nombre'] . "</td>";
                    echo "<td>" . $row['total'] . "</td>";
                    echo "<td>" . $row['producto_nombre'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No se encontraron compras.</td></tr>";
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




