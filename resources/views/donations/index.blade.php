<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Donaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Lista de Donaciones</h3>
                        <a href="{{ route('donations.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Nueva Donación
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th class="px-4 py-2 text-left">Título</th>
                                    <th class="px-4 py-2 text-left">Tipo</th>
                                    <th class="px-4 py-2 text-left">Monto</th>
                                    <th class="px-4 py-2 text-left">Estado</th>
                                    <th class="px-4 py-2 text-left">Fecha</th>
                                    <th class="px-4 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($donations as $donation)
                                    <tr class="border-t dark:border-gray-600">
                                        <td class="px-4 py-2">{{ $donation->title }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 rounded text-xs font-medium
                                                @if($donation->type === 'money') bg-green-100 text-green-800
                                                @elseif($donation->type === 'material') bg-blue-100 text-blue-800
                                                @else bg-purple-100 text-purple-800 @endif">
                                                {{ ucfirst($donation->type) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            @if($donation->type === 'money')
                                                ${{ number_format($donation->amount, 2) }}
                                            @else
                                                {{ $donation->amount }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 rounded text-xs font-medium
                                                @if($donation->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($donation->status === 'approved') bg-blue-100 text-blue-800
                                                @elseif($donation->status === 'completed') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($donation->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">{{ $donation->donation_date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('donations.show', $donation) }}" class="text-blue-600 hover:text-blue-900 mr-2">Ver</a>
                                            <a href="{{ route('donations.edit', $donation) }}" class="text-green-600 hover:text-green-900 mr-2">Editar</a>
                                            <form method="POST" action="{{ route('donations.destroy', $donation) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">No hay donaciones registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $donations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
