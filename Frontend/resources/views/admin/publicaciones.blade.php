<x-layout title="Publicaciones | Panel Admin">
    <section class="min-h-[calc(100vh-5rem)] bg-slate-50 p-8">
        <div class="max-w-6xl mx-auto">
            
            <!-- Encabezado -->
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <span class="bg-emerald-100 text-emerald-800 text-xs font-extrabold uppercase px-3 py-1 rounded-full">
                        Panel de Administración
                    </span>
                    <h1 class="text-3xl font-extrabold text-slate-900 mt-3">
                        Gestión de Publicaciones
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Publica avisos oficiales, noticias y atractivos culturales para los turistas.
                    </p>
                </div>
                <a href="/admin/dashboard" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 hover:underline">
                    ← Volver al Dashboard
                </a>
            </div>

            <!-- Formulario para Crear Nueva Publicación -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
                <h2 class="text-base font-extrabold text-slate-800 mb-4">Nueva Publicación</h2>
                
                <form id="form-publicacion" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="titulo" class="block text-xs font-bold text-slate-700 mb-1.5">Título</label>
                        <input type="text" id="titulo" required placeholder="Ej. Feria del Elote 2026"
                            class="w-full bg-slate-100 border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label for="tipo" class="block text-xs font-bold text-slate-700 mb-1.5">Categoría / Tipo</label>
                        <select id="tipo"
                            class="w-full bg-slate-100 border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                            <option value="Anuncio">Anuncio Oficial</option>
                            <option value="Noticia">Noticia Cultural</option>
                            <option value="Lugar Turistico">Lugar Turístico</option>
                        </select>
                    </div>

                    <div>
                        <label for="contenido" class="block text-xs font-bold text-slate-700 mb-1.5">Contenido / Descripción</label>
                        <input type="text" id="contenido" required placeholder="Escribe el detalle del aviso o reseña histórica..."
                            class="w-full bg-slate-100 border border-slate-200 rounded-lg px-3.5 py-2.5 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="md:col-span-3 flex justify-end mt-2">
                        <button type="submit" id="btn-crear-publicacion"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm py-2.5 px-6 rounded-xl shadow-sm transition cursor-pointer">
                            + Publicar Ahora
                        </button>
                    </div>
                </form>
            </div>

            <div id="mensaje-feedback" class="hidden mb-6 p-4 rounded-xl text-sm font-bold text-center transition-all"></div>

            <!-- Tabla de Publicaciones -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Título y Contenido</th>
                                <th class="px-6 py-4">Tipo</th>
                                <th class="px-6 py-4">Autor / Fecha</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-publicaciones" class="divide-y divide-slate-100">
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400 font-semibold">
                                    Cargando publicaciones...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </section>

    <script src="{{ asset('js/admin/publicaciones.js') }}"></script>
</x-layout>