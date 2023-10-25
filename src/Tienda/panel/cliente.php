<?php
include 'menu.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cliente</title>
    <link rel="stylesheet" type="text/css" href="../CSS/cliente.css">
    <script src="../JS/cliente.js"></script>
</head>
<body>
    <!-- Formulario para agregar Cliente -->
    <h2>Registrar Clientes</h2>
    <button id="mostrar">Ver Clientes</button>



    <form method="post" action="../../funciones/registrar_cliente.php" id="clienteForm">
        <h3>Ingrese sus datos</h3>
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required><br>
        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" required><br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required><br>
        <label for="correo">Correo:</label>
        <input type="text" id="correo" name="correo" required><br>
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required><br>
        <label for="rango">Rango:</label>
        <input type="text" id="rango" name="rango" required><br>
        <input type="submit" value="Agregar Cliente">
    </form>

    <!-- Tabla de Clientes (a completar con datos de la base de datos) -->
    <?php
        include '../../datos/conexion_be.php';

        // Realiza una consulta para seleccionar los clientes desde la base de datos
        $query = "SELECT * FROM cliente";
        $result = $conexion->query($query);

        echo "<table border='1' id='clienteTable'>";


        if ($result) {
            // Comprobar si se obtuvieron resultados
            if ($result->num_rows > 0) {
                echo "<tr>"; // Iniciar una fila para los encabezados
                echo "<th>ID Cliente</th>";
                echo "<th>DNI</th>";
                echo "<th>Nombres</th>";
                echo "<th>Apellidos</th>";
                echo "<th>Correo</th>";
                echo "<th>Dirección</th>";
                echo "<th>Fecha de Registro</th>";
                echo "<th>Puntos</th>";
                echo "<th>Rango</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    // Itera sobre cada fila de resultados y muestra los datos en la tabla
                    echo "<tr>";
                    echo "<td>" . $row['id_cliente'] . "</td>";
                    echo "<td>" . $row['dni'] . "</td>";
                    echo "<td>" . $row['nombres'] . "</td>";
                    echo "<td>" . $row['apellidos'] . "</td>";
                    echo "<td>" . $row['correo'] . "</td>";
                    echo "<td>" . $row['direccion'] . "</td>";
                    echo "<td>" . $row['fecha_registro'] . "</td>";
                    echo "<td>" . $row['puntos'] . "</td>";
                    echo "<td>" . $row['rango'] . "</td>";
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


