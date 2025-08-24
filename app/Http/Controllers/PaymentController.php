<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create($propertyId)
    {
        $property = Property::with('payments')->findOrFail($propertyId);
        return view('properties.payment', compact('property'));
    }

    public function store(Request $request)
    {
        // Prevent payment if property is available
        $property = Property::findOrFail($request->property_id);
        if ($property->status === 'available') {
            return redirect()->back()->with('error', 'Cannot make payment. Property is available for lease.');
        }
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        $property = Property::with('payments')->findOrFail($request->property_id);

        // Create new payment
        Payment::create([
            'property_id' => $property->id,
            'tenant_name' => $property->tenant_name,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'status' => 'paid',
        ]);
        
        return back()->with('success', 'Payment added successfully.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->back()->with('success', 'Payment deleted successfully.');
    }


}
