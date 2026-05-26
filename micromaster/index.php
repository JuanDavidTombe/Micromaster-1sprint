<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MicroMaster — Sistema de Gestión de Insumos Alimentarios</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&family=Fraunces:ital,wght@0,700;0,900;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<div id="auth-screen">
  <!-- Background atmosphere -->
  <div class="auth-hero-bg"></div>

  <!-- Navbar -->
  <nav class="landing-nav">
    <!-- 🏷️ Logo de la marca — para cambiarlo reemplaza el archivo assets/img/logo-micromaster.png -->
    <div class="landing-nav-logo">
      <img src="assets/img/WhatsApp Image 2025-07-07 at 2.53.03 PM.png" alt="MicroMaster" style="width:100px;height:100px;object-fit:contain;filter:drop-shadow(0 2px 6px rgba(0,0,0,0.4))">
      MicroMaster
    </div>

    <ul class="landing-nav-links">
      <li><a href="#" data-menu="tipos" onmouseover="toggleMegaMenu('tipos')">Tipos de industria</a></li>
      <li><a href="#" data-menu="productos" onmouseover="toggleMegaMenu('productos')">Productos</a></li>
      <li><a href="#" data-menu="modulos" onmouseover="toggleMegaMenu('modulos')">Módulos</a></li>
      <li><a href="#" data-menu="novedades" onmouseover="toggleMegaMenu('novedades')">Lo último</a></li>
    </ul>

    <div class="landing-nav-right">
      <button class="nav-link-right" onclick="showAuthModal('login')">Iniciar sesión</button>
      <button class="hero-btn-white" style="padding:9px 20px;font-size:13px" onclick="showAuthModal('register')">Comenzar</button>
    </div>
  </nav>

  <!-- ── MEGA MENÚ: Tipos de industria ── -->
  <div class="mega-menu-overlay" id="mega-tipos" onclick="closeMegaMenu()">
    <div class="mega-menu" onclick="event.stopPropagation()" style="align-items:flex-start">
      <div>
        <p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:16px">Industria alimentaria</p>
        <div class="mega-menu-links">
          <a class="mega-menu-link" data-key="restaurantes" href="#"><span class="icon-inline light">🍽️</span>Restaurantes</a>
          <a class="mega-menu-link" data-key="plantas" href="#"><span class="icon-inline light">🏭</span>Plantas de producción</a>
          <a class="mega-menu-link" data-key="panaderias" href="#"><span class="icon-inline light">🥐</span>Panaderías y pastelerías</a>
          <a class="mega-menu-link" data-key="cafeterias" href="#"><span class="icon-inline light">☕</span>Cafeterías y bebidas</a>
          <a class="mega-menu-link" data-key="hoteles" href="#"><span class="icon-inline light">🏨</span>Hoteles y catering</a>
          <a class="mega-menu-link" data-key="distribuidoras" href="#"><span class="icon-inline light">🛒</span>Distribuidoras de alimentos</a>
          <a class="mega-menu-sub" href="#">Ver todas las industrias →</a>
        </div>
      </div>
      <div style="flex:1;background:#f7f9fc;border-radius:12px;padding:24px;margin-left:20px">
        <div id="mega-tipos-panel">
          <p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:14px">¿Qué ofrecemos?</p>
          <div style="display:flex;flex-direction:column;gap:12px">
            <div class="mega-menu-feature" data-key="default">
              <span class="icon-inline">📦</span>
              <div><p style="font-weight:700;font-size:14px;color:#1a1a2e">Control de inventario en tiempo real</p><p style="font-size:12px;color:#2d4a6e">Monitorea tus insumos, fechas de vencimiento y stock mínimo desde cualquier dispositivo.</p></div>
            </div>
            <div class="mega-menu-feature" data-key="default">
              <span class="icon-inline">📋</span>
              <div><p style="font-weight:700;font-size:14px;color:#1a1a2e">Gestión de recetas y costos</p><p style="font-size:12px;color:#2d4a6e">Calcula el costo exacto de cada producto terminado con los precios actualizados de tus insumos.</p></div>
            </div>
            <div class="mega-menu-feature" data-key="default">
              <span class="icon-inline">🚚</span>
              <div><p style="font-weight:700;font-size:14px;color:#1a1a2e">Trazabilidad de envíos</p><p style="font-size:12px;color:#2d4a6e">Registra y rastrea cada despacho hacia clientes, hoteles y distribuidoras.</p></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ── MEGA MENÚ: Productos ── -->
  <div class="mega-menu-overlay" id="mega-productos" onclick="closeMegaMenu()">
    <div class="mega-menu" onclick="event.stopPropagation()" style="align-items:flex-start">
      <div>
        <p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:16px">Herramientas del sistema</p>
        <div class="mega-menu-links">
          <a class="mega-menu-link" onclick="closeMegaMenu()"><span class="icon-inline light">📦</span>Inventario inteligente</a>
          <a class="mega-menu-link" onclick="closeMegaMenu()"><span class="icon-inline light">📋</span>Gestión de recetas</a>
          <a class="mega-menu-link" onclick="closeMegaMenu()"><span class="icon-inline light">🚚</span>Control de envíos</a>
          <a class="mega-menu-link" onclick="closeMegaMenu()"><span class="icon-inline light">🧮</span>Calculadora de costos</a>
          <a class="mega-menu-link" onclick="closeMegaMenu()"><span class="icon-inline light">📈</span>Simulador financiero</a>
          <a class="mega-menu-link" onclick="closeMegaMenu()"><span class="icon-inline light">📊</span>Reportes y auditoría</a>
        </div>
      </div>
      <div style="flex:1;background:#f7f9fc;border-radius:12px;padding:24px;margin-left:20px">
        <p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:14px">Nuestro diferencial</p>
        <p style="font-size:13px;color:#2d4a6e;line-height:1.7">MicroMaster integra todos los procesos de tu negocio alimentario en una sola plataforma: desde la compra de insumos hasta la entrega al cliente final. Sin hojas de cálculo, sin pérdidas de información.</p>
        <div style="margin-top:16px;padding:14px;background:#E6F1FB;border-radius:8px;border-left:3px solid #185FA5">
          <p style="font-size:12px;font-weight:700;color:#185FA5"><span class="icon-inline small">✅</span>Incluido en todos los planes</p>
          <p style="font-size:12px;color:#2d4a6e;margin-top:4px">Soporte técnico, actualizaciones y capacitación sin costo adicional.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- ── MEGA MENÚ: Módulos ── -->
  <div class="mega-menu-overlay" id="mega-modulos" onclick="closeMegaMenu()">
    <div class="mega-menu" onclick="event.stopPropagation()" style="gap:20px;align-items:flex-start">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;flex:1">
        <div style="padding:16px;border:1px solid #e0e8f0;border-radius:10px;cursor:pointer" onclick="closeMegaMenu()">
          <span class="icon-inline">📦</span>
          <p style="font-weight:800;font-size:14px;margin:8px 0 4px">Inventario</p>
          <p style="font-size:12px;color:#2d4a6e">CRUD de insumos, alertas de stock y vencimiento, categorías por tipo de alimento.</p>
        </div>
        <div style="padding:16px;border:1.5px solid #e0e8f0;border-radius:10px;cursor:pointer" onclick="closeMegaMenu()">
          <span class="icon-inline">📋</span>
          <p style="font-weight:800;font-size:14px;margin:8px 0 4px">Recetas</p>
          <p style="font-size:12px;color:#2d4a6e">Vincula insumos a recetas, calcula costos automáticos y gestiona fichas técnicas.</p>
        </div>
        <div style="padding:16px;border:1.5px solid #e0e8f0;border-radius:10px;cursor:pointer" onclick="closeMegaMenu()">
          <span class="icon-inline">🚚</span>
          <p style="font-weight:800;font-size:14px;margin:8px 0 4px">Envíos</p>
          <p style="font-size:12px;color:#2d4a6e">Despachos a clientes con trazabilidad completa, actualización de stock automática.</p>
        </div>
        <div style="padding:16px;border:1.5px solid #e0e8f0;border-radius:10px;cursor:pointer" onclick="closeMegaMenu()">
          <span class="icon-inline">📊</span>
          <p style="font-weight:800;font-size:14px;margin:8px 0 4px">Reportes</p>
          <p style="font-size:12px;color:#2d4a6e">Gráficos de KPIs, historial de cambios, exportación a Excel y PDF.</p>
        </div>
      </div>
    </div>
  </div>


  <!-- ── MEGA MENÚ: Lo último ── -->
  <div class="mega-menu-overlay" id="mega-novedades" onclick="closeMegaMenu()">
    <div class="mega-menu" onclick="event.stopPropagation()" style="align-items:flex-start;gap:32px">
      <div style="flex:1">
        <p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:16px">Últimas actualizaciones</p>
        <div style="display:flex;flex-direction:column;gap:14px">
          <div style="padding-bottom:14px;border-bottom:1px solid #e0e8f0;cursor:pointer" onclick="closeMegaMenu()">
            <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#185FA5;background:#E6F1FB;padding:2px 8px;border-radius:10px">Nuevo — Abr 2026</span>
            <p style="font-weight:700;font-size:14px;margin:6px 0 2px">Módulo de trazabilidad avanzada</p>
            <p style="font-size:12px;color:#2d4a6e">Rastrea cada insumo desde el proveedor hasta el producto terminado con código QR.</p>
          </div>
          <div style="padding-bottom:14px;border-bottom:1px solid #e0e8f0;cursor:pointer" onclick="closeMegaMenu()">
            <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#0F6E56;background:#e0f2ed;padding:2px 8px;border-radius:10px">Mejora — Mar 2026</span>
            <p style="font-weight:700;font-size:14px;margin:6px 0 2px">Alertas automáticas de vencimiento</p>
            <p style="font-size:12px;color:#2d4a6e">Notificaciones por correo cuando un insumo está próximo a vencer o el stock baja del mínimo.</p>
          </div>
          <div style="cursor:pointer" onclick="closeMegaMenu()">
            <span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;color:#BA7517;background:#fdf3e0;padding:2px 8px;border-radius:10px">Próximamente</span>
            <p style="font-weight:700;font-size:14px;margin:6px 0 2px">Integración con proveedores ERP</p>
            <p style="font-size:12px;color:#2d4a6e">Conexión directa con sistemas de proveedores para actualización automática de precios e inventario.</p>
          </div>
        </div>
      </div>
      <div style="width:240px;background:#1a1a2e;border-radius:12px;padding:22px;color:#fff">
        <p style="font-size:12px;color:rgba(255,255,255,0.5);margin-bottom:12px;font-weight:600">PRÓXIMAS FUNCIONES</p>
        <p class="list-feature" style="font-size:13px;color:rgba(255,255,255,0.8);margin-bottom:6px"><span class="icon-inline small">🤖</span>IA para predicción de compras</p>
        <p class="list-feature" style="font-size:13px;color:rgba(255,255,255,0.8);margin-bottom:6px"><span class="icon-inline small">📱</span>App móvil iOS y Android</p>
        <p class="list-feature" style="font-size:13px;color:rgba(255,255,255,0.8);margin-bottom:6px"><span class="icon-inline small">🔔</span>Notificaciones push</p>
        <p class="list-feature" style="font-size:13px;color:rgba(255,255,255,0.8);margin-bottom:16px"><span class="icon-inline small">🌐</span>Multi-sucursal / multi-sede</p>
        <button onclick="closeMegaMenu()" style="width:100%;padding:10px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);border-radius:8px;color:#fff;font-size:12px;font-weight:600;cursor:pointer">Suscribirse a novedades</button>
      </div>
    </div>
  </div>

  <!-- Hero -->
  <div class="landing-hero">
    <div class="landing-hero-title">
      Leyenda local o líder industrial.<br>Lleva tu negocio<br>alimentario al siguiente nivel.
    </div>
    <div class="landing-hero-btns">
      <button class="hero-btn-white" onclick="showAuthModal('register')">Comenzar gratis</button>
      <button class="hero-btn-blue" onclick="showAuthModal('login')">Iniciar sesión</button>
    </div>

    <!-- Brand strip -->
    <div class="brand-strip">
      <span class="brand-strip-item"><span class="icon-pill">🍽️</span>Restaurantes</span>
      <span class="brand-strip-item"><span class="icon-pill">🏭</span>Plantas de alimentos</span>
      <span class="brand-strip-item"><span class="icon-pill">🥐</span>Panaderías</span>
      <span class="brand-strip-item"><span class="icon-pill">☕</span>Cafeterías</span>
      <span class="brand-strip-item"><span class="icon-pill">🏨</span>Catering y hoteles</span>
      <span class="brand-strip-item"><span class="icon-pill">🛒</span>Distribuidoras</span>
      <span class="brand-strip-item"><span class="icon-pill">🍦</span>Heladerías</span>
    </div>
  </div>

  <!-- Floating welcome card -->
  <div class="welcome-float" id="welcome-float">
    <div class="welcome-card">
      <button class="welcome-close" onclick="hideWelcome()" aria-label="Cerrar bienvenida">✕</button>
      <h3>¡Bienvenido!</h3>
      <p>Parece que te interesa MicroMaster. ¿Cómo podemos ayudarte hoy?</p>
      <button class="welcome-option" onclick="showAuthModal('register')">Quiero registrarme ahora</button>
      <button class="welcome-option" onclick="showAuthModal('login')">Ya tengo una cuenta</button>
      <button class="welcome-option" onclick="enterApp()">Explorar el sistema (Demo)</button>
    </div>
    <button class="welcome-float-btn" id="welcome-float-btn" onclick="restoreWelcome()" aria-label="Abrir bienvenida">💬</button>
  </div>

  <!-- Modal de Autenticación (Login / Registro) -->
  <div class="modal-overlay" id="modal-auth" style="z-index:200">
    <div class="modal" style="width:460px;max-height:92vh">
      <div class="modal-header">
        <div class="modal-title" id="auth-modal-title" style="font-size:18px">Iniciar Sesión</div>
        <button class="modal-close" onclick="closeModal('modal-auth')">✕</button>
      </div>
      <!-- Tabs -->
      <div style="display:flex;gap:4px;background:var(--bg);border-radius:10px;padding:4px;margin-bottom:22px">
        <button id="auth-tab-login" onclick="switchAuthMode('login')" style="flex:1;padding:9px;border:none;background:var(--white);border-radius:7px;font-family:DM Sans,sans-serif;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 2px 6px rgba(0,0,0,0.07);transition:all 0.2s">Iniciar Sesión</button>
        <button id="auth-tab-register" onclick="switchAuthMode('register')" style="flex:1;padding:9px;border:none;background:transparent;border-radius:7px;font-family:DM Sans,sans-serif;font-size:13px;font-weight:600;color:var(--text-muted);cursor:pointer;transition:all 0.2s">Registrarse</button>
      </div>

      <!-- LOGIN FORM -->
      <div id="auth-form-login">
        <div style="margin-bottom:14px">
          <label style="display:block;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px">Correo electrónico</label>
          <input type="email" value="admin@micromaster.com" style="width:100%;padding:12px 13px;border:1.5px solid var(--border);border-radius:10px;font-family:DM Sans,sans-serif;font-size:14px;color:var(--black);background:var(--bg);outline:none">
        </div>
        <div style="margin-bottom:22px">
          <label style="display:block;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px">Contraseña</label>
          <input type="password" value="admin123" style="width:100%;padding:12px 13px;border:1.5px solid var(--border);border-radius:10px;font-family:DM Sans,sans-serif;font-size:14px;color:var(--black);background:var(--bg);outline:none">
        </div>
        <button onclick="enterApp()" style="width:100%;padding:13px;background:var(--primary);color:#fff;border:none;border-radius:10px;font-family:DM Sans,sans-serif;font-size:15px;font-weight:700;cursor:pointer;margin-bottom:10px">Ingresar al sistema</button>
        <button onclick="enterApp()" style="width:100%;padding:11px;background:transparent;color:var(--primary);border:1.5px solid var(--border);border-radius:10px;font-family:DM Sans,sans-serif;font-size:14px;font-weight:600;cursor:pointer"><span class="icon-inline small">⚡</span>Acceso Demo</button>
        <p style="text-align:center;margin-top:14px;font-size:12px;color:var(--text-muted)">¿No tienes cuenta? <a href="#" onclick="switchAuthMode('register')" style="color:var(--primary);font-weight:700;text-decoration:none">Regístrate gratis</a></p>
      </div>

      <!-- REGISTER FORM -->
      <div id="auth-form-register" style="display:none">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px">
          <div>
            <label style="display:block;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px">Nombre</label>
            <input type="text" placeholder="Tu nombre" style="width:100%;padding:11px 13px;border:1.5px solid var(--border);border-radius:10px;font-family:DM Sans,sans-serif;font-size:13px;color:var(--black);background:var(--bg);outline:none">
          </div>
          <div>
            <label style="display:block;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px">Apellido</label>
            <input type="text" placeholder="Tu apellido" style="width:100%;padding:11px 13px;border:1.5px solid var(--border);border-radius:10px;font-family:DM Sans,sans-serif;font-size:13px;color:var(--black);background:var(--bg);outline:none">
          </div>
        </div>
        <div style="margin-bottom:12px">
          <label style="display:block;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px">Tipo de negocio</label>
          <select style="width:100%;padding:11px 13px;border:1.5px solid var(--border);border-radius:10px;font-family:DM Sans,sans-serif;font-size:13px;color:var(--black);background:var(--bg);outline:none">
            <option>Restaurante</option>
            <option>Planta de producción de alimentos</option>
            <option>Panadería / Pastelería</option>
            <option>Cafetería / Bebidas</option>
            <option>Hotel / Catering</option>
            <option>Distribuidora de alimentos</option>
            <option>Heladería / Snacks</option>
            <option>Otro</option>
          </select>
        </div>
        <div style="margin-bottom:12px">
          <label style="display:block;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px">Correo electrónico</label>
          <input type="email" placeholder="tu@empresa.com" style="width:100%;padding:11px 13px;border:1.5px solid var(--border);border-radius:10px;font-family:DM Sans,sans-serif;font-size:13px;color:var(--black);background:var(--bg);outline:none">
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px">
          <div>
            <label style="display:block;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px">Contraseña</label>
            <input type="password" placeholder="Mín. 8 caracteres" style="width:100%;padding:11px 13px;border:1.5px solid var(--border);border-radius:10px;font-family:DM Sans,sans-serif;font-size:13px;color:var(--black);background:var(--bg);outline:none">
          </div>
          <div>
            <label style="display:block;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px">Confirmar contraseña</label>
            <input type="password" placeholder="Repite tu contraseña" style="width:100%;padding:11px 13px;border:1.5px solid var(--border);border-radius:10px;font-family:DM Sans,sans-serif;font-size:13px;color:var(--black);background:var(--bg);outline:none">
          </div>
        </div>
        <div style="margin-bottom:20px">
          <label style="display:block;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px">Rol en la empresa</label>
          <select style="width:100%;padding:11px 13px;border:1.5px solid var(--border);border-radius:10px;font-family:DM Sans,sans-serif;font-size:13px;color:var(--black);background:var(--bg);outline:none">
            <option>Administrador</option>
            <option>Supervisor</option>
            <option>Operador</option>
          </select>
        </div>
        <button onclick="enterApp()" style="width:100%;padding:13px;background:var(--primary);color:#fff;border:none;border-radius:10px;font-family:DM Sans,sans-serif;font-size:15px;font-weight:700;cursor:pointer;margin-bottom:10px">Crear cuenta gratuita</button>
        <p style="text-align:center;font-size:12px;color:var(--text-muted)">¿Ya tienes cuenta? <a href="#" onclick="switchAuthMode('login')" style="color:var(--primary);font-weight:700;text-decoration:none">Inicia sesión</a></p>
      </div>
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
