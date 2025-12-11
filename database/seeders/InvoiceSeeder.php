<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $consultations = \App\Models\Consultation::all();

        foreach ($consultations as $consultation) {
            $doctor = $consultation->appointment->doctor;
            $consultationFee = $doctor->consultation_fee ?? 500;

            $invoice = Invoice::create([
                'consultation_id' => $consultation->id,
                'payment_status' => rand(0, 1) ? 'paid' : 'pending',
                'total_amount' => $consultationFee,
            ]);

            // Add consultation fee item
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'service_description' => 'Consultation Fee - Dr. ' . $doctor->name,
                'fee' => $consultationFee,
            ]);

            // Randomly add additional services
            if (rand(0, 1)) {
                $additionalFee = rand(200, 1000);
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'service_description' => 'Additional Tests/Procedures',
                    'fee' => $additionalFee,
                ]);

                $invoice->update(['total_amount' => $consultationFee + $additionalFee]);
            }
        }
    }
}
