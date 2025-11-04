<div class="activity-details">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
        {{ $activity->name }}
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Activity Info -->
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Información General</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-2">
                    <p><strong>Organizador:</strong> {{ $activity->user->name }}</p>
                    <p><strong>Estado:</strong>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($activity->status === 'active') bg-green-100 text-green-800
                            @elseif($activity->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($activity->status === 'completed') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($activity->status) }}
                        </span>
                    </p>
                    @if($activity->location)
                        <p><strong>Ubicación:</strong> {{ $activity->location }}</p>
                    @endif
                    @if($activity->max_participants)
                        <p><strong>Participantes:</strong> {{ $activity->users->count() }} / {{ $activity->max_participants }}</p>
                    @else
                        <p><strong>Participantes:</strong> {{ $activity->users->count() }} (sin límite)</p>
                    @endif
                </div>
            </div>

            @if($activity->description)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Descripción</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-700 dark:text-gray-300">{{ $activity->description }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Schedule Info -->
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Horario</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-2">
                    <p><strong>Fecha de inicio:</strong> {{ $activity->start_date->format('d/m/Y H:i') }}</p>
                    <p><strong>Fecha de fin:</strong> {{ $activity->end_date->format('d/m/Y H:i') }}</p>
                    <p><strong>Duración:</strong> {{ $activity->start_date->diffInHours($activity->end_date) }} horas</p>
                </div>
            </div>

            <!-- Participants List -->
            @if($activity->users->count() > 0)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                    Participantes ({{ $activity->users->count() }})
                </h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 max-h-48 overflow-y-auto">
                    <ul class="space-y-1">
                        @foreach($activity->users as $participant)
                        <li class="flex items-center justify-between">
                            <span class="text-gray-700 dark:text-gray-300">{{ $participant->name }}</span>
                            @if($participant->id === auth()->id())
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Tú</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons (for modal) -->
    <div class="mt-6 flex justify-end space-x-3">
        @if(auth()->check())
            @php
                $isParticipating = $activity->users()->where('user_id', auth()->id())->exists();
            @endphp

            @if(!$isParticipating)
                @if(!$activity->isFull())
                    <button class="join-btn px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                        Unirse a la Actividad
                    </button>
                @else
                    <button class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed" disabled>
                        Actividad Llena
                    </button>
                @endif
            @else
                <button class="leave-btn px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                    Abandonar Actividad
                </button>
            @endif
        @endif
    </div>
</div>
