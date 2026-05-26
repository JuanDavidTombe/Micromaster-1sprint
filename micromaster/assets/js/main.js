/* ============================================================
   MicroMaster — Lógica común (multipágina)
   ============================================================ */

// ── Topbar date ──
(function(){
  const el = document.getElementById('topbar-date');
  if (el) {
    el.textContent = new Date().toLocaleDateString('es-CO', {
      weekday: 'short', year: 'numeric', month: 'short', day: 'numeric'
    });
  }
})();

// ── Landing / Auth ──
function enterApp() {
  // Acceso Demo / Iniciar sesión → Dashboard
  window.location.href = 'dashboard.html';
}

function logout() {
  // Cerrar sesión → Landing
  window.location.href = 'index.html';
}

function showAuthModal(mode) {
  openModal('modal-auth');
  switchAuthMode(mode);
}

function switchAuthMode(mode) {
  const isLogin = mode === 'login';
  const formLogin = document.getElementById('auth-form-login');
  const formReg   = document.getElementById('auth-form-register');
  if (!formLogin || !formReg) return;
  formLogin.style.display = isLogin ? 'block' : 'none';
  formReg.style.display   = isLogin ? 'none'  : 'block';
  document.getElementById('auth-modal-title').textContent = isLogin ? 'Iniciar Sesión' : 'Crear cuenta';
  const tabLogin = document.getElementById('auth-tab-login');
  const tabReg   = document.getElementById('auth-tab-register');
  if (!tabLogin || !tabReg) return;
  tabLogin.style.background = isLogin ? 'var(--white)' : 'transparent';
  tabLogin.style.fontWeight = isLogin ? '700' : '600';
  tabLogin.style.color      = isLogin ? 'var(--black)' : 'var(--text-muted)';
  tabLogin.style.boxShadow  = isLogin ? '0 2px 6px rgba(0,0,0,0.07)' : 'none';
  tabReg.style.background   = !isLogin ? 'var(--white)' : 'transparent';
  tabReg.style.fontWeight   = !isLogin ? '700' : '600';
  tabReg.style.color        = !isLogin ? 'var(--black)' : 'var(--text-muted)';
  tabReg.style.boxShadow    = !isLogin ? '0 2px 6px rgba(0,0,0,0.07)' : 'none';
}

function hideWelcome() {
  const el = document.getElementById('welcome-float');
  if (el) el.classList.add('minimized');
}

function restoreWelcome() {
  const el = document.getElementById('welcome-float');
  if (el) el.classList.remove('minimized');
}

function toggleMegaMenu(id, e) {
  if (e) e.preventDefault();
  
  // Usa el nuevo sistema de contenedor unificado
  const container = document.getElementById('mega-menu-container');
  if (!container) return;
  
  // Oculta todos los panels
  document.querySelectorAll('.mega-menu-panel').forEach(p => p.classList.remove('active'));
  
  // Muestra el panel activo
  const panel = document.getElementById('panel-' + id);
  if (panel) {
    panel.classList.add('active');
    container.classList.add('open');
  }
  
  // Actualiza los estilos del nav
  const nav = document.querySelector('.landing-nav');
  if (nav) {
    if (panel) nav.classList.add('mega-open');
    else nav.classList.remove('mega-open');
  }
  
  // Actualiza el welcome card
  const welcome = document.getElementById('welcome-float');
  if (welcome && panel) welcome.classList.add('under-mega');
}

function closeMegaMenu() {
  const container = document.getElementById('mega-menu-container');
  if (container) container.classList.remove('open');
  const nav = document.querySelector('.landing-nav');
  if (nav) nav.classList.remove('mega-open');
  const welcome = document.getElementById('welcome-float');
  if (welcome) welcome.classList.remove('under-mega');
}

