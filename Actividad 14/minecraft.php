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
      /* El programa se encarga de mostrar al usuario una tabla con la hora en diferentes ciudades, o la cantidad de tiempo hasta un cumpleaños concreto */

      date_default_timezone_set("America/Mexico_City");

      // Si se ha pedido el reloj
      if (isset($_POST["reloj"])) {

        // Obteniendo la información del formumlario
        $horastr = $_POST["hora"];
        $ciudades = $_POST["ciudad"];
        $hora = strlen($horastr) > 0 ? strtotime($horastr): time();

        $columnaResultados = [];

        foreach ($ciudades as $ciudad) {

          // Cambiando la zona horaria dependiendo de la ciudad
          switch ($ciudad) {
            case "Ciudad de México":
              date_default_timezone_set("America/Mexico_City");
              break;
            case "Nueva York":
              date_default_timezone_set("America/New_York");
              break;
            case "Sao Paulo":
              date_default_timezone_set("America/Sao_Paulo");
              break;
            case "Madrid":
              date_default_timezone_set("Europe/Madrid");
              break;
            case "París":
              date_default_timezone_set("Europe/Paris");
              break;
            case "Roma":
              date_default_timezone_set("Europe/Rome");
              break;
            case "Atenas":
              date_default_timezone_set("Europe/Athens");
              break;
            case "Beijin":
              date_default_timezone_set("Asia/Shanghai");
              break;
            case "Tokio":
              date_default_timezone_set("Asia/Tokyo");
              break;
          }
          // Añadiendo la hora al arreglo de resultados
          array_push($columnaResultados, date("H:i",$hora));
        }

        // Asignando el encabezado y la columna de la izquierda de la tabla
        $columnaIzquierda = $ciudades;
        $encabezado = "<th colspan='2'>Reloj mundial</th>";
      }


      // Si se pide la calculadora de cumpleaños
      elseif (isset($_POST["cumple"])) {

        // Obteniendo la fecha del formulario
        $fecha = (isset($_POST["fecha"]) && $_POST["fecha"] != "") ? $_POST["fecha"] : date("Y-m-d");
        $fechaArreglo = explode("-", $fecha);

        // La lista de momentos con los cuales se calculará el tiempo faltante
        $momentos = isset($_POST["unidadTiempo"]) ? $_POST["unidadTiempo"] : [];

        // Obteniendo el arreglo asociativo relacionado con las fechas de cumpleaños y actual
        $diaHoy = localtime(time(), true);
        $fechaCumple = localtime(strtotime($fecha), true);


        // Cambiando el año del cumpleaños dependiendo del día en el que sea
        $fechaArreglo[0] = $diaHoy["tm_year"] + 1900;
        if ($fechaCumple["tm_yday"] <= $diaHoy["tm_yday"]) {
          $fechaArreglo[0]++;
        }
        $fecha = implode("-", $fechaArreglo);
        $fechaCumple = localtime(strtotime($fecha), true);


        $columnaResultados = [];

        foreach ($momentos as $momento) {
          
          // Haciendo el cálculo dependiendo de las opciones que hayan sido proporcionadas
          switch ($momento) {

            case "Días":
              // Restando los días del año del día del cumpleaños y el de hoy
              $valor = $fechaCumple["tm_yday"] - $diaHoy["tm_yday"];

              // Restando un día más si han pasado segundos en el día, sólo se mostrarán
              // días completos
              if ($diaHoy["tm_sec"] > 0) {
                $valor--;
              }

              // Si el valor de la resta es menor a 0, se le suman 365 días para esperar al siguiente año
              if ($valor < 0) {
                $valor += 365;
              } 
              break;

            case "Horas":

              // Mismo proceso, pero multiplicando cada día por 24 para saber la cantidad de horas 
              // transcurridas en esos días. Después a la cantidad de horas de la fecha actual, se le 
              // suma la cantidad de horas transcurridas en el día actual
              $valor = (24 * $fechaCumple["tm_yday"]) - ((24 * $diaHoy["tm_yday"]) + $diaHoy["tm_hour"]);

              
              if ($diaHoy["tm_sec"] > 0) {
                $valor--;
              }

              if ($valor < 0) {
                $valor += 365*24;
              } 
              break;

            case "Minutos":

              // Proceso similar, se multiplica ahora otra vez por 60 para obtener la cantidad de
              // minutos del día, también se toma en cuenta la cantidad de minutos de la fecha actual
              $valor = (24 * 60 * $fechaCumple["tm_yday"]) - ((24 * 60 * $diaHoy["tm_yday"]) + (60 *$diaHoy["tm_hour"]) + $diaHoy["tm_min"]);

              if ($valor < 0) {
                $valor += 365*24*60;
              } 
              break;

            case "¿Es fin de  semana?":
              $valor = $fechaCumple["tm_wday"];
  
              // Se es fin de semana si el valor del dia de la semana es 0 ó 6
              if ($valor == 0 || $valor == 6) {
                $valor = "Sí será :)";
              } 
              else {
                $valor = "No será :(";
              }
              break;

          }

          // Añadiendo el resultado al arreglo
          array_push($columnaResultados, $valor);
        }

        
        // Asignando los valores para la columna de la izquierda y el encabezado de la tabla
        $columnaIzquierda = $momentos;
        $encabezado = "<th>Cumpleaños: </th>". "<th>" . date("d-m-Y", strtotime($fecha)) . "</th>";
      }


      // Dibujando la tabla con los resultados
      echo "<table border=\"1\">
                <thead>
                  <tr>
                    $encabezado
                  </tr>
                </thead>
                <tbody>";

      for ($i = 0; $i < count($columnaIzquierda); $i++) {
        echo "<tr>";
        echo "<td>" . $columnaIzquierda[$i] . "</td>";
        echo "<td>" . $columnaResultados[$i] . "</td>";
        echo "</tr>";
      }

      echo "</tbody></table>";
    ?>
</body>

</html>