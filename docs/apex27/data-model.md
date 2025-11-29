# Apex27 data model (inferred)

## Property
- **Description:** Records for sales/lettings stock used for marketing and matching.
- **Fields:**
  - Address (line, town, postcode) – text.
  - Property type/tenure – select (flat, house, freehold/leasehold).
  - Bedrooms, bathrooms – integer.
  - Rent/Price – currency (per month/per annum for lettings).
  - Furnishing – select (furnished/part/unfurnished).
  - Availability date – date.
  - Status – pill (Available, Let agreed, Under offer, Draft).
  - Marketing flags – booleans (Publish to portals, Include in brochures, Featured).
  - Features/amenities – tags.
  - Images – gallery with featured flag and ordering index.
  - Brochure/attachments – files.
  - Portal feed status – per-portal toggle plus sync state badge.

## Contact / Applicant / Landlord / Vendor
- **Description:** People/organisations with roles and preferences.
- **Fields:**
  - Name, contact details (email, phone) – text.
  - Role – select (Applicant, Landlord, Vendor, Tenant).
  - Preferences – location, price/rent range, beds, property type, furnished flag.
  - Status/hotness – badge (Hot, Warm, Cold) inferred from match list.
  - Marketing consent – boolean badge.
  - Activity log – interactions (calls, emails, notes) with timestamp and user.
  - Linked offers/tenancies – tables referencing property and status.

## Viewing
- **Description:** Appointment linking applicant and property with time slot.
- **Fields:**
  - Property – reference.
  - Applicant/contact – reference.
  - Negotiator – reference.
  - Date/time and duration – datetime.
  - Status – enum (Confirmed, Pending, Cancelled, No-show).
  - Notes – text.
  - Calendar colour/ownership – derived from negotiator.

## Offer / Deal / Tenancy
- **Description:** Commercial progress for sales/lettings.
- **Fields:**
  - Property – reference.
  - Applicant/contact – reference.
  - Offer amount/rent – currency.
  - Dates – offer date, move-in date (tenancy).
  - Status – enum (New, Accepted, Rejected, Withdrawn; Active/Completed for tenancy).
  - Conditions/notes – text.
  - Linked negotiator – user reference.

## Marketing / Portal feed
- **Description:** Controls for advertising to portals and campaign tracking.
- **Fields:**
  - Portals list – Rightmove, Zoopla, OnTheMarket toggles.
  - Publish status – per-portal badge (Live, Pending, Blocked).
  - Media completeness – derived check for required photos/brochure.
  - Campaign metrics – cards for portal performance (impressions/enquiries) hinted on dashboard.
