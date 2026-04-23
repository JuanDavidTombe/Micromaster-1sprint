/* ============================================================
   MICROMASTER — INSUMOS ALIMENTARIOS
   app.js — Lógica principal de la aplicación
   ============================================================ */


/* -----------------------------------------------------------
   1. DATOS DE MUESTRA
   ----------------------------------------------------------- */

let inventario = [
  {
    id: 1,
    nombre: 'Leche entera',
    categoria: 'Lácteos',
    unidad: 'L',
    cantidad: 85,
    minimo: 20,
    maximo: 100,
    precio: 1.20,
    vencimiento: '2025-06-15',
    proveedor: 'Alpina'
  },
  {
    id: 2,
    nombre: 'Harina de trigo',
    categoria: 'Cereales',
    unidad: 'Kg',
    cantidad: 12,
    minimo: 15,
    maximo: 80,
    precio: 0.85,
    vencimiento: '2025-12-01',
    proveedor: 'Harinera Nacional'
  },
  {
    id: 3,
    nombre: 'Pollo entero',
    categoria: 'Proteínas',
    unidad: 'Kg',
    cantidad: 0,
    minimo: 10,
    maximo: 50,
    precio: 4.50,
    vencimiento: '2025-05-20',
    proveedor: 'Avícola del Sur'
  },
  {
    id: 4,
    nombre: 'Zanahoria',
    categoria: 'Vegetales',
    unidad: 'Kg',
    cantidad: 40,
    minimo: 5,
    maximo: 60,
    precio: 0.60,
    vencimiento: '2025-05-30',
    proveedor: 'Agrofresco'
  },
  {
    id: 5,
    nombre: 'Jugo de naranja',
    categoria: 'Bebidas',
    unidad: 'L',
    cantidad: 30,
    minimo: 10,
    maximo: 60,
    precio: 2.10,
    vencimiento: '2025-06-05',
    proveedor: 'Del Valle'
  },
  {
    id: 6,
    nombre: 'Sal refinada',
    categoria: 'Condimentos',
    unidad: 'Kg',
    cantidad: 55,
    minimo: 5,
    maximo: 50,
    precio: 0.30,
    vencimiento: '2026-01-01',
    proveedor: 'Refisal'
  }
];

let envios = [
  {
    id: 'ENV-001',
    destino: 'Restaurante El Sabor',
    insumos: [
      { nombre: 'Leche entera',   cantidad: 20, unidad: 'L'  },
      { nombre: 'Harina de trigo', cantidad: 15, unidad: 'Kg' }
    ],
    fecha: '2025-05-15',
    estado: 'Entregado',
    notas: 'Entregar antes de las 8am'
  },
  {
    id: 'ENV-002',
    destino: 'Hotel Casa Grande',
    insumos: [
      { nombre: 'Pollo entero', cantidad: 30, unidad: 'Kg' }
    ],
    fecha: '2025-05-18',
    estado: 'En tránsito',
    notas: 'Requiere cadena de frío'
  },
  {
    id: 'ENV-003',
    destino: 'Cafetería Central',
    insumos: [
      { nombre: 'Jugo de naranja', cantidad: 10, unidad: 'L'  },
      { nombre: 'Sal refinada',    cantidad: 5,  unidad: 'Kg' }
    ],
    fecha: '2025-05-20',
    estado: 'Pendiente',
    notas: ''
  }
];


/* -----------------------------------------------------------
   2. ESTADO DE LA UI (ordenamiento, edición activa)
   ----------------------------------------------------------- */

let invEditId    = null;   // ID del insumo en edición (null = nuevo)
let invSortField = null;   // Campo activo de ordenamiento en inventario
let invSortAsc   = true;   // Dirección del ordenamiento

let envSortField = null;   // Campo activo de ordenamiento en envíos
let envSortAsc   = true;


/* -----------------------------------------------------------
   3. NAVEGACIÓN ENTRE PÁGINAS
   ----------------------------------------------------------- */

const PAGE_TITLES = {
  inventario: 'Inventario',
  envios:     'Envíos'
};

