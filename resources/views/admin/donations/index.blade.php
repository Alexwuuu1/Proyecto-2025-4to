<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Gestión de Donaciones') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Título</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Monto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @forelse($donations as $donation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($donation->user->profile_photo_path)
                                                    <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $donation->user->profile_photo_path) }}" alt="">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center">
                                                        <span class="text-white font-medium">{{ substr($donation->user->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-white">{{ $donation->user->name }}</div>
                                                    <div class="text-sm text-gray-300">{{ $donation->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $donation->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 rounded text-xs font-medium
                                                @if($donation->type === 'money') bg-green-100 text-green-800
                                                @elseif($donation->type === 'material') bg-blue-100 text-blue-800
                                                @else bg-purple-100 text-purple-800 @endif">
                                                {{ ucfirst($donation->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                            @if($donation->type === 'money')
                                                ${{ number_format($donation->amount, 2) }}
                                            @else
                                                {{ $donation->amount }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 rounded text-xs font-medium
                                                @if($donation->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($donation->status === 'approved') bg-green-100 text-green-800
                                                @elseif($donation->status === 'completed') bg-blue-100 text-blue-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($donation->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $donation->donation_date->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($donation->status === 'pending')
                                                <form method="POST" action="{{ route('admin.donations.approve', $donation) }}" class="inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Aprobar</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.donations.reject', $donation) }}" class="inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de rechazar esta donación?')">Rechazar</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">{{ ucfirst($donation->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                                            No hay donaciones registradas.
                                        </td>
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
