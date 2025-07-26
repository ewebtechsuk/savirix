<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('invoice')->orderByDesc('date')->paginate(20);
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoices = Invoice::orderByDesc('date')->get();
        return view('payments.create', compact('invoices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
        $payment = Payment::create($validated);
        return redirect()->route('payments.show', $payment)->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load('invoice');
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $invoices = Invoice::orderByDesc('date')->get();
        return view('payments.edit', compact('payment', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'method' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
        $payment->update($validated);
        return redirect()->route('payments.show', $payment)->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
