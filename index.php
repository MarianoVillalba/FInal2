<?php
include 'conexion.php';
conectar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ciclistas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <h1>Gestión de Ciclistas y Pruebas</h1>
        <nav>
            <ul>
                <li><a href="abm.php">ABM Ciclistas</a></li>
                <li><a href="consultas.php">Consultar Pruebas</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Bienvenido al Sistema de Gestión</h2>
        <p>Utiliza las opciones del menú para gestionar ciclistas o consultar información de las pruebas.</p>
    </main>

    <footer>
        <p>2024 Final Programación II. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
