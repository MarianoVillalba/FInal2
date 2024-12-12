<?php
$conn = null;

function conectar() {
    global $conn;
    $host = "localhost";
    $user = "root";  
    $password = "";  
    $dbname = "examenfinal"; 

    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
}
?>
