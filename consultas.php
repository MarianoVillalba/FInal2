<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Consulta de Ciclistas y Equipos</title>
</head>
<body>
<h1>Consulta</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="abm.php">ABM Ciclistas</a></li>
                <li><a href="consultas.php">Consultar Pruebas</a></li>
            </ul>
        </nav>

<h1>Consulta de Ciclistas y Equipos por Prueba</h1>
<form method="POST" action="">
    <label for="PruebaID">Selecciona la prueba (ID de la prueba):</label>
    <input type="number" id="PruebaID" name="PruebaID" required><br><br>

    <button type="submit">Consultar</button>
</form>

<script src="js/script.js"></script>


<?php
include 'conexion.php';
conectar();
if (isset($_POST['PruebaID'])) {
    $pruebaID = $_POST['PruebaID'];
    

    if (empty($pruebaID)) {
        echo "Por favor, ingresa un ID de prueba válido.";
    } else {

        $sql = "SELECT c.Nombre AS Ciclista, e.Nombre AS Equipo, p.PruebaID
                FROM participa p
                JOIN ciclista c ON p.CiclistaID = c.CiclistaID
                JOIN equipo e ON p.EquipoID = e.EquipoID
                WHERE p.PruebaID = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $pruebaID);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<h2>Ciclistas y Equipos en la Prueba</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>Ciclista</th>
                            <th>Equipo</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['Ciclista'] . "</td>
                            <td>" . $row['Equipo'] . "</td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron ciclistas ni equipos para la prueba con ID " . $pruebaID . ".";
            }

            // Cerrar la sentencia
            $stmt->close();
        } else {
            echo "Error al preparar la consulta.";
        }
    }
} else {
    echo "Por favor, selecciona una prueba.";
}

$conn->close();
?>
</body>
</html>