// ── UNIFIED MEGA MENU BEHAVIOR ──
(function() {
  // Solo ejecutar en página de inicio
  if (!document.querySelector('.landing-nav')) return;
  
  const hoverDelay = 200;
  let closeTimer = null;
  let lastInteraction = 0;
  const menuNames = ['tipos', 'productos', 'modulos', 'novedades'];

  // Create unified container
  const container = document.createElement('div');
  container.className = 'mega-menu-container';
  container.id = 'mega-menu-container';
  const landingHero = document.querySelector('.landing-hero');
  if (landingHero && landingHero.parentNode) {
    landingHero.parentNode.insertBefore(container, landingHero);
  } else {
    document.body.appendChild(container);
  }

  // Create panels from existing overlays
  menuNames.forEach(name => {
    const overlay = document.getElementById('mega-' + name);
    if (!overlay) return;
    const megaMenu = overlay.querySelector('.mega-menu');
    if (!megaMenu) return;

    const panel = document.createElement('div');
    panel.className = 'mega-menu-panel';
    panel.id = 'panel-' + name;
    panel.innerHTML = megaMenu.innerHTML;
    container.appendChild(panel);
  });

  const openMenu = (name) => {
    if (!name || !menuNames.includes(name)) return;
    clearTimeout(closeTimer);
    lastInteraction = Date.now();

    // Show container
    container.classList.add('open');

    // Hide all panels, show active
    document.querySelectorAll('.mega-menu-panel').forEach(p => p.classList.remove('active'));
    const activePanel = document.getElementById('panel-' + name);
    if (activePanel) activePanel.classList.add('active');

    // Update nav styling
    const nav = document.querySelector('.landing-nav');
    if (nav) nav.classList.add('mega-open');

    // Update welcome card
    const welcome = document.getElementById('welcome-float');
    if (welcome) welcome.classList.add('under-mega');
  };

  const scheduleClose = () => {
    clearTimeout(closeTimer);
    closeTimer = setTimeout(() => {
      if (Date.now() - lastInteraction >= hoverDelay) {
        closeMegaMenu();
      }
    }, hoverDelay);
  };

  // Monitor nav and container for hover
  const nav = document.querySelector('.landing-nav');
  if (nav) {
    nav.addEventListener('mouseenter', () => {
      clearTimeout(closeTimer);
      lastInteraction = Date.now();
    });
    nav.addEventListener('mouseleave', () => {
      lastInteraction = Date.now();
      scheduleClose();
    });
  }

  container.addEventListener('mouseenter', () => {
    clearTimeout(closeTimer);
    lastInteraction = Date.now();
  });

  container.addEventListener('mouseleave', () => {
    lastInteraction = Date.now();
    scheduleClose();
  });

  // Close menu when clicking outside
  document.addEventListener('click', (e) => {
    const isNav = nav && nav.contains(e.target);
    const isContainer = container.contains(e.target);
    if (!isNav && !isContainer && container.classList.contains('open')) {
      closeMegaMenu();
    }
  });

  // Bind top nav links
  document.querySelectorAll('.landing-nav-links a[data-menu]').forEach(link => {
    const menuName = link.dataset.menu;
    link.addEventListener('mouseenter', (e) => {
      e.preventDefault();
      openMenu(menuName);
    });
    link.addEventListener('mouseleave', () => {
      lastInteraction = Date.now();
      scheduleClose();
    });
    link.addEventListener('click', (e) => e.preventDefault());
  });

  // Update global closeMegaMenu
  window.closeMegaMenuNew = function() {
    container.classList.remove('open');
    const nav = document.querySelector('.landing-nav');
    if (nav) nav.classList.remove('mega-open');
    const welcome = document.getElementById('welcome-float');
    if (welcome) welcome.classList.remove('under-mega');
  };
})();

// ── Hover content switching inside 'Tipos de industria' mega menu ──
(function() {
  // Solo ejecutar en página de inicio
  if (!document.querySelector('.landing-nav')) return;
  
  const overlay = document.getElementById('mega-tipos');
  if (!overlay) return;
  const panel = overlay.querySelector('#mega-tipos-panel');
  if (!panel) return;

  const defaultHTML = panel.innerHTML;

  const contentMap = {
    restaurantes: `<p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:14px">Restaurantes</p>
      <div style="display:flex;flex-direction:column;gap:12px">
        <div class="mega-menu-feature"><span class="icon-inline">🍽️</span><div><p style="font-weight:700;font-size:14px;color:#1a1a2e">Menús y control por porciones</p><p style="font-size:12px;color:#2d4a6e">Optimiza porciones, costos y fichas técnicas por receta.</p></div></div>
        <div class="mega-menu-feature"><span class="icon-inline">🔁</span><div><p style="font-weight:700;font-size:14px;color:#1a1a2e">Operaciones en tiempo real</p><p style="font-size:12px;color:#2d4a6e">Stock por sala, escandallos y órdenes conectadas al POS.</p></div></div>
      </div>`,
    plantas: `<p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:14px">Plantas de producción</p>
      <div style="display:flex;flex-direction:column;gap:12px"><div class="mega-menu-feature"><span class="icon-inline">🏭</span><div><p style="font-weight:700;font-size:14px;color:#1a1a2e">Control de lotes</p><p style="font-size:12px;color:#2d4a6e">Trazabilidad por lote y control de calidad en cada etapa.</p></div></div></div>`,
    panaderias: `<p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:14px">Panaderías y pastelerías</p>
      <div style="display:flex;flex-direction:column;gap:12px"><div class="mega-menu-feature"><span class="icon-inline">🥐</span><div><p style="font-weight:700;font-size:14px;color:#1a1a2e">Recetas por batch</p><p style="font-size:12px;color:#2d4a6e">Escalado automático de recetas y control de harina y levados.</p></div></div></div>`,
    cafeterias: `<p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:14px">Cafeterías y bebidas</p>
      <div style="display:flex;flex-direction:column;gap:12px"><div class="mega-menu-feature"><span class="icon-inline">☕</span><div><p style="font-weight:700;font-size:14px;color:#1a1a2e">Control de recetas rápidas</p><p style="font-size:12px;color:#2d4a6e">Gestión de insumos por bebida y control de consumo por turno.</p></div></div></div>`,
    hoteles: `<p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:14px">Hoteles y catering</p>
      <div style="display:flex;flex-direction:column;gap:12px"><div class="mega-menu-feature"><span class="icon-inline">🏨</span><div><p style="font-weight:700;font-size:14px;color:#1a1a2e">Escalabilidad por eventos</p><p style="font-size:12px;color:#2d4a6e">Planificación y compras centralizadas para banquetes y catering.</p></div></div></div>`,
    distribuidoras: `<p style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#999;margin-bottom:14px">Distribuidoras de alimentos</p>
      <div style="display:flex;flex-direction:column;gap:12px"><div class="mega-menu-feature"><span class="icon-inline">🛒</span><div><p style="font-weight:700;font-size:14px;color:#1a1a2e">Logística integrada</p><p style="font-size:12px;color:#2d4a6e">Rutas, stock por cliente y sincronización de inventario.</p></div></div></div>`
  };

  const links = overlay.querySelectorAll('.mega-menu-links a.mega-menu-link');
  links.forEach(l => {
    const key = l.dataset.key;
    l.addEventListener('mouseenter', (e) => {
      e.preventDefault();
      if (contentMap[key]) panel.innerHTML = contentMap[key];
      links.forEach(x => x.classList.toggle('active', x === l));
    });
    l.addEventListener('click', e => e.preventDefault());
  });

  overlay.addEventListener('mouseleave', () => {
    panel.innerHTML = defaultHTML;
    links.forEach(x => x.classList.remove('active'));
  });
})();

