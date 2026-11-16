(function () {

    // 1. CAPA DE INFRAESTRUCTURA (Services)
    const DashboardService = {
        fetchMetrics: async () => {
            if (window.api && typeof window.api.get === 'function') {
                return await window.api.get('/panel/admin/dashboard');
            }
            // Respaldo directo con fetch si window.api tarda en cargar
            const token = localStorage.getItem('token') || localStorage.getItem('auth_token');
            const res = await fetch('http://127.0.0.1:8000/api/panel/admin/dashboard', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            return { ok: res.ok, status: res.status, data: await res.json() };
        },
        getToken: () => {
            return window.api?.getToken?.() || localStorage.getItem('token') || localStorage.getItem('auth_token');
        }
    };

    // 2. CAPA DE PRESENTACIÓN (View)
    const DashboardView = {
        mostrarErrorEstado: (mensaje) => {
            const cargando = document.getElementById('cargando');
            if (cargando) {
                cargando.className = 'max-w-xl mx-auto my-12 p-6 bg-rose-50 border border-rose-200 rounded-2xl text-center text-rose-700 font-bold text-sm';
                cargando.textContent = mensaje;
            }
        },
        mostrarContenido: () => {
            document.getElementById('cargando')?.classList.add('hidden');
            document.getElementById('contenido-dashboard')?.classList.remove('hidden');
        },
        renderizarDatos: (payload) => {
            const metricas = payload?.datos || payload?.data || payload || {};

            const admins = metricas.usuarios?.por_rol?.administradores 
                ?? metricas.usuarios?.por_rol?.Administrador 
                ?? metricas.usuarios?.total_administradores 
                ?? 0;
            document.getElementById('metric-admins').textContent = admins;
            document.getElementById('metric-usuarios-total').textContent = `Total usuarios: ${metricas.usuarios?.total ?? 0}`;

            document.getElementById('metric-eventos').textContent = metricas.eventos?.activos ?? metricas.eventos?.total_eventos ?? 0;
            const boletosEmitidos = metricas.boletos?.total_emitidos ?? metricas.eventos?.boletos_emitidos ?? 0;
            document.getElementById('metric-boletos').textContent = `Boletos emitidos: ${boletosEmitidos}`;

            const ventas = metricas.tienda?.pedidos_pagados ?? metricas.tienda?.pedidos_aprobados ?? metricas.finanzas?.pedidos_pagados ?? 0;
            const ingresos = metricas.tienda?.ingresos_totales ?? metricas.finanzas?.ingresos_totales ?? 0;
            document.getElementById('metric-ventas').textContent = ventas;
            document.getElementById('metric-ingresos').textContent = `Ingresos: $${parseFloat(ingresos || 0).toFixed(2)}`;

            document.getElementById('metric-tareas').textContent = metricas.logistica?.tareas_pendientes ?? 0;
            document.getElementById('metric-tareas-completadas').textContent = `Completadas: ${metricas.logistica?.tareas_completadas ?? 0}`;
        }
    };

    // 3. CAPA DE APLICACIÓN (Controller)
    const DashboardController = {
        init: async () => {
            try {
                // Esperamos hasta 1 segundo si Vite aún está inicializando window.api
                let intentos = 0;
                while (!window.api && intentos < 20) {
                    await new Promise(r => setTimeout(r, 50));
                    intentos++;
                }

                if (!DashboardService.getToken()) {
                    window.location.href = '/login';
                    return;
                }

                const { ok, status, data } = await DashboardService.fetchMetrics();

                if (status === 401) {
                    window.api?.clearSession?.();
                    window.location.href = '/login';
                    return;
                }

                if (status === 403 || !ok) {
                    DashboardView.mostrarErrorEstado(data?.mensaje || `Error ${status}: No se pudieron cargar las métricas.`);
                    return;
                }

                DashboardView.renderizarDatos(data);
                DashboardView.mostrarContenido();
            } catch (error) {
                console.error('Error en DashboardController:', error);
                DashboardView.mostrarErrorEstado('Error al conectar con el Backend (http://127.0.0.1:8000). Verifica que php artisan serve esté activo en Backend.');
            }
        }
    };

    // Se ejecuta inmediatamente si el DOM ya cargó, o espera a que esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', DashboardController.init);
    } else {
        DashboardController.init();
    }
})();