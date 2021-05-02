<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traductor Morse</title>
</head>
<body>
    <?php
        /* Este programa se encarga de traducir ya sea texto a morse o viceversa, dependiendo de la información recibida en el formulario */

        // Recibiendo datos del formulario
        $cadena =  $_POST["texto"];
        $action =  $_POST["tipoCifrado"];

        $correspondenciasMorse = ["A"=>".-", "B"=>"-...", "C"=>"-.-.",
                            "D"=>"-..", "E"=>".", "F"=>"..-.",
                            "G"=>"--.", "H"=>"....", "I"=>"..",
                            "J"=>".---", "K"=>"-.-", "L"=>".-..",
                            "M"=>"--", "N"=>"-.", "O"=>"---",
                            "P"=>".--.", "Q"=>"--.-", "R"=>".-.",
                            "S"=>"...", "T"=>"-", "U"=>"..-",
                            "V"=>"...-", "W"=>".--", "X"=>"-..-",
                            "Y"=>"-.--", "Z"=>"--..", " "=>"/",
                            "1"=>".----", "2"=>"..---", "3"=>"...--",
                            "4"=>"....-", "5"=>".....", "6"=>"-....",
                            "7"=>"--...", "8"=>"---..", "9"=>"----.",
                            "0"=>"-----", "!"=>"--..--", "."=>".-.-.-",
                            ","=>"-.-.--", "\""=>".-..-.", "?"=>"..--.."
                            ];
        
        $cadena = strtoupper($cadena);
        // Haciendo la traducción correspondiente ("cifrado" para pasar de español a morse, "descifrado" para la acción contraria).
        $traduccion = "";
        $textoValido = true;
        switch ($action) {

            case "cifrado":
                // Iterando por cada letra del texto
                for ($i = 0; $i < strlen($cadena); $i++) {
                    $textoValido = false;
                    // Iterando por cada una de las correspondencias para ver si una coincide, imprimir su versión en morse.
                    foreach ($correspondenciasMorse as $normal => $morse) {
                        if (ord($cadena[$i]) === ord($normal)) {
                            $traduccion .= $morse . " ";
                            // Si se pudo traducir el caracter, marcar como texto valido
                            $textoValido = true;
                        }
                    }
                    // Asignar el mensaje a a mostrar si alguno de los caracteres del texto no puede traducirse
                    if (!$textoValido) {
                        $traduccion = "<strong>Has escrito un texto con caracteres no incluidos en la siguiente imagen. Por favor, utilice sólamente los caracteres que aquí aparecen:</strong><br><br>";
                        $traduccion .= "<img width=\"350\" src=\"./Morse.png\">";
                        break;
                    }
                } 
                break;

            case "descifrado":

                /* 
                Checa caracter por caracter para saber si tiene caracteres válidos, si no,
                asigna el mensaje correspondiente
                 */
                for ($i = 0; $i < strlen($cadena); $i++) {
                    if ($cadena[$i] !== ' ' && $cadena[$i] !== '.' && $cadena[$i] !== '-' && $cadena[$i] !== '/') {
                        $textoValido = false;
                        $traduccion = "<strong>Has escrito de forma incorrecta tu texto en Morse o has incluido un caraacter que no le corresponde (use '.', '-' y '/'). Por favor, corriga su texto</strong><br><br>";
                        $traduccion .= "<img width=\"350\" src=\"./Morse.png\">";
                    }
                }

                // Separando cada una de las letras del texto en morse en un arreglo
                $cadeaArreglo = explode(" ", $cadena); 

                // Iterando por todas las subcadenas del arreglo, cada una representando una letra en morse
                foreach ($cadeaArreglo as $indice => $subcadena) {

                    // Iterando por cada una de las correspondencias
                    foreach ($correspondenciasMorse as $normal => $morse) {
                        if ($subcadena == $morse) {
                            $traduccion .= $normal;
                        }
                    }
                }
                break;
        }

        if ($textoValido) {
            echo "<h3>Su texto a traducir es: <br></h3>";
            echo $cadena ."<br>";
            echo "<h3>Su traducción es: </h3><br>";
        }
        echo $traduccion . "<br>";
    ?>
    <br><br>
    <form action="./Actividad_12.html"><input type="submit" value="Regresar"></form>
</body>
</html>