// ── Navigation (multipágina) ──
// Se mantiene por compatibilidad con código que pueda invocar showPage
function showPage(id) {
  if (typeof id === 'string') window.location.href = id + '.html';
}

// ── Modals ──
function openModal(id)  { const el = document.getElementById(id); if (el) el.classList.add('open'); }
function closeModal(id) { const el = document.getElementById(id); if (el) el.classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', e => {
    if (e.target === overlay) overlay.classList.remove('open');
  });
});

// ── Toast ──
let toastTimer;
function showToast(msg, icon='✅') {
  const t = document.getElementById('toast');
  if (!t) return;
  document.getElementById('toast-msg').textContent  = msg;
  document.getElementById('toast-icon').textContent = icon;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 3000);
}

function demo()      { showToast('⚡ Modo Demo — acción simulada', '⚡'); }
function demoModal() {
  const open = document.querySelector('.modal-overlay.open');
  if (open) open.classList.remove('open');
  showToast('Registro guardado correctamente', '✅');
}

// ── Calculadora ──
function calcularDemo() {
  const sel = document.getElementById('calc-receta');
  if (!sel) return;
  const precio = parseFloat(sel.value);
  const cantidad = parseInt(document.getElementById('calc-cantidad').value) || 1;

  if (!precio) {
    document.getElementById('calc-total').textContent    = '$0';
    document.getElementById('calc-unitario').textContent = '$0';
    document.getElementById('calc-desglose').innerHTML   =
      '<div style="color:var(--text-muted);font-size:13px;padding:20px 0;text-align:center">Selecciona una receta para ver el desglose</div>';
    return;
  }

  const total = (precio * cantidad).toFixed(2);
  document.getElementById('calc-total').textContent    = '$' + total;
  document.getElementById('calc-unitario').textContent = '$' + precio.toFixed(2);

  const items = (typeof desgloses !== 'undefined')
    ? (desgloses[precio.toFixed(2)] || desgloses[String(precio)] || [])
    : [];
  document.getElementById('calc-desglose').innerHTML = items.map(i => `
    <div class="result-row">
      <span>${i.nombre} <span style="color:var(--text-muted);font-size:12px">(${i.cant})</span></span>
      <span style="font-family:DM Mono,monospace;font-size:12px;color:var(--teal)">${i.precio}</span>
    </div>
  `).join('');
}

// ── Simulador ──
function simularDemo() {
  const sel = document.getElementById('sim-receta');
  if (!sel) return;
  const precio = parseFloat(sel.value);
  const cantidad = parseInt(document.getElementById('sim-cantidad').value) || 100;
  const variacion = parseFloat(document.getElementById('sim-variacion').value) || 0;

  if (!precio) return;

  const original    = precio * cantidad;
  const nuevoPrecio = precio * (1 + variacion / 100);
  const simulado    = nuevoPrecio * cantidad;
  const diff        = simulado - original;
  const pct         = variacion;

  document.getElementById('sim-original').textContent   = '$' + original.toFixed(2);
  document.getElementById('sim-orig-u').textContent     = '$' + precio.toFixed(2) + ' por unidad';
  document.getElementById('sim-simulado').textContent   = '$' + simulado.toFixed(2);
  document.getElementById('sim-sim-u').textContent      = '$' + nuevoPrecio.toFixed(2) + ' por unidad';
  document.getElementById('sim-diferencia').textContent = (diff >= 0 ? '+' : '') + '$' + diff.toFixed(2);
  document.getElementById('sim-diferencia').style.color = diff > 0 ? 'var(--red)' : diff < 0 ? 'var(--teal)' : 'var(--black)';
  document.getElementById('sim-pct').textContent        = (pct >= 0 ? '+' : '') + pct.toFixed(1) + '%';
  document.getElementById('sim-pct').style.color        = pct > 0 ? 'var(--red)' : pct < 0 ? 'var(--teal)' : 'var(--black)';
}

function resetSim() {
  document.getElementById('sim-receta').value    = '';
  document.getElementById('sim-cantidad').value  = 100;
  document.getElementById('sim-variacion').value = 0;
  ['sim-original','sim-simulado','sim-diferencia','sim-pct'].forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    el.textContent = id.includes('pct') ? '0%' : '$0';
    el.style.color = 'var(--black)';
  });
  document.getElementById('sim-orig-u').textContent = '$0 por unidad';
  document.getElementById('sim-sim-u').textContent  = '$0 por unidad';
}

