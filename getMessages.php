<?php
session_start();

$servername = "localhost";
$username = "id22002079_login";
$password = "@";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

$sql_select = "SELECT * FROM mensajes ORDER BY id DESC";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "<div class='message'>";
        echo "<span class='username'>" . htmlspecialchars($row["username"]) . "</span>";
        echo "<p class='text'>" . htmlspecialchars($row["texto"]) . "</p>";
        echo "<span class='message-id'>ID: " . $row["id"] . "</span>";
        echo "</div>";
        echo "</li>";
    }
} else {
    echo "<p>No hay mensajes disponibles.</p>";
}

$conn->close();
?>