/**
 * Muestra la página indicada y oculta las demás.
 * Actualiza el ítem activo del sidebar y el título del topbar.
 * @param {string} page - 'inventario' | 'envios'
 */
function showPage(page) {
  // Ocultar todas las páginas
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));

  // Desactivar todos los ítems del sidebar
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

  // Activar la página y el ítem correspondiente
  document.getElementById('page-' + page).classList.add('active');

  const navItem = document.getElementById('nav-' + page);
  if (navItem) navItem.classList.add('active');

  // Actualizar título del topbar
  document.getElementById('page-title').textContent = PAGE_TITLES[page] || page;

  // Renderizar el contenido al entrar
  if (page === 'inventario') renderInventario();
  if (page === 'envios')     renderEnvios();
}


/* -----------------------------------------------------------
   4. UTILIDADES GENERALES
   ----------------------------------------------------------- */

/**
 * Muestra una notificación toast temporal en la esquina inferior derecha.
 * @param {string} msg  - Texto del mensaje
 * @param {string} icon - Emoji o símbolo
 */
function toast(msg, icon = '✓') {
  const el = document.getElementById('toast');
  document.getElementById('toast-msg').textContent  = msg;
  document.getElementById('toast-icon').textContent = icon;
  el.classList.add('show');
  setTimeout(() => el.classList.remove('show'), 3000);
}

/**
 * Abre o cierra un modal por su ID.
 */
function closeModal(id) {
  document.getElementById(id).classList.remove('open');
}

function openModal(id) {
  document.getElementById(id).classList.add('open');
}

/**
 * Escribe la fecha de hoy en el topbar.
 */
function setFecha() {
  document.getElementById('fecha-hoy').textContent =
    new Date().toLocaleDateString('es-CO', {
      day: 'numeric', month: 'short', year: 'numeric'
    });
}

/**
 * Retorna el estado de stock de un insumo.
 * @returns {{ label: string, cls: string }}
 */
function getEstadoInsumo(item) {
  if (item.cantidad === 0)              return { label: 'Agotado',    cls: 'badge-red'    };
  if (item.cantidad < item.minimo)      return { label: 'Bajo stock', cls: 'badge-yellow' };
  return                                       { label: 'Disponible', cls: 'badge-green'  };
}

/**
 * Retorna la clase CSS del badge según el estado de un envío.
 */
function getEstadoBadge(estado) {
  const map = {
    'Pendiente':   'badge-yellow',
    'En tránsito': 'badge-blue',
    'Entregado':   'badge-green',
    'Cancelado':   'badge-red'
  };
  return map[estado] || 'badge-gray';
}

/**
 * Calcula el total en $ de un envío sumando precio × cantidad de cada insumo.
 */
function calcTotal(envio) {
  return envio.insumos.reduce((sum, item) => {
    const inv = inventario.find(x => x.nombre === item.nombre);
    return sum + (inv ? inv.precio * item.cantidad : 0);
  }, 0).toFixed(2);
}

/**
 * Genera los pasos del progreso de un envío.
 * @returns {Array<{ label: string, done: boolean, active: boolean }>}
 */
function getProgreso(estado) {
  const pasos = ['Pendiente', 'En tránsito', 'Entregado'];
  const idx   = pasos.indexOf(estado);
  return pasos.map((s, i) => ({
    label:  s,
    done:   i < idx,
    active: i === idx
  }));
}


/* -----------------------------------------------------------
   5. MÓDULO INVENTARIO — RENDER
   ----------------------------------------------------------- */

/**
 * Filtra, ordena y renderiza la tabla de inventario y las estadísticas.
 */
