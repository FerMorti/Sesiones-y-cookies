<?php
session_start();
$usuario = $_GET["usuario"];
$password = $_GET["contraseña"];
validar($usuario, $password);

function validar($usuario, $password) {
    $_SESSION['usuario'] = $usuario;

    if ($usuario == "admin") {
        $_SESSION["rol"] = "jefaso";
    } else {
        $_SESSION["rol"] = "cliente";
    }

    if ($_SESSION["rol"] == "jefaso") {
        if ($password == "1234") {
            echo "Contraseña correcta!";
            $fechaActual = date('Y-m-d ');
            $horaActual = date('H:i:s');
            echo " La hora de entrada es: " . $horaActual . " y la fecha es: " . $fechaActual;
        } else {
            echo "Contraseña incorrecta >:(";
            header('Location: ejercicios.php');
            exit();
        }

        if (isset($_POST["obtenerURL"])) {
            $current_url = $_SERVER['REQUEST_URI'];
            echo "La ruta actual de la página es: " . $current_url;
        }

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

        if (isset($_POST["crearArchivo"])) {
            $nombreNuevoArchivo = $_POST["nombreNuevoArchivo"];
            $contenidoNuevoArchivo = "Este es el contenido del nuevo archivo.";
            $nombreNuevoArchivoConSufijo = $nombreNuevoArchivo;
            $rutaNuevoArchivo = "C:/xampp/htdocs/ejercicios2/" . $nombreNuevoArchivoConSufijo;

            if (file_put_contents($rutaNuevoArchivo, $contenidoNuevoArchivo) !== false) {
                chmod($rutaNuevoArchivo, 0644);
                echo "El archivo $nombreNuevoArchivoConSufijo se ha creado y escrito con éxito.";
            } else {
                echo "No se pudo crear el archivo.";
            }
        }

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
        if (isset($_POST["obtenerURL"])) {
            $current_url = $_SERVER['REQUEST_URI'];
            echo "La ruta actual de la página es: " . $current_url;
        }

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
        echo " Usuario incorrecto >:( ";
    }
}
?>
