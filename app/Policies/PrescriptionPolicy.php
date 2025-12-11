<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Prescription;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrescriptionPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Prescription $prescription)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $prescription->consultation->appointment->doctor_id === $user->id) return true;
        return $user->hasPermissionTo('view prescriptions');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create prescriptions');
    }

    public function update(User $user, Prescription $prescription)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $prescription->consultation->appointment->doctor_id === $user->id) return true;
        return $user->hasPermissionTo('edit prescriptions');
    }

    public function delete(User $user, Prescription $prescription)
    {
        if ($user->hasRole('Admin')) return true;
        if ($user->hasRole('Doctor') && $prescription->consultation->appointment->doctor_id === $user->id) return true;
        return $user->hasPermissionTo('delete prescriptions');
    }
}