// ── Reportes tabs ──
function switchReportTab(tab, el) {
  document.querySelectorAll('[id^="rtab-"]').forEach(t => t.style.display = 'none');
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  const target = document.getElementById('rtab-' + tab);
  if (target) target.style.display = 'block';
  if (el) el.classList.add('active');
}

// ── Charts (sólo si Chart.js está cargado) ──
let chartsInited = false;
function initCharts() {
  if (chartsInited) return;
  if (typeof Chart === 'undefined') return;
  if (!document.getElementById('chartCategoria')) return;
  chartsInited = true;

  const palette = ['#185FA5','#0F6E56','#BA7517','#6B8AAD','#A32D2D'];

  new Chart(document.getElementById('chartCategoria'), {
    type: 'doughnut',
    data: {
      labels: ['Lácteos','Cereales','Proteínas','Vegetales','Bebidas','Otros'],
      datasets: [{ data:[102,10.2,0,24,63,80], backgroundColor:palette, borderWidth:2, borderColor:'#fff' }]
    },
    options: {
      responsive:true, maintainAspectRatio:false,
      plugins:{ legend:{ position:'bottom', labels:{ font:{ family:'DM Sans', size:11 }, padding:10 } } }
    }
  });

  new Chart(document.getElementById('chartStock'), {
    type:'bar',
    data:{
      labels:['Disponible','Bajo Stock','Agotado'],
      datasets:[{ label:'Insumos', data:[5,2,1], backgroundColor:['#0F6E56','#BA7517','#A32D2D'], borderRadius:6, borderWidth:0 }]
    },
    options:{
      responsive:true, maintainAspectRatio:false,
      plugins:{ legend:{ display:false } },
      scales:{
        y:{ beginAtZero:true, grid:{ color:'#eee' }, ticks:{ font:{ family:'DM Sans' } } },
        x:{ grid:{ display:false }, ticks:{ font:{ family:'DM Sans' } } }
      }
    }
  });

  new Chart(document.getElementById('chartEvolucion'), {
    type:'line',
    data:{
      labels:['Nov','Dic','Ene','Feb','Mar','Abr'],
      datasets:[{
        label:'Costo mensual ($)',
        data:[1200,980,1450,1100,1380,1260],
        borderColor:'#185FA5',
        backgroundColor:'rgba(24,95,165,0.08)',
        fill:true, tension:0.4,
        pointBackgroundColor:'#185FA5', pointRadius:5, borderWidth:2
      }]
    },
    options:{
      responsive:true, maintainAspectRatio:false,
      plugins:{ legend:{ display:false } },
      scales:{
        y:{ beginAtZero:false, grid:{ color:'#eee' }, ticks:{ font:{ family:'DM Sans' } } },
        x:{ grid:{ display:false }, ticks:{ font:{ family:'DM Sans' } } }
      }
    }
  });
}

// Auto-init charts cuando la página de reportes esté lista
// Inicialización: solo mantener initCharts() (initEnviosModule fue removido)
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    initCharts();
  });
} else {
  initCharts();
}

/* ============================================================
   Módulo Pedidos (añadido al final) — variables y helpers
   ============================================================ */

// Variable global de filtro (no redeclarar si ya existe)
if (typeof filtroActual === 'undefined') window.filtroActual = 'todos';

// Array temporal de prueba (si no existe)
if (typeof basePedidosPrueba === 'undefined') window.basePedidosPrueba = [
  { id: 'ENV-1001', destino: 'Restaurante La Esquina', conductor: 'Carlos R.', ruta: 'verde', estado: 'Pendiente', eta: 'Por asignar', total: '$120.00', fecha: '2026-05-20', insumos: 'Harina, Levadura', observaciones: 'Entrega mañana', badge: 'badge-amber' },
  { id: 'ENV-1002', destino: 'Cafetería Central', conductor: 'María P.', ruta: 'azul', estado: 'En tránsito', eta: '12:30', total: '$75.50', fecha: '2026-05-21', insumos: 'Café, Azúcar', observaciones: '', badge: 'badge-blue' },
  { id: 'ENV-1003', destino: 'Panadería El Horno', conductor: '', ruta: '', estado: 'Entregado', eta: '08:10', total: '$200.00', fecha: '2026-05-19', insumos: 'Harina, Manteca', observaciones: 'Firmado por recepción', badge: 'badge-green' }
];

// Helper local para badge (no sobrescribe si ya existe)
function _mm_getPedidoBadge(estado) {
  const map = { 'En tránsito': 'badge-blue', 'Entregado': 'badge-green', 'Pendiente': 'badge-amber' };
  return map[estado] || 'badge-gray';
}

