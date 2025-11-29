# Apex27 workflows

## Creating and managing a viewing event
- **Goal:** Schedule a viewing and ensure the calendar reflects negotiator availability.
- **Actor:** Negotiator/agent.
- **Pre-conditions:** Property and applicant exist; calendar preferences configured.
- **Step-by-step:**
  1. Open Calendar ▸ Add viewing.
  2. Select property (autocomplete) and applicant; choose negotiator.
  3. Pick date/time; adjust duration; mark as Confirmed/Pending.
  4. Add notes and save; optionally send confirmations.
  5. Open Calendar settings to toggle shared calendars, working hours and colour coding.
- **System behaviours:** Appointment appears on calendar with status colour; conflicts flagged; settings immediately affect visibility across users.
- **Observations:** Fast inline editing and status badges help clarity.
- **Pain points:** Multiple dropdowns could be compressed; confirmation steps rely on modal without preview.

## Updating property details and uploading images
- **Goal:** Keep property marketing data current and media-rich.
- **Actor:** Negotiator/administrator.
- **Pre-conditions:** Property record exists; media ready.
- **Step-by-step:**
  1. Open Properties ▸ Edit.
  2. Update fields (address, beds/baths, rent/price, tenure, availability, features).
  3. Toggle marketing/portal flags.
  4. Upload images via drag-and-drop; reorder or set featured image; upload brochure.
  5. Save/Publish to push updates.
- **System behaviours:** Immediate thumbnail previews; portal status indicators; success toasts after upload.
- **Observations:** Single-screen control of details + marketing aids speed.
- **Pain points:** Limited bulk image actions; validation messages are small.

## Adding property and matching applicants
- **Goal:** Create a new property and notify matching applicants.
- **Actor:** Negotiator.
- **Pre-conditions:** Applicant list exists with preferences.
- **Step-by-step:**
  1. Properties ▸ Add property; fill core details and price.
  2. Review matching sidebar showing applicants ranked by fit.
  3. Filter matches (budget, location, hotness) and send details or schedule viewings directly.
  4. Save property for marketing/publishing.
- **System behaviours:** Match badges show strength; quick actions log communication.
- **Observations:** Matching in-context reduces navigation.
- **Pain points:** Matching logic opaque; no inline editing of applicant criteria.

## Searching lettings stock with filters/sorting
- **Goal:** Find lettings properties quickly by budget and criteria.
- **Actor:** Negotiator/applicant-facing staff.
- **Pre-conditions:** Lettings properties loaded.
- **Step-by-step:**
  1. Open Properties ▸ Lettings search.
  2. Apply filters (price range, beds, type, status) and keyword/area search.
  3. Sort results; open property records; optionally save search.
- **System behaviours:** Results table refreshes instantly; status pills show availability; saved searches persist.
- **Observations:** Persistent filter bar encourages iterative search.
- **Pain points:** Limited map view; filter reset hidden in overflow.

## Managing contacts, offers and tenancies from a contact record
- **Goal:** Maintain full lifecycle info per contact.
- **Actor:** Negotiator/property manager.
- **Pre-conditions:** Contact exists; offers/tenancies linked.
- **Step-by-step:**
  1. Contacts ▸ View contact.
  2. Review details/preferences; log call/email/notes via activity feed.
  3. Add/view offers with property, amount and status; update outcome.
  4. View tenancies with move-in dates and status; link to property.
- **System behaviours:** Timeline updates instantly; status badges change colour; offer/tenancy rows link to underlying property.
- **Observations:** Strong contact-centric view; quick actions minimise context switching.
- **Pain points:** Offer editing uses modal with minimal guidance; tenancy history hidden behind tabs.

## Using dashboard widgets, quick actions and activity feed
- **Goal:** Gain overview and act on daily tasks.
- **Actor:** Negotiator/manager.
- **Pre-conditions:** Data populated across modules.
- **Step-by-step:**
  1. Open Dashboard.
  2. Scan KPI cards for stock, applicants, offers and portal performance.
  3. Use “Today’s viewings” timeline to jump to records.
  4. Trigger quick actions (add property, schedule viewing, add applicant).
  5. Review recent activity feed and filter by type.
- **System behaviours:** Cards update live; activity feed shows relative timestamps; quick actions open modals rather than full pages.
- **Observations:** High density of actionable widgets.
- **Pain points:** Charts lack drill-down; timeline compactness limits description text.

## Managing branding & admin settings
- **Goal:** Configure organisation-wide branding, users and portal feeds.
- **Actor:** Administrator.
- **Pre-conditions:** Admin rights.
- **Step-by-step:**
  1. Admin ▸ Settings ▸ Branding/Company/Portal/User tabs.
  2. Upload logos, set colours, and toggle branding visibility.
  3. Configure portal credentials/feeds and email templates.
  4. Manage users and roles with permissions.
- **System behaviours:** Branding preview updates live; saving prompts confirmation; portal toggles show sync status.
- **Observations:** Consolidated settings tabs improve discoverability.
- **Pain points:** Some settings nested two levels deep; limited audit history.
