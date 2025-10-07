<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\ContactTag;
use App\Models\ContactNote;
use App\Models\ContactCommunication;
use App\Models\ContactViewing;
use Illuminate\Http\Request;
use App\Jobs\SendContactCommunication;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tenant = tenant();
        $company_id = $tenant->company_id ?? '468173';
        $query = Contact::where('company_id', $company_id);
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('company', 'like', "%$search%") ;
            });
        }
        if ($request->filled('tags')) {
            $tags = array_filter((array) $request->input('tags'));
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('tags.id', $tags);
            });
        }
        $contacts = $query->get();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allGroups = ContactGroup::orderBy('name')->get();
        $allTags = ContactTag::orderBy('name')->get();
        return view('contacts.create', compact('allGroups', 'allTags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
        $contact = Contact::create($validated);
        $contact->groups()->sync($request->input('groups', []));
        $contact->tags()->sync($request->input('tags', []));
        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $contact->load(['groups', 'tags', 'properties', 'notes', 'communications', 'viewings']);
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $allGroups = ContactGroup::orderBy('name')->get();
        $allTags = ContactTag::orderBy('name')->get();
        $contact->load('groups', 'tags');
        return view('contacts.edit', compact('contact', 'allGroups', 'allTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
        $contact->update($validated);
        $contact->groups()->sync($request->input('groups', []));
        $contact->tags()->sync($request->input('tags', []));
        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }

    /**
     * Search for contacts by type and name.
     */
    public function search(Request $request)
    {
        $type = $request->get('type', 'landlord');
        $q = $request->get('q', '');
        $results = Contact::where('type', $type)
            ->where('name', 'like', "%$q%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name']);
        return response()->json($results);
    }

    /**
     * Bulk actions for contacts.
     */
    public function bulk(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('contacts', []);
        $segmentTags = array_filter((array) $request->input('segment_tags', []));

        if (! $action || (empty($ids) && empty($segmentTags))) {
            return back()->with('error', 'No action or contacts selected.');
        }

        if (! empty($segmentTags) && empty($ids)) {
            $contacts = Contact::whereHas('tags', function ($q) use ($segmentTags) {
                $q->whereIn('tags.id', $segmentTags);
            })->get();
        } else {
            $contacts = Contact::whereIn('id', $ids)->when(! empty($segmentTags), function ($q) use ($segmentTags) {
                $q->whereHas('tags', function ($query) use ($segmentTags) {
                    $query->whereIn('tags.id', $segmentTags);
                });
            })->get();
        }

        if ($contacts->isEmpty()) {
            return back()->with('error', 'No contacts matched the selected criteria.');
        }
        if ($action === 'delete') {
            foreach ($contacts as $contact) {
                $contact->delete();
            }
            return back()->with('success', 'Contacts deleted.');
        } elseif ($action === 'tag') {
            $tagId = $request->input('tag');
            if ($tagId) {
                foreach ($contacts as $contact) {
                    $contact->tags()->syncWithoutDetaching([$tagId]);
                }
                return back()->with('success', 'Tag added to selected contacts.');
            }
        } elseif ($action === 'email') {
            $subject = $request->input('subject', 'Message from RESSAPP');
            $body = $request->input('body', 'This is a bulk message.');
            foreach ($contacts as $contact) {
                if ($contact->email) {
                    SendContactCommunication::dispatch($contact, 'email', [
                        'subject' => $subject,
                        'body' => $body,
                    ], auth()->id());
                }
            }
            return back()->with('success', 'Bulk email queued.');
        } elseif ($action === 'sms') {
            $smsBody = $request->input('sms_body', 'This is a bulk SMS.');
            foreach ($contacts as $contact) {
                if ($contact->phone) {
                    SendContactCommunication::dispatch($contact, 'sms', [
                        'body' => $smsBody,
                    ], auth()->id());
                }
            }
            return back()->with('success', 'Bulk SMS queued.');
        }
        return back()->with('error', 'Invalid action.');
    }

    /**
     * Add a note to a contact.
     */
    public function addNote(Request $request, Contact $contact)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);
        $contact->notes()->create([
            'note' => $request->note,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('contacts.show', $contact)->with('success', 'Note added.');
    }

    /**
     * Add a communication to a contact.
     */
    public function addCommunication(Request $request, Contact $contact)
    {
        $request->validate([
            'communication' => 'required|string|max:1000',
        ]);
        $contact->communications()->create([
            'communication' => $request->communication,
            'user_id' => auth()->id(),
            'channel' => 'internal',
            'status' => 'logged',
            'delivered_at' => now(),
        ]);
        return redirect()->route('contacts.show', $contact)->with('success', 'Communication added.');
    }

    /**
     * Add a viewing to a contact.
     */
    public function addViewing(Request $request, Contact $contact)
    {
        $request->validate([
            'property' => 'required|exists:properties,id',
            'date' => 'required|date',
        ]);
        $contact->viewings()->create([
            'property_id' => $request->property,
            'date' => $request->date,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('contacts.show', $contact)->with('success', 'Viewing added.');
    }

    /**
     * Delete a note from a contact.
     */
    public function deleteNote(Contact $contact, $noteId)
    {
        $note = $contact->notes()->findOrFail($noteId);
        $note->delete();
        return redirect()->route('contacts.show', $contact)->with('success', 'Note deleted.');
    }

    /**
     * Delete a communication from a contact.
     */
    public function deleteCommunication(Contact $contact, $communicationId)
    {
        $comm = $contact->communications()->findOrFail($communicationId);
        $comm->delete();
        return redirect()->route('contacts.show', $contact)->with('success', 'Communication deleted.');
    }

    /**
     * Delete a viewing from a contact.
     */
    public function deleteViewing(Contact $contact, $viewingId)
    {
        $viewing = $contact->viewings()->findOrFail($viewingId);
        $viewing->delete();
        return redirect()->route('contacts.show', $contact)->with('success', 'Viewing deleted.');
    }

    /**
     * Edit a note for a contact.
     */
    public function editNote(Contact $contact, $noteId)
    {
        $note = $contact->notes()->findOrFail($noteId);
        return view('contacts.partials.edit_note', compact('contact', 'note'));
    }

    /**
     * Update a note for a contact.
     */
    public function updateNote(Request $request, Contact $contact, $noteId)
    {
        $note = $contact->notes()->findOrFail($noteId);
        $request->validate(['note' => 'required|string|max:1000']);
        $note->update(['note' => $request->note]);
        return redirect()->route('contacts.show', $contact)->with('success', 'Note updated.');
    }

    /**
     * Edit a communication for a contact.
     */
    public function editCommunication(Contact $contact, $communicationId)
    {
        $comm = $contact->communications()->findOrFail($communicationId);
        return view('contacts.partials.edit_communication', compact('contact', 'comm'));
    }

    /**
     * Update a communication for a contact.
     */
    public function updateCommunication(Request $request, Contact $contact, $communicationId)
    {
        $comm = $contact->communications()->findOrFail($communicationId);
        $request->validate(['communication' => 'required|string|max:1000']);
        $comm->update(['communication' => $request->communication]);
        return redirect()->route('contacts.show', $contact)->with('success', 'Communication updated.');
    }

    /**
     * Edit a viewing for a contact.
     */
    public function editViewing(Contact $contact, $viewingId)
    {
        $viewing = $contact->viewings()->findOrFail($viewingId);
        return view('contacts.partials.edit_viewing', compact('contact', 'viewing'));
    }

    /**
     * Update a viewing for a contact.
     */
    public function updateViewing(Request $request, Contact $contact, $viewingId)
    {
        $viewing = $contact->viewings()->findOrFail($viewingId);
        $request->validate([
            'property' => 'required|exists:properties,id',
            'date' => 'required|date',
        ]);
        $viewing->update([
            'property_id' => $request->property,
            'date' => $request->date,
        ]);
        return redirect()->route('contacts.show', $contact)->with('success', 'Viewing updated.');
    }

    /**
     * API Methods
     */

    public function apiUpdateNote(Request $request, Contact $contact, $noteId)
    {
        $note = $contact->notes()->findOrFail($noteId);
        $request->validate(['note' => 'required|string|max:1000']);
        $note->update(['note' => $request->note]);
        return response()->json(['success' => true, 'note' => $note->note]);
    }

    public function apiDeleteNote(Contact $contact, $noteId)
    {
        $note = $contact->notes()->findOrFail($noteId);
        $note->delete();
        return response()->json(['success' => true]);
    }

    public function apiUpdateCommunication(Request $request, Contact $contact, $communicationId)
    {
        $comm = $contact->communications()->findOrFail($communicationId);
        $request->validate(['communication' => 'required|string|max:1000']);
        $comm->update(['communication' => $request->communication]);
        return response()->json(['success' => true, 'communication' => $comm->communication]);
    }

    public function apiDeleteCommunication(Contact $contact, $communicationId)
    {
        $comm = $contact->communications()->findOrFail($communicationId);
        $comm->delete();
        return response()->json(['success' => true]);
    }

    public function apiUpdateViewing(Request $request, Contact $contact, $viewingId)
    {
        $viewing = $contact->viewings()->findOrFail($viewingId);
        $request->validate([
            'property' => 'required|exists:properties,id',
            'date' => 'required|date',
        ]);
        $viewing->update([
            'property_id' => $request->property,
            'date' => $request->date,
        ]);
        return response()->json(['success' => true, 'property_id' => $viewing->property_id, 'date' => $viewing->date]);
    }

    public function apiDeleteViewing(Contact $contact, $viewingId)
    {
        $viewing = $contact->viewings()->findOrFail($viewingId);
        $viewing->delete();
        return response()->json(['success' => true]);
    }
}
