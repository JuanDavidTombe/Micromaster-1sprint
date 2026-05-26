<?php
// api/editar_pedido.php
header('Content-Type: application/json');
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturamos las variables idénticas a como viajan en tu FormData de main.js
    $codigo  = $_POST['id'] ?? ''; 
    $destino = $_POST['destino'] ?? '';
    $estado  = $_POST['estado'] ?? 'Pendiente';
    $insumos = $_POST['insumos'] ?? '';
    $total   = $_POST['total'] ?? 0;

    if (empty($codigo) || empty($destino)) {
        echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios para actualizar."]);
        exit;
    }

    try {
        // Limpiamos caracteres extraños del monto por si viaja con signo de pesos
        $totalLimpio = str_replace(['$', ' ', ','], '', $total);
        $totalNumero = floatval($totalLimpio);

        // UPDATE real sobre tu tabla `pedidos` en phpMyAdmin
        $sql = "UPDATE pedidos SET destino = :destino, estado = :estado, total = :total, insumos_detalle = :insumos WHERE codigo_envio = :codigo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':destino' => $destino,
            ':estado'  => $estado,
            ':total'   => $totalNumero,
            ':insumos' => $insumos,
            ':codigo'  => $codigo
        ]);

        echo json_encode(["status" => "success", "message" => "Pedido actualizado con éxito."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
