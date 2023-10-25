<?php
include 'menu.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Usuario</title>
    <link rel="stylesheet" type="text/css" href="../CSS/usuario.css">
    <script src="../JS/cliente.js"></script>
</head>
<body>

    <!-- Formulario para agregar Usuario -->
    <h2>Usuario</h2>
    <button id="mostrar">Registrar Usuarios</button>
    <form method="post" action="../../funciones/registro_interno.php" id="clienteForm">
        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" required><br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos"><br>
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required><br>
        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" required><br>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required><br>
        <label for="contrasena">Contraseña:</label> 
        <input type="password" id="contrasena" name="contrasena" required><br>
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required><br>
        <input type="submit" value="Agregar Usuario">
    </form>

    
    <?php
        include '../../datos/conexion_be.php';

        // Realiza una consulta para seleccionar los usuarios desde la base de datos
        $query = "SELECT u.*, r.rol AS nombre_rol, e.estado AS nombre_estado FROM usuarios u
                  JOIN roles r ON u.id_rol = r.id_rol
                  JOIN estado e ON u.id_estado = e.id_estado";

        $result = $conexion->query($query);

        echo "<table border='1' id='clienteTable'>";
        if ($result) {
            // Comprobar si se obtuvieron resultados
            if ($result->num_rows > 0) {
                echo "<tr>"; // Iniciar una fila para los encabezados
                echo "<th>ID Usuario</th>";
                echo "<th>Nombres</th>";
                echo "<th>Apellidos</th>"; // Corregido de "Apelllidos"
                echo "<th>DNI</th>";
                echo "<th>Telefono</th>";
                echo "<th>Correo</th>";
                echo "<th>Contraseña</th>";
                echo "<th>Fecha de Registro</th>";
                echo "<th>Rol</th>";
                echo "<th>Direccion</th>";
                echo "<th>Estado</th>"; // Agregado encabezado para el estado
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_usuario'] . "</td>";
                    echo "<td>" . $row['nombres'] . "</td>";
                    echo "<td>" . $row['apellidos'] . "</td>";
                    echo "<td>" . $row['dni'] . "</td>";
                    echo "<td>" . $row['telefono'] . "</td>";
                    echo "<td>" . $row['correo'] . "</td>";
                    echo "<td>" . $row['contrasena'] . "</td>";
                    echo "<td>" . $row['fecha_registro'] . "</td>";
                    echo "<td>" . $row['nombre_rol'] . "</td>"; // Mostrar el nombre del rol
                    echo "<td>" . $row['direccion'] . "</td>";
                    echo "<td>" . $row['nombre_estado'] . "</td>"; // Mostrar el nombre del estado
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No se encontraron usuarios.</td></tr>";
            }

            // Liberar los resultados
            $result->free();
        } else {
            echo "<tr><td colspan='10'>Error en la consulta: " . $conexion->error . "</td></tr>";
        }

        echo "</table>"; // Cerrar la tabla

        // Cerrar la conexión
        $conexion->close();
    ?>
    
</body>
</html>
