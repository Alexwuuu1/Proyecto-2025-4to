<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles de Donación') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">{{ $donation->title }}</h3>
                        <div>
                            <a href="{{ route('donations.edit', $donation) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Editar
                            </a>
                            <a href="{{ route('donations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Volver
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold mb-2">Información General</h4>
                            <div class="space-y-2">
                                <p><strong>Título:</strong> {{ $donation->title }}</p>
                                <p><strong>Descripción:</strong> {{ $donation->description ?: 'N/A' }}</p>
                                <p><strong>Tipo:</strong>
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        @if($donation->type === 'money') bg-green-100 text-green-800
                                        @elseif($donation->type === 'material') bg-blue-100 text-blue-800
                                        @else bg-purple-100 text-purple-800 @endif">
                                        {{ ucfirst($donation->type) }}
                                    </span>
                                </p>
                                <p><strong>Monto/Cantidad:</strong>
                                    @if($donation->type === 'money')
                                        ${{ number_format($donation->amount, 2) }}
                                    @else
                                        {{ $donation->amount }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2">Estado y Fechas</h4>
                            <div class="space-y-2">
                                <p><strong>Estado:</strong>
                                    <span class="px-2 py-1 rounded text-xs font-medium
                                        @if($donation->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($donation->status === 'approved') bg-blue-100 text-blue-800
                                        @elseif($donation->status === 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </p>
                                <p><strong>Fecha de Donación:</strong> {{ $donation->donation_date->format('d/m/Y') }}</p>
                                <p><strong>Creado:</strong> {{ $donation->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Actualizado:</strong> {{ $donation->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($donation->notes)
                        <div class="mt-6">
                            <h4 class="font-semibold mb-2">Notas</h4>
                            <p class="text-gray-700 dark:text-gray-300">{{ $donation->notes }}</p>
                        </div>
                    @endif

                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <form method="POST" action="{{ route('donations.destroy', $donation) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro de que quieres eliminar esta donación?')">
                                Eliminar Donación
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
