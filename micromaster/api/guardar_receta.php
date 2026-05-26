<?php
// api/guardar_receta.php
header('Content-Type: application/json');
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $insumos = $_POST['insumos'] ?? '';
    $rendimiento = $_POST['rendimiento'] ?? '';

    if (empty($nombre) || empty($insumos) || empty($rendimiento)) {
        echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
        exit;
    }

    try {
        // Calcular el consecutivo REC-XXX automático
        $stmtCount = $pdo->query("SELECT COUNT(*) as total FROM recetas");
        $rowCount = $stmtCount->fetch();
        $consecutivo = $rowCount['total'] + 1;
        $codigo_receta = 'REC-' . str_pad($consecutivo, 3, '0', STR_PAD_LEFT);

        $sql = "INSERT INTO recetas (codigo, nombre, categoria, insumos, rendimiento) 
                VALUES (:codigo, :nombre, :categoria, :insumos, :rendimiento)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigo_receta,
            ':nombre' => $nombre,
            ':categoria' => $categoria,
            ':insumos' => $insumos,
            ':rendimiento' => $rendimiento
        ]);

        echo json_encode(["status" => "success", "message" => "Receta guardada correctamente."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
