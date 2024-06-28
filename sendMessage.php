<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "id22002079_login";
    $password = "Davilis23@";
    $dbname = "id22002079_login";

    // Crear una conexión utilizando consultas preparadas
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Preparar la consulta SQL utilizando consultas preparadas
    $sql_insert = "INSERT INTO mensajes (username, texto) VALUES (?, ?)";

    // Preparar la declaración utilizando consultas preparadas
    $stmt = $conn->prepare($sql_insert);

    // Vincular parámetros y ejecutar la declaración
    $stmt->bind_param("ss", $username, $texto);

    // Obtener los valores del formulario
    $texto = $_POST["texto"];
    $username = $_SESSION["username"];

    // Ejecutar la consulta preparada
    if ($stmt->execute()) {
        echo "Mensaje enviado correctamente";
    } else {
        echo "Error al enviar el mensaje";
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
