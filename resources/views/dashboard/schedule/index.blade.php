<x-app-layout>
    @push('css')
    <style>
        #calendar {
            background: #fff;
            border-radius: 15px;
            padding: 1rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .legend-dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 4px;
        }
    </style>
    @endpush

    <div class="container-fluid">
        <x-dashboard.page-header title="My Schedule" subtitle="Your hearings, meetings and consultations" icon="fas fa-calendar-alt">
            <button class="btn btn-primary" onclick="openCreateModal()">
                <i class="fas fa-plus"></i> Add Event
            </button>
        </x-dashboard.page-header>

        <div class="mb-3 small">
            <span class="me-3"><span class="legend-dot" style="background:#dc3545"></span> Hearing</span>
            <span class="me-3"><span class="legend-dot" style="background:#0d6efd"></span> Meeting</span>
            <span class="me-3"><span class="legend-dot" style="background:#198754"></span> Consultation</span>
            <span class="me-3"><span class="legend-dot" style="background:#6c757d"></span> Personal</span>
        </div>

        <div id="calendar"></div>
    </div>

    {{-- Add/Edit Event Modal --}}
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalTitle">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <input type="hidden" id="event_id">
                        <div class="form-group mb-3">
                            <label for="event_title">Title *</label>
                            <input type="text" id="event_title" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="event_type">Type *</label>
                            <select id="event_type" class="form-select">
                                <option value="meeting">Meeting</option>
                                <option value="consultation">Consultation</option>
                                <option value="personal">Personal</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="event_start">Start *</label>
                                    <input type="datetime-local" id="event_start" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="event_end">End *</label>
                                    <input type="datetime-local" id="event_end" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="event_location">Location</label>
                            <input type="text" id="event_location" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="event_case">Related Case</label>
                            <select id="event_case" class="form-select">
                                <option value="">None</option>
                                @foreach($cases as $case)
                                <option value="{{ $case->id }}">{{ Str::limit($case->title, 50) }} ({{ $case->client?->user?->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" class="form-check-input" id="event_public">
                            <label class="form-check-label" for="event_public">
                                Show as availability on my public profile
                                <small class="d-block text-muted">Visitors will only see a busy/available block — no details.</small>
                            </label>
                        </div>
                        <div id="eventFormError" class="alert alert-danger d-none"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-auto d-none" id="deleteEventBtn" onclick="deleteEvent()">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEventBtn" onclick="saveEvent()">Save</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        let calendar;
        let eventModal;
        const csrfToken = '{{ csrf_token() }}';

        document.addEventListener('DOMContentLoaded', function () {
            eventModal = new bootstrap.Modal(document.getElementById('eventModal'));

            calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                height: 'auto',
                events: '{{ route('schedule.events') }}',
                eventClick: function (info) {
                    openEditModal(info.event);
                },
                dateClick: function (info) {
                    openCreateModal(info.dateStr);
                }
            });
            calendar.render();
        });

        function toLocalInputValue(date) {
            if (!date) return '';
            const pad = n => String(n).padStart(2, '0');
            return date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date.getDate()) +
                'T' + pad(date.getHours()) + ':' + pad(date.getMinutes());
        }

        function openCreateModal(dateStr) {
            document.getElementById('eventForm').reset();
            document.getElementById('event_id').value = '';
            document.getElementById('eventModalTitle').textContent = 'Add Event';
            document.getElementById('deleteEventBtn').classList.add('d-none');
            document.getElementById('eventFormError').classList.add('d-none');
            document.getElementById('event_type').disabled = false;
            document.getElementById('saveEventBtn').classList.remove('d-none');

            if (dateStr) {
                document.getElementById('event_start').value = dateStr.substring(0, 10) + 'T09:00';
                document.getElementById('event_end').value = dateStr.substring(0, 10) + 'T10:00';
            }
            eventModal.show();
        }

        function openEditModal(event) {
            const props = event.extendedProps;
            document.getElementById('eventFormError').classList.add('d-none');
            document.getElementById('event_id').value = event.id;
            document.getElementById('event_title').value = event.title;
            document.getElementById('event_start').value = toLocalInputValue(event.start);
            document.getElementById('event_end').value = toLocalInputValue(event.end || event.start);
            document.getElementById('event_location').value = props.location || '';
            document.getElementById('event_case').value = props.case_id || '';
            document.getElementById('event_public').checked = !!props.is_public;

            const typeSelect = document.getElementById('event_type');
            if (props.type === 'hearing') {
                // Hearings are managed from their case page
                if (!typeSelect.querySelector('option[value="hearing"]')) {
                    const opt = document.createElement('option');
                    opt.value = 'hearing';
                    opt.textContent = 'Hearing (managed from case)';
                    typeSelect.appendChild(opt);
                }
                typeSelect.value = 'hearing';
                typeSelect.disabled = true;
                document.getElementById('eventModalTitle').textContent = 'Hearing (read-only — manage from the case page)';
                document.getElementById('deleteEventBtn').classList.add('d-none');
                document.getElementById('saveEventBtn').classList.add('d-none');
            } else {
                typeSelect.disabled = false;
                typeSelect.value = props.type;
                document.getElementById('eventModalTitle').textContent = 'Edit Event';
                document.getElementById('deleteEventBtn').classList.remove('d-none');
                document.getElementById('saveEventBtn').classList.remove('d-none');
            }
            eventModal.show();
        }

        function saveEvent() {
            const id = document.getElementById('event_id').value;
            const payload = {
                title: document.getElementById('event_title').value,
                type: document.getElementById('event_type').value,
                start_datetime: document.getElementById('event_start').value,
                end_datetime: document.getElementById('event_end').value,
                location: document.getElementById('event_location').value,
                case_id: document.getElementById('event_case').value || null,
                is_public: document.getElementById('event_public').checked ? 1 : 0,
            };

            const url = id ? '{{ url('dashboard/schedule') }}/' + id : '{{ route('schedule.store') }}';
            const method = id ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
                .then(async res => {
                    if (!res.ok) {
                        const data = await res.json().catch(() => ({}));
                        throw data;
                    }
                    return res.json();
                })
                .then(() => {
                    eventModal.hide();
                    calendar.refetchEvents();
                })
                .catch(err => {
                    const errorBox = document.getElementById('eventFormError');
                    let msg = 'Could not save the event.';
                    if (err && err.errors) {
                        msg = Object.values(err.errors).flat().join(' ');
                    } else if (err && err.message) {
                        msg = err.message;
                    }
                    errorBox.textContent = msg;
                    errorBox.classList.remove('d-none');
                });
        }

        function deleteEvent() {
            const id = document.getElementById('event_id').value;
            if (!id || !confirm('Delete this event?')) return;

            fetch('{{ url('dashboard/schedule') }}/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(() => {
                    eventModal.hide();
                    calendar.refetchEvents();
                });
        }
    </script>
    @endpush
</x-app-layout>