// Dibujar filas en tbody#pedidos-tbody
function actualizarTablaPedidos(filtro, busqueda) {
  const tbody = document.getElementById('pedidos-tbody');
  if (!tbody) return;
  try { 
    const tbl = document.getElementById('pedidos-tbody')?.parentElement; 
    if (tbl) tbl.style.minHeight = '280px'; 
  } catch(e) {}
  filtro = filtro || window.filtroActual || 'todos';
  busqueda = (typeof busqueda === 'undefined') ? (document.getElementById('pedidos-search')?.value.trim().toLowerCase() || '') : (busqueda || '').toLowerCase();

  const data = (window.basePedidosPrueba || []).filter(item => {
    const filterMatches = filtro === 'todos'
      || (filtro === 'ruta' && item.estado === 'En tránsito')
      || (filtro === 'pendiente' && item.estado === 'Pendiente')
      || (filtro === 'entregado' && item.estado === 'Entregado');
    const searchMatches = busqueda === '' || [item.id, item.destino, item.conductor, item.ruta, item.estado].some(v => (v || '').toString().toLowerCase().includes(busqueda));
    return filterMatches && searchMatches;
  });

  tbody.innerHTML = data.map(item => {
    // Badges unificados: fondo azul pastel + texto azul oscuro
    const badgeBg = '#eef6ff';
    const badgeText = '#1e3a8a';
    
    return `
    <tr>
      <td style="padding:12px 14px;font-size:12px;font-weight:700;color:var(--primary);font-family:'DM Mono',monospace;border-bottom:1px solid var(--border)">${item.id}</td>
      <td style="padding:12px 14px;font-size:13px;color:var(--black);font-family:'DM Sans',sans-serif;border-bottom:1px solid var(--border)">${item.destino}</td>
      <td style="padding:12px 14px;font-size:13px;color:var(--text-muted);font-family:'DM Sans',sans-serif;border-bottom:1px solid var(--border)">${item.conductor || 'Por asignar'}</td>
      <td style="padding:12px 14px;font-size:13px;color:var(--text-muted);font-family:'DM Sans',sans-serif;border-bottom:1px solid var(--border)">${item.ruta || 'Por definir'}</td>
      <td style="padding:12px 14px;border-bottom:1px solid var(--border)"><span style="display:inline-block;padding:4px 10px;border-radius:6px;background-color:${badgeBg};color:${badgeText};font-size:11px;font-weight:700;font-family:'DM Sans',sans-serif;text-transform:uppercase">${item.estado}</span></td>
      <td style="padding:12px 14px;font-size:13px;color:var(--text-muted);font-family:'DM Sans',sans-serif;border-bottom:1px solid var(--border)">${item.eta}</td>
      <td style="padding:12px 14px;font-size:13px;color:var(--black);font-weight:700;font-family:'DM Sans',sans-serif;border-bottom:1px solid var(--border)">${item.total}</td>
    </tr>
  `;
  }).join('');
}

// setFiltro y filtrarPedidos (no sobrescribir si ya existen)
if (typeof setFiltro === 'undefined') {
  window.setFiltro = function(tipo) {
    window.filtroActual = tipo;
    // Actualizar estilo botones (si existen)
    try {
      const buttons = document.querySelectorAll('#filter-todos, #filter-ruta, #filter-pend, #filter-entregado');
      buttons.forEach(btn => {
        const isActive = btn.id === `filter-${tipo}`;
        btn.style.background = isActive ? 'var(--primary)' : '';
        btn.style.color = isActive ? '#fff' : '';
        btn.style.borderColor = isActive ? 'var(--primary)' : '';
      });
    } catch (e) {}
    actualizarTablaPedidos(window.filtroActual);
  };
}

if (typeof filtrarPedidos === 'undefined') {
  window.filtrarPedidos = function() {
    const q = document.getElementById('pedidos-search')?.value || '';
    actualizarTablaPedidos(window.filtroActual, q);
  };
}

// procesarNuevoPedido — crear y añadir al array temporal (si no existe ya)
if (typeof procesarNuevoPedido === 'undefined') {
  // ============================================================
// CONEXIÓN REAL CON EL BACKEND PHP (Reemplazo Zona A)
// ============================================================

window.procesarNuevoPedido = function() {
  const destino = document.getElementById('env-destino')?.value.trim();
  const fecha = document.getElementById('env-fecha')?.value;
  const estado = document.getElementById('env-estado')?.value;
  const insumos = document.getElementById('env-insumos')?.value.trim();
  const total = document.getElementById('env-total')?.value.trim();
  const observaciones = document.getElementById('env-obs')?.value.trim();

  if (!destino || !total) {
    if (typeof showToast === 'function') showToast('Completa los campos obligatorios (Destino y Total)', '⚠️');
    return;
  }

  const formData = new FormData();
  formData.append('destino', destino);
  formData.append('fecha', fecha);
  formData.append('estado', estado);
  formData.append('insumos', insumos);
  formData.append('total', total);
  formData.append('observaciones', observaciones);

  fetch('api/guardar_pedido.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      if (typeof closeModal === 'function') closeModal('modal-env');
      if (typeof showToast === 'function') showToast('¡Pedido guardado en MySQL!', '✅');
      setTimeout(() => location.reload(), 800); 
    } else {
      alert("Error en el servidor: " + data.message);
    }
  })
  .catch(err => console.error("Error de red en la petición:", err));
};

