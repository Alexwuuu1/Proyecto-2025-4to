<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Configuración del Sistema') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                        @csrf

                        <!-- Sistema de Puntos -->
                        <div class="bg-gray-700 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-white mb-4">Sistema de Puntos</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="points_per_activity" class="block text-sm font-medium text-gray-300">Puntos por Actividad</label>
                                    <input type="number" id="points_per_activity" name="points_per_activity" value="10" class="mt-1 block w-full bg-gray-600 border-gray-500 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" min="0" readonly>
                                    <p class="mt-1 text-sm text-gray-400">Solo lectura - 10 puntos por actividad completada</p>
                                </div>

                                <div>
                                    <label for="points_per_hour" class="block text-sm font-medium text-gray-300">Puntos por Hora</label>
                                    <input type="number" id="points_per_hour" name="points_per_hour" value="5" class="mt-1 block w-full bg-gray-600 border-gray-500 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" min="0" readonly>
                                    <p class="mt-1 text-sm text-gray-400">Solo lectura - 5 puntos por hora de voluntariado</p>
                                </div>

                                <div>
                                    <label for="points_per_donation" class="block text-sm font-medium text-gray-300">Puntos por Donación</label>
                                    <input type="number" id="points_per_donation" name="points_per_donation" value="20" class="mt-1 block w-full bg-gray-600 border-gray-500 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" min="0" readonly>
                                    <p class="mt-1 text-sm text-gray-400">Solo lectura - 20 puntos por donación realizada</p>
                                </div>

                                <div>
                                    <label for="points_per_certificate" class="block text-sm font-medium text-gray-300">Puntos por Certificado</label>
                                    <input type="number" id="points_per_certificate" name="points_per_certificate" value="50" class="mt-1 block w-full bg-gray-600 border-gray-500 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" min="0" readonly>
                                    <p class="mt-1 text-sm text-gray-400">Solo lectura - 50 puntos por certificado obtenido</p>
                                </div>
                            </div>
                        </div>

                        <!-- Rangos -->
                        <div class="bg-gray-700 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-white mb-4">Sistema de Rangos</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="p-4 bg-orange-900 rounded-lg">
                                    <div class="text-sm font-medium text-orange-200">Bronce</div>
                                    <div class="text-lg font-bold text-white">0 - 499 puntos</div>
                                </div>
                                <div class="p-4 bg-gray-600 rounded-lg">
                                    <div class="text-sm font-medium text-gray-200">Plata</div>
                                    <div class="text-lg font-bold text-white">500 - 999 puntos</div>
                                </div>
                                <div class="p-4 bg-yellow-600 rounded-lg">
                                    <div class="text-sm font-medium text-yellow-200">Oro</div>
                                    <div class="text-lg font-bold text-white">1,000 - 2,499 puntos</div>
                                </div>
                                <div class="p-4 bg-blue-600 rounded-lg">
                                    <div class="text-sm font-medium text-blue-200">Platino</div>
                                    <div class="text-lg font-bold text-white">2,500 - 4,999 puntos</div>
                                </div>
                                <div class="p-4 bg-purple-600 rounded-lg">
                                    <div class="text-sm font-medium text-purple-200">Diamante</div>
                                    <div class="text-lg font-bold text-white">5,000+ puntos</div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Sistema -->
                        <div class="bg-gray-700 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-white mb-4">Información del Sistema</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Versión de Laravel</label>
                                    <p class="mt-1 text-white">{{ app()->version() }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Entorno</label>
                                    <p class="mt-1 text-white">{{ app()->environment() }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Base de Datos</label>
                                    <p class="mt-1 text-white">{{ config('database.default') }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-300">Zona Horaria</label>
                                    <p class="mt-1 text-white">{{ config('app.timezone') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de guardar (placeholder) -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition duration-300" disabled>
                                Guardar Configuración
                            </button>
                            <p class="ml-4 text-sm text-gray-400 self-center">Funcionalidad próximamente disponible</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