function renderInventario() {
  const search = document.getElementById('search-inv').value.toLowerCase();
  const cat    = document.getElementById('filter-cat').value;
  const est    = document.getElementById('filter-estado-inv').value;

  // --- Filtrado ---
  let data = inventario.filter(item => {
    const estadoLabel = getEstadoInsumo(item).label;
    const matchSearch = !search
      || item.nombre.toLowerCase().includes(search)
      || item.categoria.toLowerCase().includes(search)
      || item.proveedor.toLowerCase().includes(search);
    const matchCat  = !cat || item.categoria === cat;
    const matchEst  = !est || estadoLabel === est;
    return matchSearch && matchCat && matchEst;
  });

  // --- Ordenamiento ---
  if (invSortField) {
    data.sort((a, b) => {
      let va = a[invSortField];
      let vb = b[invSortField];
      if (typeof va === 'string') { va = va.toLowerCase(); vb = vb.toLowerCase(); }
      return invSortAsc ? (va > vb ? 1 : -1) : (va < vb ? 1 : -1);
    });
  }

  // --- Estadísticas ---
  renderStatsInventario();

  // --- Tabla ---
  const tbody = document.getElementById('inv-tbody');

  if (!data.length) {
    tbody.innerHTML = `
      <tr><td colspan="8">
        <div class="empty">
          <div class="empty-icon">📦</div>
          <div class="empty-title">Sin resultados</div>
          <div>Prueba con otros filtros</div>
        </div>
      </td></tr>`;
    return;
  }

  tbody.innerHTML = data.map(item => buildInvRow(item)).join('');
}

/**
 * Calcula y renderiza las tarjetas de estadísticas del inventario.
 */
function renderStatsInventario() {
  const total = inventario.length;
  const disp  = inventario.filter(i => getEstadoInsumo(i).label === 'Disponible').length;
  const bajo  = inventario.filter(i => getEstadoInsumo(i).label === 'Bajo stock').length;
  const agot  = inventario.filter(i => getEstadoInsumo(i).label === 'Agotado').length;
  const valor = inventario.reduce((s, i) => s + i.precio * i.cantidad, 0).toFixed(2);

  document.getElementById('stats-inv').innerHTML = `
    <div class="stat-card">
      <div class="stat-label">Total insumos</div>
      <div class="stat-value">${total}</div>
      <div class="stat-sub">en inventario</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Disponibles</div>
      <div class="stat-value" style="color:var(--green)">${disp}</div>
      <div class="stat-sub">con stock OK</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Bajo stock</div>
      <div class="stat-value" style="color:var(--yellow)">${bajo}</div>
      <div class="stat-sub">requieren reabasto</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Agotados</div>
      <div class="stat-value" style="color:var(--red)">${agot}</div>
      <div class="stat-sub">sin existencias</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Valor total</div>
      <div class="stat-value">$${Number(valor).toLocaleString('es-CO')}</div>
      <div class="stat-sub">en inventario</div>
    </div>`;
}

/**
 * Construye el HTML de una fila de inventario.
 */
function buildInvRow(item) {
  const est  = getEstadoInsumo(item);
  const pct  = item.maximo > 0 ? Math.min(100, Math.round(item.cantidad / item.maximo * 100)) : 0;
  const barColor = pct < 20 ? 'var(--red)' : pct < 50 ? 'var(--yellow)' : 'var(--green)';

  // Alerta de vencimiento
  const hoy  = new Date();
  const venc = new Date(item.vencimiento);
  const diff = Math.ceil((venc - hoy) / (1000 * 60 * 60 * 24));
  let vDisplay;
  if (diff < 0)       vDisplay = `<span style="color:var(--red);font-weight:600">⚠ Vencido</span>`;
  else if (diff < 15) vDisplay = `<span style="color:var(--yellow);font-weight:600">⏳ ${diff}d</span>`;
  else                vDisplay = `<span style="color:var(--light)">${item.vencimiento}</span>`;

  return `
    <tr>
      <td>
        <strong>${item.nombre}</strong><br>
        <span style="font-size:11px;color:var(--light)">${item.proveedor}</span>
      </td>
      <td><span class="badge badge-gray">${item.categoria}</span></td>
      <td>
        <strong>${item.cantidad}</strong>
        <span style="color:var(--light);font-size:11px"> ${item.unidad}</span>
      </td>
      <td>
        <div class="bar-wrap">
          <div class="bar-bg">
            <div class="bar-fill" style="width:${pct}%;background:${barColor}"></div>
          </div>
          <span style="font-size:11px;color:var(--light)">${pct}%</span>
        </div>
        <div class="bar-meta">mín ${item.minimo} / máx ${item.maximo}</div>
      </td>
      <td>$${item.precio.toFixed(2)}</td>
      <td><span class="badge ${est.cls}">${est.label}</span></td>
      <td>${vDisplay}</td>
      <td>
        <div class="actions">
          <button class="btn-icon" onclick="editInsumo(${item.id})" title="Editar">✏</button>
          <button class="btn-icon danger" onclick="deleteInsumo(${item.id})" title="Eliminar">🗑</button>
        </div>
      </td>
    </tr>`;
}

