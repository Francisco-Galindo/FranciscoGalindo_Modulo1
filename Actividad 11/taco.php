<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu taco: </title>
</head>
<body>
    <?php
        /* 
        Este código en PHP recibe respuestas de un formulario de opción múltiple, a partir de cuantas veces se repiten ciertas opciones, asigna un tipo de taco 
        */

        /* 
        Recibiendo el número de preguntas desde el formulario y 
        creando un arreglo donde se contará la cantidad de respuestas con cada opción */ 
        $numeroPreguntas = $_POST["numPreguntas"];
        $respuestas = ["A"=>0, "B"=>0, "C"=>0, "D"=>0];

        /* 
        Debido a que el nombre de cada pregunta es "preguntaX", 
        donde X es el numero de la pregunta, 
        se puede hacer un ciclo for donde se vaya iterando por cada pregunta y 
        actualizar el arreglo correspondientemente. 
        */
        for ($i = 0; $i < $numeroPreguntas; $i++) {
            $preguntaCadena = "pregunta" . $i;
            $respuesta = $_POST[$preguntaCadena];
            $respuestas[$respuesta] ++;
        }

        /* 
        Ordenando el arreglo de manera descendente y eliminando el último lugar
        para quedar con las tres opciones más repetidas 
        */
        arsort($respuestas);
        array_pop($respuestas);

        /* 
        Iterando por cada una de tres opciones más repetidas para saber si hay empates,
        Se añadirá a un nuevo arreglo la opción más repetida, junto con todas las opciones que estén
        empatadas por el primer lugar
        */
        $respuestaTopAnteriorCantidad = 0;
        $arregloOpcionesGanadoras = [];
        foreach ($respuestas as $opcion => $cantidad) {
            if ($cantidad >= $respuestaTopAnteriorCantidad) {
                array_push($arregloOpcionesGanadoras, $opcion);
                $respuestaTopAnteriorCantidad = $cantidad;
            }
        }

        /* Convirtiendo el arreglo en una cadena*/
        sort($arregloOpcionesGanadoras);
        $cadenaOpcionesGanadoras = implode("", $arregloOpcionesGanadoras);

        /* Dependiendo de las opciones más repetidas, asignar el taco */
        switch ($cadenaOpcionesGanadoras) {
            case "A":
                $tipoTaco = "Taco al pastor";
                break;
            case "B":
                $tipoTaco = "Taco de suadero";
                break;
            case "C":
                $tipoTaco = "Taco de barbacoa";
                break;
            case "D":
                $tipoTaco = "Taco Lagunero";
                break;
            case "AB":
                $tipoTaco = "Taco campechano";
                break;
            case "BC":
                $tipoTaco = "Taco de carnitas";
                break;
            case "CD":
                $tipoTaco = "Taco bell";
                break;
            case "AD":
                $tipoTaco = "Taco light";
                break;
            case "AC":
                $tipoTaco = "Taco placero";
                break;
            case "BD":
                $tipoTaco = "Taco de mixiote";
                break;
            default:
                $tipoTaco = "Taco de sal";
        }

        echo "<br> Eres un <strong>". $tipoTaco . "</strong><br>";
    ?>
</body>
</html>