window.procesarNuevoInsumo = function() {
  const nombre = document.getElementById('ins-nombre')?.value.trim();
  const cantidad = document.getElementById('ins-cantidad')?.value.trim();
  const unidad = document.getElementById('ins-unidad')?.value;
  const categoria = document.getElementById('ins-categoria')?.value;

  if (!nombre || !cantidad) {
    if (typeof showToast === 'function') showToast('Completa los campos obligatorios', '⚠️');
    return;
  }

  const formData = new FormData();
  formData.append('nombre', nombre);
  formData.append('cantidad', cantidad);
  formData.append('unidad', unidad);
  formData.append('categoria', categoria);

  fetch('api/guardar_insumo.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      if (typeof closeModal === 'function') closeModal('modal-insumo');
      if (typeof showToast === 'function') showToast('Stock actualizado en MySQL', '✅');
      setTimeout(() => location.reload(), 800);
    } else {
      alert("Error en el servidor: " + data.message);
    }
  })
  .catch(err => console.error("Error de red en la petición:", err));
};

if (typeof showTooltip === 'undefined') {
  window.showTooltip = function() { /* placeholder: mapa no inicializado */ };
}
if (typeof closeTooltip === 'undefined') {
  window.closeTooltip = function() { /* placeholder */ };
}

// Inicializar tabla con datos de prueba al cargar (si existe tbody)
//document.addEventListener('DOMContentLoaded', function() {
//  actualizarTablaPedidos(window.filtroActual);
//});

/* Fin Módulo Pedidos */
}
window.procesarNuevaReceta = function() {
  const nombre = document.getElementById('rec-nombre')?.value.trim();
  const categoria = document.getElementById('rec-categoria')?.value;
  const insumos = document.getElementById('rec-insumos')?.value.trim();
  const rendimiento = document.getElementById('rec-rendimiento')?.value.trim();

  if (!nombre || !insumos || !rendimiento) {
    alert("Por favor completa todos los campos del formulario.");
    return;
  }

  const formData = new FormData();
  formData.append('nombre', nombre);
  formData.append('categoria', categoria);
  formData.append('insumos', insumos);
  formData.append('rendimiento', rendimiento);

  fetch('api/guardar_receta.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      if (typeof closeModal === 'function') closeModal('modal-rec');
      location.reload(); // Refresca para pintar la nueva fórmula de MySQL
    } else {
      alert("Error al guardar receta: " + data.message);
    }
  })
  .catch(err => console.error("Error en la petición:", err));
};
/* SISTEMA DE ELIMINACIÓN ASYNC */
window.procesarNuevaReceta = function() {
  const nombre = document.getElementById('rec-nombre')?.value.trim();
  const categoria = document.getElementById('rec-categoria')?.value;
  const insumos = document.getElementById('rec-insumos')?.value.trim();
  const rendimiento = document.getElementById('rec-rendimiento')?.value.trim();

  if (!nombre || !insumos || !rendimiento) {
    alert("Por favor completa todos los campos del formulario.");
    return;
  }

  const formData = new FormData();
  formData.append('nombre', nombre);
  formData.append('categoria', categoria);
  formData.append('insumos', insumos);
  formData.append('rendimiento', rendimiento);

  fetch('api/guardar_receta.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      if (typeof closeModal === 'function') closeModal('modal-rec');
      location.reload(); 
    } else {
      alert("Error al guardar receta: " + data.message);
    }
  })
  .catch(err => console.error("Error en la petición:", err));
};

// ============================================================
// 🗑️ SISTEMA DE ELIMINACIÓN ASÍNCRONA REAL GLOBAL
// ============================================================
window.eliminarInsumoReal = function(id) {
  if (confirm("🚨 ¿Estás seguro de que deseas eliminar este insumo de forma permanente en MySQL?")) {
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('api/eliminar_insumo.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        location.reload();
      } else {
        alert("Error al eliminar: " + data.message);
      }
    })
    .catch(err => console.error("Error en la petición:", err));
  }
};

window.eliminarPedidoReal = function(id) {
  if (confirm("🚨 ¿Estás seguro de que deseas eliminar este pedido de forma permanente en MySQL?")) {
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('api/eliminar_pedido.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        location.reload();
      } else {
        alert("Error al eliminar: " + data.message);
      }
    })
    .catch(err => console.error("Error en la petición:", err));
  }
};

