<?php
// Include config file
require_once "config.php";

// Attempt select query execution
$sql = "SELECT c.nombre, p.destino, p.km_inicial, v.marca
        FROM prestamos p
        JOIN clientes c ON p.cliente_id = c.id
        JOIN vehiculos v ON p.vehiculo_id = v.id
        ORDER BY v.marca";

$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Informe de Préstamos de Vehículos</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Informe de Préstamos de Vehículos</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Nombre del Cliente</th>
                <th>Destino</th>
                <th>Kilómetros Iniciales</th>
                <th>Marca del Vehículo</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['destino']; ?></td>
                    <td><?php echo $row['km_inicial']; ?></td>
                    <td><?php echo $row['marca']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No se encontraron registros.</p>
    <?php endif; ?>

    <?php
    // Close the database connection
    mysqli_close($link);
    ?>
</body>
</html>