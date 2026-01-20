<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['consultation.appointment.patient', 'consultation.appointment.doctor', 'items'])
            ->whereHas('consultation.appointment.patient');

        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where(function ($sub) use ($search) {
                $sub->whereHas('consultation.appointment.patient', function ($p) use ($search) {
                    $p->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })->orWhereHas('consultation.appointment.doctor', function ($d) use ($search) {
                    $d->where('name', 'like', "%{$search}%");
                });
            });
        });

        $query->when($request->filled('payment_status'), function ($q) use ($request) {
            $q->where('payment_status', $request->payment_status);
        });

        // Handle date range filtering with validation for both dates
        $query->when($request->filled('start_date') && $request->filled('end_date'), function ($q) use ($request) {
            $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
        });

        $invoices = $query->latest()->paginate(20)->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        // Get consultations without invoices
        $availableConsultations = Consultation::whereDoesntHave('invoice')
            ->with(['appointment.patient', 'appointment.doctor'])
            ->get();

        return view('admin.invoices.create', compact('availableConsultations'));
    }

    /**
     * Store a newly created invoice.
     */
    public function store(Request $request)
    {
        $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
            'payment_status' => 'required|in:pending,paid,partial,cancelled',
            'services' => 'required|array|min:1',
            'services.*.description' => 'required|string|max:255',
            'services.*.fee' => 'required|numeric|min:0',
        ]);

        // Check if consultation already has an invoice
        $existingInvoice = Invoice::where('consultation_id', $request->consultation_id)->exists();
        if ($existingInvoice) {
            return back()->withErrors(['consultation_id' => 'This consultation already has an invoice.'])->withInput();
        }

        // Calculate total amount
        $totalAmount = collect($request->services)->sum('fee');

        // Use database transaction to ensure data integrity
        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'consultation_id' => $request->consultation_id,
                'payment_status' => $request->payment_status,
                'total_amount' => $totalAmount,
            ]);

            // Create invoice items
            foreach ($request->services as $service) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_description' => $service['description'],
                    'fee' => $service['fee'],
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create invoice. Please try again.'])->withInput();
        }

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['consultation.appointment.patient', 'consultation.appointment.doctor', 'items']);
        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load(['items', 'consultation.appointment.patient', 'consultation.appointment.doctor']);
        return view('admin.invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified invoice.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,partial,cancelled',
            'services' => 'required|array|min:1',
            'services.*.description' => 'required|string|max:255',
            'services.*.fee' => 'required|numeric|min:0',
        ]);

        // Calculate total amount
        $totalAmount = collect($request->services)->sum('fee');

        // Use database transaction to ensure data integrity
        DB::beginTransaction();
        try {
            $invoice->update([
                'payment_status' => $request->payment_status,
                'total_amount' => $totalAmount,
            ]);

            // Delete existing items and create new ones
            $invoice->items()->delete();

            foreach ($request->services as $service) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_description' => $service['description'],
                    'fee' => $service['fee'],
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update invoice. Please try again.'])->withInput();
        }

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified invoice.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Mark invoice as paid.
     */
    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update(['payment_status' => 'paid']);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice marked as paid.');
    }

    /**
     * Download invoice as PDF.
     */
    public function download(Invoice $invoice)
    {
        $invoice->load(['consultation.appointment.patient', 'consultation.appointment.doctor', 'items']);

        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'));

        // Generate filename
        $filename = 'invoice-' . $invoice->id . '-' . date('Y-m-d') . '.pdf';

        // Save to storage
        Storage::put('invoices/' . $filename, $pdf->output());

        // Update invoice with PDF path
        $invoice->update(['pdf_path' => 'invoices/' . $filename]);

        return $pdf->download($filename);
    }
}
