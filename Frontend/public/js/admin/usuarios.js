document.addEventListener('DOMContentLoaded', () => {

    // 1. CAPA DE INFRAESTRUCTURA (Services)
    const UsuariosService = {
        fetchUsuarios: () => window.api.get('/panel/admin/usuarios'),
        updateRol: async (id, rolId) => {
            const body = { rol_id: parseInt(rolId, 10) };

            if (typeof window.api.patch === 'function') {
                return await window.api.patch(`/panel/admin/usuarios/${id}/rol`, body);
            }

            const res = await fetch(`http://127.0.0.1:8000/api/panel/admin/usuarios/${id}/rol`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${window.api.getToken()}`
                },
                body: JSON.stringify(body)
            });
            return { ok: res.ok, status: res.status, data: await res.json() };
        }
    };

    // 2. CAPA DE PRESENTACIÓN (View)
    const UsuariosView = {
        extraerListaUsuarios: (payload) => {
            if (!payload) return [];
            if (Array.isArray(payload)) return payload;

            const candidatos = [
                payload.datos, payload.data, payload.usuarios, payload.users,
                payload.datos?.data, payload.datos?.usuarios,
                payload.data?.data, payload.data?.usuarios
            ];
            for (const item of candidatos) {
                if (Array.isArray(item)) return item;
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

        renderTabla: (payload) => {
            const tbody = document.getElementById('tabla-usuarios');
            const usuarios = UsuariosView.extraerListaUsuarios(payload);
            
            if (usuarios.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="px-6 py-10 text-center text-slate-400">No se encontraron usuarios registrados.</td></tr>';
                return;
            }

            const nombresRoles = { 1: 'Administrador', 2: 'Staff', 3: 'Turista' };

            tbody.innerHTML = usuarios.map(user => {
                const rolId = Number(user.rol_id ?? user.rol?.id ?? 3);
                const nombreRol = typeof user.rol === 'string' 
                    ? user.rol 
                    : (user.rol?.nombre || nombresRoles[rolId] || 'Turista');

                return `
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-bold text-slate-900">#${user.id}</td>
                        <td class="px-6 py-4">
                            <p class="font-extrabold text-slate-800">${user.nombre_completo || user.name || 'Sin nombre'}</p>
                            <p class="text-xs text-slate-400">${user.email}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-[11px] font-black uppercase rounded-md 
                                ${rolId === 1 ? 'bg-purple-100 text-purple-700' : 
                                  rolId === 2 ? 'bg-emerald-100 text-emerald-700' : 
                                  'bg-sky-100 text-sky-700'}">
                                ${nombreRol}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <select onchange="UsuariosController.cambiarRol(${user.id}, this)" 
                                class="bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none cursor-pointer">
                                <option value="1" ${rolId === 1 ? 'selected' : ''}>Administrador</option>
                                <option value="2" ${rolId === 2 ? 'selected' : ''}>Staff Operativo</option>
                                <option value="3" ${rolId === 3 ? 'selected' : ''}>Turista</option>
                            </select>
                        </td>
                    </tr>
                `;
            }).join('');
        },

        mostrarErrorTabla: (mensaje) => {
            document.getElementById('tabla-usuarios').innerHTML = 
                `<tr><td colspan="4" class="px-6 py-10 text-center text-rose-600 font-bold">${mensaje}</td></tr>`;
        },

        mostrarFeedback: (mensaje, esError = false) => {
            const div = document.getElementById('mensaje-feedback');
            div.textContent = mensaje;
            div.className = `mt-4 p-4 rounded-xl text-sm font-bold text-center transition-all ${esError ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700'}`;
            div.classList.remove('hidden');
            setTimeout(() => div.classList.add('hidden'), 4000);
        }
    };

    // 3. CAPA DE APLICACIÓN (Controller)
    window.UsuariosController = {
        init: async () => {
            try {
                if (!window.api?.getToken()) return window.location.href = '/login';

                const { ok, status, data } = await UsuariosService.fetchUsuarios();

                if (status === 401) {
                    window.api.clearSession();
                    return window.location.href = '/login';
                }
                if (!ok) {
                    return UsuariosView.mostrarErrorTabla(data?.mensaje || `Error ${status} al obtener usuarios.`);
                }

                UsuariosView.renderTabla(data);
            } catch (err) {
                UsuariosView.mostrarErrorTabla('Error al conectar con el servidor Backend.');
            }
        },

        cambiarRol: async (usuarioId, selectElement) => {
            const nuevoRolId = selectElement.value;
            selectElement.disabled = true;

            try {
                const { ok, data } = await UsuariosService.updateRol(usuarioId, nuevoRolId);
                if (ok) {
                    UsuariosView.mostrarFeedback(data?.mensaje || 'Rol actualizado correctamente.');
                } else {
                    const errores = data?.errores ? Object.values(data.errores).flat().join(' ') : '';
                    UsuariosView.mostrarFeedback(errores || data?.mensaje || 'Error al actualizar el rol.', true);
                }
            } catch (err) {
                UsuariosView.mostrarFeedback('Error de red al cambiar rol.', true);
            } finally {
                await window.UsuariosController.init();
            }
        }
    };

    window.UsuariosController.init();
});