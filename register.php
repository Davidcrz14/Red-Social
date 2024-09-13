<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ya está autenticado, si es así redirigirlo a la página principal
if(isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establecer la conexión con la base de datos
    $servername = "localhost";
    $username = "id22002079_login";
    $password = "@";
    $dbname = "";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Obtener los valores del formulario de registro
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta SQL para verificar si el usuario ya existe en la base de datos
    $sql_check = "SELECT * FROM login WHERE username='$username'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 0) {
        // El usuario no existe, proceder con el registro

        // Consulta SQL para insertar el nuevo usuario en la tabla de login
        $sql_insert = "INSERT INTO login (username, password) VALUES ('$username', '$password')";

        // Ejecutar la consulta SQL
        if ($conn->query($sql_insert) === TRUE) {
            // Redirigir al usuario a la página de inicio de sesión
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    } else {
        // El usuario ya existe
        echo "<p style='color: red;'>El nombre de usuario ya está en uso.</p>";
    }

    // Cerrar la conexión con la base de datos
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="css/re.css">
</head>
<body>
    <div class="register-container">
        <h2>Registrarse</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="input-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>
