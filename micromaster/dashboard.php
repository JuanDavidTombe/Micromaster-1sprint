<?php
// dashboard.php - INICIO DEL ARCHIVO: Calcular estadísticas en tiempo real
require_once 'conexion.php';

try {
    // (Añadir dentro del bloque try {} existente en la línea 1 de dashboard.php)
    
    // Consulta A: Traer lotes que están activos o completados en el día
    $stmtProceso = $pdo->query("SELECT * FROM produccion WHERE estado IN ('En proceso', 'Completado') ORDER BY id_lote ASC");
    $lotesEnProceso = $stmtProceso->fetchAll();

    // Consulta B: Traer los lotes futuros planificados de la tabla inferior
    $stmtPlanificacion = $pdo->query("SELECT * FROM produccion WHERE estado NOT IN ('En proceso', 'Completado') ORDER BY id_lote ASC");
    $lotesPlanificados = $stmtPlanificacion->fetchAll();

    // 1. Contar total de pedidos hoy
    $resPedidos = $pdo->query("SELECT COUNT(*) FROM pedidos");
    $totalPedidos = $resPedidos->fetchColumn();

    // 2. Contar pedidos pendientes
    $resPendientes = $pdo->query("SELECT COUNT(*) FROM pedidos WHERE estado = 'Pendiente'");
    $pedidosPendientes = $resPendientes->fetchColumn();

    // 3. Contar total de insumos en inventario
    $resInsumos = $pdo->query("SELECT COUNT(*) FROM inventario");
    $totalInsumos = $resInsumos->fetchColumn();

    // 4. Contar cuántos insumos tienen alertas de "Bajo Stock" (menos de 20 unidades)
    $resAlertas = $pdo->query("SELECT COUNT(*) FROM inventario WHERE cantidad < 20");
    $insumosAlerta = $resAlertas->fetchColumn();

} catch (Exception $e) {
    $totalPedidos = 0;
    $pedidosPendientes = 0;
    $totalInsumos = 0;
    $insumosAlerta = 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MicroMaster — Dashboard</title>
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
    <a class="nav-item active" href="dashboard.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><rect x="3" y="3" width="7" height="7" rx="1.5" /><rect x="14" y="3" width="7" height="7" rx="1.5" /><rect x="3" y="14" width="7" height="7" rx="1.5" /><rect x="14" y="14" width="7" height="7" rx="1.5" /></svg></span>
      <span>Inicio</span>
    </a>
    <a class="nav-item" href="inventario.php">
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
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><circle cx="12" cy="12" r="3" /><line x1="19.4" y1="15" x2="21" y2="15" /><line x1="3" y1="15" x2("M4,7.5 L1,3 L9,7.5 L9,7.5 L9,7.5 L9,7.5 " /></svg></span>
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
      <div class="page-title" id="topbar-title">Inicio</div>
      <div class="topbar-right">
        <div class="topbar-date" id="topbar-date"></div>
      </div>
    </div>

    <div class="content">

      <div class="page active" id="page-dashboard">

        <!-- KPIs operacionales enfocados en producción alimentaria -->
        <div class="stats-row">
          <div class="stat-card">
            <div class="stat-label">En Producción Hoy</div>
            <div class="stat-value blue">3</div>
            <div class="stat-sub">lotes activos</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Planificados</div>
            <div class="stat-value green">5</div>
            <div class="stat-sub">órdenes de producción</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Insumos Críticos</div>
            <div class="stat-value red">2</div>
            <div class="stat-sub">bajo stock mínimo</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Por Vencer</div>
            <div class="stat-value amber">3</div>
            <div class="stat-sub">en los próximos 15 días</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Valor Inventario</div>
            <div class="stat-value green">$846</div>
            <div class="stat-sub">valorización actual</div>
          </div>
          <div class="stat-card">
            <div class="stat-label">Despachos Pend.</div>
            <div class="stat-value">1</div>
            <div class="stat-sub">pendiente de salida</div>
          </div>
        </div>

        <!-- Producciones en proceso -->
                <!-- Producciones en proceso dinámicas desde MySQL -->
        <div class="section-divider"><h3>🏭 Producciones en Proceso</h3></div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:14px;margin-bottom:24px">
          <?php if (!empty($lotesEnProceso)): ?>
            <?php foreach ($lotesEnProceso as $lote): ?>
              <?php 
                $esCompletado = $lote['estado'] === 'Completado';
                $badgeClass = $esCompletado ? 'badge-green' : 'badge-blue';
                $barFillClass = $esCompletado ? 'background:var(--teal)' : 'background:var(--primary)';
              ?>
              <div style="background:var(--white);border:1.5px solid var(--border);border-radius:14px;padding:20px">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px">
                  <div>
                    <div style="font-weight:800;font-size:15px;color:var(--black)"><?php echo htmlspecialchars($lote['producto']); ?> — <?php echo htmlspecialchars($lote['codigo_op']); ?></div>
                    <div style="font-size:12px;color:var(--text-muted);margin-top:2px"><?php echo htmlspecialchars($lote['categoria']); ?> · <?php echo htmlspecialchars($lote['horario_fecha']); ?></div>
                  </div>
                  <span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($lote['estado']); ?></span>
                </div>
                <div style="background:var(--bg);border-radius:8px;overflow:hidden;height:8px;margin-bottom:8px">
                  <div style="height:100%; width:<?php echo $lote['progreso']; ?>%; <?php echo $barFillClass; ?>; border-radius:8px; transition:width 0.5s"></div>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--text-muted)">
                  <span>Progreso: <?php echo $lote['progreso']; ?>% <?php echo $esCompletado ? '✅' : ''; ?></span>
                  <span>Rendimiento: <?php echo htmlspecialchars($lote['cantidad']); ?></span>
                </div>
                <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--bg);font-size:12px;color:var(--text-muted)">
                  Insumos: <?php echo htmlspecialchars($lote['insumos_necesarios']); ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div style="grid-column: 1 / -1; padding:20px; text-align:center; background:var(--white); border-radius:14px; border:1.5px solid var(--border); color:var(--text-muted); font-size:13px;">No hay lotes en proceso hoy.</div>
          <?php endif; ?>
        </div>
        <!-- Planificación de producción -->
        <div class="section-divider"><h3><span class="section-icon">📅</span>Planificación — Próximos lotes</h3></div>
        <div class="table-wrap" style="margin-bottom:24px">
          <table>
            <thead><tr>
              <th>Orden</th><th>Producto</th><th>Categoría</th><th>Cantidad</th><th>Insumos necesarios</th><th>Fecha planificada</th><th>Estado</th>
            </tr></thead>
                        <tbody>
              <?php if (!empty($lotesPlanificados)): ?>
                <?php foreach ($lotesPlanificados as $plan): ?>
                  <?php 
                    // Asignar colores de badges dinámicos según el tipo de alerta de planificación
                    $badgeStyle = 'badge-amber';
                    if ($plan['estado'] === 'Insumo crítico') $badgeStyle = 'badge-red';
                    if ($plan['estado'] === 'Pendiente aprobación') $badgeStyle = 'badge-gray';
                    if ($plan['estado'] === 'Bebidas') $badgeStyle = 'badge-green';
                  ?>
                  <tr>
                    <td><span style="font-family:DM Mono,monospace;font-weight:700"><?php echo htmlspecialchars($plan['codigo_op']); ?></span></td>
                    <td><strong><?php echo htmlspecialchars($plan['producto']); ?></strong></td>
                    <td><span class="badge badge-gray"><?php echo htmlspecialchars($plan['categoria']); ?></span></td>
                    <td><?php echo htmlspecialchars($plan['cantidad']); ?></td>
                    <td style="font-size:12px;color:var(--text-muted)"><?php echo htmlspecialchars($plan['insumos_necesarios']); ?></td>
                    <td style="font-size:12px"><?php echo htmlspecialchars($plan['horario_fecha']); ?></td>
                    <td><span class="badge <?php echo $badgeStyle; ?>"><?php echo htmlspecialchars($plan['estado']); ?></span></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" style="padding:20px; text-align:center; color:var(--text-muted); font-size:13px;">No hay lotes planificados en el cronograma.</td>
                </tr>
              <?php endif; ?>
            </tbody>

          </table>
        </div>

        <!-- Alertas de stock crítico -->
                <!-- Alertas de stock crítico y próximos vencimientos (ESTRUCTURA UNIFICADA Y LIMPIA) -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
          
          <!-- Columna Izquierda: Insumos Críticos desde MySQL -->
          <div style="background:var(--white);border:1.5px solid #f5cccc;border-radius:14px;padding:20px">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px">
              <span style="font-size:18px">🚨</span>
              <h3 style="font-family:Fraunces,serif;font-size:16px;font-weight:900;color:var(--red)">Insumos Críticos</h3>
            </div>
            <div style="display:flex;flex-direction:column;gap:10px">
              <?php
              $stmtCriticos = $pdo->query("SELECT * FROM inventario WHERE cantidad < 20 ORDER BY cantidad ASC");
              $insumosCriticosArray = $stmtCriticos->fetchAll();

              if (!empty($insumosCriticosArray)): 
                foreach ($insumosCriticosArray as $critico):
                  $esAgotado = floatval($critico['cantidad']) == 0;
                  $colorTexto = $esAgotado ? 'var(--red)' : 'var(--amber)';
                  $textoEstado = $esAgotado ? 'AGOTADO' : 'Bajo Stock';
              ?>
                  <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;background:#fdf5f5;border:1px solid #f5cccc;border-radius:8px">
                    <div>
                      <p style="font-weight:700;font-size:13px;color:var(--black)"><?php echo htmlspecialchars($critico['nombre']); ?></p>
                      <p style="font-size:11px;color:<?php echo $colorTexto; ?>">
                        Stock: <?php echo htmlspecialchars($critico['cantidad']) . ' ' . htmlspecialchars($critico['unidad']); ?> — <?php echo $textoEstado; ?>
                      </p>
                    </div>
                    <a href="inventario.php" class="btn btn-sm" style="background:var(--red);color:#fff;border-color:var(--red);text-decoration:none;display:inline-flex;align-items:center;">Reabastecer</a>
                  </div>
              <?php 
                endforeach;
              else: 
              ?>
                <div style="padding:16px; text-align:center; background:#f0faf5; border:1px solid #b6e8cf; border-radius:8px; color:#14532d; font-family:'DM Sans', sans-serif; font-size:13px; font-weight:600;">
                  ✅ Todo el inventario se encuentra al día.
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Columna Derecha: Próximos a Vencer -->
          <div style="background:var(--white);border:1.5px solid #f5e8cc;border-radius:14px;padding:20px">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px">
              <span style="font-size:18px">⏰</span>
              <h3 style="font-family:Fraunces,serif;font-size:16px;font-weight:900;color:var(--amber)">Próximos a Vencer</h3>
            </div>
            <div style="display:flex;flex-direction:column;gap:10px">
              <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;background:#fdf9f0;border-radius:8px">
                <div>
                  <p style="font-weight:700;font-size:13px;color:var(--black)">Pollo entero</p>
                  <p style="font-size:11px;color:var(--red)">Vence: 2026-05-28 — ¡6 días!</p>
                </div>
                <span class="badge badge-red">Urgente</span>
              </div>
              <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;background:#fdf9f0;border-radius:8px">
                <div>
                  <p style="font-weight:700;font-size:13px;color:var(--black)">Zanahoria</p>
                  <p style="font-size:11px;color:var(--amber)">Vence: 2026-06-07 — 16 días</p>
                </div>
                <span class="badge badge-amber">Atención</span>
              </div>
            </div>
          </div>

        </div> <!-- Cierre del Grid de Alertas -->

      </div> <!-- Cierre de page active -->
    </div> <!-- Cierre de content -->
  </div> <!-- Cierre de main -->
