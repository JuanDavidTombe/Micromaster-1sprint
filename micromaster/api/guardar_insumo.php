<?php
// api/guardar_insumo.php
header('Content-Type: application/json');
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;
    $unidad = $_POST['unidad'] ?? 'kg';
    $categoria = $_POST['categoria'] ?? 'Materia Prima';

    if (empty($nombre) || empty($cantidad)) {
        echo json_encode(["status" => "error", "message" => "Campos obligatorios vacíos."]);
        exit;
    }

    try {
        // Calcular el siguiente código secuencial (INS-XXX)
        $stmtCount = $pdo->query("SELECT COUNT(*) as total FROM inventario");
        $rowCount = $stmtCount->fetch();
        $consecutivo = $rowCount['total'] + 1;
        $codigo_insumo = 'INS-' . str_pad($consecutivo, 3, '0', STR_PAD_LEFT);

        $sql = "INSERT INTO inventario (codigo, nombre, cantidad, unidad, categoria, estado) 
                VALUES (:codigo, :nombre, :cantidad, :unidad, :categoria, 'Ok')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigo_insumo,
            ':nombre' => $nombre,
            ':cantidad' => $cantidad,
            ':unidad' => $unidad,
            ':categoria' => $categoria
        ]);

        echo json_encode(["status" => "success", "message" => "Insumo guardado correctamente."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
