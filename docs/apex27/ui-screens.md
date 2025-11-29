# Apex27 UI screens and navigation

## Create a Viewing Event and Manage Calendar Settings
- **Screen:** Calendar / Viewings creation form.
- **Menu:** Sidebar ▸ Calendar ▸ Add viewing.
- **Key components:** Date/time picker, property lookup autocomplete, applicant selector, negotiator dropdown, status pill (Confirmed/Pending), notes text area, and save/confirm buttons. Calendar settings panel includes toggles for calendar sharing, working hours, and colour coding per negotiator.
- **UX details:** Inline validation for required fields, side-by-side date and time inputs, and a mini calendar preview showing clashes. Status badge updates after saving.

## Update Property Details and Upload Images
- **Screen:** Property edit page with gallery.
- **Menu:** Sidebar ▸ Properties ▸ Edit.
- **Key components:** Two-column form (address, type, tenure, beds/baths, rent/price, marketing status), feature tags, brochure upload, image gallery with drag-and-drop ordering and delete icons, portal feed switches.
- **UX details:** Sticky action bar for Save/Publish, thumbnail hover actions for set-as-featured, inline success toasts after image upload.

## Use the Aktonz Apex Dashboard / Dashboard Page
- **Screen:** Dashboard overview.
- **Menu:** Sidebar ▸ Dashboard.
- **Key components:** KPI cards (properties on market, new applicants, offers), “Today’s viewings” timeline, recent activity feed, quick action tiles (add property, schedule viewing, add applicant), and chart blocks for pipeline/portal performance.
- **UX details:** Cards use coloured badges for status (Live, Draft, Under offer). Activity feed shows relative timestamps and icons per event.

## Navigate Aktonz Dashboard Menu Options / Manage Contacts, Properties and Marketing
- **Screen:** Main sidebar navigation and top-level list pages.
- **Menu:** Persistent left sidebar with modules: Dashboard, Properties, Applicants, Contacts, Calendar/Viewings, Offers, Tenancies, Marketing/Portals, Admin.
- **Key components:** Collapsible section headers, badges with counts (e.g., New, Due today), search bar at top of list pages, table views with column filters and pagination.
- **UX details:** Hover highlights active menu item; quick filters above tables (Status, Negotiator, Price band), and action buttons per row (Edit, Clone, Archive) exposed via kebab menu.

## Navigate Apex27 Admin Panel Settings and Branding
- **Screen:** Admin settings and branding tabs.
- **Menu:** Sidebar ▸ Admin ▸ Settings ▸ Branding.
- **Key components:** Tabs for Company details, Branding, Email templates, Portal feeds, User management. Upload controls for logo/colour, text inputs for company name/addresses, toggle for show branding on emails, and role selector tables.
- **UX details:** Preview card showing how branding appears on emails/portals, confirmation modals for saving settings, and inline help text.

## Add Property Details and Match Applicants
- **Screen:** Property creation with applicant matching sidebar.
- **Menu:** Sidebar ▸ Properties ▸ Add property.
- **Key components:** Form for address, property type, price/rent, bedrooms/bathrooms, furnishing, availability date, and marketing flags. Matching panel lists applicants with badges for match strength and budget alignment, with quick buttons to send details or schedule viewing.
- **UX details:** Match list supports filters (hotness, budget, location), and inline actions avoid leaving the page.

## Add Property Details and Search for Lettings
- **Screen:** Property add flow plus lettings search results.
- **Menu:** Sidebar ▸ Properties ▸ Add ▸ Switch to Lettings search.
- **Key components:** Search bar with keyword/area, filters for price range, beds, property type, and status. Results table with sortable columns and status pills (Available, Let agreed).
- **UX details:** Persistent filters bar with reset, quick toggle between sales and lettings stock, and “Save search” option.

## View / Edit / Manage Contact and Offers
- **Screen:** Contact view with linked offers and tenancies.
- **Menu:** Sidebar ▸ Contacts ▸ View contact.
- **Key components:** Contact header card (name, role e.g., Applicant/Landlord, phone/email chips), tabs for Details, Preferences, Activity, Offers, Tenancies. Offer table shows property, amount, status and dates; tenancy section shows move-in dates and status (Active, Past).
- **UX details:** Timeline/activity feed with icons for calls/emails/notes, buttons for Log call, Add viewing, Add offer. Badges indicate applicant hotness and marketing consent.

## Manage Contacts, Properties and Marketing
- **Screen:** Combined management pages.
- **Menu:** Sidebar ▸ Contacts / Properties / Marketing.
- **Key components:** Tables with bulk action checkboxes, filters for negotiator and status, portals list with toggles (Rightmove, Zoopla, OnTheMarket), and marketing status cards per property.
- **UX details:** Bulk publish/unpublish buttons, status pills for portal sync, and inline banners indicating missing media preventing publishing.
