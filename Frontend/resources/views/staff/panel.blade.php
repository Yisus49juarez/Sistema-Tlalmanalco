<x-layout title="Panel Operativo Staff | Turismo Tlalmanalco">
    <section class="min-h-[calc(100vh-5rem)] bg-white flex items-center justify-center p-6">
        <div id="cargando" class="text-sm text-slate-400 font-semibold">Verificando permisos de Staff Operativo...</div>

        <div id="contenido-rol" class="hidden max-w-2xl w-full border border-slate-200 rounded-2xl p-8 shadow-sm">
            <span class="bg-emerald-100 text-emerald-800 text-xs font-extrabold uppercase px-3 py-1 rounded-full">
                Área Operativa y Logística
            </span>
            <h1 class="text-3xl font-extrabold text-slate-900 mt-3">
                Rol: <span id="nombre-rol" class="text-emerald-700"></span>
            </h1>
            <p class="text-sm text-slate-500 mt-1 mb-6">
                Sesión iniciada como: <strong id="nombre-usuario" class="text-slate-800"></strong>
            </p>

            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200 mb-6">
                <h2 class="text-xs font-extrabold uppercase text-slate-500 mb-3">Módulos habilitados para este rol:</h2>
                <ul id="lista-permisos" class="space-y-2 text-sm text-slate-700 font-medium list-disc list-inside"></ul>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            if (!window.api.getToken()) return window.location.href = '/login';

            const { ok, status, data } = await window.api.get('/panel/staff');

            if (status === 401) { window.api.clearSession(); return window.location.href = '/login'; }
            if (status === 403 || !ok) { alert('Acceso restringido únicamente al personal de Staff.'); return window.location.href = '/'; }

            document.getElementById('cargando').classList.add('hidden');
            document.getElementById('nombre-rol').textContent = data.rol;
            document.getElementById('nombre-usuario').textContent = `${data.usuario} (${data.email})`;
            document.getElementById('lista-permisos').innerHTML = data.permisos.map(p => `<li>${p}</li>`).join('');
            document.getElementById('contenido-rol').classList.remove('hidden');
        });
    </script>
</x-layout>