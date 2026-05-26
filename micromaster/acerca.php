<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MicroMaster — Acerca de</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/main.css">

<style>
    .sidebar { width: 260px; min-height: 100vh; padding: 8px 10px; background: #08101f; color: rgba(255,255,255,.92); display: flex; flex-direction: column; gap: 2px; }
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
    <a class="nav-item active" href="acerca.php">
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
      <div class="page-title" id="topbar-title">Acerca de</div>
      <div class="topbar-right">
        <div class="topbar-date" id="topbar-date"></div>
      </div>
    </div>

    <div class="content">

      <div class="page active" id="page-acerca">
        <div class="section-divider"><h3>ℹ️ Acerca de MicroMaster</h3></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">

          <!-- Info del programa -->
          <div style="background:var(--white);border:1.5px solid var(--border);border-radius:14px;padding:24px">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
              <div style="width:44px;height:44px;background:var(--primary);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;font-family:Fraunces,serif;font-weight:900">M</div>
              <div>
                <p style="font-weight:900;font-size:16px;color:var(--black)">MicroMaster v2.0</p>
                <p style="font-size:12px;color:var(--text-muted)">Sistema de Gestión de Insumos Alimentarios</p>
              </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:16px">
              <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 0;border-bottom:1px solid var(--bg)">
                <span style="color:var(--text-muted);font-weight:600">Versión actual</span>
                <span style="font-family:DM Mono,monospace;font-weight:700">2.0.1 — Abr 2026</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 0;border-bottom:1px solid var(--bg)">
                <span style="color:var(--text-muted);font-weight:600">Licencia</span>
                <span style="font-weight:700">Plan Pro — Activo</span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 0;border-bottom:1px solid var(--bg)">
                <span style="color:var(--text-muted);font-weight:600">Próxima actualización</span>
                <span style="font-weight:700;color:var(--teal)">Mayo 2026 <span class="icon-inline small">✅</span></span>
              </div>
              <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 0">
                <span style="color:var(--text-muted);font-weight:600">Soporte técnico</span>
                <span style="font-weight:700">Lun–Vie 8am–6pm</span>
              </div>
            </div>
            <div style="background:var(--primary-light);border-radius:10px;padding:14px">
              <p style="font-size:12px;font-weight:700;color:var(--primary);margin-bottom:4px"><span class="icon-inline small">📧</span>Contáctanos</p>
              <p style="font-size:12px;color:var(--text-muted);margin-bottom:2px">soporte@micromaster.co</p>
              <p style="font-size:12px;color:var(--text-muted);margin-bottom:2px">ventas@micromaster.co</p>
              <p style="font-size:12px;color:var(--text-muted)">info@micromaster.co</p>
            </div>
          </div>

          <!-- Equipo de desarrollo + próximas actualizaciones -->
          <div style="display:flex;flex-direction:column;gap:14px">
            <div style="background:var(--white);border:1.5px solid var(--border);border-radius:14px;padding:20px">
              <p style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);margin-bottom:12px">👨‍💻 Equipo de desarrollo</p>
              <div style="display:flex;flex-direction:column;gap:8px">
                <div style="display:flex;align-items:center;gap:10px">
                  <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--primary),#3a8fdf);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:900;color:#fff;flex-shrink:0">JT</div>
                  <div>
                    <p style="font-size:13px;font-weight:700">Juan David Tombe</p>
                    <p style="font-size:11px;color:var(--text-muted)">Líder · Arquitecto de Software · juandtombe@micromaster.co</p>
                  </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px">
                  <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--teal),#22a87e);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:900;color:#fff;flex-shrink:0">KM</div>
                  <div>
                    <p style="font-size:13px;font-weight:700">Kevin Jesús Millán</p>
                    <p style="font-size:11px;color:var(--text-muted)">Programador Full Stack · kevinmillan@micromaster.co</p>
                  </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px">
                  <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--amber),#e09a20);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:900;color:#fff;flex-shrink:0">DB</div>
                  <div>
                    <p style="font-size:13px;font-weight:700">Deiby Anderson Vitonco</p>
                    <p style="font-size:11px;color:var(--text-muted)">Programador Backend · deibybitonco@micromaster.co</p>
                  </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px">
                  <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#3d4a6b,#5e718d);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:900;color:#fff;flex-shrink:0">MP</div>
                  <div>
                    <p style="font-size:13px;font-weight:700">María Camila Palechor</p>
                    <p style="font-size:11px;color:var(--text-muted)">Frontend / UI·UX · mcamilapalechor@micromaster.co</p>
                  </div>
                </div>
              </div>
            </div>

            <div style="background:var(--primary-dark);border-radius:14px;padding:20px;color:#fff">
              <p style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:rgba(255,255,255,0.5);margin-bottom:12px"><span class="section-icon">🚀</span>Próximas actualizaciones</p>
              <div style="display:flex;flex-direction:column;gap:8px">
                <div style="display:flex;justify-content:space-between;align-items:center">
                  <p class="list-feature" style="font-size:13px"><span class="icon-inline small">📱</span>App móvil (iOS / Android)</p>
                  <span style="font-size:10px;background:rgba(255,255,255,0.1);padding:2px 8px;border-radius:10px;color:rgba(255,255,255,0.6)">Mayo 2026</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center">
                  <p class="list-feature" style="font-size:13px"><span class="icon-inline small">🤖</span>IA para predicción de compras</p>
                  <span style="font-size:10px;background:rgba(255,255,255,0.1);padding:2px 8px;border-radius:10px;color:rgba(255,255,255,0.6)">Jul 2026</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center">
                  <p class="list-feature" style="font-size:13px"><span class="icon-inline small">🌐</span>Gestión multi-sucursal</p>
                  <span style="font-size:10px;background:rgba(255,255,255,0.1);padding:2px 8px;border-radius:10px;color:rgba(255,255,255,0.6)">Sep 2026</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center">
                  <p class="list-feature" style="font-size:13px"><span class="icon-inline small">📦</span>Integración con proveedores ERP</p>
                  <span style="font-size:10px;background:rgba(255,255,255,0.1);padding:2px 8px;border-radius:10px;color:rgba(255,255,255,0.6)">Nov 2026</span>
                </div>
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