/**
 * Cambia el campo de ordenamiento de inventario.
 */
function sortInv(field) {
  if (invSortField === field) invSortAsc = !invSortAsc;
  else { invSortField = field; invSortAsc = true; }
  renderInventario();
}


/* -----------------------------------------------------------
   6. MÓDULO INVENTARIO — CRUD
   ----------------------------------------------------------- */

/**
 * Abre el modal de inventario en modo "nuevo insumo".
 */
function openModalInv() {
  invEditId = null;
  document.getElementById('modal-inv-title').textContent = 'Agregar Insumo';

  // Limpiar campos del formulario
  ['inv-nombre', 'inv-cantidad', 'inv-minimo',
   'inv-maximo', 'inv-precio', 'inv-vencimiento', 'inv-proveedor']
    .forEach(id => { document.getElementById(id).value = ''; });

  openModal('modal-inv');
}

/**
 * Carga los datos de un insumo existente en el formulario y abre el modal.
 */
function editInsumo(id) {
  const item = inventario.find(i => i.id === id);
  if (!item) return;

  invEditId = id;
  document.getElementById('modal-inv-title').textContent = 'Editar Insumo';

  document.getElementById('inv-nombre').value      = item.nombre;
  document.getElementById('inv-cat').value         = item.categoria;
  document.getElementById('inv-unidad').value      = item.unidad;
  document.getElementById('inv-cantidad').value    = item.cantidad;
  document.getElementById('inv-minimo').value      = item.minimo;
  document.getElementById('inv-maximo').value      = item.maximo;
  document.getElementById('inv-precio').value      = item.precio;
  document.getElementById('inv-vencimiento').value = item.vencimiento;
  document.getElementById('inv-proveedor').value   = item.proveedor;

  openModal('modal-inv');
}

/**
 * Lee el formulario del modal y guarda (crea o actualiza) el insumo.
 */
function saveInsumo() {
  const nombre   = document.getElementById('inv-nombre').value.trim();
  const cantidad = parseFloat(document.getElementById('inv-cantidad').value);
  const precio   = parseFloat(document.getElementById('inv-precio').value);

  // Validaciones básicas
  if (!nombre)                    return toast('El nombre es requerido', '⚠');
  if (isNaN(cantidad) || cantidad < 0) return toast('Cantidad inválida', '⚠');

  const datos = {
    nombre,
    categoria:   document.getElementById('inv-cat').value,
    unidad:      document.getElementById('inv-unidad').value,
    cantidad,
    minimo:      parseFloat(document.getElementById('inv-minimo').value)  || 0,
    maximo:      parseFloat(document.getElementById('inv-maximo').value)  || 100,
    precio:      isNaN(precio) ? 0 : precio,
    vencimiento: document.getElementById('inv-vencimiento').value || '—',
    proveedor:   document.getElementById('inv-proveedor').value   || '—'
  };

  if (invEditId) {
    // Actualizar insumo existente
    const idx = inventario.findIndex(i => i.id === invEditId);
    inventario[idx] = { ...inventario[idx], ...datos };
    toast('Insumo actualizado');
  } else {
    // Crear nuevo insumo
    datos.id = Date.now();
    inventario.push(datos);
    toast('Insumo agregado');
  }

  closeModal('modal-inv');
  renderInventario();
}

/**
 * Elimina un insumo tras confirmación del usuario.
 */
function deleteInsumo(id) {
  if (!confirm('¿Eliminar este insumo?')) return;
  inventario = inventario.filter(i => i.id !== id);
  renderInventario();
  toast('Insumo eliminado', '🗑');
}


/* -----------------------------------------------------------
   7. MÓDULO ENVÍOS — RENDER
   ----------------------------------------------------------- */