window.eliminarRecetaReal = function(id) {
  if (confirm("🚨 ¿Estás seguro de que deseas eliminar esta receta de forma permanente en MySQL?")) {
    const formData = new FormData();
    formData.append('id', id);
    
    fetch('api/eliminar_receta.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        location.reload();
      } else {
        alert("Error al eliminar: " + data.message);
      }
    })
    .catch(err => console.error("Error en la petición:", err));
  }
};
// ============================================================
// 👁️ VISUALIZADOR DINÁMICO DE FICHAS TÉCNICAS (OJO Y LÁPIZ)
// ============================================================
// ============================================================
// 👁️ VISUALIZADOR INTELIGENTE DE FICHAS TÉCNICAS PARA RECETAS
// ============================================================
// ============================================================
// 👁️ VISUALIZADOR INTELIGENTE DE FICHAS TÉCNICAS PARA INVENTARIO
// ============================================================
// ============================================================
// 👁️✏️ SISTEMA MAESTRO UNIFICADO DE INVENTARIO (OJO Y LÁPIZ REAL)
// ============================================================
window.verInsumoFicha = function(fila, esEdicion) {
    if (!fila) return;
    
    // 1. Extraemos los textos de la fila (Tu lógica funcional intacta)
    const celdas = fila.getElementsByTagName('td');
    if (celdas.length < 3) return;

    const nombreReal = celdas[0].querySelector('strong')?.innerText || celdas[0].innerText;
    const categoriaReal = celdas[1].innerText.trim();
    const textoStock = celdas[2].innerText.trim();
    const numeroLimpio = parseFloat(textoStock.replace(/[^\d.]/g, '')) || 0;
    const unidadLimpia = textoStock.includes('L') ? 'L' : (textoStock.includes('ml') ? 'ml' : (textoStock.includes('g') ? 'g' : 'kg'));

    // 2. Mapeamos los inputs del modal
    const inputNombre = document.getElementById('ins-nombre');
    const selectCategoria = document.getElementById('ins-categoria');
    const inputCantidad = document.getElementById('ins-cantidad');
    const selectUnidad = document.getElementById('ins-unidad');

    // 3. Inyectamos los datos reales de MySQL en los campos
    if (inputNombre) inputNombre.value = nombreReal.trim();
    if (selectCategoria) selectCategoria.value = categoriaReal;
    if (inputCantidad) inputCantidad.value = numeroLimpio;
    if (selectUnidad) selectUnidad.value = unidadLimpia;

    // 4. Cambiamos el botón del modal según el botón presionado (Ojo o Lápiz)
    const botonModal = document.querySelector('#modal-inv .btn-primary');
    if (botonModal) {
        if (esEdicion) {
            // Configuración para el LÁPIZ: Habilitar inputs y activar API real
            if (inputCantidad) inputCantidad.disabled = false;
            if (selectCategoria) selectCategoria.disabled = false;
            if (selectUnidad) selectUnidad.disabled = false;
            
            botonModal.innerText = "Actualizar Insumo";
            botonModal.setAttribute('onclick', 'guardarCambiosInsumoBD()');
        } else {
            // Configuración para el OJO: Solo lectura, bloqueamos campos
            if (inputCantidad) inputCantidad.disabled = true;
            if (selectCategoria) selectCategoria.disabled = true;
            if (selectUnidad) selectUnidad.disabled = true;
            
            botonModal.innerText = "Cerrar Vista";
            botonModal.setAttribute('onclick', "closeModal('modal-inv')");
        }
    }

    // 5. Abrimos el modal visualmente
    if (typeof openModal === 'function') openModal('modal-inv');
};

// Función asíncrona real encargada de enviar los datos modificados a MySQL
window.guardarCambiosInsumoBD = function() {
    const nombre = document.getElementById('ins-nombre')?.value.trim();
    const categoria = document.getElementById('ins-categoria')?.value;
    const cantidad = document.getElementById('ins-cantidad')?.value.trim();
    const unidad = document.getElementById('ins-unidad')?.value;

    const formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('categoria', categoria);
    formData.append('cantidad', cantidad);
    formData.append('unidad', unidad);

    fetch('api/editar_insumo.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            if (typeof closeModal === 'function') closeModal('modal-inv');
            location.reload(); // Recargamos para ver el cambio guardado en phpMyAdmin
        } else {
            alert("Error al actualizar: " + data.message);
        }
    })
    .catch(err => console.error("Error en la red:", err));
};
// ============================================================
// 👁️✏️ SISTEMA MAESTRO UNIVERSAL DE INVENTARIO (OJO Y LÁPIZ REPARADO)
// ============================================================
// ============================================================
// 👁️✏️ SISTEMA MAESTRO UNIVERSAL DE RECETAS (OJO Y LÁPIZ REAL)
// ============================================================
window.verRecetaFicha = function(fila, esEdicion) {
    if (!fila) return;
    
    // 1. Extraemos los textos directamente de las celdas de la tabla (td)
    const celdas = fila.getElementsByTagName('td');
    if (celdas.length < 4) return;

    // Obtener nombre limpiando etiquetas strong
    const nombreFormula = celdas[0].querySelector('strong')?.innerText || celdas[0].innerText.split('\n')[0];
    
    // Obtener el identificador del código (ej: REC-001) guardado en la etiqueta pequeña
    const codigoReal = celdas[0].querySelector('span')?.innerText || '';
    
    // Obtener la categoría del badge
    const categoriaTexto = celdas[1].querySelector('.badge')?.innerText || celdas[1].innerText.trim();
    
    // Obtener los ingredientes e insumos
    const insumosTexto = celdas[2].innerText.trim();
    
    // Obtener el costo de rendimiento limpiando el signo de pesos ($)
    const costoTexto = celdas[3].innerText.replace('$', '').trim();

    // 2. Mapeamos los inputs reales de tu modal de recetas
    const inputNombre = document.getElementById('rec-nombre');
    const selectCategoria = document.getElementById('rec-categoria');
    const inputInsumos = document.getElementById('rec-insumos');
    const inputRendimiento = document.getElementById('rec-rendimiento');

    // 3. Inyectamos los valores de phpMyAdmin dentro del formulario
    if (inputNombre) inputNombre.value = nombreFormula.trim();
    if (selectCategoria) selectCategoria.value = categoriaTexto;
    if (inputInsumos) inputInsumos.value = insumosTexto;
    if (inputRendimiento) inputRendimiento.value = costoTexto;

    // 4. Cambiamos el comportamiento y el botón azul del modal según la acción
    const botonModal = document.querySelector('#modal-rec .btn-primary');
    if (botonModal) {
        if (esEdicion) {
            // Si es el LÁPIZ: Liberamos los campos para escribir y preparamos la API de MySQL
            if (inputNombre) inputNombre.disabled = false;
            if (selectCategoria) selectCategoria.disabled = false;
            if (inputInsumos) inputInsumos.disabled = false;
            if (inputRendimiento) inputRendimiento.disabled = false;
            
            botonModal.innerText = "Actualizar Receta";
            // Guardamos el código identificador de la fila de forma segura en la llamada
            botonModal.setAttribute('onclick', `guardarCambiosRecetaBD('${codigoReal}')`);
        } else {
            // Si es el OJO: Solo lectura, bloqueamos todas las cajas
            if (inputNombre) inputNombre.disabled = true;
            if (selectCategoria) selectCategoria.disabled = true;
            if (inputInsumos) inputInsumos.disabled = true;
            if (inputRendimiento) inputRendimiento.disabled = true;
            
            botonModal.innerText = "Cerrar Vista";
            botonModal.setAttribute('onclick', "closeModal('modal-rec')");
        }
    }

    // 5. Abrimos el modal de recetas visualmente en tu interfaz
    if (typeof openModal === 'function') {
        openModal('modal-rec');
    } else {
        const modal = document.getElementById('modal-rec');
        if (modal) modal.classList.add('open');
    }
};

