<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // &nbsp;
        // Validación para después
        $texto =  $_POST["texto"];
        $action =  $_POST["tipoCifrado"];
        $cadenasABuscar = ['a', 'b', 'c', 'i', 'Brodi'];
        $cadena = $texto;
        $correspondencia = ['A'=>'.-', 'B'=>'-...', 'C'=>'-.-.',
                            'D'=>'-..', 'E'=>'.', 'F'=>'..-.',
                            'G'=>'--.', 'H'=>'....', 'I'=>'..',
                            'J'=>'.---', 'K'=>'-.-', 'L'=>'.-..',
                            'M'=>'--', 'N'=>'-.', 'O'=>'---',
                            'P'=>'.--.', 'Q'=>'--.-', 'R'=>'.-.',
                            'S'=>'...', 'T'=>'-', 'U'=>'..-',
                            'V'=>'...-', 'W'=>'.--', 'X'=>'-..-',
                            'Y'=>'-.--', 'Z'=>'--..', ' '=>'/',
                            '1'=>'.----', '2'=>'..---', '3'=>'...--',
                            '4'=>'....-', '5'=>'.....', '6'=>'-....',
                            '7'=>'--...', '8'=>'---..', '9'=>'----.',
                            '0'=>'-----', '!'=>'--..--', '.'=>'.-.-.-',
                            ','=>'-.-.-.', '"'=>'.-..-.', '?'=>'..--..'
                            ];
        
        $cadena = strtoupper($cadena);
        echo $cadena .":<br>";

        switch ($action) {
            case "cifrado":                
                for ($i = 0; $i < strlen($cadena); $i++) {
                    foreach ($correspondencia as $normal => $morse) {
                        if ($cadena[$i] === $normal) {
                            echo $morse . " ";
                            break;
                        }
                    }
                }
                break;

            case "descifrado":
                for ($i = 0; $i < strlen($cadena); $i++) {
                    foreach ($correspondencia as $normal => $morse) {
                        if ($i + strlen($morse) <= strlen($cadena) && ($i === 0 || $cadena[$i - 1]  === " " )) {
                            $subcadena = substr($cadena, $i, strlen($morse));


                            $subcadenaAbarcaLetra = ($i + strlen($morse) == strlen($cadena) || $cadena[$i + strlen($morse)] === " ");

                            if ($subcadena == $morse && $subcadenaAbarcaLetra) {
                                echo $normal;
                                $i += strlen($subcadena) - 1;
                                break;
                            }
                        }
                    }
                }
        }
        

    ?>
</body>
</html>