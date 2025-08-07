@php($no_vite_js = true)
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Info Alert: Using the Diary -->
    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert" data-user-helper-key="diary-general">
        <h4 class="alert-heading d-flex justify-content-between align-items-center">
            Using the Diary
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </h4>
        <div>Manage appointments, viewings, inspections, reminders, and more. Use the calendar and filters below to navigate your diary. <b>Click "Add New Event" to quickly schedule something.</b></div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="fw-bold mb-2">Diary / Calendar</h1>
            <p class="text-muted mb-0">All your events in one place. Use filters and search to find what you need.</p>
        </div>
    </div>
    <div class="mb-3 d-flex flex-wrap justify-content-between align-items-center gap-2 bg-light p-3 rounded shadow-sm">
        <div class="d-flex gap-2 align-items-center">
            <button class="btn btn-success btn-lg px-4 fw-bold" id="addEventBtn">
                <i class="bi bi-calendar-plus me-2"></i> Add New Event
            </button>
            <button class="btn btn-outline-secondary" id="todayBtn" title="Go to today">Today</button>
            <button class="btn btn-outline-secondary" id="prevBtn" title="Previous period">&lt;</button>
            <button class="btn btn-outline-secondary" id="nextBtn" title="Next period">&gt;</button>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <!-- Branch filter placeholder -->
            <select id="branchFilter" class="form-select" title="Filter by branch" style="max-width: 160px;">
                <option value="">All Branches</option>
                <!-- TODO: Populate with branches -->
            </select>
            <select id="eventTypeFilter" class="form-select" title="Filter by event type">
                <option value="">All Types</option>
                <option value="appointment">Appointment</option>
                <option value="viewing">Viewing</option>
                <option value="inspection">Inspection</option>
                <option value="reminder">Reminder</option>
                <option value="other">Other</option>
            </select>
            <input type="text" id="eventSearch" class="form-control" placeholder="Search events..." style="max-width:200px;" title="Search events">
            <select id="calendarView" class="form-select" title="Change calendar view">
                <option value="dayGridMonth">Month</option>
                <option value="timeGridWeek">Week</option>
                <option value="timeGridDay">Day</option>
                <option value="listWeek">List</option>
            </select>
        </div>
    </div>
    <div id="calendar" class="shadow-sm mb-3"></div>

    <!-- Strong notification about confirmations/reminders -->
    <div class="alert alert-warning mt-3">
        <strong class="text-danger">Please note:</strong> Confirmations and reminders are only sent to attendees. Notifications are sent only if the respective notify options are selected for supported event types.
    </div>
</div>

<!-- Modal for Add/Edit Event -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="eventForm">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="eventModalLabel">Add/Edit Event</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="eventFormError" class="alert alert-danger d-none"></div>
          <!-- Duplicate contact warning -->
          <div class="alert alert-danger d-none" id="duplicateContactWarning">
            <h6 class="text-uppercase mb-1">Duplicate Contact Found</h6>
            <div class="mb-1"><span data-duplicate-message></span> How would you like to proceed?</div>
            <div class="form-row mb-2">
                <div class="col"><button type="button" class="btn btn-outline-primary btn-sm">Use Existing</button></div>
                <div class="col"><button type="button" class="btn btn-outline-success btn-sm">Create New Anyway</button></div>
            </div>
          </div>
          <div class="mb-3">
            <label for="eventTitle" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="eventTitle" name="title" required placeholder="Event title">
          </div>
          <div class="mb-3">
            <label for="eventType" class="form-label">Type <span class="text-danger">*</span></label>
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
            <select class="form-select" id="eventContact" name="contact_id" multiple data-tags="true">
              <!-- TODO: Populate with contacts via AJAX or backend -->
            </select>
            <small class="form-text text-muted">You can select multiple contacts and add tags.</small>
          </div>
          <div class="mb-3">
            <label for="eventStart" class="form-label">Start <span class="text-danger">*</span></label>
            <input type="datetime-local" class="form-control" id="eventStart" name="start" required>
          </div>
          <div class="mb-3">
            <label for="eventEnd" class="form-label">End</label>
            <input type="datetime-local" class="form-control" id="eventEnd" name="end">
          </div>
          <div class="mb-3">
            <label for="eventDescription" class="form-label">Description</label>
            <textarea class="form-control" id="eventDescription" name="description" placeholder="Event details..."></textarea>
          </div>
          <!-- Consents section -->
          <h6 class="text-uppercase mt-4">Consents</h6>
          <div class="row mb-2">
            <div class="col-md-2">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" value="1" name="contact_email_consent" id="event-contact-email-consent" checked />
                <label class="form-check-label" for="event-contact-email-consent">Email</label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" value="1" name="contact_sms_consent" id="event-contact-sms-consent" />
                <label class="form-check-label" for="event-contact-sms-consent">SMS</label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" value="1" name="contact_phone_consent" id="event-contact-phone-consent" />
                <label class="form-check-label" for="event-contact-phone-consent">Phone</label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" value="1" name="contact_post_consent" id="event-contact-post-consent" />
                <label class="form-check-label" for="event-contact-post-consent">Post</label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" value="1" name="contact_marketing_consent" id="event-contact-marketing-consent" />
                <label class="form-check-label" for="event-contact-marketing-consent">Marketing</label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" value="1" name="contact_listing_match_consent" id="event-contact-listing-match-consent" />
                <label class="form-check-label" for="event-contact-listing-match-consent">Property Match</label>
              </div>
            </div>
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

<!-- Placeholders for additional modals (Apex27 style) -->
<div class="modal fade" id="new-contact-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">New Contact</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@include('contacts.partials.form')</div></div></div></div>
<div class="modal fade" id="new-lead-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">New Lead</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@include('leads.partials.form')</div></div></div></div>
<div class="modal fade" id="log-communication-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Log Communication</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@include('communications.partials.form')</div></div></div></div>
<div class="modal fade" id="task-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Task</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@include('tasks.partials.form')</div></div></div></div>
<div class="modal fade" id="send-sms-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Send SMS</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@include('sms.partials.form')</div></div></div></div>
<div class="modal fade" id="onboarding-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-xl modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Onboarding</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@include('onboarding.partials.form')</div></div></div></div>
<div class="modal fade" id="group-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Group</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@include('groups.partials.form')</div></div></div></div>
<div class="modal fade" id="email-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Send Email</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">@include('emails.partials.form')</div></div></div></div>
<!-- Add more modal placeholders as needed -->

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="/js/diary-custom.js"></script>
<script>
$(function() {
  // Enable Select2 for multi-select tags
  $('#eventContact').select2({
    tags: true,
    width: '100%',
    placeholder: 'Select or add contacts',
    allowClear: true
  });
  // TODO: Enable Select2 for other tag fields if needed
});
</script>
@endpush
@endsection
