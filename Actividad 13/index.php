<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego</title>
</head>
  <body>
    <h1>Juego XD</h1>
    <?php 
      /* Juego de batalla naval con PHP */

      const CASILLA_VACIA = "./water.png";
      const CASILLA_LLENA = "./xd";
      const CASILLA_LLENA = "./xd";
      const CASILLA_FALLO = "./barrier.png";
      const CASILLA_GOLPE = "./fire.png";


      // Función que se encarga de tomar un tablero $tableroDeJuego y
      // crear un barco de tamaño $barcoTamano con una dirección y 
      // posición aleatorias.
      function crearBarco($tableroDeJuego, $barcoTamano) {
        
        $tableroDeJuegoTamano = count($tableroDeJuego);
        do {
          $creadoCorrectamente = true;
          // Este arreglo permite conocer todas las posiciones del tablero 
          // donde se encuentra el barco en creación
          $barcoPosiciones = [];

          $posX = rand(0, $tableroDeJuegoTamano-$barcoTamano);
          $posY = rand(0, $tableroDeJuegoTamano-$barcoTamano);

          // Representa la dirección en ambos ejes del barco, 
          // Si el barco se mueve en el eje x, no debe moverse en el eje y,
          // y viceversa
          $deltaX = rand(0,1);
          $deltaY = $deltaX == 0 ? 1 : 0;

          for ($i = 0; $i < $barcoTamano; $i++) {
            $casillaLibre = ($tableroDeJuego[$posX][$posY] == CASILLA_VACIA); 
            
            // Llenando la casilla con una parte del barco
            if ($casillaLibre) {
              $tableroDeJuego[$posX][$posY] = CASILLA_LLENA;
              
              // Guardando las coordenadas de esta casilla en el arreglo
              // para potencialmente modificar la casilla en una iteración futura
              array_push($barcoPosiciones, [$posX, $posY]);
              
              $posX += $deltaX;
              $posY += $deltaY;
            }
            // Si la casilla está llena, es necesario vaciár las casillas llenadas previamente
            // para poder intentar de nuevo.
            else {
              $creadoCorrectamente = false;
              foreach($barcoPosiciones as $coords) {
                $tableroDeJuego[$coords[0]][$coords[1]] = CASILLA_VACIA;
              }
            }
          }

        } while ($creadoCorrectamente == false);


        return $tableroDeJuego;
      }


      // Validando que se haya recibido la dificultad de juego y asignándola
      $dificultad = isset($_POST["dificultad"]) ? $_POST["dificultad"] : "Normal";
      
      switch ($dificultad) {
        case "Fácil":
          $vidasMax = 10;
          $tableroTamano = 8;
          $barcosLista = [4];
          break;
        case "Difícil":
          $vidasMax = 9;
          $tableroTamano = 13;
          $barcosLista = [4, 3, 3];
          break;
        default:
          $vidasMax = 8;
          $tableroTamano = 10;
          $barcosLista = [4, 3];
          break;

      }


      $vidas = isset($_POST["vidas"]) ? $_POST["vidas"] : $vidasMax;

      // Una partida es nueva si la cantidad de vidas es igual a la cantidad
      // máxima de vidas posibles y no se ha recibido ningún valor de vidas en
      // un formulario
      $nuevaPartida = ($vidas == $vidasMax && !isset($_POST["vidas"]));


      $tablero = [];
      $disparosHistorialCadena = "";
  
      
      // Inicialización del tablero
      if ($nuevaPartida) {
        $victoria = false;

        // Creando un tablero con casillas vacías
        for ($i = 0; $i < $tableroTamano; $i++) {
          $tableroFila = [];
          for ($j = 0; $j < $tableroTamano; $j++) {
            array_push($tableroFila, CASILLA_VACIA);
          }
          array_push($tablero, $tableroFila);
  
        }

        // Iterando sobre el arreglo de barcos a crear, y creándolos en coordenadas aleatorias
        foreach ($barcosLista as $barcoLong) {
          $tablero = crearBarco($tablero, $barcoLong);
        }

      }
      else {

        // Fueron enviadas por el formulario varias casillas de nombre 
        // casilla,X,Y . Donde X y Y son las coordenadas de la casilla
        // Por lo tanto, podemos iterar por cada una de ellas y reconstruir el 
        // tablero a partir de ellas
        for ($x = 0; $x < $tableroTamano; $x++) {
          $tableroFila = [];
          for ($y = 0; $y < $tableroTamano; $y++) {
            $casillaEnviada = "casilla," . $x . "," . $y;
            $valorCasilla = $_POST[$casillaEnviada];

            // Devolviendo las casillas donde hubo un disparo fallido a una casilla vacía
            $valorCasilla = ($valorCasilla == CASILLA_FALLO) ? CASILLA_VACIA : $valorCasilla;
            array_push($tableroFila, $valorCasilla);
          }
          array_push($tablero, $tableroFila);
  
        }

        // Checando si el disparo recibido es válido, lo es si se ha realizado 
        // dentro de los confines del tablero y la casilla de destino está
        // vacía o está llena (tiene un barco)
        $posX = $_POST["coordX"];
        $posX = ord(strtoupper($posX)) - ord("A");
        $posY = $_POST["coordY"] - 1;
        $disparoValido = ($posX < $tableroTamano && ($tablero[$posX][$posY] == CASILLA_VACIA || $tablero[$posX][$posY] == CASILLA_LLENA));


        if ($disparoValido) {
          switch ($tablero[$posX][$posY]) {
            case CASILLA_LLENA:
              $tablero[$posX][$posY] = CASILLA_GOLPE;
              break;
            default:
              $tablero[$posX][$posY] = CASILLA_FALLO;
              $vidas--;
              break;
          }

          // Recibiendo el historial de disparos que fue enviado por el formulario,
          // añadiendo el nuevo disparo al historial
          if (isset($_POST["historialDisparos"])) {

            if ($_POST["historialDisparos"] == "") {
              $disparosHistorialCadena = $_POST["coordX"] . $_POST["coordY"];
            }
            else {
              $disparosHistorialCadena = $_POST["historialDisparos"]. ", " . $_POST["coordX"] . $_POST["coordY"];
            }  
          }
        }

        // Cambiando el valor de $victoria si ninguna casilla tiene un barco
        $victoria = true;
        for ($i = 0; $i < $tableroTamano; $i++) {
          for ($j = 0; $j < $tableroTamano; $j++) {
            if ($tablero[$i][$j] == CASILLA_LLENA) {
              $victoria = false;
            }
          }

        }

      }

      // Desplegando información del juego en pantalla
      if ($vidas > 0 && $victoria == false) {
        echo "<strong>Vidas: </strong>";

        for ($i = 0; $i < $vidas; $i++) {
          echo "<img width=\"20\" src=\"heart.png\" >";
        }

        echo "<br><strong>Historial de disparos : </strong>" . $disparosHistorialCadena . "<br>";

        if (isset($disparoValido) && !$disparoValido) {
          echo '<h3>Tu disparo es inválido</h3>';
        }
      }

      // Imprimiendo mensaje de victoria
      elseif ($victoria == true) {
        echo "<h1>Ganaste</h1> <br><br>";
        echo "<img width=\"200\" src=\"victory.png\" >";
      }
      // Imprimiendo pantalla de derrota
      else {
        echo "<h1>Perdiste</h1> <br><br>";
        echo "<img width=\"200\" src=\"sad_cat.png\" >";
      }
    ?> 

    <br>
    <table border="3" style="border-collapse: collapse;">
      <?php
        // Dibujando el tablero
        if ($vidas > 0 && $victoria == false) {
          for ($i = 0; $i <= $tableroTamano; $i++) {
            echo "<tr>";
            for ($j = 0; $j <= $tableroTamano; $j++) {
              $relleno = "";
              if ($i == 0 && $j > 0) {
                $relleno = chr(ord('A') + $j - 1);
              }
              else if ($i > 0 && $j == 0) {
                $relleno = $i;
              }
              else if ($i > 0 && $j > 0) {
                $relleno = $tablero[$j-1][$i-1];
                $relleno = "<img width=\"40\" src=\"" . $relleno . "\" >";
              }
              echo "<td>" . $relleno . "</td>";
            }
            echo "</tr>";  
          }
        }
      ?>
    </table>
    <br>

    <?php
      // Formulario para hacer un nuevo disparo
      if ($vidas > 0 && $victoria == false) {
        echo "<form action=\"index.php\" method=\"POST\">";
        echo "<input type=\"hidden\" name=\"historialDisparos\" value=\"" . $disparosHistorialCadena ."\">";
        echo "<input type=\"hidden\" name=\"vidas\" value=\"" . $vidas ."\">";
        echo "<input type=\"hidden\" name=\"dificultad\" value=\"" . $dificultad ."\">";

        // Enviando la información de cada una de las casillas
        for ($i = 0; $i < $tableroTamano; $i++) {
          for ($j = 0; $j < $tableroTamano; $j++) {
            $casilla = "casilla," . $i . "," . $j;
            echo "<input type=\"hidden\" name=\"$casilla\" value=\"" . $tablero[$i][$j] . "\">";
          }    
        }
        
        echo "<label> Posición en X: 
                <input type=\"text\" maxlength=\"1\" maxlenght=\"1\" name=\"coordX\" required>
              </label>";

        echo "<label> Posición en Y: 
                <input type=\"number\" min=\"1\" max=\"" . $tableroTamano . "\" name=\"coordY\" required> 
              </label>";
        echo "<input type=\"submit\" value=\"Disparar\">";
        echo "</form>";
      }

      // Formulario para elegir dificultad y reiniciar juego.
      echo "<form action=\"index.php\" method=\"POST\">";
      echo "<label>Elige una dificultad para reiniciar el juego
              <select name=\"dificultad\">
                <option value=\"Fácil\">Fácil</option>
                <option value=\"Normal\">Normal</option>
                <option value=\"Difícil\">Difícil</option>
              </select>
            </label>";

      echo "<input type=\"submit\" value=\"Reiniciar juego\">";
      echo "</form>";

    ?>
    <br><br>

  </body>
</html>