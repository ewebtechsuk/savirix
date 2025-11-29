# Savarix improvement plan inspired by Apex27

## 1. Quick wins (UI/UX)
- **Dashboard polish:** Add KPI cards with status colour pills and a “Today’s viewings” timeline. Introduce quick action tiles (Add property, Schedule viewing, Add applicant, Log offer) to cut navigation time.
- **Activity feed:** Enrich feed with icons per event type and relative timestamps; allow filtering by module (properties, viewings, offers, contacts).
- **Viewing form:** Use side-by-side date/time inputs, status pills (Confirmed/Pending/Cancelled) and negotiator colour coding for clarity.
- **Property gallery:** Enable drag-and-drop image ordering and featured image toggle; show inline success/error toasts on upload.
- **Contact header chips:** Display role badges (Applicant/Landlord/Vendor) and marketing consent chips for at-a-glance context.

## 2. Workflow improvements
- **Property + applicant matching:** Add a sidebar panel on property add/edit showing ranked applicants with badges for fit/budget and inline actions to send details or schedule viewings.
- **Calendar-driven viewings:** Integrate conflict detection and working-hours awareness; allow quick reschedule from the timeline without leaving the form.
- **Contact-centric deal view:** Surface offers and tenancies directly in the contact view with status badges and links to properties; provide quick “Add offer/tenancy” buttons.
- **Search filters:** Keep persistent filter bars for lettings/sales lists with reset and save-search options to mirror Apex27’s speed.

## 3. Data model and automation ideas
- **Status and marketing flags:** Add per-portal publishing flags with sync status badges; track media completeness to block publish if required assets missing.
- **Activity tracking:** Standardise activity log schema (type, timestamp, user, linked entity) for richer dashboards and filters.
- **Viewing ownership:** Store negotiator colour/working hours to drive calendar rendering and conflict warnings.
- **Applicant matching score:** Compute and store a match score between property and applicants to support badge display and sorting.

## 4. Prioritised roadmap
- **P1 – Must have:** Dashboard quick actions and viewings timeline; property edit with gallery ordering and portal publish toggles; contact view showing offers/tenancies; conflict-aware viewing form.
- **P2 – Should have:** Applicant matching sidebar with scores; activity feed filters and iconography; per-portal marketing readiness checklist; calendar sharing and working-hours settings.
- **P3 – Nice to have:** Saved searches for lettings/sales, map-assisted search, branding preview in admin, and portal performance KPIs on dashboard.

These recommendations focus on accelerating negotiator workflows and clarifying marketing status so Savarix can meet or exceed Apex27 usability for Aktonz and London Capital Investments.
