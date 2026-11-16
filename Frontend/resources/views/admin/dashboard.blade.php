<x-layout title="Panel Administrador | Turismo Tlalmanalco">
    <section class="min-h-[calc(100vh-5rem)] bg-slate-50 p-8">
        
        <!-- Estado de Carga -->
        <div id="cargando" class="flex justify-center items-center h-64 text-sm text-slate-400 font-semibold">
            Conectando con el backend y cargando métricas...
        </div>

        <!-- Contenido del Dashboard -->
        <div id="contenido-dashboard" class="hidden max-w-6xl mx-auto">
            
            <!-- Encabezado -->
            <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <span class="bg-purple-100 text-purple-800 text-xs font-extrabold uppercase px-3 py-1 rounded-full">
                        Panel de Administración
                    </span>
                    <h1 class="text-3xl font-extrabold text-slate-900 mt-3">Dashboard General</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Métricas en tiempo real del sistema Turismo Tlalmanalco.
                    </p>
                </div>
            </div>

            <!-- Grid de Métricas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Administradores</p>
                    <p id="metric-admins" class="text-4xl font-extrabold text-blue-600 mt-2">0</p>
                    <p id="metric-usuarios-total" class="text-xs text-slate-400 mt-2">Total usuarios: 0</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Eventos Activos</p>
                    <p id="metric-eventos" class="text-4xl font-extrabold text-green-600 mt-2">0</p>
                    <p id="metric-boletos" class="text-xs text-slate-400 mt-2">Boletos emitidos: 0</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Ventas Aprobadas</p>
                    <p id="metric-ventas" class="text-4xl font-extrabold text-purple-600 mt-2">0</p>
                    <p id="metric-ingresos" class="text-xs text-slate-400 mt-2">Ingresos: $0.00</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Tareas Pendientes</p>
                    <p id="metric-tareas" class="text-4xl font-extrabold text-red-500 mt-2">0</p>
                    <p id="metric-tareas-completadas" class="text-xs text-slate-400 mt-2">Completadas: 0</p>
                </div>
            </div>

            <!-- Accesos Rápidos -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-extrabold text-slate-800 mb-5">Herramientas de Administración</h2>
                <div class="flex flex-wrap gap-4">
                    <a href="/admin/usuarios" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3 px-6 rounded-xl shadow-sm transition flex items-center gap-2">
                        👥 Gestionar Usuarios y Roles
                    </a>
                    <a href="/admin/tareas" class="bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm py-3 px-6 rounded-xl shadow-sm transition flex items-center gap-2">
                        📋 Tareas Logísticas
                    </a>
                    <a href="/admin/publicaciones" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm py-3 px-6 rounded-xl shadow-sm transition flex items-center gap-2">
                        📢 Publicaciones y Avisos
                    </a>
                </div>
            </div>

        </div>
    </section>

    <script src="{{ asset('js/admin/dashboard.js') }}" defer></script>
</x-layout>