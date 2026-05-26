<?php
// api/eliminar_receta.php
header('Content-Type: application/json');
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        echo json_encode(["status" => "error", "message" => "ID de receta no proporcionado."]);
        exit;
    }

    try {
        $sql = "DELETE FROM recetas WHERE id_receta = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        echo json_encode(["status" => "success", "message" => "Receta eliminada correctamente."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
