<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero</title>
</head>
<body>
    <h1>Tablero</h1>
    <table border="1">
        <tbody>
        <?php
            // Para designar el tamaño del tablero
            $n = 7;

            // Variables para facilitar los echos donde se utilizará cada color
            $blanco = "<img width=\"50\" src=\"./blanco.jpg\">";
            $negro = "<img width=\"50\" src=\"./negro.jpg\">";
            // Variable para tener control sobre el color de  la primer casilla de la fila anterior
            $primerRellenoAnterior = $negro;

            // Loop para las filas
            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";

                // Loop para las columnas
                for ($j = 0; $j < $n; $j++) {
                    // Si es la primer casilla de la columna, que el relleno sea el color contrario al homólogo de la fila anterior
                    if ($j == 0) {
                        $relleno = $primerRellenoAnterior == $blanco ? $negro : $blanco;
                        $primerRellenoAnterior = $relleno;
                    }
                    // De otra manera, que el relleno sea el color contrario a la casilla anterior
                    else {
                        $relleno = $relleno == $blanco ? $negro : $blanco;
                    }
                    
                    // Imprimiendo el contenido de la casilla
                    echo "<td>" . $relleno . "</td>";
                }
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    
</body>
</html>