</div> <!-- Cierre de app -->

<!-- Modales del Sistema -->
<div class="modal-overlay" id="modal-inv">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Agregar Insumo</div>
      <button class="modal-close" onclick="closeModal('modal-inv')">✕</button>
    </div>
    <div class="form-grid">
      <div class="field"><label>Nombre</label><input type="text" id="ins-nombre" placeholder="Nombre del insumo"></div>
      <div class="field"><label>Categoría</label>
        <select id="ins-categoria">
          <option>Lácteos</option><option>Cereales</option><option>Proteínas</option><option>Vegetales</option><option>Bebidas</option><option>Condimentos</option><option>Grasas</option>
        </select>
      </div>
      <div class="field"><label>Cantidad</label><input type="number" id="ins-cantidad" placeholder="0"></div>
      <div class="field"><label>Unidad</label>
        <select id="ins-unidad">
          <option>kg</option><option>L</option><option>g</option><option>ml</option><option>u</option>
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
      <button class="btn btn-primary" onclick="procesarNuevoInsumo()">Guardar Insumo</button>
    </div>
  </div>
</div>

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

<div class="modal-overlay" id="modal-env">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Nuevo Envío</div>
      <button class="modal-close" onclick="closeModal('modal-env')">✕</button>
    </div>
    <div class="form-grid">
      <div class="field span2"><label>Destino</label><input type="text" id="env-destino" placeholder="Nombre del cliente / establecimiento"></div>
      <div class="field"><label>Fecha Envío</label><input type="date" id="env-fecha"></div>
      <div class="field"><label>Estado Inicial</label>
        <select id="env-estado"><option>Pendiente</option><option>En tránsito</option><option>Entregado</option></select>
      </div>
      <div class="field span2"><label>Insumos a enviar</label><textarea id="env-insumos" placeholder="Ej: Leche 20L, Aceite 10L, Harina 5kg"></textarea></div>
      <div class="field"><label>Total Estimado ($)</label><input type="number" id="env-total" placeholder="0.00"></div>
      <div class="field"><label>Observaciones</label><input type="text" id="env-obs" placeholder="Notas adicionales"></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal('modal-env')">Cancelar</button>
      <button class="btn btn-primary" onclick="procesarNuevoPedido()">Crear Envío</button>
    </div>
  </div>
</div>

<div class="toast" id="toast">
  <span id="toast-icon" class="icon-inline small">✅</span>
  <span id="toast-msg">Acción completada</span>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>
