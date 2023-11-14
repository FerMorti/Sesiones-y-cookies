<?php
// Inicia la sesión para poder utilizar variables de sesión
session_start();

// Obtiene los valores de usuario y contraseña desde la URL (GET)
$usuario = $_GET["usuario"];
$password = $_GET["contraseña"];

// Llama a la función validar con los datos de usuario y contraseña
validar($usuario, $password);

// Función que valida el usuario y realiza acciones según el rol
function validar($usuario, $password) {
    // Guarda el nombre de usuario en la sesión
    $_SESSION['usuario'] = $usuario;

    // Determina el rol del usuario (admin o cliente)
    if ($usuario == "admin") {
        $_SESSION["rol"] = "jefaso"; // Si el usuario es 'admin', asigna el rol 'jefaso'
    } else {
        $_SESSION["rol"] = "cliente"; // Si no es 'admin', asigna el rol 'cliente'
    }

    // Si el rol es 'jefaso' (admin)
    if ($_SESSION["rol"] == "jefaso") {
        // Verifica la contraseña del 'jefaso'
        if ($password == "1234") {
            echo "Contraseña correcta!";
            // Muestra la hora y fecha actual
            $fechaActual = date('Y-m-d ');
            $horaActual = date('H:i:s');
            echo " La hora de entrada es: " . $horaActual . " y la fecha es: " . $fechaActual;
        } else {
            echo "Contraseña incorrecta >:(";
            header('Location: ejercicios.php'); // Redirecciona si la contraseña es incorrecta
            exit();
        }

        // Comprueba si se ha enviado el formulario para obtener la URL de la página actual
        if (isset($_POST["obtenerURL"])) {
            $current_url = $_SERVER['REQUEST_URI'];
            echo "La ruta actual de la página es: " . $current_url;
        }

        // Comprueba si se ha enviado el formulario para buscar archivos
        if (isset($_POST["buscarArchivo"])) {
            $rutaDirectorio = "C:/xampp/htdocs/ejercicios2";
            $nombreArchivoBuscado = $_POST["nombreArchivo"];

            echo "Archivos encontrados en la ruta $rutaDirectorio que coinciden con '$nombreArchivoBuscado':<br>";

            $archivos = scandir($rutaDirectorio);

            foreach ($archivos as $archivo) {
                if (strpos($archivo, $nombreArchivoBuscado) !== false) {
                    echo $archivo . "<br>";
                }
            }
        }

        // Comprueba si se ha enviado el formulario para crear un nuevo archivo
        if (isset($_POST["crearArchivo"])) {
            $nombreNuevoArchivo = $_POST["nombreNuevoArchivo"];
            $contenidoNuevoArchivo = "Este es el contenido del nuevo archivo.";
            $nombreNuevoArchivoConSufijo = $nombreNuevoArchivo;
            $rutaNuevoArchivo = "C:/xampp/htdocs/ejercicios2/" . $nombreNuevoArchivoConSufijo;

            // Intenta crear el archivo y muestra un mensaje
            if (file_put_contents($rutaNuevoArchivo, $contenidoNuevoArchivo) !== false) {
                chmod($rutaNuevoArchivo, 0644);
                echo "El archivo $nombreNuevoArchivoConSufijo se ha creado y escrito con éxito.";
            } else {
                echo "No se pudo crear el archivo.";
            }
        }

        // Muestra un formulario para realizar acciones adicionales
        echo '
        <form method="post">
            <br>
            <input type="submit" name="obtenerURL" value="Obten la url de la pagina actual"/>
            <br>
            <br>
            <input type="text" name="nombreArchivo" placeholder="Nombre del archivo" />
            <input type="submit" name="buscarArchivo" value="Buscar Archivo" />
            <br>
            <br>
            <input type="text" name="nombreNuevoArchivo" placeholder="Nombre del nuevo archivo .txt" />
            <input type="submit" name="crearArchivo" value="Crea un nuevo archivo con sus permisos y sus cosillas jeje"/>
        </form>
        ';
    } elseif ($_SESSION["rol"] == "cliente") {
        // Si el rol es 'cliente'
        // Comprueba si se ha enviado el formulario para obtener la URL de la página actual
        if (isset($_POST["obtenerURL"])) {
            $current_url = $_SERVER['REQUEST_URI'];
            echo "La ruta actual de la página es: " . $current_url;
        }

        // Comprueba si se ha enviado el formulario para buscar archivos
        if (isset($_POST["buscarArchivo"])) {
            $rutaDirectorio = "C:/xampp/htdocs/ejercicios2";
            $nombreArchivoBuscado = $_POST["nombreArchivo"];

            echo "Archivos encontrados en la ruta $rutaDirectorio que coinciden con '$nombreArchivoBuscado':<br>";

            $archivos = scandir($rutaDirectorio);

            foreach ($archivos as $archivo) {
                if (strpos($archivo, $nombreArchivoBuscado) !== false) {
                    echo $archivo . "<br>";
                }
            }
        }

        // Muestra un formulario para realizar acciones adicionales para el cliente
        echo '
        <form method="post">         
            <br>
            <input type="submit" name="obtenerURL" value="Obten la url de la pagina actual"/>
            <br>
            <br>
            <input type="text" name="nombreArchivo" placeholder="Nombre del archivo" />
            <input type="submit" name="buscarArchivo" value="Buscar Archivo" />
        </form>
        ';
    } else {
        // Si el rol no es ni 'jefaso' ni 'cliente'
        echo " Usuario incorrecto >:( ";
    }
}
?>
