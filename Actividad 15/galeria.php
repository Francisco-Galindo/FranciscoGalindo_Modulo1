<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería</title>
</head>
<body>
    <?php
        // Acción a realizar cuando se recibe un archivo del formulario
        if (isset($_FILES['archivo'])) {

            $arch = $_FILES['archivo']['tmp_name'];
            $name = $_FILES['archivo']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);


            // Checando validez del archivo
            if (isset($_POST['nombreObra']) && ($ext == "png" || $ext == "jpg" || $ext == "jpeg")) {
                
                // Obteniendo nombre del archivo y cambiando espacios por guiones bajos
                $obra = $_POST['nombreObra'];
                for ($i = 0; $i < strlen($obra); $i++) {
                    if ($obra[$i] == " ") {
                        $obra[$i] = "_";
                    }
                }
                
                // Mismo proceso con el autor
                $autor = (isset($_POST['nombreAutor']) && $_POST['nombreAutor'] != "") ? $_POST['nombreAutor'] : 'sin_autor';
                for ($i = 0; $i < strlen($autor); $i++) {
                    if ($autor[$i] == " ") {
                        $autor[$i] = "_";
                    }
                }
                $anno = (isset($_POST['anno']) && $_POST['anno'] != "") ? $_POST['anno']: 'sin_fecha';


                $nombreArchivo = $obra . '$' . $autor . '$&' . $anno . '&.' . $ext; 
                rename($arch, './statics/' . $nombreArchivo);

                // Imprimiendo mensaje de éxito y asignando el texto del botón junto con la acción que realizará
                echo "<h1>Tu imagen se ha cargado correctamenta en la galería</h1>";
                $mensajeBoton = "Ver galería";
                $action = "./galeria.php";
            } 
            else {

                // Acciones correspondiendes a un archivo inválido
                echo "<h1>Hubo un erro subiendo tu imagen, asegurate de que la extensión sea la correcta (.png, .jpg, .jpeg)</h1>";
                $mensajeBoton = "Agregar obra a la galería";
                $action = "./form.html";
            }
        }

        // Acciones para cuando se quiere ver la galería
        else {
            
            $carpetaImagenes = "./statics";
            $carpeta = opendir($carpetaImagenes);
            $archivos = [];

            
            do {
                $archivo = readdir($carpeta);

                if ($archivo) {
                    $ext = pathinfo($archivo, PATHINFO_EXTENSION);
                    if ($ext == "png" || $ext == "jpg" || $ext == "jpeg") {
                        array_push($archivos, $archivo);
                    }
                }
            } while ($archivo);

            // Imprimiendo la tabla con todo lo respectivo a al archivo en cuestión.
            if (count($archivos) > 0) {
                $contador = 0;
                echo "<table border='1'><tbody>";
                foreach ($archivos as $value) {

                    $valueCopia = strtoupper($value);

                    // Intercambiando guiones bajos por espacios para mostrarlos en la galería
                    for ($i = 0; $i < strlen($valueCopia); $i++) {
                        if ($valueCopia[$i] == "_") {
                            $valueCopia[$i] = " ";
                        }
                    }

                    // Separando las partes de la cadena del nombre del archivo para obtener los datos del archivo
                    $archivoArreglo = explode("$", $valueCopia);
                    $obra = $archivoArreglo[0];
                    $autor = $archivoArreglo[1];
                    $anno = explode("&", $archivoArreglo[2])[1];

                    if ($contador % 2 == 0) {
                        echo "<tr>";
                    }
                    echo '<td><img width="200" src="./statics/';
                    echo $value . '">';

                    echo "<br><ul><li><strong>NOMBRE DE LA PINTURA: </strong></li>" . $obra . "<br>";
                    echo "<li><strong>NOMBRE DEL PINTOR: </strong></li>" . $autor . "<br>";
                    echo "<li><strong>AÑO EN QUE SE REALIZÓ: </strong></li>" . $anno . "<br></td>";
                    
                    if ($contador % 2 != 0) {
                        echo "</tr>";
                    }

                    $contador++;
                }
                echo "</tbody></table>";
            }
            // Caso donde no hay imágenes en la galería
            else {
                echo "<h1>No hay imágenes en la galería</h1>";
            }

            closedir($carpeta);

            // Texto y acción del botón para subir una nueva imagen
            $mensajeBoton = "Agregar obra a la galería";
            $action = "./form.html";
        }


        echo '  <br><form action="' . $action . '" method="POST">
                    <label>
                        <input type="submit" value="' . $mensajeBoton . '">
                    </label>
                </form>';
    ?>
</body>
</html>