<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rankings y Puntos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Current User Ranking -->
                    @if($userRanking)
                    <div class="mb-8 bg-gradient-to-r from-blue-50 to-purple-50 p-6 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tu Ranking Actual</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $userRanking->rank_position ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-600">Posición</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $userRanking->total_points }}</div>
                                <div class="text-sm text-gray-600">Puntos Totales</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-purple-600">{{ $userRanking->rank }}</div>
                                <div class="text-sm text-gray-600">Rango</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-orange-600">{{ $userRanking->hours_volunteered }}</div>
                                <div class="text-sm text-gray-600">Horas</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Rankings Table -->
                    <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Top Voluntarios</h3>
                        @if(Auth::user()->isAdmin())
                        <form method="POST" action="{{ route('rankings.update-all') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">
                                Actualizar Rankings
                            </button>
                        </form>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posición</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Voluntario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Puntos</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rango</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actividades</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Donaciones</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certificados</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($rankings as $ranking)
                                <tr class="{{ $userRanking && $ranking->id === $userRanking->id ? 'bg-blue-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                #{{ $ranking->rank_position }}
                                            </div>
                                            @if($ranking->rank_position <= 3)
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $ranking->rank_position == 1 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $ranking->rank_position == 2 ? 'bg-gray-100 text-gray-800' : '' }}
                                                {{ $ranking->rank_position == 3 ? 'bg-orange-100 text-orange-800' : '' }}">
                                                🏆
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $ranking->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $ranking->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                        {{ number_format($ranking->total_points) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $ranking->rank == 'Diamante' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $ranking->rank == 'Platino' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $ranking->rank == 'Oro' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $ranking->rank == 'Plata' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $ranking->rank == 'Bronce' ? 'bg-orange-100 text-orange-800' : '' }}">
                                            {{ $ranking->rank }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ranking->activities_completed }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ranking->hours_volunteered }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ranking->donations_made }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $ranking->certificates_earned }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        No hay rankings disponibles aún.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Points System Info -->
                    <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-lg font-semibold mb-4">Sistema de Puntos</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <h5 class="font-medium mb-2">Cómo ganar puntos:</h5>
                                <ul class="space-y-1 text-gray-600">
                                    <li>• 10 puntos por actividad completada</li>
                                    <li>• 5 puntos por hora de voluntariado</li>
                                    <li>• 20 puntos por donación realizada</li>
                                    <li>• 50 puntos por certificado obtenido</li>
                                </ul>
                            </div>
                            <div>
                                <h5 class="font-medium mb-2">Rangos:</h5>
                                <ul class="space-y-1 text-gray-600">
                                    <li>• <span class="text-orange-600">Bronce:</span> 0 - 499 puntos</li>
                                    <li>• <span class="text-gray-600">Plata:</span> 500 - 999 puntos</li>
                                    <li>• <span class="text-yellow-600">Oro:</span> 1,000 - 2,499 puntos</li>
                                    <li>• <span class="text-blue-600">Platino:</span> 2,500 - 4,999 puntos</li>
                                    <li>• <span class="text-purple-600">Diamante:</span> 5,000+ puntos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
