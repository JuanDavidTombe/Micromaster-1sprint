<?php
// api/editar_receta.php
header('Content-Type: application/json');
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturamos las variables enviadas desde el modal de recetas
    $codigo = $_POST['id'] ?? ''; // El identificador único ej: REC-001
    $nombre = $_POST['nombre'] ?? '';
    $categoria = $_POST['categoria'] ?? 'Panadería';
    $insumos = $_POST['insumos'] ?? '';
    $rendimiento = $_POST['rendimiento'] ?? '';

    if (empty($codigo) || empty($nombre)) {
        echo json_encode(["status" => "error", "message" => "El código y nombre de la receta son obligatorios."]);
        exit;
    }

    try {
        // Ejecutamos el UPDATE real usando el código único como filtro
        $sql = "UPDATE recetas SET nombre = :nombre, categoria = :categoria, insumos = :insumos, rendimiento = :rendimiento WHERE codigo = :codigo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre'      => $nombre,
            ':categoria'   => $categoria,
            ':insumos'     => $insumos,
            ':rendimiento' => $rendimiento,
            ':codigo'      => $codigo
        ]);

        echo json_encode(["status" => "success", "message" => "Receta actualizada correctamente."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>
