<?php
// Conexion a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "examenfinal";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar formularios si hay solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    // Agregar ciclista
    if ($accion === 'agregar_ciclista') {
        $nombre = $_POST['Nombre'];
        $fecha_nac = $_POST['Fecha_Nac'];
        $nacionalidad = $_POST['Nacionalidad'];

        $sql = "INSERT INTO ciclista (Nombre, Fecha_Nac, Nacionalidad) VALUES ('$nombre', '$fecha_nac', '$nacionalidad')";
        if ($conn->query($sql) === TRUE) {
            echo "Ciclista agregado con éxito.<br>";
        } else {
            echo "Error: " . $conn->error . "<br>";
        }
    }

    // Asignar ciclista a un equipo
    if ($accion === 'asignar_equipo') {
        $ciclista_id = $_POST['CiclistaID'];
        $equipo_id = $_POST['EquipoID'];
        $fec_inicio = $_POST['Fec_Inicio'];

        $sql = "INSERT INTO pertenece (CiclistaID, EquipoID, Fec_Inicio) VALUES ($ciclista_id, $equipo_id, '$fec_inicio')";
        if ($conn->query($sql) === TRUE) {
            echo "Ciclista asignado al equipo con éxito.<br>";
        } else {
            echo "Error: " . $conn->error . "<br>";
        }
    }

    // Eliminar ciclista
    if ($accion === 'eliminar_ciclista') {
        $ciclista_id_eliminar = $_POST['CiclistaIDEliminar'];

        // Eliminar primero las relaciones en la tabla "pertenece" (si existen) antes de eliminar al ciclista
        $sql_relacion = "DELETE FROM pertenece WHERE CiclistaID = $ciclista_id_eliminar";
        if ($conn->query($sql_relacion) === TRUE) {
            // Ahora eliminar el ciclista
            $sql_eliminar = "DELETE FROM ciclista WHERE CiclistaID = $ciclista_id_eliminar";
            if ($conn->query($sql_eliminar) === TRUE) {
                echo "Ciclista eliminado con éxito.<br>";
            } else {
                echo "Error al eliminar ciclista: " . $conn->error . "<br>";
            }
        } else {
            echo "Error al eliminar relación de ciclista con el equipo: " . $conn->error . "<br>";
        }
    }
}

// Consultar datos para formularios
$ciclistas = [];
$sql_ciclistas = "SELECT * FROM ciclista";
$result_ciclistas = $conn->query($sql_ciclistas);
if ($result_ciclistas->num_rows > 0) {
    while ($row = $result_ciclistas->fetch_assoc()) {
        $ciclistas[] = $row;
    }
}

$equipos = [];
$sql_equipos = "SELECT * FROM equipo";
$result_equipos = $conn->query($sql_equipos);
if ($result_equipos->num_rows > 0) {
    while ($row = $result_equipos->fetch_assoc()) {
        $equipos[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Gestión de Ciclistas</title>
</head>
<body>
<header>
    <h1>ABM</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="abm.php">ABM Ciclistas</a></li>
                <li><a href="consultas.php">Consultar Pruebas</a></li>
            </ul>
        </nav>
    </header>
    <h1>Gestión de Ciclistas</h1>

    <h2>Agregar Ciclista</h2>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="agregar_ciclista">
        <label for="Nombre">Nombre:</label>
        <input type="text" id="Nombre" name="Nombre" required><br><br>

        <label for="Fecha_Nac">Fecha de Nacimiento:</label>
        <input type="date" id="Fecha_Nac" name="Fecha_Nac" required><br><br>

        <label for="Nacionalidad">Nacionalidad:</label>
        <input type="text" id="Nacionalidad" name="Nacionalidad" required><br><br>

        <button type="submit">Agregar Ciclista</button>
    </form>

    <h2>Eliminar Ciclista</h2>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="eliminar_ciclista">
        <label for="CiclistaIDEliminar">Ciclista:</label>
        <select name="CiclistaIDEliminar" id="CiclistaIDEliminar" required>
            <?php foreach ($ciclistas as $ciclista): ?>
                <option value="<?= $ciclista['CiclistaID'] ?>"><?= $ciclista['Nombre'] ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <button type="submit">Eliminar Ciclista</button>
    </form>

    <h2>Asignar Ciclista a un Equipo</h2>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="asignar_equipo">
        <label for="CiclistaID">Ciclista:</label>
        <select name="CiclistaID" id="CiclistaID" required>
            <?php foreach ($ciclistas as $ciclista): ?>
                <option value="<?= $ciclista['CiclistaID'] ?>"><?= $ciclista['Nombre'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="EquipoID">Equipo:</label>
        <select name="EquipoID" id="EquipoID" required>
            <?php foreach ($equipos as $equipo): ?>
                <option value="<?= $equipo['EquipoID'] ?>"><?= $equipo['Nombre'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="Fec_Inicio">Fecha de Inicio:</label>
        <input type="date" id="Fec_Inicio" name="Fec_Inicio" required><br><br>

        <button type="submit">Asignar</button>
    </form>

    <h2>Listado de Ciclistas y Equipos</h2>
    <?php
    $sql_listado = "SELECT c.Nombre AS Ciclista, e.Nombre AS Equipo, p.Fec_Inicio
                    FROM pertenece p
                    JOIN ciclista c ON p.CiclistaID = c.CiclistaID
                    JOIN equipo e ON p.EquipoID = e.EquipoID";
    $result_listado = $conn->query($sql_listado);

    if ($result_listado->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Ciclista</th>
                <th>Equipo</th>
                <th>Fecha de Inicio</th>
            </tr>
            <?php while ($row = $result_listado->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Ciclista'] ?></td>
                    <td><?= $row['Equipo'] ?></td>
                    <td><?= $row['Fec_Inicio'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>

    <script src="js/script.js"></script>
</body>
</html>
