<?php
session_start();

if (!isset($_SESSION['nombre']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Solicitudes</title>
    <link rel="stylesheet" href="css/buscar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@800&display=swap&family=Roboto&family=Roboto+Condensed&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <section class="top">
            <h2>Buscar solicitudes por número de reloj</h2>
            <p class="descripcion">Ingresa el número de reloj para consultar todas las solicitudes registradas para ese empleado.</p>
        </section>

        <input type="text" id="reloj" placeholder="Número de reloj"><br><br>
        <button onclick="buscar()">Buscar</button>
        <button onclick="verPendientes()">Ver solicitudes pendientes</button><br><br>
        <button onclick="location.href='admin_index.php'" class="send-button">Volver</button>

        <ul id="resultados"></ul>
    </div>

    <script>
        function buscar() {
            const numero = document.getElementById("reloj").value;
            fetch(`http://localhost:3006/solicitudes/${numero}`)
                .then(res => res.json())
                .then(mostrarResultados)
                .catch(err => {
                    console.error("Error:", err);
                    document.getElementById("resultados").innerHTML = "<li>Error al buscar datos</li>";
                });
        }

        function verPendientes() {
            fetch("http://localhost:3006/solicitudes", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ estado: "pendiente" })
            })
            .then(res => res.json())
            .then(mostrarResultados)
            .catch(err => {
                console.error("Error:", err);
                document.getElementById("resultados").innerHTML = "<li>Error al buscar pendientes</li>";
            });
        }

        function mostrarResultados(data) {
            const lista = document.getElementById("resultados");
            lista.innerHTML = "";

            if (!Array.isArray(data) || data.length === 0) {
                lista.innerHTML = "<li>No se encontraron solicitudes</li>";
                return;
            }

            data.forEach(solicitud => {
                const inicio = new Date(solicitud.fecha_inicio).toLocaleDateString();
                const fin = new Date(solicitud.fecha_fin).toLocaleDateString();
                const item = document.createElement("li");

                item.textContent = `Usuario: ${solicitud.nombre} (${solicitud.numero_reloj}) - Del ${inicio} al ${fin} - Motivo: ${solicitud.motivo} - Estado: ${solicitud.estado}`;
                lista.appendChild(item);
            });
        }
</script>
</body>
</html>
