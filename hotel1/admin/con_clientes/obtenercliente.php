<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hola</h1>
</body>
</html>
=======
<?php
include "../../conecction/db.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion']) && $_GET['accion'] === 'obtener') {
    $clienteId = $_GET['id'];

    $query = "SELECT * FROM clientes WHERE cliente_id = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $clienteId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            echo json_encode($row);
        } else {
            echo json_encode(["error" => "Cliente no encontrado."]);
        }
    } else {
        echo json_encode(["error" => "Error al obtener el cliente."]);
    }
    mysqli_stmt_close($stmt);
}
>>>>>>> 5e51d2de40982c067c0e00acc4ae7bf30681bad3
