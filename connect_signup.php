<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli('localhost:3306', 'root', '', 'vacaciones');
    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }

    $turno = $conn->real_escape_string($_POST['turno']);
    $numero_reloj = $conn->real_escape_string($_POST['numero_reloj']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $password = $_POST['password']; 
    $fecha_ingreso = $conn->real_escape_string($_POST['fecha_ingreso']);
    $antigüedad = $conn->real_escape_string($_POST['antigüedad']);
    $puesto = $conn->real_escape_string($_POST['puesto']);
    $area = $conn->real_escape_string($_POST['area']);
    $fecha_nacimiento = $conn->real_escape_string($_POST['fecha_nacimiento']);
    $edad = $conn->real_escape_string($_POST['edad']);
    $numero_telefono = $conn->real_escape_string($_POST['numero_telefono']);

    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $checkSql = "SELECT * FROM usuario WHERE numero_reloj = '$numero_reloj'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo "Ese usuario ya está registrado. <a href='login.html'>Inicia sesión.</a>";
    } else {
        $insertSql = "INSERT INTO usuario (turno, numero_reloj, nombre, password, fecha_ingreso, antigüedad, puesto, area, fecha_nacimiento, edad, numero_telefono, tipo_usuario)
                      VALUES ('$turno', '$numero_reloj', '$nombre', '$password_hash', '$fecha_ingreso', '$antigüedad', '$puesto', '$area', '$fecha_nacimiento', '$edad', '$numero_telefono', 'user')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Registro exitoso. <a href='login.html'>Inicia sesión aquí.</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
}
?>
