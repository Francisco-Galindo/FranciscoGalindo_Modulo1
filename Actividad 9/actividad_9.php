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
            /* Se crea una tabla, en cada celda se desplegarán imagenes
             blancas o negras para  representar un tablero de ajedrez de un tamaño dado */

            $tamanoTablero = 8;

            // Variables para facilitar la asignación de color
            $blanco = "<img width=\"50\" src=\"./blanco.jpg\">";
            $negro = "<img width=\"50\" src=\"./negro.jpg\">";

            // Repitiendose en cada fila
            for ($i = 0; $i < $tamanoTablero; $i++) {
                echo "<tr>";

                // Repitiendose por cada casilla de cada columna
                for ($j = 0; $j < $tamanoTablero; $j++) {

                    // Si es la primer casilla de la fila y el numero de fila es par,
                    // que el color de la casilla sea negro, blanco si no
                    if ($j == 0) {
                        $colorCasilla = ($i % 2 == 0) ? $negro : $blanco;
                    }
                    // Que el relleno sea el color contrario a la casilla anterior
                    else {
                        $colorCasilla = $colorCasilla == $blanco ? $negro : $blanco;
                    }
                    
                    // Imprimiendo el contenido de la casilla
                    echo "<td>" . $colorCasilla . "</td>";
                }
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    
</body>
</html>
