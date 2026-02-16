<?php
require_once __DIR__ . '/bootstrap.php';

function categorias(): array {
    return db()->query("SELECT * FROM categoria ORDER BY nombre")->fetchAll();
}

function productos(?string $q = null, ?int $cat = null): array {
    $sql = "
        SELECT p.*, c.nombre AS categoria
        FROM producto p
        JOIN categoria c ON c.id = p.categoria_id
        WHERE 1=1
    ";
    $params = [];

    if ($q !== null && trim($q) !== '') {
        $sql .= " AND (p.titulo LIKE ? OR p.descripcion LIKE ?)";
        $like = '%' . trim($q) . '%';
        $params[] = $like;
        $params[] = $like;
    }

    if ($cat !== null && $cat > 0) {
        $sql .= " AND p.categoria_id = ?";
        $params[] = $cat;
    }

    $sql .= " ORDER BY p.id DESC";

    $st = db()->prepare($sql);
    $st->execute($params);
    return $st->fetchAll();
}

function producto_por_id(int $id) {
    $st = db()->prepare("
        SELECT p.*, c.nombre AS categoria
        FROM producto p
        JOIN categoria c ON c.id = p.categoria_id
        WHERE p.id = ?
    ");
    $st->execute([$id]);
    return $st->fetch();
}

