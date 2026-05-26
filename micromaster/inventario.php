<?php
// inventario.php - INICIO DEL ARCHIVO: Cargar stock desde phpMyAdmin
require_once 'conexion.php';

try {
    // Consultamos todos los insumos ordenados por nombre
    $stmt = $pdo->query("SELECT * FROM inventario ORDER BY nombre ASC");
    $listaInsumos = $stmt->fetchAll();
} catch (Exception $e) {
    $listaInsumos = []; // Evita que se rompa la página si falla la BD
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MicroMaster — Inventario</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/main.css">

<style>
    .sidebar { width: 260px; min-height: 100vh; padding: 8px 10px; background: var(--primary-dark); color: rgba(255,255,255,.92); display: flex; flex-direction: column; gap: 2px; }
    .sidebar-logo { display: flex; align-items: center; gap: 8px; padding-bottom: 6px; border-bottom: 1px solid rgba(255,255,255,.08); }
    .sidebar-logo-img { width: 44px; height: 44px; border-radius: 14px; object-fit: cover; }
    .sidebar-logo-title { font-family: 'Inter', sans-serif; font-size: 17px; font-weight: 700; letter-spacing: .04em; color: #f8fafc; }
    .sidebar-logo-sub { font-family: 'Inter', sans-serif; font-size: 11px; letter-spacing: .22em; text-transform: uppercase; color: rgba(255,255,255,.45); margin-top: -2px; }
    .sidebar-section-label { font-family: 'Inter', sans-serif; font-size: 8px; text-transform: uppercase; letter-spacing: .20em; color: rgba(255,255,255,.35); margin-top: 2px; margin-bottom: 2px; }
    .nav-item { display: flex; align-items: center; gap: 8px; padding: 6px 8px; border-radius: 10px; color: rgba(255,255,255,.82); text-decoration: none; font-family: 'Inter', sans-serif; font-size: 11px; letter-spacing: .01em; transition: background .2s ease, color .2s ease; }
    .nav-item:hover { background: rgba(255,255,255,.08); color: #f8fafc; }
    .nav-icon { width: 22px; height: 22px; display: flex; flex-shrink: 0; align-items: center; justify-content: center; color: rgba(255,255,255,.68); }
    .nav-item.active { background: rgba(52,211,153,.18); color: #e2f9e7; }
    .nav-item.active .nav-icon { color: #4ade80; }
    .nav-item.active:hover { background: rgba(52,211,153,.24); }
    .sidebar-user { margin-top: auto; padding-top: 6px; border-top: 1px solid rgba(255,255,255,.08); display: flex; flex-direction: column; gap: 3px; }
    .sidebar-user-name { font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 700; color: #f8fafc; }
    .sidebar-user-role { font-family: 'Inter', sans-serif; font-size: 12px; color: rgba(255,255,255,.5); }
    .btn-logout { display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 999px; border: 1px solid rgba(255,255,255,.12); background: rgba(255,255,255,.05); color: rgba(255,255,255,.88); font-family: 'Inter', sans-serif; font-size: 11px; cursor: pointer; transition: background .2s ease, border-color .2s ease; }
    .btn-logout:hover { background: rgba(255,255,255,.12); border-color: rgba(255,255,255,.22); }
    .btn-logout span { display: inline-flex; align-items: center; }
  </style>
</head>
<body>

<div id="app" class="visible">

  <aside class="sidebar">
    <div class="sidebar-logo">
      <img src="assets/img/WhatsApp Image 2025-07-07 at 2.53.03 PM.png" alt="MicroMaster" class="sidebar-logo-img">
      <div>
        <div class="sidebar-logo-title">MicroMaster</div>
        <div class="sidebar-logo-sub">Gestión de Insumos</div>
      </div>
    </div>

    <div class="sidebar-section-label">Principal</div>
    <a class="nav-item" href="dashboard.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><rect x="3" y="3" width="7" height="7" rx="1.5" /><rect x="14" y="3" width="7" height="7" rx="1.5" /><rect x="3" y="14" width="7" height="7" rx="1.5" /><rect x="14" y="14" width="7" height="7" rx="1.5" /></svg></span>
      <span>Inicio</span>
    </a>
    <a class="nav-item active" href="inventario.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><path d="M4 7.5L12 3l8 4.5v9L12 21 4 16.5v-9z" /><path d="M12 3v18" /><path d="M4 7.5l8 4.5 8-4.5" /></svg></span>
      <span>Inventario</span>
    </a>
    <a class="nav-item" href="recetas.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><path d="M8 4h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z" /><path d="M8 8h8" /><path d="M12 12h4" /><path d="M12 16h4" /></svg></span>
      <span>Recetas</span>
    </a>
    <a class="nav-item" href="envios.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><path d="M3 12h13l3 5h2" /><path d="M5 12V8a2 2 0 0 1 2-2h9v6" /><circle cx="7.5" cy="18.5" r="2.5" /><circle cx="18.5" cy="18.5" r="2.5" /><path d="M16 7h4v5" /></svg></span>
      <span>Envíos</span>
    </a>

    <div class="sidebar-section-label">Herramientas</div>
    <a class="nav-item" href="calculadora.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><rect x="6" y="3" width="12" height="18" rx="2" /><path d="M10 7h4" /><path d="M10 12h4" /><path d="M10 17h4" /></svg></span>
      <span>Calculadora</span>
    </a>
    <a class="nav-item" href="simulador.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><polyline points="3 17 9 11 13 15 21 7" /><polyline points="21 11 21 7 17 7" /></svg></span>
      <span>Simulador</span>
    </a>
    <a class="nav-item" href="reportes.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><path d="M5 19V10h4v9H5z" /><path d="M10 19V4h4v15h-4z" /><path d="M15 19V14h4v5h-4z" /></svg></span>
      <span>Reportes</span>
    </a>
    <a class="nav-item" href="configuracion.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><circle cx="12" cy="12" r="3" /><line x1="19.4" y1="15" x2="21" y2="15" /><line x1="3" y1="15" x2="4.6" y2="15" /><line x1="19.4" y1="9" x2="21" y2="9" /><line x1="3" y1="9" x2="4.6" y2="9" /><path d="M16.24 7.76l1.42-1.42" /><path d="M6.34 17.66l1.42-1.42" /><path d="M16.24 16.24l1.42 1.42" /><path d="M6.34 6.34l1.42 1.42" /></svg></span>
      <span>Configuración</span>
    </a>
    <a class="nav-item" href="acerca.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12" y2="12" /><circle cx="12" cy="16" r="1" /></svg></span>
      <span>Acerca de</span>
    </a>

    <div class="sidebar-user">
      <div class="sidebar-user-name">Admin Principal</div>
      <div class="sidebar-user-role">Administrador</div>
      <button class="btn-logout" onclick="logout()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="18" height="18" style="display: block;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" /><polyline points="16 17 21 12 16 7" /><line x1="21" y1="12" x2="9" y2="12" /></svg><span>Cerrar Sesión</span></button>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="main">
    <div class="topbar">
      <div class="page-title" id="topbar-title">Inventario</div>
      <div class="topbar-right">
        <div class="topbar-date" id="topbar-date"></div>
      </div>
    </div>

    <div class="content">

      <div class="page active" id="page-inventario">
        <div class="stats-row">
          <div class="stat-card">
            <div class="stat-label">Total Insumos</div>
            <div class="stat-value">8</div>
            <div class="stat-sub">en sistema</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Disponibles</div>
            <div class="stat-value green">5</div>
            <div class="stat-sub">OK</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Stock Bajo</div>
            <div class="stat-value amber">2</div>
            <div class="stat-sub">bajo mínimo</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Agotados</div>
            <div class="stat-value red">1</div>
            <div class="stat-sub">sin stock</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Valor Total</div>
            <div class="stat-value blue">$846</div>
            <div class="stat-sub">inventario</div>
          </div>
        </div>

        <div class="toolbar">
          <div class="search-box">
            <span class="icon-inline light">🔍</span>
            <input type="text" placeholder="Buscar insumo...">
          </div>
          <select class="filter-select">
            <option>Todas las categorías</option>
            <option>Lácteos</option>
            <option>Cereales</option>
            <option>Proteínas</option>
            <option>Vegetales</option>
            <option>Bebidas</option>
          </select>
          <select class="filter-select">
            <option>Todos los estados</option>
            <option>Disponible</option>
            <option>Bajo stock</option>
            <option>Agotado</option>
          </select>
          <button class="btn btn-primary" onclick="openModal('modal-inv')">+ Agregar Insumo</button>
        </div>

        <div class="table-wrap">
          <table>
            <thead><tr>
              <th>Nombre</th><th>Categoría</th><th>Stock</th><th>Precio/U</th><th>Vencimiento</th><th>Estado</th><th>Acciones</th>
            </tr></thead>
            <tbody>
  <?php if (!empty($listaInsumos)): ?>
    <?php foreach ($listaInsumos as $insumo): ?>
      <?php 
        // 🎨 Paleta de colores pastel unificada (Estilo MicroMaster)
        $cantidad = floatval($insumo['cantidad']);
        
        // Reglas de negocio automáticas para los estados del stock
        if ($cantidad == 0) {
            $badgeBg = '#fee2e2';     // Rojo pastel suave
            $badgeColor = '#b91c1c';  // Texto rojo oscuro
            $barColor = 'bar-red';
            $estadoTexto = 'Agotado';
            $porcentajeBarra = 0;
        } elseif ($cantidad < 20) {
            $badgeBg = '#ffedd5';     // Naranja pastel suave
            $badgeColor = '#c2410c';  // Texto naranja oscuro
            $barColor = 'bar-amber';
            $estadoTexto = 'Bajo Stock';
            $porcentajeBarra = 20;
        } else {
            $badgeBg = '#dcfce7';     // Verde pastel suave
            $badgeColor = '#15803d';  // Texto verde oscuro
            $barColor = 'bar-green';
            $estadoTexto = 'Disponible';
            // Calculamos un porcentaje proporcional simple para la barra (máximo 100)
            $porcentajeBarra = min(100, intval(($cantidad / 120) * 100));
        }
      ?>
      <tr style="border-bottom: 1px solid var(--border);">
        <td style="padding:14px 16px; font-family:'DM Sans', sans-serif; font-size:13px; font-weight:600; color:#1e293b; text-align:left;"><strong><?php echo htmlspecialchars($insumo['nombre']); ?></strong></td>
        <td style="padding:14px 16px; text-align:left;"><span class="badge badge-blue"><?php echo htmlspecialchars($insumo['categoria']); ?></span></td>
        <td style="padding:14px 16px; text-align:left;">
          <div class="bar-wrap">
            <div class="bar-bg"><div class="bar-fill <?php echo $barColor; ?>" style="width:<?php echo $porcentajeBarra; ?>%"></div></div>
            <span style="font-size:12px; color:var(--text-muted)"><?php echo htmlspecialchars($insumo['cantidad']) . ' ' . htmlspecialchars($insumo['unidad']); ?></span>
          </div>
        </td>
        <td style="padding:14px 16px; font-family:'DM Mono', monospace; font-size:12px; text-align:left; color:var(--text);">$0.85</td>
        <td style="padding:14px 16px; font-size:12px; text-align:left; color:var(--text-muted);">2026-12-01</td>
        <td style="padding:14px 16px; text-align:left;">
          <span style="display:inline-block; padding:4px 10px; background:<?php echo $badgeBg; ?>; color:<?php echo $badgeColor; ?>; border-radius:6px; font-family:'DM Sans', sans-serif; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">
            <?php echo $estadoTexto; ?>
          </span>
        </td>
        <td style="padding:14px 16px; text-align:left;">
          <div class="actions">
            <button class="btn-icon">✏️</button>
            <button class="btn-icon danger">🗑️</button>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="7" style="padding:30px; text-align:center; color:var(--text-muted); font-family:'DM Sans', sans-serif; font-size:14px;">No hay insumos registrados en la base de datos.</td>
    </tr>
  <?php endif; ?>
</tbody>

          </table>
        </div>
      </div>

    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /app -->

<!-- Modal Inventario -->
<!-- Modal Inventario Corregido -->
<div class="modal-overlay" id="modal-inv">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Agregar Insumo</div>
      <button class="modal-close" onclick="closeModal('modal-inv')">✕</button>
    </div>
    <div class="form-grid">
      <!-- Agregados identificadores únicos para la captura por JavaScript -->
      <div class="field"><label>Nombre</label><input type="text" id="ins-nombre" placeholder="Nombre del insumo"></div>
      <div class="field"><label>Categoría</label>
        <select id="ins-categoria">
          <option value="Lácteos">Lácteos</option>
          <option value="Cereales">Cereales</option>
          <option value="Proteínas">Proteínas</option>
          <option value="Vegetales">Vegetales</option>
          <option value="Bebidas">Bebidas</option>
          <option value="Condimentos">Condimentos</option>
          <option value="Grasas">Grasas</option>
        </select>
      </div>
      <div class="field"><label>Cantidad</label><input type="number" id="ins-cantidad" placeholder="0"></div>
      <div class="field"><label>Unidad</label>
        <select id="ins-unidad">
          <option value="kg">kg</option>
          <option value="L">L</option>
          <option value="g">g</option>
          <option value="ml">ml</option>
          <option value="u">u</option>
        </select>
      </div>
      <div class="field"><label>Stock Mínimo</label><input type="number" placeholder="0"></div>
      <div class="field"><label>Stock Máximo</label><input type="number" placeholder="0"></div>
      <div class="field"><label>Precio/Unidad</label><input type="number" placeholder="0.00"></div>
      <div class="field"><label>Vencimiento</label><input type="date"></div>
      <div class="field span2"><label>Proveedor</label><input type="text" placeholder="Nombre del proveedor"></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal('modal-inv')">Cancelar</button>
      <!-- Cambiado demoModal() por procesarNuevoInsumo() -->
      <button class="btn btn-primary" onclick="procesarNuevoInsumo()">Guardar Insumo</button>
    </div>
  </div>
</div>


<!-- Modal Recetas -->
<div class="modal-overlay" id="modal-rec">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Nueva Receta</div>
      <button class="modal-close" onclick="closeModal('modal-rec')">✕</button>
    </div>
    <div class="form-grid">
      <div class="field span2"><label>Nombre de la Receta</label><input type="text" placeholder="Ej: Pan de queso"></div>
      <div class="field"><label>Categoría</label><select><option>Panadería</option><option>Repostería</option><option>Bebidas</option><option>Platos</option></select></div>
      <div class="field"><label>Costo Estimado</label><input type="number" placeholder="0.00"></div>
      <div class="field span2"><label>Insumos (separados por coma)</label><input type="text" placeholder="Harina 1kg, Sal 20g, Leche 0.6L"></div>
      <div class="field span2"><label>Descripción</label><textarea placeholder="Descripción del proceso de preparación..."></textarea></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal('modal-rec')">Cancelar</button>
      <button class="btn btn-primary" onclick="demoModal()">Guardar Receta</button>
    </div>
  </div>
</div>

<!-- Modal Envíos -->
<div class="modal-overlay" id="modal-env">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Nuevo Envío</div>
      <button class="modal-close" onclick="closeModal('modal-env')">✕</button>
    </div>
    <div class="form-grid">
      <div class="field span2"><label>Destino</label><input type="text" placeholder="Nombre del cliente / establecimiento"></div>
      <div class="field"><label>Fecha Envío</label><input type="date"></div>
      <div class="field"><label>Estado Inicial</label><select><option>Pendiente</option><option>En tránsito</option></select></div>
      <div class="field span2"><label>Insumos a enviar</label><textarea placeholder="Ej: Leche 20L, Aceite 10L, Harina 5kg"></textarea></div>
      <div class="field"><label>Total Estimado ($)</label><input type="number" placeholder="0.00"></div>
      <div class="field"><label>Observaciones</label><input type="text" placeholder="Notas adicionales"></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal('modal-env')">Cancelar</button>
      <button class="btn btn-primary" onclick="demoModal()">Crear Envío</button>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast" id="toast">
  <span id="toast-icon" class="icon-inline small">✅</span>
  <span id="toast-msg">Acción completada</span>
</div>



<script src="assets/js/main.js"></script>
</body>
</html>