/**
 * Filtra, ordena y renderiza la tabla de envíos y las estadísticas.
 */
function renderEnvios() {
  const search = document.getElementById('search-env').value.toLowerCase();
  const est    = document.getElementById('filter-estado-env').value;

  // --- Filtrado ---
  let data = envios.filter(e =>
    (!search || e.id.toLowerCase().includes(search) || e.destino.toLowerCase().includes(search))
    && (!est || e.estado === est)
  );

  // --- Ordenamiento ---
  if (envSortField) {
    data.sort((a, b) => {
      let va = a[envSortField];
      let vb = b[envSortField];
      if (envSortField === 'total') { va = parseFloat(calcTotal(a)); vb = parseFloat(calcTotal(b)); }
      if (typeof va === 'string')   { va = va.toLowerCase(); vb = vb.toLowerCase(); }
      return envSortAsc ? (va > vb ? 1 : -1) : (va < vb ? 1 : -1);
    });
  }

  // --- Estadísticas ---
  renderStatsEnvios();

  // --- Tabla ---
  const tbody = document.getElementById('env-tbody');

  if (!data.length) {
    tbody.innerHTML = `
      <tr><td colspan="8">
        <div class="empty">
          <div class="empty-icon">🚚</div>
          <div class="empty-title">Sin envíos</div>
          <div>Prueba con otros filtros</div>
        </div>
      </td></tr>`;
    return;
  }

  tbody.innerHTML = data.map(e => buildEnvRow(e)).join('');
}

/**
 * Calcula y renderiza las tarjetas de estadísticas de envíos.
 */
function renderStatsEnvios() {
  const total      = envios.length;
  const pendientes = envios.filter(e => e.estado === 'Pendiente').length;
  const transito   = envios.filter(e => e.estado === 'En tránsito').length;
  const entregados = envios.filter(e => e.estado === 'Entregado').length;
  const valorTotal = envios.reduce((s, e) => s + parseFloat(calcTotal(e)), 0).toFixed(2);

  document.getElementById('stats-env').innerHTML = `
    <div class="stat-card">
      <div class="stat-label">Total envíos</div>
      <div class="stat-value">${total}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Pendientes</div>
      <div class="stat-value" style="color:var(--yellow)">${pendientes}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">En tránsito</div>
      <div class="stat-value" style="color:var(--blue)">${transito}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Entregados</div>
      <div class="stat-value" style="color:var(--green)">${entregados}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Valor total</div>
      <div class="stat-value">$${Number(valorTotal).toLocaleString('es-CO')}</div>
    </div>`;
}

/**
 * Construye el HTML de una fila de envíos incluyendo la barra de progreso.
 */
function buildEnvRow(envio) {
  const steps    = getProgreso(envio.estado);
  const insStr   = envio.insumos.map(i => `${i.nombre} (${i.cantidad}${i.unidad})`).join(', ');

  // HTML del indicador de progreso
  const progHTML = steps.map((s, idx) => `
    <span class="p-step ${s.done ? 'done' : ''} ${s.active ? 'active' : ''}" title="${s.label}">
      <span class="p-dot"></span>
    </span>
    ${idx < steps.length - 1 ? `<span class="p-line ${s.done ? 'done' : ''}"></span>` : ''}
  `).join('');

  return `
    <tr>
      <td><strong style="font-family:var(--font-display);font-size:15px">${envio.id}</strong></td>
      <td>${envio.destino}</td>
      <td style="max-width:180px;font-size:11px;color:var(--light)">${insStr}</td>
      <td style="font-size:12px">${envio.fecha}</td>
      <td><strong>$${calcTotal(envio)}</strong></td>
      <td><span class="badge ${getEstadoBadge(envio.estado)}">${envio.estado}</span></td>
      <td><div class="env-progress">${progHTML}</div></td>
      <td>
        <div class="actions">
          <button class="btn-icon" onclick="openDetalle('${envio.id}')" title="Ver detalle">👁</button>
          <button class="btn-icon" onclick="cambiarEstado('${envio.id}')" title="Avanzar estado">↻</button>
          <button class="btn-icon danger" onclick="deleteEnvio('${envio.id}')" title="Eliminar">🗑</button>
        </div>
      </td>
    </tr>`;
}

