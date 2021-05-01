

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de ingreso a la universidad</title>
</head>
<body>
    
    <table border="1">
        <thead>
            <tr>
                <th colspan="4"><h2>Solicitud de ingreso a la universidad</h2></th>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
                <?php 
                    // Validando que cada uno de los campos de información hayan sido enviados
                    $nombre = (isset($_POST["nombre"]) && $_POST["nombre"] != "") ? $_POST["nombre"] : "Dato no disponible";
                    $apellidoPaterno = (isset($_POST["apellidoPaterno"]) && $_POST["apellidoPaterno"] != "") ? $_POST["apellidoPaterno"] : "Dato no disponible";
                    $apellidoMaterno = (isset($_POST["apellidoMaterno"]) && $_POST["apellidoMaterno"] != "") ? $_POST["apellidoMaterno"] : "Dato no disponible";
                    $genero = (isset($_POST["genero"]) && $_POST["genero"] != "") ? $_POST["genero"] : "Dato no disponible";
                    $edad = (isset($_POST["edad"]) && $_POST["edad"] != "") ? $_POST["edad"] : "Dato no disponible";
                    $mail = (isset($_POST["mail"]) && $_POST["mail"] != "") ? $_POST["mail"] : "Dato no disponible";
                    $tel = (isset($_POST["tel"]) && $_POST["tel"] != "") ? $_POST["tel"] : "Dato no disponible";
                    $cel = (isset($_POST["cel"]) && $_POST["cel"] != "") ? $_POST["cel"] : "Dato no disponible";
                    $escuela = (isset($_POST["escuela"]) && $_POST["escuela"] != "") ? $_POST["escuela"] : "Dato no disponible";
                    $promedio = (isset($_POST["promedio"]) && $_POST["promedio"] != "") ? $_POST["promedio"] : "Dato no disponible";
                    $primeraOpcion = (isset($_POST["primeraOpcion"]) && $_POST["primeraOpcion"] != "") ? $_POST["primeraOpcion"] : "Dato no disponible";
                    $segundaOpcion = (isset($_POST["segundaOpcion"]) && $_POST["segundaOpcion"] != "") ? $_POST["segundaOpcion"] : "Dato no disponible";
                ?>
                <?php 
                    // Para los siguientes bloques de PHP, se imprimen los datos proporcionados por el formulario en sus espacios correspondientes
                    echo "<td>" . $nombre . "</td>";
                    echo "<td>" . $apellidoPaterno . "</td>";
                    echo "<td colspan=\"2\">" . $apellidoMaterno . "</td>";
                ?>       
            </tr>
            <tr>                         
                <td><u><strong>Apellido paterno</strong></u></td>
                <td><u><strong>Apellido paterno</strong></u></td>
                <td colspan="2"><u><strong>Nombre (s)</strong></u></td>
            </tr>
            <tr>
                <td><u><strong>Sexo:</strong></u></td>";
                <?php 
                    echo "<td>" . $genero . "</td>";
                    echo "<td><u><strong>Edad:</strong></u></td>";
                    echo "<td>" . $edad . "</td>";
                ?>
            </tr>

            <tr>
                <?php
                    echo "<td colspan=\"2\">" . $mail . "</td>";
                    echo "<td>" . $tel . "</td>";
                    echo "<td>" . $cel . "</td>";
                ?>
            </tr>

            <tr>
                <td colspan="2"><u><strong>Correo electrónico</strong></u></td>
                <td><u><strong>Teléfono</strong></u></td>
                <td><u><strong>Celular</strong></u></td>
            </tr>
                <tr><td><u><strong>Escuela de procedencia: </strong></u></td>
                <?php 
                    echo "<td>" . $escuela . "</td>";
                    echo "<td><u><strong>Promedio: </strong></u></td>>"; 
                    echo "<td>" . $promedio . "</td></tr>";
                    echo "<tr><td colspan=\"2\"><u><strong>Primera opción</strong></u></td>";   
                    echo "<td colspan=\"2\">" . $primeraOpcion . "</td></tr>"; 

                    echo "<tr><td colspan=\"2\"><u><strong>Segunda opción</strong></u></td>";   
                    echo "<td colspan=\"2\">" . $segundaOpcion . "</td></tr>"; 
                ?>
            
        </tbody>
    </table>
    <?php 
    ?>
</body>
</html>