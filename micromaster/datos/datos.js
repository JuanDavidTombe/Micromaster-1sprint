/* ============================================================
   MicroMaster — Datos de demostración
   ============================================================ */

// Desglose de insumos por receta (clave = precio unitario)
const desgloses = {
  '1.85': [
    { nombre: 'Harina de trigo', cant: '1 kg',   precio: '$0.85'  },
    { nombre: 'Sal refinada',    cant: '20 g',   precio: '$0.006' },
    { nombre: 'Leche entera',    cant: '0.6 L',  precio: '$0.72'  },
    { nombre: 'Levadura',        cant: '20 g',   precio: '$0.27'  }
  ],
  '6.20': [
    { nombre: 'Harina de trigo', cant: '0.3 kg', precio: '$0.26' },
    { nombre: 'Azúcar',          cant: '0.25 kg',precio: '$0.30' },
    { nombre: 'Chocolate',       cant: '0.2 kg', precio: '$1.80' },
    { nombre: 'Huevos',          cant: '4 u',    precio: '$1.20' },
    { nombre: 'Manteca',         cant: '0.15 kg',precio: '$0.64' }
  ],
  '3.15': [
    { nombre: 'Ron',             cant: '50 ml',  precio: '$1.50' },
    { nombre: 'Limón',           cant: '20 g',   precio: '$0.12' },
    { nombre: 'Azúcar',          cant: '10 g',   precio: '$0.03' },
    { nombre: 'Agua mineral',    cant: '150 ml', precio: '$0.30' }
  ],
  '0.60': [
    { nombre: 'Café molido',     cant: '15 g',   precio: '$0.13' },
    { nombre: 'Agua',            cant: '250 ml', precio: '$0.02' }
  ]
};

// Insumos (referencia para futuras integraciones)
const insumos = [
  { nombre:'Leche entera',   categoria:'Lácteos',     stock:85, unidad:'L',  precio:1.20, vence:'2025-06-15', estado:'Disponible' },
  { nombre:'Harina de trigo',categoria:'Cereales',    stock:12, unidad:'kg', precio:0.85, vence:'2025-12-01', estado:'Bajo Stock' },
  { nombre:'Pollo entero',   categoria:'Proteínas',   stock:0,  unidad:'kg', precio:4.50, vence:'2025-05-20', estado:'Agotado'    },
  { nombre:'Zanahoria',      categoria:'Vegetales',   stock:40, unidad:'kg', precio:0.60, vence:'2025-05-30', estado:'Disponible' },
  { nombre:'Café molido',    categoria:'Café',        stock:25, unidad:'kg', precio:8.50, vence:'2025-08-15', estado:'Disponible' },
  { nombre:'Aceite vegetal', categoria:'Grasas',      stock:60, unidad:'L',  precio:3.20, vence:'2025-09-10', estado:'Disponible' },
  { nombre:'Sal refinada',   categoria:'Condimentos', stock:55, unidad:'kg', precio:0.30, vence:'2026-01-01', estado:'Disponible' },
  { nombre:'Jugo de naranja',categoria:'Bebidas',     stock:30, unidad:'L',  precio:2.10, vence:'2025-06-05', estado:'Bajo Stock' }
];

// Recetas
const recetas = [
  { nombre:'Pan Francés',        categoria:'Panadería',  insumos:4, costo:1.85, estado:'Activa' },
  { nombre:'Torta de Chocolate', categoria:'Repostería', insumos:5, costo:6.20, estado:'Activa' },
  { nombre:'Mojito',             categoria:'Bebidas',    insumos:5, costo:3.15, estado:'Activa' },
  { nombre:'Café Americano',     categoria:'Bebidas',    insumos:2, costo:0.60, estado:'Activa' }
];

// Envíos
const envios = [
  { id:'ENV-001', destino:'Restaurante El Sabor', fecha:'2024-01-16', estado:'Entregado',   total:245.00 },
  { id:'ENV-002', destino:'Hotel Casa Grande',    fecha:'2024-01-20', estado:'En Tránsito', total:380.50 },
  { id:'ENV-003', destino:'Cafetería Central',    fecha:'2024-01-22', estado:'Pendiente',   total:128.75 }
];
