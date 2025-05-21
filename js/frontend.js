function buscar() {
    const numero = document.getElementById("numero_reloj").value;

    fetch(`http://localhost:3006/solicitudes/${numero}`)
        .then(res => res.json())
        .then(data => {
            mostrarResultados(data); 
        })
        .catch(err => {
            console.error("Error al buscar:", err);
        });
}

function buscarPendientes() {
    fetch("http://localhost:3006/solicitudes", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ estado: "pendiente" })
    })
    .then(res => res.json())
    .then(data => {
        mostrarResultados(data); 
    })
    .catch(err => {
        console.error("Error al buscar pendientes:", err);
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
