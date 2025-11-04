<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Certificado: ') . $certificate->certificate_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium mb-4">Detalles del Certificado</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Número de Certificado</dt>
                                    <dd class="mt-1">{{ $certificate->certificate_number }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Usuario</dt>
                                    <dd class="mt-1">{{ $certificate->user->name }} ({{ $certificate->user->email }})</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Horas Totales</dt>
                                    <dd class="mt-1">{{ $certificate->total_hours }} horas</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Fecha de Emisión</dt>
                                    <dd class="mt-1">{{ $certificate->issue_date->format('d/m/Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 py-1 rounded text-xs font-medium
                                            @if($certificate->status === 'active') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($certificate->status) }}
                                        </span>
                                    </dd>
                                </div>
                                @if($certificate->description)
                                    <div>
                                        <dt class="font-medium text-gray-500 dark:text-gray-400">Descripción</dt>
                                        <dd class="mt-1">{{ $certificate->description }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium mb-4">Acciones</h3>
                            <div class="space-y-3">
                                <a href="{{ route('certificates.download', $certificate) }}" target="_blank" class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                    Descargar PDF
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('certificates.edit', $certificate) }}" class="block w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center">
                                        Editar Certificado
                                    </a>
                                    <form method="POST" action="{{ route('certificates.destroy', $certificate) }}" class="block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro de eliminar este certificado?')">
                                            Eliminar Certificado
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('certificates.index') }}" class="text-blue-600 hover:text-blue-900">← Volver a Certificados</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
