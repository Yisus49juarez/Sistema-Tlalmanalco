<!-- Línea superior turquesa de la maqueta -->
<div class="h-1.5 w-full bg-gradient-to-r from-teal-400 via-emerald-400 to-cyan-500"></div>

<header class="bg-white shadow-sm sticky top-0 z-50 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        
        <!-- Logo: Turismo Tlalmanalco (Morado con emblema colorido) -->
        <a href="/" class="flex items-center gap-3 group">
            <span class="text-xl sm:text-2xl font-extrabold tracking-tight text-purple-800 group-hover:text-purple-600 transition">
                Turismo Tlalmanalco
            </span>
            <!-- Emblema multicolor inspirado en el logo de la maqueta -->
            <div class="flex items-end gap-0.5 h-8">
                <span class="w-1.5 h-5 bg-amber-400 rounded-full transform -rotate-12"></span>
                <span class="w-1.5 h-7 bg-orange-500 rounded-full transform -rotate-6"></span>
                <span class="w-1.5 h-8 bg-pink-500 rounded-full"></span>
                <span class="w-1.5 h-7 bg-emerald-500 rounded-full transform rotate-6"></span>
                <span class="w-1.5 h-6 bg-sky-500 rounded-full transform rotate-12"></span>
            </div>
        </a>

        <!-- Enlaces Centrales con los colores exactos de la Ilustración 6 -->
        <nav class="hidden md:flex items-center gap-8 text-sm font-extrabold">
            <a href="/#carrusel-lugares" class="text-pink-600 hover:text-pink-500 transition">
                Lugares
            </a>
            <a href="/#seccion-eventos" class="text-emerald-600 hover:text-emerald-500 transition">
                Eventos
            </a>
            <a href="/#seccion-eventos" class="text-sky-500 hover:text-sky-400 transition">
                Souvenirs
            </a>
            <a href="#footer-contacto" class="text-purple-700 hover:text-purple-500 transition">
                Contacto
            </a>
        </nav>

        <!-- Botones Superiores: Iniciar Sesión y Crear Cuenta -->
        <div id="nav-guest" class="flex items-center gap-3">
            <a href="/login" class="text-xs sm:text-sm font-bold text-slate-600 hover:text-purple-700 px-3.5 py-2 rounded-lg hover:bg-slate-100 transition">
                Iniciar Sesión
            </a>
            <a href="/registro" class="text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-purple-700 to-sky-500 hover:from-purple-600 hover:to-sky-400 px-4 py-2 rounded-lg shadow-sm transition">
                Crear Cuenta
            </a>
        </div>

        <!-- Estado de Usuario Autenticado -->
        <div id="nav-auth" class="hidden items-center gap-3 bg-slate-50 px-3.5 py-1.5 rounded-xl border border-slate-200">
            <span id="nav-user-role" class="text-[11px] font-extrabold uppercase tracking-wider bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-full"></span>
            <span id="nav-user-name" class="text-sm font-bold text-slate-700"></span>
            <button id="btn-logout" class="text-xs bg-rose-500 hover:bg-rose-600 text-white font-bold px-3 py-1.5 rounded-lg transition cursor-pointer">
                Salir
            </button>
        </div>

    </div>
</header>