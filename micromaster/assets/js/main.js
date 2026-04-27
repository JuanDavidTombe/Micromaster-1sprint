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
  if (el) el.style.display = 'none';
}

function toggleMegaMenu(id, e) {
  if (e) e.preventDefault();
  const menus = ['mega-tipos','mega-productos','mega-modulos','mega-precios','mega-novedades'];
  const targetId = 'mega-' + id;
  menus.forEach(m => {
    const el = document.getElementById(m);
    if (el && m !== targetId) el.classList.remove('open');
  });
  const target = document.getElementById(targetId);
  if (target) target.classList.toggle('open');
}

function closeMegaMenu() {
  ['mega-tipos','mega-productos','mega-modulos','mega-precios','mega-novedades']
    .forEach(m => { const el = document.getElementById(m); if (el) el.classList.remove('open'); });
}

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
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initCharts);
} else {
  initCharts();
}
