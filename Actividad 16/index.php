<?php
    session_start();

    // Recibiendo la información del formulario en caso de que no haya una sesión ya existente
    if (!isset($_SESSION["nombre"]) && isset($_POST["nombre"])) {
        $_SESSION["nombre"] = $_POST["nombre"];
        $_SESSION["apellidos"] = $_POST["apellidos"];
        $_SESSION["grupo"] = $_POST["grupo"];
        $_SESSION["fecha"] = $_POST["fecha"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["contra"] = $_POST["contra"];
        
    }
    // Cerrando la sesión en caso de que no haya información en el formulario y no exista información de la sesión, para ser redirigidos al formulario
    elseif (!isset($_SESSION["nombre"]) && !isset($_POST["nombre"])) {
        header("location: ./cerrar.php");
    }
    

    // Imprimiendo la tabla de información de inicio de sesión
    echo "<table border='1'>
    <thead>
        <tr>
            <th colspan='2'>Información de inicio de sesión</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nombre completo: </td>";
            echo "<td>" . $_SESSION['nombre'] . " " . $_SESSION['apellidos'] . "</td>
            
        </tr>
        <tr>
            <td>Grupo: </td>";
            echo "<td>" . $_SESSION['grupo'] . "</td>
        </tr>
        <tr>
            <td>fecha de nacimiento: </td>";
            echo "<td>" . $_SESSION['fecha'] . "</td>
        </tr>
        <tr>
        <td>Correo electrónico: </td>";
            echo "<td>" . $_SESSION['email'] . "</td>
        </tr>
    </tbody>
</table>";
?>

<form action="cerrar.php" method="POST">
    <input type="submit" value="Cerrar sesión">
</form>
