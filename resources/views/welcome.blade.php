<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registracking — Gestión de deudas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Registracking" class="h-9 w-auto">
                <span class="font-semibold text-lg text-gray-800">Registracking</span>
            </div>

            <nav class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Ir al Panel
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-gray-700 hover:text-gray-900">
                        Iniciar sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    {{-- Hero --}}
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6">
                    Lleva el control de tus deudas <span class="text-blue-600">sin complicaciones</span>
                </h1>
                <p class="text-lg text-gray-600 mb-10">
                    Registra deudores, agrega deudas, registra pagos y recibe alertas
                    de vencimientos. Todo en un solo lugar, sin necesidad de hojas de cálculo.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            Ir al Panel
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                           class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            Comenzar gratis
                        </a>
                        <a href="{{ route('login') }}"
                           class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100 font-medium">
                            Iniciar sesión
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Features --}}
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Gestiona deudores</h3>
                    <p class="text-gray-600 text-sm">
                        Registra a cada persona con sus datos de contacto y consulta su historial completo.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Controla deudas</h3>
                    <p class="text-gray-600 text-sm">
                        Crea deudas con monto, descripción y fecha de vencimiento. Mira el saldo pendiente al instante.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="w-10 h-10 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Alertas de vencimiento</h3>
                    <p class="text-gray-600 text-sm">
                        Recibe avisos de deudas vencidas y próximas a vencer directamente en tu panel.
                    </p>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-gray-500">
            Soluciones Jmartech — John Jáner M.G. — Registracking © 2026
        </div>
    </footer>

</body>
</html>