<x-layout title="Crear Cuenta | Turismo Tlalmanalco">
    <section class="min-h-[calc(100vh-5rem)] bg-slate-100 py-14 px-4 flex items-center justify-center">
        
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-slate-200/70 overflow-hidden">
            
            <!-- Barra superior arcoíris/multicolor de la Ilustración 7 -->
            <div class="h-2 w-full bg-gradient-to-r from-amber-400 via-pink-500 via-purple-600 to-cyan-400"></div>

            <div class="p-8 sm:p-10">
                <h1 class="text-3xl font-extrabold text-purple-800 tracking-tight">
                    Crear Cuenta
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1.5 mb-7">
                    Regístrate para vivir la experiencia turística completa.
                </p>

                <!-- Alerta de Errores -->
                <div id="alert-error" class="hidden bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl p-3.5 mb-5 font-semibold"></div>

                <form id="form-registro" class="space-y-5">
                    <div>
                        <label for="nombre_completo" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Nombre completo
                        </label>
                        <input type="text" id="nombre_completo" required
                            class="w-full bg-slate-100 border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-600 transition">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Correo electrónico
                        </label>
                        <input type="email" id="email" required
                            class="w-full bg-slate-100 border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-600 transition">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Contraseña
                        </label>
                        <input type="password" id="password" required minlength="8"
                            class="w-full bg-slate-100 border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-600 transition">
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="btn-submit"
                            class="w-full bg-gradient-to-r from-purple-700 to-indigo-600 hover:from-purple-600 hover:to-indigo-500 text-white font-bold text-sm py-3.5 rounded-lg shadow-md transition cursor-pointer">
                            Crear Cuenta
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-xs sm:text-sm text-slate-500">
                    ¿Ya tienes una cuenta?
                    <a href="/login" class="text-sky-500 hover:text-sky-600 font-extrabold ml-1 hover:underline">
                        Inicia sesión
                    </a>
                </div>
            </div>
        </div>

    </section>

    <script>
        document.getElementById('form-registro').addEventListener('submit', async (e) => {
            e.preventDefault();
            const alertError = document.getElementById('alert-error');
            const btnSubmit = document.getElementById('btn-submit');
            const passwordVal = document.getElementById('password').value;

            alertError.classList.add('hidden');
            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Registrando...';

            const payload = {
                nombre_completo: document.getElementById('nombre_completo').value,
                email: document.getElementById('email').value,
                password: passwordVal,
                password_confirmation: passwordVal
            };

            try {
                const { ok, data: result } = await window.api.post('/auth/register', payload);

                if (!ok) {
                    const mensajes = result.errors
                        ? Object.values(result.errors).flat().join('<br>')
                        : (result.message || 'Error al crear la cuenta.');
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
                btnSubmit.textContent = 'Crear Cuenta';
            }
        });
    </script>
</x-layout>