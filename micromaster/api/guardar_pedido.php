<?php
// api/guardar_pedido.php
header('Content-Type: application/json');
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destino = $_POST['destino'] ?? '';
    $estado = $_POST['estado'] ?? 'Pendiente';
    $total = $_POST['total'] ?? 0;
    $fecha = $_POST['fecha'] ?? date('Y-m-d');
    $insumos = $_POST['insumos'] ?? '';
    $observaciones = $_POST['observaciones'] ?? '';

    if (empty($destino) || empty($total)) {
        echo json_encode(["status" => "error", "message" => "Campos obligatorios vacíos."]);
        exit;
    }

    try {
        // Calcular el siguiente código secuencial (ENV-XXX)
        $stmtCount = $pdo->query("SELECT COUNT(*) as total FROM pedidos");
        $rowCount = $stmtCount->fetch();
        $consecutivo = $rowCount['total'] + 1;
        $codigo_envio = 'ENV-' . str_pad($consecutivo, 3, '0', STR_PAD_LEFT);

        // Insertar en la base de datos
        $sql = "INSERT INTO pedidos (codigo_envio, destino, estado, total, fecha_envio, insumos_detalle, observaciones) 
                VALUES (:codigo, :destino, :estado, :total, :fecha, :insumos, :obs)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigo_envio,
            ':destino' => $destino,
            ':estado' => $estado,
            ':total' => $total,
            ':fecha' => $fecha,
            ':insumos' => $insumos,
            ':obs' => $observaciones
        ]);

        echo json_encode(["status" => "success", "message" => "Pedido guardado correctamente."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
