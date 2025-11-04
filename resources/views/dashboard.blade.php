@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-unifranz-orange via-orange-400 to-yellow-400">
        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            <div class="relative max-w-7xl mx-auto px-4 py-24 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                        ¡Bienvenido al Sistema de Voluntariado UNIFRANZ!
                    </h1>
                    <p class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto">
                        Únete a nuestra comunidad de voluntarios y haz la diferencia en tu entorno.
                        Participa en actividades, gana puntos, obtén certificados y contribuye al cambio social.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('calendar.index') }}" class="bg-white text-unifranz-orange px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                            Ver Calendario de Actividades
                        </a>
                        <a href="{{ route('activities.index') }}" class="bg-unifranz-black text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-800 transition duration-300">
                            Explorar Actividades
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                    <div class="p-6">
                        <div class="text-4xl font-bold text-unifranz-orange mb-2">{{ \App\Models\User::count() }}</div>
                        <div class="text-gray-600">Voluntarios Registrados</div>
                    </div>
                    <div class="p-6">
                        <div class="text-4xl font-bold text-unifranz-orange mb-2">{{ \App\Models\Activity::count() }}</div>
                        <div class="text-gray-600">Actividades Disponibles</div>
                    </div>
                    <div class="p-6">
                        <div class="text-4xl font-bold text-unifranz-orange mb-2">{{ \App\Models\Certificate::count() }}</div>
                        <div class="text-gray-600">Certificados Otorgados</div>
                    </div>
                    <div class="p-6">
                        <div class="text-4xl font-bold text-unifranz-orange mb-2">${{ number_format(\App\Models\Donation::sum('amount'), 2) }}</div>
                        <div class="text-gray-600">Donaciones Recaudadas</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">¿Qué puedes hacer en nuestra plataforma?</h2>
                    <p class="text-lg text-gray-600">Descubre todas las funcionalidades disponibles para ti</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Actividades -->
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="text-unifranz-orange text-4xl mb-4">📅</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Actividades de Voluntariado</h3>
                        <p class="text-gray-600 mb-4">Participa en actividades programadas, únete al calendario y contribuye con tu tiempo y habilidades.</p>
                        <a href="{{ route('activities.index') }}" class="text-unifranz-orange hover:text-orange-600 font-medium">Ver Actividades →</a>
                    </div>

                    <!-- Donaciones -->
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="text-unifranz-orange text-4xl mb-4">💝</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Donaciones</h3>
                        <p class="text-gray-600 mb-4">Contribuye económicamente a las causas que te importan y ayuda a financiar proyectos sociales.</p>
                        <a href="{{ route('donations.index') }}" class="text-unifranz-orange hover:text-orange-600 font-medium">Hacer Donación →</a>
                    </div>

                    <!-- Rankings -->
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="text-unifranz-orange text-4xl mb-4">🏆</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Sistema de Puntos y Rankings</h3>
                        <p class="text-gray-600 mb-4">Gana puntos por tu participación, sube en los rankings y obtén reconocimientos especiales.</p>
                        <a href="{{ route('rankings.index') }}" class="text-unifranz-orange hover:text-orange-600 font-medium">Ver Rankings →</a>
                    </div>

                    <!-- Certificados -->
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="text-unifranz-orange text-4xl mb-4">📜</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Certificados</h3>
                        <p class="text-gray-600 mb-4">Obtén certificados oficiales por tus horas de voluntariado y demuestra tu compromiso social.</p>
                        <a href="{{ route('certificates.index') }}" class="text-unifranz-orange hover:text-orange-600 font-medium">Mis Certificados →</a>
                    </div>

                    <!-- Perfil -->
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="text-unifranz-orange text-4xl mb-4">👤</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Perfil Personal</h3>
                        <p class="text-gray-600 mb-4">Personaliza tu perfil, actualiza tu información y lleva un registro de tus contribuciones.</p>
                        <a href="{{ route('profile.edit') }}" class="text-unifranz-orange hover:text-orange-600 font-medium">Editar Perfil →</a>
                    </div>

                    <!-- Calendario -->
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="text-unifranz-orange text-4xl mb-4">📆</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Calendario Interactivo</h3>
                        <p class="text-gray-600 mb-4">Visualiza todas las actividades programadas en un calendario intuitivo y únete fácilmente.</p>
                        <a href="{{ route('calendar.index') }}" class="text-unifranz-orange hover:text-orange-600 font-medium">Ver Calendario →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Message for User -->
        <div class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">¡Hola, {{ Auth::user()->name }}!</h2>
                    <p class="text-gray-600 mb-6">Bienvenido de vuelta a tu plataforma de voluntariado. Tu rol actual: <span class="font-semibold text-unifranz-orange">{{ ucfirst(Auth::user()->role) }}</span></p>

                    @if(Auth::user()->role === 'admin')
                    <div class="bg-unifranz-gray p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-unifranz-black mb-4">Panel Administrativo</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('admin.dashboard') }}" class="bg-unifranz-orange hover:bg-orange-600 text-white px-4 py-2 rounded text-center">
                                Dashboard Admin
                            </a>
                            <a href="{{ route('admin.users') }}" class="bg-unifranz-black hover:bg-gray-800 text-white px-4 py-2 rounded text-center">
                                Gestionar Usuarios
                            </a>
                            <a href="{{ route('admin.reports') }}" class="bg-unifranz-black hover:bg-gray-800 text-white px-4 py-2 rounded text-center">
                                Ver Reportes
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
