<x-layout title="Tareas Logísticas | Panel Admin">
    <section class="min-h-[calc(100vh-5rem)] bg-slate-50 p-8">
        <div class="max-w-6xl mx-auto">
            
            <!-- Encabezado -->
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <span class="bg-amber-100 text-amber-800 text-xs font-extrabold uppercase px-3 py-1 rounded-full">
                        Panel de Administración
                    </span>
                    <h1 class="text-3xl font-extrabold text-slate-900 mt-3">Tareas Logísticas</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Asigna y supervisa tareas operativas por evento a uno o varios miembros del Staff.
                    </p>
                </div>
                <a href="/admin/dashboard" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 hover:underline">
                    ← Volver al Dashboard
                </a>
            </div>

            <!-- Formulario de Asignación -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
                <h2 class="text-base font-extrabold text-slate-800 mb-4">Asignar Nueva Tarea</h2>
                
                <form id="form-tarea" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="evento_id" class="block text-xs font-bold text-slate-700 mb-1.5">Selecciona el Evento</label>
                            <select id="evento_id" required
                                class="w-full bg-slate-100 border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm text-slate-800 font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 cursor-pointer">
                                <option value="">Cargando eventos...</option>
                            </select>
                        </div>

                        <div>
                            <label for="titulo" class="block text-xs font-bold text-slate-700 mb-1.5">Título de la Tarea</label>
                            <input type="text" id="titulo" required placeholder="Ej. Control de accesos QR"
                                class="w-full bg-slate-100 border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div>
                            <label for="descripcion_tarea" class="block text-xs font-bold text-slate-700 mb-1.5">Descripción / Detalles</label>
                            <input type="text" id="descripcion_tarea" required placeholder="Ej. Revisar vallas y pases en entrada principal"
                                class="w-full bg-slate-100 border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-bold text-slate-700">
                                Selecciona el Personal de Staff (puedes elegir uno o varios)
                            </label>
                            <button type="button" id="btn-toggle-todos"
                                class="text-xs font-extrabold text-amber-600 hover:text-amber-700 hover:underline cursor-pointer">
                                Seleccionar todos
                            </button>
                        </div>
                        <div id="contenedor-staff-checkboxes" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200 max-h-52 overflow-y-auto">
                            <p class="text-xs text-slate-400 font-semibold col-span-full">Cargando personal de Staff...</p>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" id="btn-crear-tarea"
                            class="bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm py-2.5 px-6 rounded-xl shadow-sm transition cursor-pointer">
                            + Asignar Tarea al Staff Seleccionado
                        </button>
                    </div>
                </form>
            </div>

            <div id="mensaje-feedback" class="hidden mb-6 p-4 rounded-xl text-sm font-bold text-center transition-all"></div>

            <!-- Tabla de Tareas -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Tarea / Evento</th>
                                <th class="px-6 py-4">Asignado a (Staff)</th>
                                <th class="px-6 py-4">Estatus</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-tareas" class="divide-y divide-slate-100">
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400 font-semibold">Cargando tareas...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <script src="{{ asset('js/admin/tareas.js') }}"></script>
</x-layout>