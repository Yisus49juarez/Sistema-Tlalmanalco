<x-layout title="Iniciar Sesión | Turismo Tlalmanalco">
    <section class="min-h-[calc(100vh-5rem)] bg-slate-100 py-14 px-4 flex items-center justify-center">
        
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-slate-200/70 overflow-hidden">
            
            <div class="h-2 w-full bg-gradient-to-r from-amber-400 via-pink-500 via-purple-600 to-cyan-400"></div>

            <div class="p-8 sm:p-10">
                <h1 class="text-3xl font-extrabold text-sky-600 text-center tracking-tight mb-8">
                    Iniciar Sesión
                </h1>

                <div id="alert-error" class="hidden bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl p-3.5 mb-5 font-semibold"></div>

                <form id="form-login" class="space-y-5">
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Correo electrónico
                        </label>
                        <input type="email" id="email" required
                            class="w-full bg-slate-100 border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Contraseña
                        </label>
                        <input type="password" id="password" required
                            class="w-full bg-slate-100 border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 transition">
                        
                        <div class="text-right mt-2">
                            <a href="#footer-contacto" class="text-xs font-bold text-pink-600 hover:underline">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="btn-submit"
                            class="w-full bg-gradient-to-r from-sky-500 to-indigo-600 hover:from-sky-400 hover:to-indigo-500 text-white font-bold text-sm py-3.5 rounded-lg shadow-md transition cursor-pointer">
                            Iniciar Sesión
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-xs sm:text-sm text-slate-500">
                    ¿No tienes cuenta?
                    <a href="/registro" class="text-purple-700 hover:text-purple-900 font-extrabold ml-1 hover:underline">
                        Regístrate aquí
                    </a>
                </div>
            </div>
        </div>

    </section>

    <script>
        document.getElementById('form-login').addEventListener('submit', async (e) => {
            e.preventDefault();
            const alertError = document.getElementById('alert-error');
            const btnSubmit = document.getElementById('btn-submit');

            alertError.classList.add('hidden');
            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Iniciando sesión...';

            const payload = {
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };

            try {
                const { ok, data: result } = await window.api.post('/auth/login', payload);

                if (!ok) {
                    const mensajes = result.errors
                        ? Object.values(result.errors).flat().join('<br>')
                        : (result.message || 'Credenciales incorrectas.');
                    alertError.innerHTML = mensajes;
                    alertError.classList.remove('hidden');
                    return;
                }

                window.api.saveSession(result.data);
                window.location.href = result.data.redirect_to || '/cartelera';
            } catch (error) {
                alertError.textContent = 'No se pudo conectar con el servidor Backend.';
                alertError.classList.remove('hidden');
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.textContent = 'Iniciar Sesión';
            }
        });
    </script>
</x-layout>