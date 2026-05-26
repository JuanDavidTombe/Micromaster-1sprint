<?php
// reportes.php - INICIO DEL ARCHIVO: Consultas de analítica masiva
require_once 'conexion.php';

try {
    // Consulta real A: Contar los registros actuales de mi tabla `inventario`
    $stmtTotalInsumos = $pdo->query("SELECT COUNT(*) FROM inventario");
    $totalInsumosReporte = $stmtTotalInsumos->fetchColumn() ?? 0;

    // Consulta real B: Contar el volumen total de registros en mi tabla `pedidos`
    $stmtTotalEnvios = $pdo->query("SELECT COUNT(*) FROM pedidos");
    $totalEnviosReporte = $stmtTotalEnvios->fetchColumn() ?? 0;

    // Consulta real C: Sumar numéricamente los totales de los pedidos entregados limpianzo el formato de texto si es necesario
    $stmtVentas = $pdo->query("SELECT SUM(REPLACE(REPLACE(total, '$', ''), ',', '')) FROM pedidos WHERE estado = 'Entregado'");
    $ventasTotales = $stmtVentas->fetchColumn() ?? 0;

} catch (Exception $e) {
    $totalInsumosReporte = 0;
    $totalEnviosReporte = 0;
    $ventasTotales = 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MicroMaster — Reportes</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/main.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <a class="nav-item" href="inventario.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><path d="M4 7.5L12 3l8 4.5v9L12 21 4 16.5v-9z" /><path d="M12 3v18" /><path d("M4 7.5l8 4.5 8-4.5" /></svg></span>
      <span>Inventario</span>
    </a>
    <a class="nav-item" href="recetas.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><path d="M8 4h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z" /><path d="M8 8h8" /><path d="M12 12h4" /><path d="M12 16h4" /></svg></span>
      <span>Recetas</span>
    </a>
    <a class="nav-item" href="envios.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><path d="M3 12h13l3 5h2" /><path d="M5 12V8a2 2 0 0 1 2-2h9v6" /><circle cx="7.5" cy="18.5" r="2.5" /><circle cx="18.5" cy="18.5" r("M4,7.5 L1,3 L9,7.5 L9,7.5 L9,7.5 L9,7.5 " /></svg></span>
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
    <a class="nav-item active" href="reportes.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><path d="M5 19V10h4v9H5z" /><path d="M10 19V4h4v15h-4z" /><path d="M15 19V14h4v5h-4z" /></svg></span>
      <span>Reportes</span>
    </a>
    <a class="nav-item" href="configuracion.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><circle cx="12" cy="12" r="3" /><line x1="19.4" y1="15" x2="21" y2="15" /><line x1="3" y1="15" x2="4.6" y2="15" /><line x1="19.4" y1="9" x2("M4,7.5 L1,3 L9,7.5 L9,7.5 L9,7.5 L9,7.5 " /></svg></span>
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
      <div class="page-title" id="topbar-title">Reportes</div>
      <div class="topbar-right">
        <div class="topbar-date" id="topbar-date"></div>
      </div>
    </div>

    <div class="content">

      <div class="page active" id="page-reportes">
        <div class="tab-row">
          <button class="tab-btn active" onclick="switchReportTab('metricas', this)"><span class="icon-inline small">📊</span>Métricas</button>
          <button class="tab-btn" onclick="switchReportTab('trazabilidad', this)"><span class="icon-inline small">📋</span>Trazabilidad</button>
          <button class="tab-btn" onclick="switchReportTab('documentos', this)"><span class="icon-inline small">📄</span>Documentos</button>
          <button class="tab-btn" onclick="switchReportTab('descargas', this)"><span class="icon-inline small">💾</span>Descargas</button>
        </div>

        <!-- MÉTRICAS -->
        <div id="rtab-metricas">
          <div class="kpi-grid">
            <div class="kpi-card">
              <div class="kpi-icon">💰</div>
              <div class="kpi-value">$<?php echo number_format($ventasTotales, 2); ?></div>
              <div class="kpi-label">Valor Inventario</div>
            </div>
            <div class="kpi-card">
              <div class="kpi-icon">📋</div>
              <div class="kpi-value"><?php echo $totalEnviosReporte; ?></div>
              <div class="kpi-label">Costo Prom. Receta</div>
            </div>
            <div class="kpi-card">
              <div class="kpi-icon">⚠️</div>
              <div class="kpi-value" style="color:var(--amber)"><?php echo $totalInsumosReporte; ?></div>
              <div class="kpi-label">Alertas Activas</div>
            </div>
            <div class="kpi-card">
              <div class="kpi-icon">🍽️</div>
              <div class="kpi-value" style="color:var(--teal)">4</div>
              <div class="kpi-label">Recetas Activas</div>
            </div>
          </div>

          <div class="chart-row">
            <div class="chart-card">
              <div class="chart-title">Valor de Inventario por Categoría</div>
              <div class="chart-sub">Distribución del valor total de insumos</div>
              <div class="chart-wrap"><canvas id="chartCategoria"></canvas></div>
            </div>
            <div class="chart-card">
              <div class="chart-title">Estado del Stock</div>
              <div class="chart-sub">Disponible / Bajo stock / Agotado</div>
              <div class="chart-wrap"><canvas id="chartStock"></canvas></div>
            </div>
            <div class="chart-card wide">
              <div class="chart-title">Evolución de Costos de Producción</div>
              <div class="chart-sub">Últimos 6 meses — tendencia de costos</div>
              <div class="chart-wrap" style="height:180px"><canvas id="chartEvolucion"></canvas></div>
            </div>
          </div>
        </div>

        <!-- TRAZABILIDAD -->
        <div id="rtab-trazabilidad" style="display:none">
          <div class="toolbar">
            <div class="search-box">
              <span class="icon-inline small">🔍</span>
              <input type="text" placeholder="Buscar en historial...">
            </div>
            <select class="filter-select">
              <option>Todas las acciones</option>
              <option>Crear insumo</option>
              <option>Editar receta</option>
              <option>Crear envío</option>
              <option>Cambiar estado</option>
            </select>
            <button class="btn btn-outline" onclick="demo()">📥 Exportar CSV</button>
          </div>
          <div class="table-wrap">
            <table>
              <thead><tr>
                <th>Fecha</th><th>Usuario</th><th>Acción</th><th>Detalle</th>
              </tr></thead>
              <tbody>
                <tr>
                  <td style="font-family:DM Mono,monospace;font-size:11px">2024-01-16 10:30</td>
                  <td><span class="badge badge-blue">admin</span></td>
                  <td><span class="badge badge-amber">Cambiar estado envío</span></td>
                  <td>ENV-002: Pendiente → En tránsito</td>
                </tr>
                <tr>
                  <td style="font-family:DM Mono,monospace;font-size:11px">2024-01-16 09:00</td>
                  <td><span class="badge badge-blue">admin</span></td>
                  <td><span class="badge badge-green">Crear envío</span></td>
                  <td>ENV-001 a Restaurante El Sabor ($245.00)</td>
                </tr>
                <tr>
                  <td style="font-family:DM Mono,monospace;font-size:11px">2024-01-15 15:20</td>
                  <td><span class="badge badge-gray">operador</span></td>
                  <td><span class="badge badge-amber">Editar receta</span></td>
                  <td>Pan Francés — modificó cantidad de harina</td>
                </tr>
                <tr>
                  <td style="font-family:DM Mono,monospace;font-size:11px">2024-01-15 14:30</td>
                  <td><span class="badge badge-blue">admin</span></td>
                  <td><span class="badge badge-green">Crear insumo</span></td>
                  <td>Leche entera (85L, $1.20/L)</td>
                </tr>
                <tr>
                  <td style="font-family:DM Mono,monospace;font-size:11px">2024-01-14 11:15</td>
                  <td><span class="badge badge-gray">supervisor</span></td>
                  <td><span class="badge badge-green">Crear receta</span></td>
                  <td>Torta de Chocolate — 5 insumos, $6.20/u</td>
                </tr>
                <tr>
                  <td style="font-family:DM Mono,monospace;font-size:11px">2024-01-13 09:45</td>
                  <td><span class="badge badge-blue">admin</span></td>
                  <td><span class="badge badge-red">Eliminar insumo</span></td>
                  <td>Levadura (5kg) — fuera de catálogo</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- DOCUMENTOS -->
        <div id="rtab-documentos" style="display:none">
          <div class="upload-area" onclick="demo()">
            <div class="upload-icon">📁</div>
            <div class="upload-title">Arrastra archivos aquí o haz clic para subir</div>
            <div class="upload-sub">Formatos: Excel (.xlsx, .xls), Word (.doc, .docx), PDF — Máx. 10MB</div>
          </div>
          <div class="table-wrap">
            <table>
              <thead><tr>
                <th>Nombre</th><th>Tipo</th><th>Tamaño</th><th>Subido</th><th>Acciones</th>
              </tr></thead>
              <tbody>
                <tr>
                  <td><span class="icon-inline small">📊</span><strong>Inventario_Enero_2024.xlsx</strong></td>
                  <td><span class="badge badge-green">Excel</span></td>
                  <td style="font-size:12px">248 KB</td>
                  <td style="font-size:12px">2024-01-15 14:22</td>
                  <td><div class="actions">
                    <button class="btn btn-xs btn-outline" onclick="demo()"><span class="icon-inline small">👁️</span>Ver</button>
                    <button class="btn btn-xs btn-primary" onclick="demo()"><span class="icon-inline small">⬇️</span>Descargar</button>
                    <button class="btn-icon danger" onclick="demo()">🗑️</button>
                  </div></td>
                </tr>
                <tr>
                  <td><span class="icon-inline small">📄</span><strong>Reporte_Q4_2023.pdf</strong></td>
                  <td><span class="badge badge-red">PDF</span></td>
                  <td style="font-size:12px">1.2 MB</td>
                  <td style="font-size:12px">2024-01-10 09:30</td>
                  <td><div class="actions">
                    <button class="btn btn-xs btn-outline" onclick="demo()"><span class="icon-inline small">👁️</span>Ver</button>
                    <button class="btn btn-xs btn-primary" onclick="demo()"><span class="icon-inline small">⬇️</span>Descargar</button>
                    <button class="btn-icon danger" onclick="demo()">🗑️</button>
                  </div></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- DESCARGAS -->
        <div id="rtab-descargas" style="display:none">
          <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:14px">
            <div class="calc-panel">
              <h3><span class="section-icon">📦</span>Inventario Actual</h3>
              <p style="font-size:12px;color:var(--text-muted);margin-bottom:16px">Exportar lista completa de insumos con stock y precios</p>
              <div style="display:flex;gap:8px;flex-wrap:wrap">
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📊</span>Excel</button>
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📋</span>CSV</button>
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📄</span>PDF</button>
              </div>
            </div>
            <div class="calc-panel">
              <h3><span class="section-icon">📋</span>Lista de Recetas</h3>
              <p style="font-size:12px;color:var(--text-muted);margin-bottom:16px">Recetas activas con costos e insumos detallados</p>
              <div style="display:flex;gap:8px;flex-wrap:wrap">
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📊</span>Excel</button>
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📋</span>CSV</button>
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📄</span>PDF</button>
              </div>
            </div>
            <div class="calc-panel">
              <h3><span class="section-icon">🚚</span>Historial de Envíos</h3>
              <p style="font-size:12px;color:var(--text-muted);margin-bottom:16px">Todos los envíos con estados y montos</p>
              <div style="display:flex;gap:8px;flex-wrap:wrap">
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📊</span>Excel</button>
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📋</span>CSV</button>
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📄</span>PDF</button>
              </div>
            </div>
            <div class="calc-panel">
              <h3><span class="section-icon">🔍</span>Trazabilidad / Auditoría</h3>
              <p style="font-size:12px;color:var(--text-muted);margin-bottom:16px">Historial completo de cambios del sistema</p>
              <div style="display:flex;gap:8px;flex-wrap:wrap">
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📊</span>Excel</button>
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📋</span>CSV</button>
                <button class="btn btn-outline btn-sm" onclick="demo()"><span class="icon-inline small">📄</span>PDF</button>
              </div>
            </div>
            <div class="calc-panel">
              <h3><span class="section-icon">📊</span>Resumen de Métricas</h3>
              <p style="font-size:12px;color:var(--text-muted);margin-bottom:16px">KPIs y gráficos del sistema en un reporte ejecutivo</p>
              <div style="display:flex;gap:8px">
                <button class="btn btn-primary btn-sm" onclick="demo()"><span class="icon-inline small">📄</span>Descargar PDF</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /app -->

<!-- Modal Inventario -->
<div class="modal-overlay" id="modal-inv">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Agregar Insumo</div>
      <button class="modal-close" onclick="closeModal('modal-inv')">✕</button>
    </div>
    <div class="form-grid">
      <div class="field"><label>Nombre</label><input type="text" placeholder="Nombre del insumo"></div>
      <div class="field"><label>Categoría</label><select><option>Lácteos</option><option>Cereales</option><option>Proteínas</option><option>Vegetales</option><option>Bebidas</option><option>Condimentos</option><option>Grasas</option></select></div>
      <div class="field"><label>Cantidad</label><input type="number" placeholder="0"></div>
      <div class="field"><label>Unidad</label><select><option>kg</option><option>L</option><option>g</option><option>ml</option><option>u</option></select></div>
      <div class="field"><label>Stock Mínimo</label><input type="number" placeholder="0"></div>
      <div class="field"><label>Stock Máximo</label><input type="number" placeholder="0"></div>
      <div class="field"><label>Precio/Unidad</label><input type="number" placeholder="0.00"></div>
      <div class="field"><label>Vencimiento</label><input type="date"></div>
      <div class="field span2"><label>Proveedor</label><input type="text" placeholder="Nombre del proveedor"></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal('modal-inv')">Cancelar</button>
      <button class="btn btn-primary" onclick="demoModal()">Guardar Insumo</button>
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
