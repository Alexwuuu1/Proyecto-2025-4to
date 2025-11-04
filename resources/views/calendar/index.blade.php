<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Calendario Interactivo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Calendario de Actividades
                            </h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">
                                Visualiza y participa en las actividades de voluntariado programadas
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <button id="todayBtn" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                                Hoy
                            </button>
                            <button id="monthBtn" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                Mes
                            </button>
                            <button id="weekBtn" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                Semana
                            </button>
                            <button id="dayBtn" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                Día
                            </button>
                        </div>
                    </div>

                    <!-- Calendar Legend -->
                    <div class="mb-6 flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Activa</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-500 rounded mr-2"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Pendiente</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-gray-500 rounded mr-2"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Completada</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Cancelada</span>
                        </div>
                    </div>

                    <!-- Calendar Container -->
                    <div id="calendar" class="bg-white dark:bg-gray-800 rounded-lg shadow-inner"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Details Modal -->
    <div id="activityModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100" id="modalTitle"></h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div id="modalContent" class="text-gray-700 dark:text-gray-300">
                    <!-- Content will be loaded here -->
                </div>

                <div class="flex justify-end mt-6 space-x-3">
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                        Cerrar
                    </button>
                    <div id="actionButtons">
                        <!-- Action buttons will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('activityModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            const actionButtons = document.getElementById('actionButtons');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                events: {
                    url: '{{ route("calendar.activities") }}',
                    method: 'GET'
                },
                eventClick: function(info) {
                    showActivityDetails(info.event.id);
                },
                eventDidMount: function(info) {
                    // Add tooltip with activity info
                    info.el.setAttribute('title', `${info.event.title}\n${info.event.extendedProps.location || 'Sin ubicación'}\nParticipantes: ${info.event.extendedProps.current_participants}/${info.event.extendedProps.max_participants || '∞'}`);
                },
                height: 'auto',
                dayMaxEvents: true,
                moreLinkClick: 'popover'
            });

            calendar.render();

            // View buttons
            document.getElementById('todayBtn').addEventListener('click', () => calendar.today());
            document.getElementById('monthBtn').addEventListener('click', () => calendar.changeView('dayGridMonth'));
            document.getElementById('weekBtn').addEventListener('click', () => calendar.changeView('timeGridWeek'));
            document.getElementById('dayBtn').addEventListener('click', () => calendar.changeView('timeGridDay'));

            // Update button styles
            function updateViewButtons(view) {
                document.querySelectorAll('#monthBtn, #weekBtn, #dayBtn').forEach(btn => {
                    btn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                    btn.classList.add('bg-gray-500', 'hover:bg-gray-600');
                });

                if (view === 'dayGridMonth') {
                    document.getElementById('monthBtn').classList.remove('bg-gray-500', 'hover:bg-gray-600');
                    document.getElementById('monthBtn').classList.add('bg-blue-500', 'hover:bg-blue-600');
                } else if (view === 'timeGridWeek') {
                    document.getElementById('weekBtn').classList.remove('bg-gray-500', 'hover:bg-gray-600');
                    document.getElementById('weekBtn').classList.add('bg-blue-500', 'hover:bg-blue-600');
                } else if (view === 'timeGridDay') {
                    document.getElementById('dayBtn').classList.remove('bg-gray-500', 'hover:bg-gray-600');
                    document.getElementById('dayBtn').classList.add('bg-blue-500', 'hover:bg-blue-600');
                }
            }

            calendar.on('viewDidMount', function(info) {
                updateViewButtons(info.view.type);
            });

            function showActivityDetails(activityId) {
                fetch(`{{ url('/calendar/activities') }}/${activityId}`)
                    .then(response => response.text())
                    .then(html => {
                        // Extract modal content from the HTML response
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const content = doc.querySelector('.activity-details');

                        if (content) {
                            modalTitle.textContent = content.querySelector('h1')?.textContent || 'Detalles de Actividad';
                            modalContent.innerHTML = content.innerHTML;

                            // Update action buttons
                            const joinBtn = content.querySelector('.join-btn');
                            const leaveBtn = content.querySelector('.leave-btn');

                            actionButtons.innerHTML = '';
                            if (joinBtn) {
                                const newJoinBtn = joinBtn.cloneNode(true);
                                newJoinBtn.addEventListener('click', () => {
                                    joinActivity(activityId);
                                });
                                actionButtons.appendChild(newJoinBtn);
                            }
                            if (leaveBtn) {
                                const newLeaveBtn = leaveBtn.cloneNode(true);
                                newLeaveBtn.addEventListener('click', () => {
                                    leaveActivity(activityId);
                                });
                                actionButtons.appendChild(newLeaveBtn);
                            }
                        }

                        modal.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error loading activity details:', error);
                    });
            }

            function joinActivity(activityId) {
                fetch(`{{ url('/calendar/activities') }}/${activityId}/join`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        calendar.refetchEvents();
                        closeModal();
                        showMessage('Te has unido a la actividad exitosamente', 'success');
                    } else {
                        showMessage(data.message || 'Error al unirse a la actividad', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('Error al unirse a la actividad', 'error');
                });
            }

            function leaveActivity(activityId) {
                fetch(`{{ url('/calendar/activities') }}/${activityId}/leave`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        calendar.refetchEvents();
                        closeModal();
                        showMessage('Has abandonado la actividad', 'success');
                    } else {
                        showMessage(data.message || 'Error al abandonar la actividad', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('Error al abandonar la actividad', 'error');
                });
            }

            function showMessage(message, type) {
                // Simple notification - you can enhance this with a proper notification system
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });

        function closeModal() {
            document.getElementById('activityModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('activityModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-app-layout>
