@extends('layouts.app')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Financial Billing Report</h1>
            <div class="flex space-x-2">
                <form action="{{ route('admin.reports.export') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="billing">
                    <input type="hidden" name="format" value="pdf">
                    <button class="bg-red-50 text-red-600 px-4 py-2 rounded-lg font-medium text-sm">Download PDF</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-600 text-white p-6 rounded-xl shadow-md">
                <p class="text-sm opacity-80">Total Billed</p>
                <p class="text-3xl font-bold"><span
                        class="font-bengali">৳</span>{{ number_format($stats['total_amount'], 2) }}</p>
            </div>
            <div class="bg-green-600 text-white p-6 rounded-xl shadow-md">
                <p class="text-sm opacity-80">Total Paid</p>
                <p class="text-3xl font-bold"><span
                        class="font-bengali">৳</span>{{ number_format($stats['paid_amount'], 2) }}</p>
            </div>
            <div class="bg-yellow-500 text-white p-6 rounded-xl shadow-md">
                <p class="text-sm opacity-80">Pending Collection</p>
                <p class="text-3xl font-bold"><span
                        class="font-bengali">৳</span>{{ number_format($stats['pending_amount'], 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 text-xs font-bold uppercase text-gray-500">Invoice ID</th>
                        <th class="p-4 text-xs font-bold uppercase text-gray-500">Date</th>
                        <th class="p-4 text-xs font-bold uppercase text-gray-500">Patient</th>
                        <th class="p-4 text-xs font-bold uppercase text-gray-500">Amount</th>
                        <th class="p-4 text-xs font-bold uppercase text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-mono text-sm">#INV-{{ $invoice->id }}</td>
                            <td class="p-4 text-sm">{{ $invoice->created_at->format('M d, Y') }}</td>
                            <td class="p-4 text-sm font-medium">
                                {{ $invoice->consultation?->appointment?->patient?->name ?? 'N/A' }}</td>
                            <td class="p-4 text-sm font-bold text-gray-900"><span
                                    class="font-bengali">৳</span>{{ number_format($invoice->total_amount, 2) }}
                            </td>
                            <td class="p-4">
                                <span
                                    class="px-2 py-1 rounded text-xs font-bold {{ $invoice->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ strtoupper($invoice->payment_status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">No invoices found for this period.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
