@php($no_vite_js = true)
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="fw-bold">Diary</h1>
            <p class="text-muted">This is your diary/calendar page. You can add appointments, reminders, and events here.</p>
        </div>
    </div>
    <div class="mb-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex gap-2 align-items-center">
            <button class="btn btn-primary me-2" id="addEventBtn">Add Event</button>
            <button class="btn btn-outline-secondary" id="todayBtn">Today</button>
            <button class="btn btn-outline-secondary" id="prevBtn">&lt;</button>
            <button class="btn btn-outline-secondary" id="nextBtn">&gt;</button>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <select id="eventTypeFilter" class="form-select">
                <option value="">All Types</option>
                <option value="appointment">Appointment</option>
                <option value="viewing">Viewing</option>
                <option value="inspection">Inspection</option>
                <option value="reminder">Reminder</option>
                <option value="other">Other</option>
            </select>
            <input type="text" id="eventSearch" class="form-control" placeholder="Search events..." style="max-width:200px;">
            <select id="calendarView" class="form-select">
                <option value="dayGridMonth">Month</option>
                <option value="timeGridWeek">Week</option>
                <option value="timeGridDay">Day</option>
                <option value="listWeek">List</option>
            </select>
        </div>
    </div>
    <div id="calendar"></div>
</div>

<!-- Modal for Add/Edit Event -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="eventForm">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">Add/Edit Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="eventFormError" class="alert alert-danger d-none"></div>
          <div class="mb-3">
            <label for="eventTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="eventTitle" name="title" required>
          </div>
          <div class="mb-3">
            <label for="eventType" class="form-label">Type</label>
            <select class="form-select" id="eventType" name="type" required>
              <option value="appointment">Appointment</option>
              <option value="viewing">Viewing</option>
              <option value="inspection">Inspection</option>
              <option value="reminder">Reminder</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="eventProperty" class="form-label">Property</label>
            <select class="form-select" id="eventProperty" name="property_id">
              <option value="">None</option>
              <!-- TODO: Populate with properties via AJAX or backend -->
            </select>
          </div>
          <div class="mb-3">
            <label for="eventContact" class="form-label">Contact</label>
            <select class="form-select" id="eventContact" name="contact_id">
              <option value="">None</option>
              <!-- TODO: Populate with contacts via AJAX or backend -->
            </select>
          </div>
          <div class="mb-3">
            <label for="eventStart" class="form-label">Start</label>
            <input type="datetime-local" class="form-control" id="eventStart" name="start" required>
          </div>
          <div class="mb-3">
            <label for="eventEnd" class="form-label">End</label>
            <input type="datetime-local" class="form-control" id="eventEnd" name="end">
          </div>
          <div class="mb-3">
            <label for="eventDescription" class="form-label">Description</label>
            <textarea class="form-control" id="eventDescription" name="description"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger me-auto d-none" id="deleteEventBtn">Delete</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet">
<style>
  #calendar {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    padding: 16px;
    min-height: 600px;
  }
  .fc-event-appointment { background-color: #0d6efd !important; color: #fff !important; }
  .fc-event-viewing { background-color: #20c997 !important; color: #fff !important; }
  .fc-event-inspection { background-color: #ffc107 !important; color: #212529 !important; }
  .fc-event-reminder { background-color: #fd7e14 !important; color: #fff !important; }
  .fc-event-other { background-color: #6c757d !important; color: #fff !important; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="/js/diary-custom.js"></script>
@endpush
@endsection
