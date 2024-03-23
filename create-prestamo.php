<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$cliente_id = "";
$cliente_id_err = "";
$vehiculo_id = "";
$vehiculo_id_err = "";
$fecha_inicio = "";
$fecha_inicio_err = "";
$fecha_fin = "";
$fecha_fin_err = "";
$destino = "";
$destino_err = "";
$km_inicial = "";
$km_inicial_err = "";
$km_final = "";
$km_final_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate cliente_id
    $input_cliente_id = trim($_POST["cliente_id"]);
    if (empty($input_cliente_id)) {
        $cliente_id_err = "Por favor ingrese el ID del cliente.";
    } else {
        $cliente_id = $input_cliente_id;
    }

    // Validate vehiculo_id
    $input_vehiculo_id = trim($_POST["vehiculo_id"]);
    if (empty($input_vehiculo_id)) {
        $vehiculo_id_err = "Por favor ingrese el ID del vehículo.";
    } else {
        $vehiculo_id = $input_vehiculo_id;
    }

    // Validate fecha_inicio
    $input_fecha_inicio = trim($_POST["fecha_inicio"]);
    if (empty($input_fecha_inicio)) {
        $fecha_inicio_err = "Por favor ingrese la fecha de inicio.";
    } else {
        $fecha_inicio = $input_fecha_inicio;
    }

    // Validate fecha_fin
    $input_fecha_fin = trim($_POST["fecha_fin"]);
    if (empty($input_fecha_fin)) {
        $fecha_fin_err = "Por favor ingrese la fecha de fin.";
    } else {
        $fecha_fin = $input_fecha_fin;
    }

    // Validate destino
    $input_destino = trim($_POST["destino"]);
    if (empty($input_destino)) {
        $destino_err = "Por favor ingrese el destino.";
    } else {
        $destino = $input_destino;
    }

    // Validate km_inicial
    $input_km_inicial = trim($_POST["km_inicial"]);
    if (empty($input_km_inicial)) {
        $km_inicial_err = "Por favor ingrese el kilometraje inicial.";
    } else {
        $km_inicial = $input_km_inicial;
    }

    // Validate km_final (opcional)
    $input_km_final = trim($_POST["km_final"]);
    if (!empty($input_km_final)) {
        $km_final = $input_km_final;
    }

    // Check input errors before inserting in database
    if (empty($cliente_id_err) && empty($vehiculo_id_err) && empty($fecha_inicio_err) && empty($fecha_fin_err) && empty($destino_err) && empty($km_inicial_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO prestamos (cliente_id, vehiculo_id, fecha_inicio, fecha_fin, destino, km_inicial, km_final) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iisssii", $param_cliente_id, $param_vehiculo_id, $param_fecha_inicio, $param_fecha_fin, $param_destino, $param_km_inicial, $param_km_final);

            // Set parameters
            $param_cliente_id = $cliente_id;
            $param_vehiculo_id = $vehiculo_id;
            $param_fecha_inicio = $fecha_inicio;
            $param_fecha_fin = $fecha_fin;
            $param_destino = $destino;
            $param_km_inicial = $km_inicial;
            $param_km_final = $km_final;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Préstamo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Crear Préstamo</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario para crear un nuevo préstamo.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">

                        <div class="form-group <?php echo (!empty($cliente_id_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre del Cliente</label>
                            <select name="cliente_id" id="cliente_id" class="form-control" required>
                                <option value="">Seleccione un cliente</option>
                                <?php
                                $sql = "SELECT id, nombre FROM clientes";
                                $result = mysqli_query($link, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $selected = ($cliente_id == $row['id']) ? " selected" : "";
                                    echo "<option value='" . $row['id'] . "'" . $selected . ">" . $row['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $cliente_id_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($vehiculo_id_err)) ? 'has-error' : ''; ?>">
                            <label>Marca del Vehículo</label>
                            <select name="vehiculo_id" id="vehiculo_id" class="form-control" required>
                                <option value="">Seleccione un vehículo</option>
                                <?php
                                $sql = "SELECT id, marca FROM vehiculos";
                                $result = mysqli_query($link, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $selected = ($vehiculo_id == $row['id']) ? " selected" : "";
                                    echo "<option value='" . $row['id'] . "'" . $selected . ">" . $row['marca'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $vehiculo_id_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($fecha_inicio_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?php echo $fecha_inicio; ?>" required>
                            <span class="help-block"><?php echo $fecha_inicio_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($fecha_fin_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?php echo $fecha_fin; ?>" required>
                            <span class="help-block"><?php echo $fecha_fin_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($destino_err)) ? 'has-error' : ''; ?>">
                            <label>Destino</label>
                            <select name="destino" id="destino" class="form-control" required>
                                <option value="">Seleccione un destino</option>
                                <?php
                                $sql = "SELECT id, nombre FROM ciudades";
                                $result = mysqli_query($link, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $selected = ($destino == $row['nombre']) ? " selected" : "";
                                    echo "<option value='" . $row['nombre'] . "'" . $selected . ">" . $row['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $destino_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($km_inicial_err)) ? 'has-error' : ''; ?>">
                            <label>Kilometraje Inicial</label>
                            <input type="text" name="km_inicial" id="km_inicial" class="form-control" value="<?php echo $km_inicial; ?>" required>
                            <span class="help-block"><?php echo $km_inicial_err; ?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($km_final_err)) ? 'has-error' : ''; ?>">
                            <label>Kilometraje Final (opcional)</label>
                            <input type="text" name="km_final" id="km_final" class="form-control" value="<?php echo $km_final; ?>">
                            <span class="help-block"><?php echo $km_final_err; ?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Crear">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            let cliente_id = document.getElementById("cliente_id").value;
            let vehiculo_id = document.getElementById("vehiculo_id").value;
            let fecha_inicio = document.getElementById("fecha_inicio").value;
            let fecha_fin = document.getElementById("fecha_fin").value;
            let destino = document.getElementById("destino").value;
            let km_inicial = document.getElementById("km_inicial").value;
            let km_final = document.getElementById("km_final").value;

            if (cliente_id === "") {
                alert("Por favor, seleccione un cliente.");
                return false;
            }

            if (vehiculo_id === "") {
                alert("Por favor, seleccione un vehículo.");
                return false;
            }

            if (fecha_inicio === "") {
                alert("Por favor, ingrese la fecha de inicio.");
                return false;
            }

            if (fecha_fin === "") {
                alert("Por favor, ingrese la fecha de fin.");
                return false;
            }

            if (destino === "") {
                alert("Por favor, seleccione un destino.");
                return false;
            }

            if (km_inicial === "") {
                alert("Por favor, ingrese el kilometraje inicial.");
                return false;
            } else if (isNaN(km_inicial)) {
                alert("El kilometraje inicial debe ser un número.");
                return false;
            }

            if (km_final !== "" && isNaN(km_final)) {
                alert("El kilometraje final debe ser un número.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>