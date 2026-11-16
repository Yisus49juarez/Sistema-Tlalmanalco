document.addEventListener('DOMContentLoaded', () => {

    // 1. CAPA DE INFRAESTRUCTURA (Services)
    const TareasService = {
        getTareas: () => window.api.get('/panel/admin/tareas'),
        getUsuarios: () => window.api.get('/panel/admin/usuarios'),
        getEventos: () => window.api.get('/inicio'),
        createTarea: (payload) => window.api.post('/panel/admin/tareas', payload),
        updateEstatus: async (id, estatus) => {
            const res = await fetch(`http://127.0.0.1:8000/api/panel/admin/tareas/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${window.api.getToken()}`
                },
                body: JSON.stringify({ estatus, estado: estatus })
            });
            return { ok: res.ok, status: res.status, data: await res.json() };
        },
        deleteTarea: async (id) => {
            const res = await fetch(`http://127.0.0.1:8000/api/panel/admin/tareas/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${window.api.getToken()}`
                }
            });
            return { ok: res.ok, status: res.status, data: await res.json() };
        }
    };

    // 2. CAPA DE PRESENTACIÓN (View)
    const TareasView = {
        normalizarLista: (payload) => {
            if (!payload) return [];
            if (Array.isArray(payload)) return payload;

            const candidatos = [
                payload.datos, payload.data, payload.tareas, payload.tareas_logisticas,
                payload.usuarios, payload.eventos,
                payload.datos?.data, payload.data?.data,
                payload.datos?.tareas, payload.data?.tareas,
                payload.datos?.proximos_eventos, payload.data?.proximos_eventos,
                payload.datos?.eventos, payload.data?.eventos,
                payload.datos?.usuarios, payload.data?.usuarios
            ];
            for (const c of candidatos) {
                if (Array.isArray(c)) return c;
            }

            for (const key of Object.keys(payload)) {
                const val = payload[key];
                if (Array.isArray(val)) return val;
                if (val && typeof val === 'object') {
                    for (const subKey of Object.keys(val)) {
                        if (Array.isArray(val[subKey])) return val[subKey];
                    }
                }
            }
            return [];
        },

        renderEventosSelect: (eventos) => {
            const select = document.getElementById('evento_id');
            if (!eventos.length) {
                select.innerHTML = '<option value="">Sin eventos disponibles</option>';
                return;
            }
            select.innerHTML = '<option value="" disabled selected>-- Elige un evento --</option>' +
                eventos.map(ev => `<option value="${ev.id}">${ev.titulo || ev.nombre} ${ev.lugar ? `(${ev.lugar})` : ''}</option>`).join('');
        },

        renderStaffCheckboxes: (staffList) => {
            const box = document.getElementById('contenedor-staff-checkboxes');
            if (!staffList.length) {
                box.innerHTML = '<p class="col-span-full text-xs text-rose-600 font-bold">No hay personal con rol Staff registrado.</p>';
                return;
            }
            box.innerHTML = staffList.map(u => `
                <label class="flex items-center gap-3 bg-white p-3 rounded-xl border border-slate-200 hover:border-amber-400 cursor-pointer">
                    <input type="checkbox" value="${u.id}" class="checkbox-staff w-4 h-4 text-amber-500 rounded">
                    <div class="overflow-hidden">
                        <p class="text-xs font-extrabold text-slate-800 truncate">${u.nombre_completo || u.name}</p>
                        <p class="text-[11px] text-slate-400 truncate">${u.email}</p>
                    </div>
                </label>
            `).join('');
        },

        renderTabla: (tareas, diccionarios) => {
            const tbody = document.getElementById('tabla-tareas');
            if (!tareas.length) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-10 text-center text-slate-400">No hay tareas logísticas registradas.</td></tr>';
                return;
            }

            tbody.innerHTML = tareas.map(t => {
                const estatus = t.estatus || t.estado || 'Pendiente';
                const completada = estatus.toLowerCase().includes('complet');
                const titulo = t.titulo || t.descripcion_tarea || t.descripcion || 'Sin título';
                const detalle = (t.titulo && (t.descripcion_tarea || t.descripcion)) ? (t.descripcion_tarea || t.descripcion) : '';
                const nombreEvento = t.evento?.titulo || t.evento?.nombre || diccionarios.eventos[t.evento_id] || `Evento #${t.evento_id}`;
                const staffId = t.staff_id || t.user_id || t.usuario_id;
                const nombreStaff = t.staff?.nombre_completo || t.staff?.name || diccionarios.staff[staffId] || `Staff #${staffId}`;

                return `
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-bold text-slate-900">#${t.id}</td>
                        <td class="px-6 py-4">
                            <p class="font-extrabold text-slate-800">${titulo}</p>
                            ${detalle ? `<p class="text-xs text-slate-500 mt-0.5">${detalle}</p>` : ''}
                            <span class="text-xs text-indigo-600 font-bold mt-1 inline-flex items-center gap-1 bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100">
                                📍 ${nombreEvento}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-2.5 py-1 rounded-lg text-xs font-bold">
                                👤 ${nombreStaff}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <select onchange="TareasController.cambiarEstatus(${t.id}, this.value)"
                                class="text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200 cursor-pointer ${completada ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'}">
                                <option value="Pendiente" ${!completada ? 'selected' : ''}>Pendiente</option>
                                <option value="Completada" ${completada ? 'selected' : ''}>Completada</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="TareasController.eliminar(${t.id})" class="text-xs bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold px-3 py-1.5 rounded-lg cursor-pointer">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        },

        getFormData: () => ({
            eventoId: parseInt(document.getElementById('evento_id').value, 10),
            titulo: document.getElementById('titulo').value.trim(),
            descripcion: document.getElementById('descripcion_tarea').value.trim(),
            staffIds: Array.from(document.querySelectorAll('.checkbox-staff:checked')).map(cb => parseInt(cb.value, 10))
        }),

        setSubmitting: (isSubmitting) => {
            const btn = document.getElementById('btn-crear-tarea');
            btn.disabled = isSubmitting;
            btn.textContent = isSubmitting ? 'Asignando...' : '+ Asignar Tarea al Staff Seleccionado';
        },

        mostrarFeedback: (msg, esError = false) => {
            const div = document.getElementById('mensaje-feedback');
            div.textContent = msg;
            div.className = `mb-6 p-4 rounded-xl text-sm font-bold text-center ${esError ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700'}`;
            div.classList.remove('hidden');
            setTimeout(() => div.classList.add('hidden'), 4000);
        }
    };

    // 3. CAPA DE APLICACIÓN (Controller)
    window.TareasController = {
        state: {
            tareas: [],
            diccionarios: { staff: {}, eventos: {} }
        },

        init: async () => {
            if (!window.api?.getToken()) return window.location.href = '/login';

            const [resUsuarios, resEventos] = await Promise.all([
                TareasService.getUsuarios(),
                TareasService.getEventos()
            ]);

            if (resUsuarios.status === 401) {
                window.api.clearSession();
                return window.location.href = '/login';
            }

            if (resUsuarios.ok) {
                const usuarios = TareasView.normalizarLista(resUsuarios.data);
                usuarios.forEach(u => window.TareasController.state.diccionarios.staff[u.id] = u.nombre_completo || u.name);
                const staff = usuarios.filter(u => Number(u.rol_id) === 2 || u.rol?.nombre?.toLowerCase() === 'staff');
                TareasView.renderStaffCheckboxes(staff);
            }

            if (resEventos.ok) {
                const eventos = TareasView.normalizarLista(resEventos.data);
                eventos.forEach(e => window.TareasController.state.diccionarios.eventos[e.id] = e.titulo || e.nombre);
                TareasView.renderEventosSelect(eventos);
            }

            await window.TareasController.cargarTareas();
        },

        cargarTareas: async () => {
            const { ok, data } = await TareasService.getTareas();
            if (ok) {
                const lista = TareasView.normalizarLista(data);
                if (lista.length) window.TareasController.state.tareas = lista;
            }
            TareasView.renderTabla(window.TareasController.state.tareas, window.TareasController.state.diccionarios);
        },

        crearMasivo: async (e) => {
            e.preventDefault();
            const { eventoId, titulo, descripcion, staffIds } = TareasView.getFormData();

            if (!eventoId || !staffIds.length) {
                return TareasView.mostrarFeedback('Selecciona un evento y al menos un miembro del Staff.', true);
            }

            TareasView.setSubmitting(true);
            let creadas = 0;
            let errorMsg = '';

            for (const staffId of staffIds) {
                const { ok, data } = await TareasService.createTarea({
                    evento_id: eventoId,
                    staff_id: staffId,
                    titulo,
                    descripcion,
                    descripcion_tarea: descripcion
                });

                if (ok) {
                    creadas++;
                    const nueva = data?.datos || data?.data || data?.tarea || {
                        id: Date.now() + creadas,
                        evento_id: eventoId,
                        staff_id: staffId,
                        titulo,
                        descripcion_tarea: descripcion,
                        estatus: 'Pendiente'
                    };
                    window.TareasController.state.tareas.unshift(nueva);
                } else {
                    const errores = data?.errores ? Object.values(data.errores).flat().join(' ') : '';
                    errorMsg = errores || data?.mensaje || 'Error al guardar tarea.';
                }
            }

            TareasView.setSubmitting(false);

            if (creadas > 0) {
                document.getElementById('form-tarea').reset();
                TareasView.mostrarFeedback(`Tarea asignada a ${creadas} miembro(s) del Staff.`);
                await window.TareasController.cargarTareas();
            } else {
                TareasView.mostrarFeedback(errorMsg, true);
            }
        },

        cambiarEstatus: async (id, estatus) => {
            const { ok, data } = await TareasService.updateEstatus(id, estatus);
            TareasView.mostrarFeedback(data?.mensaje || (ok ? 'Estatus actualizado.' : 'Error al actualizar.'), !ok);
            await window.TareasController.cargarTareas();
        },

        eliminar: async (id) => {
            if (!confirm('¿Eliminar esta tarea logística?')) return;
            const { ok, data } = await TareasService.deleteTarea(id);
            if (ok) window.TareasController.state.tareas = window.TareasController.state.tareas.filter(t => t.id !== id);
            TareasView.mostrarFeedback(data?.mensaje || 'Tarea eliminada.', !ok);
            await window.TareasController.cargarTareas();
        },

        toggleTodosStaff: () => {
            const checks = Array.from(document.querySelectorAll('.checkbox-staff'));
            const todos = checks.every(c => c.checked);
            checks.forEach(c => c.checked = !todos);
        }
    };

    document.getElementById('form-tarea').addEventListener('submit', window.TareasController.crearMasivo);
    document.getElementById('btn-toggle-todos').addEventListener('click', window.TareasController.toggleTodosStaff);

    window.TareasController.init();
});