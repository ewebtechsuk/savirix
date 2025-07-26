<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\ContactTag;
use App\Models\ContactNote;
use App\Models\ContactCommunication;
use App\Models\ContactViewing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::orderBy('name')->paginate(20);
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
        if (!$action || empty($ids)) {
            return back()->with('error', 'No action or contacts selected.');
        }
        $contacts = Contact::whereIn('id', $ids)->get();
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
                    Mail::raw($body, function ($message) use ($contact, $subject) {
                        $message->to($contact->email)->subject($subject);
                    });
                }
            }
            return back()->with('success', 'Bulk email sent.');
        } elseif ($action === 'sms') {
            $smsBody = $request->input('sms_body', 'This is a bulk SMS.');
            // Example: integrate with Twilio or other SMS provider here
            foreach ($contacts as $contact) {
                if ($contact->phone) {
                    // Replace with real SMS sending logic
                    // SmsService::send($contact->phone, $smsBody);
                }
            }
            return back()->with('success', 'Bulk SMS sent (mocked).');
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
