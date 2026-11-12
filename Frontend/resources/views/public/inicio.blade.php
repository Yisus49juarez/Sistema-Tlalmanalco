<x-layout title="Turismo Tlalmanalco | Inicio">

    <!-- Barra degradada morado-turquesa sobre el banner (Ilustración 6) -->
    <div class="h-2 w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-emerald-400"></div>

    <!-- SECCIÓN 1: HERO BANNER Y CARRUSEL DE LUGARES TURÍSTICOS -->
    <section id="carrusel-lugares" class="relative w-full h-[430px] sm:h-[480px] bg-slate-900 overflow-hidden select-none">
        
        <!-- Contenedor dinámico de Slides del Carrusel -->
        <div id="carousel-slides" class="relative w-full h-full">
            <!-- Slide inicial mientras responde la API -->
            <div class="relative w-full h-full flex items-center justify-center">
                <img src="https://images.unsplash.com/photo-1518638150340-f706e86654de?auto=format&fit=crop&w=1920&q=85"
                     alt="Volcán Iztaccíhuatl y Bosques de Tlalmanalco"
                     class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-slate-950/45"></div>
                <div class="relative z-10 text-center px-4 max-w-4xl mx-auto text-white">
                    <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold tracking-tight drop-shadow-md mb-4">
                        Descubre la Magia de Tlalmanalco
                    </h1>
                    <p class="text-sm sm:text-lg text-slate-100 font-medium max-w-2xl mx-auto drop-shadow mb-8">
                        Explora nuestros volcanes, bosques, arquitectura colonial y eventos culturales.
                    </p>
                    <a href="#seccion-eventos" class="inline-block bg-slate-900/75 hover:bg-purple-700 text-white text-xs sm:text-sm font-bold px-6 py-3 rounded-lg border border-white/30 backdrop-blur-sm transition shadow-lg">
                        Explorar Próximos Eventos
                    </a>
                </div>
            </div>
        </div>

        <!-- Flecha Izquierda del Carrusel -->
        <button id="btn-prev" aria-label="Anterior"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-black/40 hover:bg-purple-700 text-white flex items-center justify-center backdrop-blur-sm border border-white/25 transition cursor-pointer">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <!-- Flecha Derecha del Carrusel -->
        <button id="btn-next" aria-label="Siguiente"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-black/40 hover:bg-purple-700 text-white flex items-center justify-center backdrop-blur-sm border border-white/25 transition cursor-pointer">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <!-- Indicadores inferiores del Carrusel -->
        <div id="carousel-dots" class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 bg-black/35 backdrop-blur-md px-3.5 py-1.5 rounded-full">
        </div>
    </section>

    <!-- SECCIÓN 2 (SEPARADA ABAJO): PRÓXIMOS EVENTOS DESTACADOS (Ilustración 6) -->
    <section id="seccion-eventos" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-purple-900">
                Próximos Eventos Destacados
            </h2>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full">
                Cartelera Oficial Tlalmanalco
            </span>
        </div>

        <!-- Grid de 3 Columnas idéntico a la Ilustración 6 -->
        <div id="contenedor-eventos" class="grid grid-cols-1 md:grid-cols-3 gap-7">
            <p class="text-slate-400 text-sm">Cargando próximos eventos...</p>
        </div>

    </section>

    <script>
        // Imágenes de alta calidad para el carrusel de Lugares Turísticos
        const imagenesCarrusel = [
            'https://images.unsplash.com/photo-1518638150340-f706e86654de?auto=format&fit=crop&w=1920&q=85',
            'https://images.unsplash.com/photo-1585464231875-d9ef1f5ad396?auto=format&fit=crop&w=1920&q=85',
            'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=1920&q=85',
            'https://images.unsplash.com/photo-1518998053901-5348d3961a04?auto=format&fit=crop&w=1920&q=85'
        ];

        // Colores de encabezado de las tarjetas de eventos según la Ilustración 6 (Azul, Verde, Naranja)
        const coloresTarjetas = [
            'bg-sky-500',
            'bg-emerald-500',
            'bg-amber-500'
        ];

        let slideActual = 0;
        let totalSlides = 0;
        let timerCarrusel = null;

        function irASlide(index) {
            const slides = document.querySelectorAll('.slide-lugar');
            const dots = document.querySelectorAll('.dot-lugar');
            if (!slides.length) return;

            slideActual = (index + totalSlides) % totalSlides;

            slides.forEach((s, i) => {
                if (i === slideActual) {
                    s.classList.remove('opacity-0', 'pointer-events-none');
                    s.classList.add('opacity-100');
                } else {
                    s.classList.remove('opacity-100');
                    s.classList.add('opacity-0', 'pointer-events-none');
                }
            });

            dots.forEach((d, i) => {
                d.className = i === slideActual
                    ? 'dot-lugar w-6 h-2 rounded-full bg-white transition-all cursor-pointer'
                    : 'dot-lugar w-2 h-2 rounded-full bg-white/50 hover:bg-white/80 transition-all cursor-pointer';
            });
        }

        function iniciarAutoPlay() {
            if (timerCarrusel) clearInterval(timerCarrusel);
            timerCarrusel = setInterval(() => irASlide(slideActual + 1), 5000);
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const slidesEl = document.getElementById('carousel-slides');
            const dotsEl = document.getElementById('carousel-dots');
            const eventosEl = document.getElementById('contenedor-eventos');

            try {
                const { ok, data: result } = await window.api.get('/inicio');
                if (!ok) throw new Error('Error al obtener datos de inicio');
                const { lugares_turisticos, proximos_eventos } = result.data;

                // Armar slides combinando la portada principal + los lugares turísticos de la API
                const listaSlides = [
                    {
                        titulo: 'Descubre la Magia de Tlalmanalco',
                        subtitulo: 'Explora nuestros volcanes, bosques, arquitectura colonial y eventos culturales.',
                        ubicacion: 'Tlalmanalco, Estado de México'
                    },
                    ...lugares_turisticos.map(l => ({
                        titulo: l.nombre,
                        subtitulo: l.descripcion,
                        ubicacion: l.ubicacion
                    }))
                ];

                totalSlides = listaSlides.length;

                slidesEl.innerHTML = listaSlides.map((item, idx) => `
                    <div class="slide-lugar absolute inset-0 w-full h-full transition-opacity duration-700 ${idx === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none'}">
                        <img src="${imagenesCarrusel[idx % imagenesCarrusel.length]}" alt="${item.titulo}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-slate-950/45"></div>
                        <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-4 max-w-4xl mx-auto text-white">
                            <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold uppercase tracking-widest px-3.5 py-1 rounded-full mb-3 border border-white/30">
                                📍 ${item.ubicacion}
                            </span>
                            <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight drop-shadow-md mb-4">
                                ${item.titulo}
                            </h2>
                            <p class="text-sm sm:text-lg text-slate-100 font-medium max-w-2xl mx-auto drop-shadow mb-7">
                                ${item.subtitulo}
                            </p>
                            <a href="#seccion-eventos" class="inline-block bg-slate-900/75 hover:bg-purple-700 text-white text-xs sm:text-sm font-bold px-6 py-3 rounded-lg border border-white/30 backdrop-blur-sm transition shadow-lg">
                                Explorar Próximos Eventos
                            </a>
                        </div>
                    </div>
                `).join('');

                dotsEl.innerHTML = listaSlides.map((_, idx) => `
                    <button onclick="irASlide(${idx}); iniciarAutoPlay();" aria-label="Slide ${idx + 1}"
                        class="dot-lugar ${idx === 0 ? 'w-6 bg-white' : 'w-2 bg-white/50'} h-2 rounded-full transition-all cursor-pointer"></button>
                `).join('');

                document.getElementById('btn-prev').addEventListener('click', () => {
                    irASlide(slideActual - 1);
                    iniciarAutoPlay();
                });

                document.getElementById('btn-next').addEventListener('click', () => {
                    irASlide(slideActual + 1);
                    iniciarAutoPlay();
                });

                iniciarAutoPlay();

                // Renderizar Tarjetas de Eventos con el estilo de la Ilustración 6
                eventosEl.innerHTML = proximos_eventos.map((evento, idx) => {
                    const colorBloque = coloresTarjetas[idx % coloresTarjetas.length];
                    const fechaFormateada = new Date(evento.fecha_hora).toLocaleDateString('es-MX', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });

                    return `
                        <article class="bg-white rounded-2xl shadow-sm hover:shadow-md border border-slate-200/80 overflow-hidden transition flex flex-col">
                            <!-- Bloque superior de color sólido como en la Ilustración 6 -->
                            <div class="${colorBloque} h-40 w-full flex flex-col justify-between p-4 text-white relative overflow-hidden">
                                <div class="flex justify-between items-center text-xs font-bold">
                                    <span class="bg-black/20 backdrop-blur-xs px-2.5 py-1 rounded-md">
                                        📍 ${evento.lugar}
                                    </span>
                                    <span class="bg-white/25 px-2.5 py-1 rounded-md">
                                        ${parseFloat(evento.precio) === 0 ? 'Gratis' : '$' + parseFloat(evento.precio).toFixed(2)}
                                    </span>
                                </div>
                                <div class="text-right opacity-25 text-6xl font-black select-none">
                                    <i class="fa-solid fa-calendar-star"></i>
                                </div>
                            </div>

                            <!-- Cuerpo blanco inferior -->
                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div>
                                    <h3 class="text-base font-extrabold text-slate-900 mb-1">
                                        ${evento.titulo}
                                    </h3>
                                    <p class="text-xs text-slate-500 font-medium mb-3">
                                        ${fechaFormateada}
                                    </p>
                                    <p class="text-xs text-slate-600 line-clamp-2 mb-4">
                                        ${evento.descripcion ?? ''}
                                    </p>
                                </div>
                                <div>
                                    <a href="/login" class="text-xs font-extrabold text-indigo-700 hover:text-purple-800 hover:underline inline-flex items-center gap-1">
                                        Ver detalles <span>&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    `;
                }).join('');

            } catch (error) {
                console.error('Error al cargar inicio:', error);
            }
        });
    </script>

</x-layout>