<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Property;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['contact', 'property'])->orderByDesc('date')->paginate(20);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::orderBy('name')->get();
        $properties = Property::orderBy('title')->get();
        return view('invoices.create', compact('contacts', 'properties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255',
            'date' => 'required|date',
            'contact_id' => 'required|exists:contacts,id',
            'property_id' => 'nullable|exists:properties,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,paid,overdue',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);
        $invoice = Invoice::create($validated);
        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['contact', 'property']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $contacts = Contact::orderBy('name')->get();
        $properties = Property::orderBy('title')->get();
        return view('invoices.edit', compact('invoice', 'contacts', 'properties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255',
            'date' => 'required|date',
            'contact_id' => 'required|exists:contacts,id',
            'property_id' => 'nullable|exists:properties,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:unpaid,paid,overdue',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);
        $invoice->update($validated);
        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
