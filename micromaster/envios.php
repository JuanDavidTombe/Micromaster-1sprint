<?php
// envios.php - INICIO DEL ARCHIVO: Cargar datos desde phpMyAdmin
require_once 'conexion.php';

try {
    // Consultamos todos los pedidos en la base de datos
    $stmt = $pdo->query("SELECT * FROM pedidos ORDER BY id_pedido DESC");
    $listaPedidos = $stmt->fetchAll();
} catch (Exception $e) {
    $listaPedidos = []; // Si falla, inicializamos el arreglo vacío para no romper la página
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MicroMaster — Envíos</title>
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
    <a class="nav-item" href="inventario.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><path d="M4 7.5L12 3l8 4.5v9L12 21 4 16.5v-9z" /><path d="M12 3v18" /><path d="M4 7.5l8 4.5 8-4.5" /></svg></span>
      <span>Inventario</span>
    </a>
    <a class="nav-item" href="recetas.php">
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><path d="M8 4h8a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z" /><path d="M8 8h8" /><path d="M12 12h4" /><path d="M12 16h4" /></svg></span>
      <span>Recetas</span>
    </a>
    <a class="nav-item active" href="envios.php">
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
      <span class="nav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22" style="display: block;"><circle cx="12" cy="12" r="3" /><line x1="19.4" y1="15" x2="21" y2="15" /><line x1="3" y1="15" x2="4.6" y2="15" /><line x1("M4,7.5 L1,3 L9,7.5 L9,7.5 L9,7.5 L9,7.5 " /></svg></span>
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
    <div class="main">
      <div class="topbar">
        <div class="page-title">Envíos</div>
        <div class="topbar-right"><div class="topbar-date" id="topbar-date"></div></div>
      </div>
      <div class="content">
        <div class="page active" id="page-envios">
          <div class="stats-row" style="margin-bottom:16px">
            <div class="stat-card"><div class="stat-label">Rutas Activas</div><div class="stat-value blue">3</div><div class="stat-sub">en tránsito</div></div>
            <div class="stat-card"><div class="stat-label">Conductores</div><div class="stat-value green">3</div><div class="stat-sub">en línea</div></div>
            <div class="stat-card"><div class="stat-label">Pedidos Hoy</div><div class="stat-value">9</div><div class="stat-sub">total del día</div></div>
            <div class="stat-card"><div class="stat-label">Entregados</div><div class="stat-value green">4</div><div class="stat-sub">completados</div></div>
            <div class="stat-card"><div class="stat-label">Pendientes</div><div class="stat-value amber">3</div><div class="stat-sub">en espera</div></div>
            <div class="stat-card"><div class="stat-label">En Ruta</div><div class="stat-value blue">2</div><div class="stat-sub">despachados</div></div>
          </div>
          <div style="display:grid;grid-template-columns:240px 1fr;gap:14px;margin-bottom:14px">
            <div style="background:var(--white);border:1.5px solid var(--border);border-radius:16px;padding:18px;display:flex;flex-direction:column;gap:10px">
              <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);margin-bottom:4px">Control de Flotas</div>
              <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:#f0faf5;border-radius:10px;border:1px solid #b6e8cf">
                <div style="display:flex;align-items:center;gap:8px"><div style="width:10px;height:10px;border-radius:50%;background:#16a34a;flex-shrink:0"></div><div><p style="font-size:12px;font-weight:700;color:#14532d">Ruta Norte</p><p style="font-size:10px;color:#166534">Carlos M. · TXK-2241</p></div></div>
                <label style="cursor:pointer;position:relative;display:inline-block;width:34px;height:18px"><input type="checkbox" id="toggle-ruta-verde" checked onchange="toggleRuta('verde',this.checked)" style="opacity:0;width:0;height:0"><span id="track-verde" style="position:absolute;inset:0;background:#16a34a;border-radius:9px;transition:all 0.3s"></span><span id="thumb-verde" style="position:absolute;top:2px;left:2px;width:14px;height:14px;background:#fff;border-radius:50%;transition:transform 0.3s;transform:translateX(16px)"></span></label>
              </div>
              <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:#eff6ff;border-radius:10px;border:1px solid #bfdbfe">
                <div style="display:flex;align-items:center;gap:8px"><div style="width:10px;height:10px;border-radius:50%;background:#2563eb;flex-shrink:0"></div><div><p style="font-size:12px;font-weight:700;color:#1e3a8a">Ruta Suroeste</p><p style="font-size:10px;color:#1d4ed8">Andrés V. · PCY-8819</p></div></div>
                <label style="cursor:pointer;position:relative;display:inline-block;width:34px;height:18px"><input type="checkbox" id="toggle-ruta-azul" checked onchange="toggleRuta('azul',this.checked)" style="opacity:0;width:0;height:0"><span id="track-azul" style="position:absolute;inset:0;background:#2563eb;border-radius:9px;transition:all 0.3s"></span><span id="thumb-azul" style="position:absolute;top:2px;left:2px;width:14px;height:14px;background:#fff;border-radius:50%;transition:transform 0.3s;transform:translateX(16px)"></span></label>
              </div>
              <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:#fff7ed;border-radius:10px;border:1px solid #fed7aa">
                <div style="display:flex;align-items:center;gap:8px"><div style="width:10px;height:10px;border-radius:50%;background:#ea580c;flex-shrink:0"></div><div><p style="font-size:12px;font-weight:700;color:#7c2d12">Ruta Sur</p><p style="font-size:10px;color:#c2410c">Diana R. · NVQ-5530</p></div></div>
                <label style="cursor:pointer;position:relative;display:inline-block;width:34px;height:18px"><input type="checkbox" id="toggle-ruta-naranja" checked onchange="toggleRuta('naranja',this.checked)" style="opacity:0;width:0;height:0"><span id="track-naranja" style="position:absolute;inset:0;background:#ea580c;border-radius:9px;transition:all 0.3s"></span><span id="thumb-naranja" style="position:absolute;top:2px;left:2px;width:14px;height:14px;background:#fff;border-radius:50%;transition:transform 0.3s;transform:translateX(16px)"></span></label>
              </div>
            </div>
            <div style="background:#e8f0e4;border-radius:16px;border:1.5px solid var(--border);position:relative;overflow:hidden;min-height:460px;display:block;width:100%;box-sizing:border-box">
              <div id="map-tooltip" style="display:none;position:absolute;z-index:50;width:280px;background:rgba(255,255,255,0.92);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.7);border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,0.2);padding:16px;pointer-events:none;transition:all 0.2s">
                <button onclick="closeTooltip()" style="position:absolute;top:10px;right:10px;background:rgba(0,0,0,0.08);border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;font-size:12px;pointer-events:all">✕</button>
                <div id="tt-header" style="margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid rgba(0,0,0,0.08)">
                  <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px">
                    <span id="tt-id" style="font-family:'DM Mono',monospace;font-size:11px;font-weight:700;color:var(--primary)"></span>
                    <span id="tt-badge" style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px"></span>
                  </div>
                  <p id="tt-address" style="font-size:12px;color:var(--text-muted)"></p>
                </div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
                  <div id="tt-avatar" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:900;color:#fff;flex-shrink:0"></div>
                  <div>
                    <p id="tt-conductor" style="font-size:12px;font-weight:700;color:var(--black)"></p>
                    <p id="tt-placa" style="font-size:11px;color:var(--text-muted)"></p>
                    <p id="tt-tel" style="font-size:11px;color:var(--primary)"></p>
                  </div>
                  <div style="margin-left:auto;text-align:right">
                    <p style="font-size:10px;color:var(--text-muted)">ETA</p>
                    <p id="tt-eta" style="font-size:14px;font-weight:800;color:var(--teal)"></p>
                  </div>
                </div>
                <div>
                  <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:6px">Carga del pedido</p>
                  <div id="tt-carga" style="max-height:80px;overflow-y:auto;display:flex;flex-direction:column;gap:3px"></div>
                </div>
              </div>
              <svg id="mapa-popayan" width="100%" viewBox="0 0 700 460" xmlns="http://www.w3.org/2000/svg" style="display:block">
                <defs>
                  <style>
                    @keyframes pulse-truck { 0%,100%{opacity:1} 50%{opacity:0.4} }
                  </style>
                  <filter id="shadow-map" x="-20%" y="-20%" width="140%" height="140%">
                    <feDropShadow dx="0" dy="2" stdDeviation="3" flood-opacity="0.2"/>
                  </filter>
                </defs>
                <rect width="700" height="460" fill="#e8f0e4"/>
                <ellipse cx="320" cy="195" rx="28" ry="18" fill="#c8ddb4" opacity="0.7"/>
                <rect x="180" y="80" width="45" height="30" rx="6" fill="#c8ddb4" opacity="0.5"/>
                <rect x="480" y="320" width="50" height="35" rx="6" fill="#c8ddb4" opacity="0.5"/>
                <rect x="110" y="340" width="60" height="40" rx="8" fill="#c8ddb4" opacity="0.5"/>
                <ellipse cx="560" cy="120" rx="35" ry="22" fill="#c8ddb4" opacity="0.4"/>
                <path d="M0 310 Q80 290 140 305 Q200 320 260 300 Q320 280 380 295 Q440 310 500 295 Q560 280 620 290 Q660 296 700 285" fill="none" stroke="#a0c4e8" stroke-width="8" stroke-linecap="round" opacity="0.7"/>
                <path d="M0 340 Q60 330 120 345 Q180 360 240 340" fill="none" stroke="#b8d4f0" stroke-width="5" stroke-linecap="round" opacity="0.5"/>
                <rect x="270" y="150" width="30" height="22" rx="2" fill="#ddd5c8" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="308" y="150" width="30" height="22" rx="2" fill="#ddd5c8" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="346" y="150" width="30" height="22" rx="2" fill="#ddd5c8" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="270" y="180" width="30" height="22" rx="2" fill="#ddd5c8" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="308" y="180" width="30" height="22" rx="2" fill="#ddd5c8" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="346" y="180" width="30" height="22" rx="2" fill="#ddd5c8" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="270" y="210" width="30" height="22" rx="2" fill="#ddd5c8" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="308" y="210" width="30" height="22" rx="2" fill="#ddd5c8" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="346" y="210" width="30" height="22" rx="2" fill="#ddd5c8" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="220" y="80" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="256" y="80" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="292" y="80" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="220" y="108" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="256" y="108" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="380" y="80" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="416" y="80" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="180" y="260" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="216" y="260" width="28" height="20" rx="2" fill="#c8ddb4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="150" y="290" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="186" y="290" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="360" y="260" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="396" y="260" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <rect x="360" y="288" width="28" height="20" rx="2" fill="#d8d0c4" stroke="#c9beb0" stroke-width="0.5"/>
                <line x1="322" y1="20" x2="322" y2="440" stroke="#fff" stroke-width="5" opacity="0.8"/>
                <line x1="255" y1="20" x2="255" y2="440" stroke="#fff" stroke-width="3" opacity="0.6"/>
                <path d="M200 20 Q185 120 175 200 Q165 280 155 380 Q148 420 140 460" stroke="#fff" stroke-width="4" fill="none" opacity="0.7"/>
                <line x1="20" y1="215" x2="680" y2="215" stroke="#fff" stroke-width="5" opacity="0.8"/>
                <line x1="20" y1="155" x2="680" y2="155" stroke="#fff" stroke-width="3" opacity="0.6"/>
                <path d="M20 270 Q100 265 200 272 Q300 278 400 268 Q500 258 680 265" stroke="#fff" stroke-width="3" fill="none" opacity="0.6"/>
                <path d="M420 20 Q450 100 470 180 Q490 260 510 340 Q525 390 540 460" stroke="#fff" stroke-width="4" fill="none" opacity="0.7"/>
                <text x="328" y="35" font-size="8" fill="#888" font-family="DM Sans,sans-serif" font-weight="600">Cr. 6</text>
                <text x="258" y="35" font-size="8" fill="#888" font-family="DM Sans,sans-serif" font-weight="600">Cr. 10</text>
                <text x="155" y="35" font-size="8" fill="#888" font-family="DM Sans,sans-serif" font-weight="600">Cr. 17</text>
                <text x="22" y="212" font-size="8" fill="#888" font-family="DM Sans,sans-serif" font-weight="600">Cl. 5</text>
                <text x="22" y="152" font-size="8" fill="#888" font-family="DM Sans,sans-serif" font-weight="600">Cl. 10</text>
                <text x="442" y="30" font-size="8" fill="#888" font-family="DM Sans,sans-serif" font-weight="600">Av. Panamericana</text>
                <text x="295" y="145" font-size="9" fill="#7a6a5a" font-family="DM Sans,sans-serif" font-weight="700" text-anchor="middle">Centro Histórico</text>
                <text x="260" y="100" font-size="8" fill="#8a7a6a" font-family="DM Sans,sans-serif">Belén</text>
                <text x="395" y="75" font-size="8" fill="#8a7a6a" font-family="DM Sans,sans-serif">Ciudad Jardín</text>
                <text x="165" y="255" font-size="8" fill="#8a7a6a" font-family="DM Sans,sans-serif">Puelenje</text>
                <text x="370" y="255" font-size="8" fill="#8a7a6a" font-family="DM Sans,sans-serif">San Camilo</text>
                <text x="540" y="110" font-size="8" fill="#8a7a6a" font-family="DM Sans,sans-serif">Lomas de Granada</text>
                <g id="ruta-verde">
                  <path id="path-verde" d="M322 195 Q322 160 322 120 Q322 90 380 75 Q420 65 450 55" fill="none" stroke="#16a34a" stroke-width="4" stroke-linecap="round" opacity="0.85"/>
                  <path d="M322 195 Q322 160 322 120 Q322 90 380 75 Q420 65 450 55" fill="none" stroke="#bbf7d0" stroke-width="2" stroke-linecap="round" stroke-dasharray="6 4" opacity="0.6"/>
                  <g class="map-pin" onclick="showTooltip(event,'ENV-V01','Hospital Univ. San José','En tránsito','Carlos Montoya','TXK-2241','311 452 8800','8 min','#16a34a','CJM',['Pan Francés 50u','Leche entera 20L','Café molido 5kg','Sal refinada 3kg'],322,120)" style="cursor:pointer">
                    <circle cx="322" cy="120" r="14" fill="#16a34a" stroke="#fff" stroke-width="2.5" filter="url(#shadow-map)"/>
                    <text x="322" y="125" font-size="11" fill="#fff" font-family="DM Sans,sans-serif" font-weight="700" text-anchor="middle">1</text>
                  </g>
                  <g class="map-pin" onclick="showTooltip(event,'ENV-V02','Cra 21 #4N-15 Ciudad Jardín','Entregado','Carlos Montoya','TXK-2241','311 452 8800','Entregado','#16a34a','CJM',['Aceite vegetal 10L','Zanahoria 15kg','Harina de trigo 8kg'],430,68)" style="cursor:pointer">
                    <circle cx="430" cy="68" r="14" fill="#16a34a" stroke="#fff" stroke-width="2.5" filter="url(#shadow-map)"/>
                    <text x="430" y="73" font-size="11" fill="#fff" font-family="DM Sans,sans-serif" font-weight="700" text-anchor="middle">2</text>
                  </g>
                  <circle class="truck-dot" cx="0" cy="0" r="7" fill="#16a34a" stroke="#fff" stroke-width="2" id="truck-verde">
                    <animateMotion dur="6s" repeatCount="indefinite" path="M322 195 Q322 160 322 120 Q322 90 380 75 Q420 65 450 55"/>
                  </circle>
                </g>
                <g id="ruta-azul">
                  <path d="M322 215 Q280 225 230 238 Q190 250 175 270 Q162 290 150 320" fill="none" stroke="#2563eb" stroke-width="4" stroke-linecap="round" opacity="0.85"/>
                  <path d="M322 215 Q280 225 230 238 Q190 250 175 270 Q162 290 150 320" fill="none" stroke="#bfdbfe" stroke-width="2" stroke-linecap="round" stroke-dasharray="6 4" opacity="0.6"/>
                  <g class="map-pin" onclick="showTooltip(event,'ENV-A01','Variante Puelenje Km 3','En tránsito','Andrés Valencia','PCY-8819','315 682 3300','15 min','#2563eb','AV',['Pollo entero 30kg','Aceite vegetal 15L','Sal refinada 8kg','Jugo naranja 20L'],215,240)" style="cursor:pointer">
                    <circle cx="215" cy="240" r="14" fill="#2563eb" stroke="#fff" stroke-width="2.5" filter="url(#shadow-map)"/>
                    <text x="215" y="245" font-size="11" fill="#fff" font-family="DM Sans,sans-serif" font-weight="700" text-anchor="middle">3</text>
                  </g>
                  <g class="map-pin" onclick="showTooltip(event,'ENV-A02','El Edén de mis Abuelos, Vía Variante','Pendiente','Andrés Valencia','PCY-8819','315 682 3300','32 min','#f59e0b','AV',['Harina trigo 20kg','Leche entera 30L','Levadura 2kg','Azúcar 10kg'],148,322)" style="cursor:pointer">
                    <circle cx="148" cy="322" r="14" fill="#f59e0b" stroke="#fff" stroke-width="2.5" filter="url(#shadow-map)"/>
                    <text x="148" y="327" font-size="11" fill="#fff" font-family="DM Sans,sans-serif" font-weight="700" text-anchor="middle">4</text>
                  </g>
                  <circle class="truck-dot" cx="0" cy="0" r="7" fill="#2563eb" stroke="#fff" stroke-width="2" style="animation-delay:2s">
                    <animateMotion dur="7s" repeatCount="indefinite" begin="2s" path="M322 215 Q280 225 230 238 Q190 250 175 270 Q162 290 150 320"/>
                  </circle>
                </g>
                <g id="ruta-naranja">
                  <path d="M322 215 Q355 225 375 248 Q392 265 395 290 Q398 310 395 335" fill="none" stroke="#ea580c" stroke-width="4" stroke-linecap="round" opacity="0.85"/>
                  <path d="M322 215 Q355 225 375 248 Q392 265 395 290 Q398 310 395 335" fill="none" stroke="#fed7aa" stroke-width="2" stroke-linecap="round" stroke-dasharray="6 4" opacity="0.6"/>
                  <g class="map-pin" onclick="showTooltip(event,'ENV-N01','Calle 2 #19-50 San Camilo','Entregado','Diana Rodríguez','NVQ-5530','312 904 6670','Entregado','#16a34a','DR',['Café molido 8kg','Agua mineral 50L','Azúcar 5kg'],385,268)" style="cursor:pointer">
                    <circle cx="385" cy="268" r="14" fill="#16a34a" stroke="#fff" stroke-width="2.5" filter="url(#shadow-map)"/>
                    <text x="385" y="273" font-size="11" fill="#fff" font-family="DM Sans,sans-serif" font-weight="700" text-anchor="middle">5</text>
                  </g>
                  <g class="map-pin" onclick="showTooltip(event,'ENV-N02','Cra 9 #6-38 Br. San Andrés','En tránsito','Diana Rodríguez','NVQ-5530','312 904 6670','18 min','#2563eb','DR',['Zanahoria 25kg','Aceite vegetal 8L','Harina trigo 12kg','Sal 4kg'],393,335)" style="cursor:pointer">
                    <circle cx="393" cy="335" r="14" fill="#2563eb" stroke="#fff" stroke-width="2.5" filter="url(#shadow-map)"/>
                    <text x="393" y="340" font-size="11" fill="#fff" font-family="DM Sans,sans-serif" font-weight="700" text-anchor="middle">6</text>
                  </g>
                  <circle class="truck-dot" cx="0" cy="0" r="7" fill="#ea580c" stroke="#fff" stroke-width="2" style="animation-delay:1s">
                    <animateMotion dur="5.5s" repeatCount="indefinite" begin="1s" path="M322 215 Q355 225 375 248 Q392 265 395 290 Q398 310 395 335"/>
                  </circle>
                </g>
                <g filter="url(#shadow-map)">
                  <circle cx="322" cy="195" r="20" fill="#1a1a2e" stroke="#fff" stroke-width="3"/>
                  <circle cx="322" cy="195" r="8" fill="#fff" opacity="0.2"/>
                  <polygon points="322,181 313,191 331,191" fill="#fff"/>
                  <rect x="315" y="191" width="14" height="10" fill="#fff" rx="1"/>
                  <rect x="318" y="196" width="8" height="5" fill="#1a1a2e" rx="1"/>
                </g>
                <circle cx="322" cy="195" r="26" fill="none" stroke="#1a1a2e" stroke-width="1.5" opacity="0.3">
                  <animate attributeName="r" from="20" to="34" dur="2s" repeatCount="indefinite"/>
                  <animate attributeName="opacity" from="0.4" to="0" dur="2s" repeatCount="indefinite"/>
                </circle>
                <rect x="220" y="222" width="135" height="20" rx="4" fill="rgba(26,26,46,0.85)"/>
                <text x="287" y="235" font-size="9" fill="#fff" font-family="DM Sans,sans-serif" font-weight="700" text-anchor="middle">Centro Dist. — Parque Caldas</text>
                <text x="600" y="440" font-size="8" fill="#888" font-family="DM Sans,sans-serif" text-anchor="middle">Popayán, Cauca</text>
                <text x="668" y="32" font-size="14" fill="#666" font-family="DM Sans,sans-serif" font-weight="700" text-anchor="middle">N</text>
                <line x1="668" y1="36" x2="668" y2="56" stroke="#666" stroke-width="1.5"/>
                <polygon points="668,36 664,50 668,45 672,50" fill="#666"/>
              </svg>
            </div>
          </div>
          <div style="background:var(--white);border:1.5px solid var(--border);border-radius:16px;overflow:hidden;display:block;width:100%;box-sizing:border-box">
            <div style="padding:16px 18px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px">
              <h3 style="font-family:Fraunces,serif;font-size:16px;font-weight:900;color:var(--black)">Módulo de Pedidos</h3>
              <div style="display:flex;gap:8px;flex-wrap:wrap">
                <div class="search-box" style="min-width:180px">
                  <span style="font-size:14px;color:#aab8cc">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                  </span>
                  <input type="text" id="pedidos-search" placeholder="Buscar pedido..." oninput="filtrarPedidos()" style="font-size:13px">
                </div>
                <button class="btn btn-sm" id="filter-todos" onclick="setFiltro('todos')" style="background:var(--primary);color:#fff;border-color:var(--primary)">Todos</button>
                <button class="btn btn-sm btn-outline" id="filter-ruta" onclick="setFiltro('ruta')">En ruta</button>
                <button class="btn btn-sm btn-outline" id="filter-pend" onclick="setFiltro('pendiente')">Pendientes</button>
                <button class="btn btn-sm btn-outline" id="filter-entregado" onclick="setFiltro('entregado')">Entregados</button>
                <button class="btn btn-primary btn-sm" onclick="openModal('modal-env')">+ Nuevo pedido</button>
              </div>
            </div>
            <div style="display:block;overflow:hidden;width:100%;box-sizing:border-box">
              <table id="pedidos-table" style="width:100%;border-collapse:collapse">
                <thead><tr style="background:#f7f9fc;border-bottom:1.5px solid var(--border)">
                  <th style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);padding:10px 14px;text-align:left">ID</th>
                  <th style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);padding:10px 14px;text-align:left">Destino</th>
                  <th style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);padding:10px 14px;text-align:left">Conductor</th>
                  <th style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);padding:10px 14px;text-align:left">Ruta</th>
                  <th style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);padding:10px 14px;text-align:left">Estado</th>
                  <th style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);padding:10px 14px;text-align:left">ETA</th>
                  <th style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);padding:10px 14px;text-align:left">Total</th>
                </tr></thead>
                <tbody id="pedidos-tbody">
  <?php if (!empty($listaPedidos)): ?>
    <?php foreach ($listaPedidos as $pedido): ?>
      <?php 
        // 🎨 Paleta de colores pastel unificada (Estilo Inventario)
        $badgeBg = '#ffedd5';    // Naranja pastel suave para Pendiente
        $badgeColor = '#c2410c'; // Texto naranja oscuro
        
        if ($pedido['estado'] === 'En tránsito') {
            $badgeBg = '#e0f2fe';    // Azul pastel suave
            $badgeColor = '#0369a1'; // Texto azul oscuro
        } else if ($pedido['estado'] === 'Entregado') {
            $badgeBg = '#dcfce7';    // Verde pastel suave
            $badgeColor = '#15803d'; // Texto verde oscuro
        }
      ?>
      <tr style="border-bottom: 1px solid var(--border);">
        <td style="padding:14px 16px; font-size:12px; font-weight:700; color:var(--primary); font-family:'DM Mono', monospace; text-align:left;"><?php echo htmlspecialchars($pedido['codigo_envio']); ?></td>
        <td style="padding:14px 16px; font-size:13px; font-weight:600; color:#1e293b; font-family:'DM Sans', sans-serif; text-align:left;"><?php echo htmlspecialchars($pedido['destino']); ?></td>
        <td style="padding:14px 16px; font-size:12px; color:var(--text-muted); font-family:'DM Sans', sans-serif; text-align:left;"><?php echo htmlspecialchars($pedido['conductor']); ?></td>
        <td style="padding:14px 16px; font-size:12px; font-family:'DM Sans', sans-serif; text-align:left;"><span style="padding:4px 8px; background:#f1f5f9; border-radius:6px; color:#475569; font-weight:500; font-size:11px;"><?php echo htmlspecialchars($pedido['ruta']); ?></span></td>
        <td style="padding:14px 16px; text-align:left;"><span style="display:inline-block; padding:4px 10px; border-radius:6px; background-color:<?php echo $badgeBg; ?>; color:<?php echo $badgeColor; ?>; font-size:11px; font-weight:700; font-family:'DM Sans', sans-serif; text-transform:uppercase; letter-spacing:0.5px;"><?php echo htmlspecialchars($pedido['estado']); ?></span></td>
        <td style="padding:14px 16px; font-size:12px; font-weight:600; color:#1e293b; font-family:'DM Sans', sans-serif; text-align:left;"><?php echo htmlspecialchars($pedido['eta']); ?></td>
        <td style="padding:14px 16px; font-size:13px; color:#1e293b; font-weight:700; font-family:'DM Sans', sans-serif; text-align:left;">$<?php echo number_format($pedido['total'], 2); ?></td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <!-- Mensaje de respaldo por si no hay registros -->
    <tr>
      <td colspan="7" style="padding:30px; text-align:center; color:var(--text-muted); font-family:'DM Sans', sans-serif; font-size:14px;">No hay envíos registrados en la base de datos.</td>
    </tr>
  <?php endif; ?>
</tbody>

              </table>
            </div>
          </div>
        </div>
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
        <div class="field span2"><label>Destino</label><input id="env-destino" type="text" placeholder="Nombre del cliente / establecimiento"></div>
        <div class="field"><label>Fecha Envío</label><input id="env-fecha" type="date"></div>
        <div class="field"><label>Estado Inicial</label><select id="env-estado"><option>Pendiente</option><option>En tránsito</option><option>Entregado</option></select></div>
        <div class="field span2"><label>Insumos a enviar</label><textarea id="env-insumos" placeholder="Ej: Leche 20L, Aceite 10L, Harina 5kg"></textarea></div>
        <div class="field"><label>Total Estimado ($)</label><input id="env-total" type="number" placeholder="0.00"></div>
        <div class="field"><label>Observaciones</label><input id="env-obs" type="text" placeholder="Notas adicionales"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('modal-env')">Cancelar</button>
        <button class="btn btn-primary" onclick="procesarNuevoPedido()">Crear Envío</button>
      </div>
    </div>
  </div>
  <div class="toast" id="toast"><span id="toast-icon" class="icon-inline small">✅</span><span id="toast-msg">Acción completada</span></div>
  
  <script src="assets/js/main.js"></script>
</body>
</html>
