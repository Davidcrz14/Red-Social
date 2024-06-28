<?php
// Iniciar sesión
session_start();

// Verificar si la sesión del usuario está establecida
if (!isset($_SESSION["username"])) {
    // Si la sesión no está establecida, redirigir al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit(); // Detener la ejecución del script después de redirigir
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="css/styles.css" id="theme">
    <style>
        /* Estilos para posicionar el botón de "Modo Oscuro" */
        #darkModeBtn {
            position: absolute;
            top: 10px; /* Distancia desde la parte superior */
            right: 10px; /* Distancia desde la derecha */
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para cargar mensajes al cargar la página
            loadMessages();

            // Función para cargar mensajes cada 5 segundos
            setInterval(function() {
                loadMessages();
            }, 2000); // Carga los mensajes cada 5 segundos

            // Función para enviar mensaje
            $('#messageForm').submit(function(e) {
                e.preventDefault();
                var texto = $('#texto').val();
                $.post('sendMessage.php', { texto: texto }, function(data) {
                    loadMessages(); // Recargar mensajes después de enviar uno nuevo
                    $('#texto').val(''); // Limpiar el campo de texto después de enviar el mensaje
                });
            });

            // Cambiar de tema al hacer clic en el botón "Modo Oscuro"
            $('#darkModeBtn').click(function() {
                var currentTheme = $('#theme').attr('href');
                if (currentTheme === 'css/styles.css') {
                    $('#theme').attr('href', 'css/black.css');
                    $('#darkModeBtn').text('Modo Claro'); // Cambia el texto del botón
                } else {
                    $('#theme').attr('href', 'css/styles.css');
                    $('#darkModeBtn').text('Modo Oscuro'); // Cambia el texto del botón
                }
            });
        });

        // Función para cargar mensajes desde el servidor
        function loadMessages() {
            $.get('getMessages.php', function(data) {
                $('#messageList').html(data); // Actualizar la lista de mensajes
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Bienvenido: <?php echo $_SESSION["username"]; ?></h2>
        <form id="messageForm">
            <div class="input-group">
                <label for="texto">Mensaje:</label>
                <textarea id="texto" name="texto" rows="4" cols="50" required></textarea>
            </div>
            <button type="submit">Enviar Mensaje</button>
        </form>
        <h2>Mensajes de Usuarios</h2>
        <ul id="messageList" class="message-list">
            <!-- Aquí se cargarán los mensajes mediante JavaScript -->
        </ul>
        <button id="darkModeBtn">Modo Oscuro</button>

        <p><a href="logout.php">Cerrar sesión</a></p>
    </div>
</body>
</html>
