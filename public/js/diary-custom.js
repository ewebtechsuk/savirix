function getEventColor(type) {
    switch(type) {
        case 'appointment': return '#0d6efd';
        case 'viewing': return '#20c997';
        case 'inspection': return '#ffc107';
        case 'reminder': return '#fd7e14';
        case 'other': return '#6c757d';
        default: return undefined;
    }
}

function getEventClass(type) {
    return 'fc-event-' + (type || 'other');
}

function showEventPopover(info) {
    var content = `<div><span class='badge bg-secondary mb-1'>${info.event.extendedProps.type || ''}</span><br><strong>${info.event.title}</strong><br>${info.event.extendedProps.description || ''}</div>`;
    var popover = new bootstrap.Popover(info.el, {
        content: content,
        html: true,
        trigger: 'hover',
        placement: 'top',
        container: 'body'
    });
    popover.show();
    info.el.addEventListener('mouseleave', function() { popover.hide(); popover.dispose(); });
}

function openEventModalForNew() {
    document.getElementById('eventForm').reset();
    document.getElementById('eventForm').removeAttribute('data-id');
    document.getElementById('deleteEventBtn').classList.add('d-none');
    document.getElementById('eventFormError').classList.add('d-none');
    var modal = new bootstrap.Modal(document.getElementById('eventModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;
    var currentTypeFilter = '';
    var currentSearch = '';
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: false,
        height: 700,
        selectable: true,
        editable: true,
        eventResizableFromStart: true,
        events: function(fetchInfo, successCallback, failureCallback) {
            let url = '/api/diary-events?start=' + fetchInfo.startStr + '&end=' + fetchInfo.endStr;
            if (currentTypeFilter) url += '&type=' + encodeURIComponent(currentTypeFilter);
            if (currentSearch) url += '&search=' + encodeURIComponent(currentSearch);
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const events = (data.data || []).map(event => ({
                        id: event.id,
                        title: event.title,
                        start: event.start,
                        end: event.end,
                        description: event.description,
                        type: event.type,
                        color: getEventColor(event.type),
                        classNames: [getEventClass(event.type)],
                        property_id: event.property_id,
                        contact_id: event.contact_id
                    }));
                    successCallback(events);
                })
                .catch(failureCallback);
        },
        eventClick: function(info) {
            const event = info.event;
            document.getElementById('eventForm').reset();
            document.getElementById('eventTitle').value = event.title;
            document.getElementById('eventType').value = event.extendedProps.type;
            document.getElementById('eventStart').value = event.start ? event.start.toISOString().slice(0,16) : '';
            document.getElementById('eventEnd').value = event.end ? event.end.toISOString().slice(0,16) : '';
            document.getElementById('eventDescription').value = event.extendedProps.description || '';
            document.getElementById('eventProperty').value = event.extendedProps.property_id || '';
            document.getElementById('eventContact').value = event.extendedProps.contact_id || '';
            document.getElementById('eventForm').setAttribute('data-id', event.id);
            document.getElementById('deleteEventBtn').classList.remove('d-none');
            document.getElementById('eventFormError').classList.add('d-none');
            var modal = new bootstrap.Modal(document.getElementById('eventModal'));
            modal.show();
        },
        dateClick: function(info) {
            openEventModalForNew();
            document.getElementById('eventStart').value = info.dateStr.length > 10 ? info.dateStr : info.dateStr + 'T09:00';
        },
        eventDidMount: function(info) {
            showEventPopover(info);
        },
        eventDrop: function(info) {
            fetch(`/api/diary-events/${info.event.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    start: info.event.start.toISOString(),
                    end: info.event.end ? info.event.end.toISOString() : null
                })
            }).then(() => calendar.refetchEvents());
        },
        eventResize: function(info) {
            fetch(`/api/diary-events/${info.event.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    start: info.event.start.toISOString(),
                    end: info.event.end ? info.event.end.toISOString() : null
                })
            }).then(() => calendar.refetchEvents());
        }
    });
    calendar.render();

    document.getElementById('calendarView').addEventListener('change', function() {
        calendar.changeView(this.value);
    });
    document.getElementById('addEventBtn').addEventListener('click', function() {
        openEventModalForNew();
    });
    document.getElementById('todayBtn').addEventListener('click', function() {
        calendar.today();
    });
    document.getElementById('prevBtn').addEventListener('click', function() {
        calendar.prev();
    });
    document.getElementById('nextBtn').addEventListener('click', function() {
        calendar.next();
    });
    document.getElementById('eventTypeFilter').addEventListener('change', function() {
        currentTypeFilter = this.value;
        calendar.refetchEvents();
    });
    document.getElementById('eventSearch').addEventListener('input', function() {
        currentSearch = this.value;
        calendar.refetchEvents();
    });
    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = this.getAttribute('data-id');
        const data = {
            title: document.getElementById('eventTitle').value,
            type: document.getElementById('eventType').value,
            start: document.getElementById('eventStart').value,
            end: document.getElementById('eventEnd').value,
            description: document.getElementById('eventDescription').value,
            property_id: document.getElementById('eventProperty').value,
            contact_id: document.getElementById('eventContact').value
        };
        const method = id ? 'PUT' : 'POST';
        const url = id ? `/api/diary-events/${id}` : '/api/diary-events';
        document.getElementById('eventFormError').classList.add('d-none');
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(resp => {
            if (resp.errors) {
                document.getElementById('eventFormError').textContent = Object.values(resp.errors).join(' ');
                document.getElementById('eventFormError').classList.remove('d-none');
                return;
            }
            var modal = bootstrap.Modal.getInstance(document.getElementById('eventModal'));
            modal.hide();
            calendar.refetchEvents();
        });
    });
    document.getElementById('deleteEventBtn').addEventListener('click', function() {
        const id = document.getElementById('eventForm').getAttribute('data-id');
        if (!id) return;
        if (!confirm('Are you sure you want to delete this event?')) return;
        fetch(`/api/diary-events/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(() => {
            var modal = bootstrap.Modal.getInstance(document.getElementById('eventModal'));
            modal.hide();
            calendar.refetchEvents();
        });
    });
    // TODO: Populate property/contact dropdowns via AJAX if needed
});
