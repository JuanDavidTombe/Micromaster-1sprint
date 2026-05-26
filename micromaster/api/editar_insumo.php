<?php
// api/editar_insumo.php
header('Content-Type: application/json');
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturamos las variables enviadas por el formulario
    $nombre = $_POST['nombre'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;
    $unidad = $_POST['unidad'] ?? 'kg';
    $categoria = $_POST['categoria'] ?? 'Materia Prima';

    if (empty($nombre)) {
        echo json_encode(["status" => "error", "message" => "El nombre del insumo es obligatorio."]);
        exit;
    }

    try {
        // Ejecutamos el UPDATE usando el nombre como identificador clave
        $sql = "UPDATE inventario SET cantidad = :cantidad, unidad = :unidad, categoria = :categoria WHERE nombre = :nombre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':cantidad' => $cantidad,
            ':unidad' => $unidad,
            ':categoria' => $categoria,
            ':nombre' => $nombre
        ]);

        echo json_encode(["status" => "success", "message" => "Insumo actualizado correctamente."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
