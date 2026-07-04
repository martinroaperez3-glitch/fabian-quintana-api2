const CFG = {
  negocio: {
    nombre: 'Fabián Quintana',
    subtitulo: 'Salón Masculino',
    ciudad: 'Encarnación, Paraguay',
  },
  pin: '1111',
  bloqueMin: 30,
  horarios: {
    0: [],
    1: [['14:30', '19:30']],
    2: [['09:00', '12:00'], ['14:30', '19:30']],
    3: [['09:00', '12:00'], ['14:30', '19:30']],
    4: [['09:00', '12:00'], ['14:30', '19:30']],
    5: [['09:00', '12:00'], ['14:30', '19:30']],
    6: [['09:00', '12:00'], ['14:30', '19:30']],
  },
  servicios: [
    { id: 'corte', nombre: 'Corte de Cabello', precio: 70000, dur: 30 },
    { id: 'barba', nombre: 'Arreglo de Barba', precio: 40000, dur: 30 },
    { id: 'combo', nombre: 'Combo Corte + Barba', precio: 100000, dur: 60, destacado: true },
    { id: 'color', nombre: 'Coloración', precio: 130000, dur: 60 },
  ],
};

const API_BASE = window.location.origin + '/api';
const DEFAULT_BARBER_ID = 1;

const apiFetch = async (path, options = {}) => {
  const res = await fetch(path, {
    ...options,
    headers: { 'Content-Type': 'application/json', ...(options.headers || {}) },
  });
  if (!res.ok) throw new Error(`${res.status} ${res.statusText}`);
  return await res.json();
};

async function horasDisponibles(iso, dur) {
  const servicio = CFG.servicios.find(s => s.dur == dur);
  if (!servicio) return [];
  try {
    const data = await apiFetch(`${API_BASE}/appointments/available`, {
      method: 'POST',
      body: JSON.stringify({ tenant_id: 1, barber_id: DEFAULT_BARBER_ID, service_id: servicio.id, date: iso })
    });
    return (data.slots || []).map(s => s.start);
  } catch (e) {
    console.error("Error disponibilidad:", e);
    return [];
  }
}