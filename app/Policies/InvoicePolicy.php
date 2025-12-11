<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Invoice $invoice)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $invoice->consultation->appointment->doctor_id === $user->id) return true;
        return $user->hasPermissionTo('view invoices');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create invoices');
    }

    public function update(User $user, Invoice $invoice)
    {
        if ($user->hasRole('Admin')) return true;
        return $user->hasPermissionTo('edit invoices');
    }

    public function process(User $user, Invoice $invoice)
    {
        if ($user->hasRole('Admin')) return true;
        return $user->hasPermissionTo('process payments');
    }
}