// Función asíncrona real encargada de enviar los cambios modificados a MySQL
window.guardarCambiosRecetaBD = function(codigo) {
    const nombre = document.getElementById('rec-nombre')?.value.trim();
    const categoria = document.getElementById('rec-categoria')?.value;
    const insumos = document.getElementById('rec-insumos')?.value.trim();
    const rendimiento = document.getElementById('rec-rendimiento')?.value.trim();

    const formData = new FormData();
    formData.append('id', codigo); // Enviamos el código identificador único (REC-XXX)
    formData.append('nombre', nombre);
    formData.append('categoria', categoria);
    formData.append('insumos', insumos);
    formData.append('rendimiento', '$' + rendimiento); // Le concatenamos el signo pesos para que conserve tu formato original de BD

    fetch('api/editar_receta.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            if (typeof closeModal === 'function') closeModal('modal-rec');
            location.reload(); // Recargamos la página para ver el cambio real de phpMyAdmin en pantalla
        } else {
            alert("Error al actualizar: " + data.message);
        }
    })
    .catch(err => console.error("Error de red:", err));
};
// Función asíncrona real encargada de enviar los cambios de Envíos a MySQL
window.guardarCambiosPedidoBD = function(codigo) {
    const destino = document.getElementById('env-destino')?.value.trim();
    const estado = document.getElementById('env-estado')?.value;
    const insumos = document.getElementById('env-insumos')?.value.trim();
    const total = document.getElementById('env-total')?.value.trim();

    const formData = new FormData();
    formData.append('id', codigo); // Enviamos el identificador único (ENV-XXX)
    formData.append('destino', destino);
    formData.append('estado', estado);
    formData.append('insumos', insumos);
    formData.append('total', total);

    fetch('api/editar_pedido.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            if (typeof closeModal === 'function') closeModal('modal-env');
            location.reload(); // Recargamos para ver la actualización reflejada de inmediato
        } else {
            alert("Error al actualizar pedido: " + data.message);
        }
    })
    .catch(err => console.error("Error de red en envíos:", err));
};
// ── MÓDULO DE ENVÍOS (Lector de fila dinámico para el Lápiz de Edición) ──
// ── MÓDULO DE ENVÍOS (Lápiz de Edición Real Reparado Celda por Celda) ──
window.verPedidoFicha = function(fila) {
    if (!fila) return;
    const celdas = fila.getElementsByTagName('td');
    if (celdas.length < 3) return;

    // 1. Extraemos los textos de la fila de forma segura e independiente del orden
    const codigoReal  = celdas[0].innerText.trim(); // Código ENV-XXX siempre en la primera celda
    const destinoReal = celdas[1].innerText.trim(); // Nombre del destino en la segunda celda
    
    // Para el total, recorremos las celdas buscando la que tenga el signo de pesos ($)
    let totalReal = "0.00";
    for (let i = 0; i < celdas.length; i++) {
        if (celdas[i].innerText.includes('$')) {
            totalReal = celdas[i].innerText.replace('$', '').replace(',', '').trim();
            break;
        }
    }

    // 2. Inyectamos la información dentro de los inputs de tu modal original 'modal-env'
    const inputDestino = document.getElementById('env-destino');
    const inputTotal   = document.getElementById('env-total');

    if (inputDestino) inputDestino.value = destinoReal;
    if (inputTotal)   inputTotal.value = totalReal;

    // 3. Ajustamos el botón azul del modal para apuntar al guardado asíncrono
    const botonModal = document.querySelector('#modal-env .btn-primary');
    if (botonModal) {
        botonModal.innerText = "Actualizar Envío";
        botonModal.setAttribute('onclick', `guardarCambiosPedidoBD('${codigoReal}')`);
    }

    // 4. Abrimos el modal visual de forma nativa en tu frontend
    if (typeof openModal === 'function') openModal('modal-env');
};
