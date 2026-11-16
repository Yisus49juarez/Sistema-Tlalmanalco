<x-layout title="Gestión de Usuarios | Panel Admin">
    <section class="min-h-[calc(100vh-5rem)] bg-slate-50 p-8">
        <div class="max-w-6xl mx-auto">
            
            <!-- Encabezado -->
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <span class="bg-purple-100 text-purple-800 text-xs font-extrabold uppercase px-3 py-1 rounded-full">
                        Panel de Administración
                    </span>
                    <h1 class="text-3xl font-extrabold text-slate-900 mt-3">Gestión de Roles y Usuarios</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Administra los permisos de acceso de los usuarios registrados.
                    </p>
                </div>
                <a href="/admin/dashboard" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 hover:underline">
                    ← Volver al Dashboard
                </a>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Nombre / Correo</th>
                                <th class="px-6 py-4">Rol Actual</th>
                                <th class="px-6 py-4 text-right">Acción (Cambiar Rol)</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-usuarios" class="divide-y divide-slate-100">
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 font-semibold">
                                    Cargando usuarios...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div id="mensaje-feedback" class="hidden mt-4 p-4 rounded-xl text-sm font-bold text-center transition-all"></div>
        </div>
    </section>

    <script src="{{ asset('js/admin/usuarios.js') }}"defer></script>
</x-layout>