/**
 * Cambia el campo de ordenamiento de envíos.
 */
function sortEnv(field) {
  if (envSortField === field) envSortAsc = !envSortAsc;
  else { envSortField = field; envSortAsc = true; }
  renderEnvios();
}


/* -----------------------------------------------------------
   8. MÓDULO ENVÍOS — CRUD
   ----------------------------------------------------------- */

/**
 * Abre el modal de nuevo envío con un campo de insumo inicial.
 */
function openModalEnv() {
  document.getElementById('env-destino').value = '';
  document.getElementById('env-fecha').value   = '';
  document.getElementById('env-notas').value   = '';
  document.getElementById('env-estado').value  = 'Pendiente';
  document.getElementById('env-insumos-list').innerHTML = '';
  addInsumoLine();  // Agrega la primera línea vacía
  openModal('modal-env');
}

/**
 * Agrega una línea de insumo (select + cantidad) al formulario de envíos.
 */
function addInsumoLine() {
  const wrapper = document.getElementById('env-insumos-list');
  const div     = document.createElement('div');
  div.style.cssText = 'display:flex;gap:7px;align-items:center';

  const options = inventario.map(i =>
    `<option value="${i.nombre}">${i.nombre}</option>`
  ).join('');

  div.innerHTML = `
    <select style="flex:2;padding:7px 9px;border-radius:6px;background:var(--bg);
      border:1.5px solid var(--border);color:var(--black);font-family:Barlow,sans-serif;font-size:12px">
      ${options}
    </select>
    <input type="number" placeholder="Cant." min="1"
      style="width:68px;padding:7px 9px;border-radius:6px;background:var(--bg);
      border:1.5px solid var(--border);color:var(--black);font-size:12px">
    <button onclick="this.parentElement.remove()"
      style="background:none;border:none;color:var(--red);font-size:16px;cursor:pointer">×</button>
  `;

  wrapper.appendChild(div);
}

/**
 * Lee el formulario y crea un nuevo envío.
 */
function saveEnvio() {
  const destino = document.getElementById('env-destino').value.trim();
  const fecha   = document.getElementById('env-fecha').value;

  if (!destino) return toast('El destino es requerido', '⚠');
  if (!fecha)   return toast('La fecha es requerida', '⚠');

  // Recoger líneas de insumos
  const lineas  = document.getElementById('env-insumos-list').querySelectorAll('div');
  const insumos = [];

  lineas.forEach(linea => {
    const sel = linea.querySelector('select');
    const inp = linea.querySelector('input');
    if (sel && inp && inp.value) {
      const inv = inventario.find(i => i.nombre === sel.value);
      insumos.push({
        nombre:   sel.value,
        cantidad: parseFloat(inp.value) || 0,
        unidad:   inv ? inv.unidad : ''
      });
    }
  });

  if (!insumos.length) return toast('Agrega al menos un insumo', '⚠');

  // Generar ID correlativo
  const nuevoId = 'ENV-' + String(envios.length + 1).padStart(3, '0');

  envios.push({
    id:      nuevoId,
    destino,
    insumos,
    fecha,
    estado:  document.getElementById('env-estado').value,
    notas:   document.getElementById('env-notas').value
  });

  closeModal('modal-env');
  renderEnvios();
  toast('Envío ' + nuevoId + ' creado', '🚚');
}

/**
 * Avanza el estado de un envío al siguiente paso del ciclo.
 */
function cambiarEstado(id) {
  const envio = envios.find(e => e.id === id);
  if (!envio) return;

  const ciclo = ['Pendiente', 'En tránsito', 'Entregado', 'Cancelado'];
  const idx   = ciclo.indexOf(envio.estado);

  if (idx < ciclo.length - 1) {
    envio.estado = ciclo[idx + 1];
    renderEnvios();
    toast('Estado → ' + envio.estado);
  } else {
    toast('Estado final alcanzado', '⚠');
  }
}

/**
 * Abre el modal de detalle de un envío con su progreso visual completo.
 */
