<?php
// api/eliminar_insumo.php
header('Content-Type: application/json');
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        echo json_encode(["status" => "error", "message" => "ID de insumo no proporcionado."]);
        exit;
    }

    try {
        $sql = "DELETE FROM inventario WHERE id_insumo = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        echo json_encode(["status" => "success", "message" => "Insumo eliminado correctamente."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
