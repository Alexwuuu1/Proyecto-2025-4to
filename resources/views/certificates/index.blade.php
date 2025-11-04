<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Certificados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Lista de Certificados</h3>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('certificates.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Nuevo Certificado
                            </a>
                        @endif
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
                                    <th class="px-4 py-2 text-left">Número de Certificado</th>
                                    <th class="px-4 py-2 text-left">Horas Totales</th>
                                    <th class="px-4 py-2 text-left">Fecha de Emisión</th>
                                    <th class="px-4 py-2 text-left">Estado</th>
                                    <th class="px-4 py-2 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($certificates as $certificate)
                                    <tr class="border-t dark:border-gray-600">
                                        <td class="px-4 py-2">{{ $certificate->certificate_number }}</td>
                                        <td class="px-4 py-2">{{ $certificate->total_hours }} horas</td>
                                        <td class="px-4 py-2">{{ $certificate->issue_date->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 rounded text-xs font-medium
                                                @if($certificate->status === 'active') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($certificate->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('certificates.show', $certificate) }}" class="text-blue-600 hover:text-blue-900 mr-2">Ver</a>
                                            <a href="{{ route('certificates.download', $certificate) }}" class="text-green-600 hover:text-green-900 mr-2" target="_blank">Descargar PDF</a>
                                            @if(Auth::user()->isAdmin())
                                                <a href="{{ route('certificates.edit', $certificate) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Editar</a>
                                                <form method="POST" action="{{ route('certificates.destroy', $certificate) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">No hay certificados registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $certificates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