function openDetalle(id) {
  const envio = envios.find(e => e.id === id);
  if (!envio) return;

  const steps = getProgreso(envio.estado);

  // Pasos visuales del progreso
  const progHTML = steps.map((s, idx) => `
    <div style="display:flex;flex-direction:column;align-items:center">
      <div style="width:28px;height:28px;border-radius:50%;display:flex;align-items:center;
        justify-content:center;font-size:11px;font-weight:700;
        background:${s.done ? 'var(--green)' : s.active ? 'var(--black)' : 'var(--border)'};
        color:${s.done || s.active ? '#fff' : 'var(--mid)'}">
        ${s.done ? '✓' : idx + 1}
      </div>
      <div style="font-size:10px;color:${s.active ? 'var(--black)' : 'var(--light)'};
        margin-top:4px;text-align:center;width:60px">
        ${s.label}
      </div>
    </div>
    ${idx < steps.length - 1
      ? `<div style="flex:1;height:2px;background:${s.done ? 'var(--green)' : 'var(--border)'};
           margin-bottom:14px;min-width:32px"></div>`
      : ''}
  `).join('');

  // Filas de insumos con sus totales
  const insumosHTML = envio.insumos.map((item, idx) => {
    const inv = inventario.find(x => x.nombre === item.nombre);
    const sub = inv ? (inv.precio * item.cantidad).toFixed(2) : '0.00';
    return `
      <div style="display:flex;justify-content:space-between;padding:9px 13px;
        ${idx > 0 ? 'border-top:1px solid var(--border)' : ''};font-size:13px">
        <span>${item.nombre}</span>
        <span style="color:var(--mid)">${item.cantidad} ${item.unidad} — $${sub}</span>
      </div>`;
  }).join('');

  const notasHTML = envio.notas
    ? `<div>
         <div style="font-size:11px;font-weight:700;text-transform:uppercase;
           color:var(--light);margin-bottom:6px">Notas</div>
         <div style="background:var(--bg);border:1.5px solid var(--border);border-radius:7px;
           padding:10px 13px;font-size:13px;color:var(--mid)">${envio.notas}</div>
       </div>`
    : '';

  document.getElementById('env-detail-content').innerHTML = `
    <div style="display:flex;justify-content:space-between;margin-bottom:18px">
      <div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;
          letter-spacing:0.6px;color:var(--light);margin-bottom:4px">ID del Envío</div>
        <div style="font-family:var(--font-display);font-size:22px;font-weight:800">${envio.id}</div>
      </div>
      <span class="badge ${getEstadoBadge(envio.estado)}" style="font-size:12px;padding:4px 12px">
        ${envio.estado}
      </span>
    </div>

    <div style="display:flex;align-items:center;gap:4px;padding:14px;
      background:var(--bg);border-radius:8px;margin-bottom:18px">
      ${progHTML}
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">
      <div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;
          color:var(--light);margin-bottom:3px">Destino</div>
        <div style="font-weight:600">${envio.destino}</div>
      </div>
      <div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;
          color:var(--light);margin-bottom:3px">Fecha</div>
        <div style="font-weight:600">${envio.fecha}</div>
      </div>
    </div>

    <div style="margin-bottom:16px">
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;
        color:var(--light);margin-bottom:8px">Insumos</div>
      <div style="border:1.5px solid var(--border);border-radius:7px;overflow:hidden">
        ${insumosHTML}
        <div style="display:flex;justify-content:space-between;padding:9px 13px;
          border-top:1.5px solid var(--border);background:var(--bg);font-size:13px">
          <strong>Total</strong>
          <strong>$${calcTotal(envio)}</strong>
        </div>
      </div>
    </div>

    ${notasHTML}
  `;

  openModal('modal-env-detail');
}

/**
 * Elimina un envío tras confirmación del usuario.
 */
function deleteEnvio(id) {
  if (!confirm('¿Eliminar este envío?')) return;
  envios = envios.filter(e => e.id !== id);
  renderEnvios();
  toast('Envío eliminado', '🗑');
}


/* -----------------------------------------------------------
   9. INICIALIZACIÓN
   ----------------------------------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
  setFecha();
  renderInventario();  // Inventario es la página de inicio
});