<?php
// Include config file
require_once "config.php";

// Initialize HTML variable
$html = '';

// Attempt select query execution
$sql = "SELECT c.nombre AS cliente, p.destino, p.km_inicial, v.marca AS vehiculo
        FROM prestamos p
        JOIN clientes c ON p.cliente_id = c.id
        JOIN vehiculos v ON p.vehiculo_id = v.id
        ORDER BY v.marca";
        


if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $html .= "<div class='table-responsive'>";
        $html .= "<table class='table table-bordered table-striped'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>Nombre del Cliente</th>";
        $html .= "<th>Destino</th>";
        $html .= "<th>Kilómetros Iniciales</th>";
        $html .= "<th>Marca del Vehículo</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";

        while ($row = mysqli_fetch_array($result)) {
            $html .= "<tr>";
            $html .= "<td>" . $row['cliente'] . "</td>";
            $html .= "<td>" . $row['destino'] . "</td>";
            $html .= "<td>" . $row['km_inicial'] . "</td>";
            $html .= "<td>" . $row['vehiculo'] . "</td>";
            $html .= "</tr>";
        }

        $html .= "</tbody>";
        $html .= "</table>";
        $html .= "</div>";

        // Free result set
        mysqli_free_result($result);
    } else {
        $html .= "<p class='lead'><em>No se encontraron registros.</em></p>";
    }
} else {
    $html .= "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link); // Output error message
}

// Close connection
mysqli_close($link);

// Output filtered data HTML
echo $html;
?>