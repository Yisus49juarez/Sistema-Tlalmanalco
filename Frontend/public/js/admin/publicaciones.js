const iniciarPublicaciones = () => {
    if (!window.api) {
        return setTimeout(iniciarPublicaciones, 50);
    }

    // =========================================================================
    // 1. CAPA DE INFRAESTRUCTURA (Services)
    // =========================================================================
    const PublicacionesService = {
        getPublicaciones: async () => await window.api.get('/panel/admin/publicaciones'),
        createPublicacion: async (payload) => await window.api.post('/panel/admin/publicaciones', payload),
        deletePublicacion: async (id) => {
            const res = await fetch(`http://127.0.0.1:8000/api/panel/admin/publicaciones/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${window.api.getToken()}`
                }
            });
            return { ok: res.ok, status: res.status, data: await res.json() };
        }
    };

    // =========================================================================
    // 2. CAPA DE PRESENTACIÓN (View)
    // =========================================================================
    const PublicacionesView = {
        normalizarLista: (payload) => {
            if (!payload) return [];
            if (Array.isArray(payload)) return payload;

            const candidatos = [
                payload.datos, payload.data, payload.publicaciones,
                payload.datos?.data, payload.data?.data,
                payload.datos?.publicaciones, payload.data?.publicaciones
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

        renderTabla: (publicaciones) => {
            const tbody = document.getElementById('tabla-publicaciones');

            if (!publicaciones.length) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-10 text-center text-slate-400">No hay publicaciones registradas.</td></tr>';
                return;
            }

            tbody.innerHTML = publicaciones.map(pub => {
                const fecha = pub.created_at
                    ? new Date(pub.created_at).toLocaleDateString('es-MX', { year: 'numeric', month: 'short', day: 'numeric' })
                    : 'Reciente';
                const contenido = pub.contenido || pub.descripcion || '';
                const autor = pub.autor?.nombre_completo || pub.usuario?.nombre_completo || 'Administrador';
                const tipo = pub.tipo || pub.categoria || 'Anuncio';

                return `
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-bold text-slate-900">#${pub.id}</td>
                        <td class="px-6 py-4">
                            <p class="font-extrabold text-slate-800">${pub.titulo}</p>
                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">${contenido}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-emerald-100 text-emerald-800 text-[11px] font-black uppercase px-2.5 py-1 rounded-md">
                                ${tipo}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-slate-700">👤 ${autor}</p>
                            <p class="text-[11px] text-slate-400">${fecha}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="PublicacionesController.eliminar(${pub.id})"
                                class="text-xs bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold px-3 py-1.5 rounded-lg transition cursor-pointer">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        },

        mostrarErrorTabla: (mensaje) => {
            document.getElementById('tabla-publicaciones').innerHTML =
                `<tr><td colspan="5" class="px-6 py-10 text-center text-rose-600 font-bold">${mensaje}</td></tr>`;
        },

        getFormData: () => ({
            titulo: document.getElementById('titulo').value.trim(),
            tipo: document.getElementById('tipo').value,
            contenido: document.getElementById('contenido').value.trim()
        }),

        setSubmitting: (isSubmitting) => {
            const btn = document.getElementById('btn-crear-publicacion');
            btn.disabled = isSubmitting;
            btn.textContent = isSubmitting ? 'Publicando...' : '+ Publicar Ahora';
        },

        mostrarFeedback: (mensaje, esError = false) => {
            const div = document.getElementById('mensaje-feedback');
            div.textContent = mensaje;
            div.className = `mb-6 p-4 rounded-xl text-sm font-bold text-center transition-all ${esError ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700'}`;
            div.classList.remove('hidden');
            setTimeout(() => div.classList.add('hidden'), 4000);
        }
    };

    // =========================================================================
    // 3. CAPA DE APLICACIÓN (Controller)
    // =========================================================================
    window.PublicacionesController = {
        state: {
            publicaciones: []
        },

        init: async () => {
            if (!window.api.getToken()) return window.location.href = '/login';
            await window.PublicacionesController.cargarPublicaciones();
        },

        cargarPublicaciones: async () => {
            try {
                const { ok, status, data } = await PublicacionesService.getPublicaciones();

                if (status === 401) {
                    window.api.clearSession();
                    return window.location.href = '/login';
                }

                if (!ok) {
                    return PublicacionesView.mostrarErrorTabla(data?.mensaje || 'Error al obtener publicaciones.');
                }

                const lista = PublicacionesView.normalizarLista(data);
                if (lista.length || window.PublicacionesController.state.publicaciones.length === 0) {
                    window.PublicacionesController.state.publicaciones = lista;
                }

                PublicacionesView.renderTabla(window.PublicacionesController.state.publicaciones);
            } catch (err) {
                PublicacionesView.mostrarErrorTabla('Error de conexión con el servidor Backend.');
            }
        },

        crear: async (e) => {
            e.preventDefault();
            const { titulo, tipo, contenido } = PublicacionesView.getFormData();

            PublicacionesView.setSubmitting(true);

            try {
                const { ok, data } = await PublicacionesService.createPublicacion({
                    titulo,
                    tipo,
                    categoria: tipo,
                    contenido,
                    descripcion: contenido
                });

                if (ok) {
                    const nueva = data?.datos || data?.data || data?.publicacion || {
                        id: Date.now(),
                        titulo,
                        tipo,
                        contenido,
                        created_at: new Date().toISOString()
                    };
                    window.PublicacionesController.state.publicaciones.unshift(nueva);

                    document.getElementById('form-publicacion').reset();
                    PublicacionesView.mostrarFeedback(data?.mensaje || 'Publicación creada correctamente.');
                    await window.PublicacionesController.cargarPublicaciones();
                } else {
                    const errores = data?.errores ? Object.values(data.errores).flat().join(' ') : '';
                    PublicacionesView.mostrarFeedback(errores || data?.mensaje || 'Error al guardar la publicación.', true);
                }
            } catch (err) {
                PublicacionesView.mostrarFeedback('Error de red al intentar publicar.', true);
            } finally {
                PublicacionesView.setSubmitting(false);
            }
        },

        eliminar: async (id) => {
            if (!confirm('¿Seguro que deseas eliminar esta publicación?')) return;

            try {
                const { ok, data } = await PublicacionesService.deletePublicacion(id);
                if (ok) {
                    window.PublicacionesController.state.publicaciones =
                        window.PublicacionesController.state.publicaciones.filter(p => p.id !== id);
                }
                PublicacionesView.mostrarFeedback(data?.mensaje || (ok ? 'Publicación eliminada.' : 'Error al eliminar.'), !ok);
                await window.PublicacionesController.cargarPublicaciones();
            } catch (err) {
                PublicacionesView.mostrarFeedback('Error de red al eliminar.', true);
            }
        }
    };

    document.getElementById('form-publicacion').addEventListener('submit', window.PublicacionesController.crear);

    window.PublicacionesController.init();
};

iniciarPublicaciones();